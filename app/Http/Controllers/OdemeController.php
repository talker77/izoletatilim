<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentValidationRequest;
use App\Jobs\NewOrderAddedJob;
use App\Models\Ayar;
use App\Models\Iyzico;
use App\Models\İyzicoFailsJson;
use App\Models\Log;
use App\Models\PackageUser;
use App\Models\Sepet;
use App\Models\Siparis;
use App\Repositories\Interfaces\AccountInterface;
use App\Repositories\Interfaces\CityTownInterface;
use App\Repositories\Interfaces\OdemeInterface;
use App\Repositories\Interfaces\SiparisInterface;
use App\Repositories\Traits\IyzicoTrait;
use App\Repositories\Traits\SepetSupportTrait;
use App\Utils\Concerns\Controllers\PaymentConcern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Cart;

class OdemeController extends Controller
{
    use SepetSupportTrait;
    use IyzicoTrait;
    use PaymentConcern;

    private SiparisInterface $orderService;
    private OdemeInterface $paymentService;
    private CityTownInterface $cityTownService;
    private AccountInterface $accountService;

    public function __construct(SiparisInterface $orderService, OdemeInterface $paymentService, CityTownInterface $cityTownService, AccountInterface $accountService)
    {
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
        $this->cityTownService = $cityTownService;
        $this->accountService = $accountService;
    }

    public function index(Request $request)
    {
        $basket = Sepet::getCurrentBasket();;
        $this->matchSessionCartWithBasketItems($basket);

        if ($this->getBasketItemCount() == 0 || $basket->basket_items->count() == 0) {
            return redirect()->route('homeView')->with('message', __('lang.there_is_no_item_in_your_cart_to_checkout'))->with('message_type', 'info');
        }

        if (!$request->user()->default_address) {
            error(__('lang.no_address_information_is_entered_selected_please_add_or_select_a_new_address_below'));
            return redirect()->route('odeme.adres');
        }
        $address = $request->user()->default_address;
        $states = $this->cityTownService->all();
        $defaultInvoiceAddress = $request->user()->default_invoice_address;
        $owner = Ayar::getCache();

        if (session()->get('coupon')) {
            $this->couponService->checkCoupon($this->getProductIdList(), session()->get('coupon')['code'], $this->getCardSubTotal(), $basket->currency_id, $basket);
        }

        return view('site.odeme.payment', compact('address', 'states', 'defaultInvoiceAddress', 'owner', 'basket'));
    }


    /**
     * ödeme işlemi başlatır
     * @param PaymentValidationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payment(PaymentValidationRequest $request)
    {
        try {
            $user = $request->user();
            $currentBasket = Sepet::getCurrentBasket();
            Log::addIyzicoLog('Ödeme işlemine başlandı', "sepet id : $currentBasket->id", $currentBasket->id);
            \DB::beginTransaction();

            if (!$currentBasket->basket_items->count()) {
                return redirect(route('basket'))->withErrors(__('lang.there_are_no_items_in_your_cart'));
            }
            $defaultAddress = $this->accountService->getUserDefaultAddress($user->id);
            $invoiceAddress = $this->getOrCreateInvoiceAddress($request, $user, $defaultAddress);
            $order = $this->createOrderFromRequest($invoiceAddress, $defaultAddress, $currentBasket);

            $creditCartInfo = $this->getCardInfoFromRequest($request);
            $payment = $this->paymentService->makeIyzicoPayment($order, $currentBasket, $creditCartInfo, $currentBasket->user, $invoiceAddress, $defaultAddress);
            if ($payment['status'] === "success") {
                $iyzico3DResponse = $this->getIyzico3DSecurityDetailsFromIyzicoResponseData($payment);
                Session::put('conversationId', $iyzico3DResponse['conversationId']); //basket id
                Session::put('threeDSHtmlContent', $iyzico3DResponse['threeDSHtmlContent']);
                \DB::commit();
                return redirect()->route('odeme.threeDSecurityRequest');
            } else {
                $this->paymentService->logPaymentError($payment, $order);
                dd($order);
                error($payment['errorMessage']);
                return back()->withInput();
            }
        } catch (\Exception $exception) {
            \DB::rollBack();
            error($exception->getMessage());
            return back()->withInput();
        }

    }


    /**
     * bankadan dönen 3D ödeme sayfası kullanıcıya gösterilir
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function threeDSecurityRequest(Request $request)
    {
        $orderId = session()->get('orderId');
        Log::addIyzicoLog('3D sayfasına gelindi', "sipariş id : $orderId", $orderId, Log::TYPE_ORDER);
        if (!$orderId) {
            Log::addIyzicoLog('Sipariş id olmadığı için 3d kapatıldı', 'order id :' . $orderId, $orderId, Log::TYPE_ORDER);
            return redirect()->route('odemeView')->withErrors(__('lang.no_order_found_to_pay'));
        }

        return view('site.odeme.iyzico.threeDSecurity');
    }


    /**
     * iyzico 3D doğrulama sonrası post attığı istek
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function threeDSecurityResponse(Request $request)
    {
        $requestData = $request->only('status', 'paymentId', 'conversationId', 'mdStatus');
        $orderId = session()->get('orderId');
        Log::addIyzicoLog('iyzico 3D response geldi', (string)json_encode($requestData), $orderId, Log::TYPE_ORDER);
        $packageUser = PackageUser::find($orderId);

        if ($requestData['status'] != 'success') {
            Log::addIyzicoLog('iyzico 3D response success değil', (string)json_encode($requestData), $orderId, Log::TYPE_ORDER);
            return redirect()->route('odemeView')->withErrors(Iyzico::getMdStatusByParam($requestData['mdStatus']));
        }
        $isThreeDSCompletedResponse = $this->paymentService->completeIyzico3DSecurityPayment($requestData['conversationId'], $requestData['paymentId']);
        if ($isThreeDSCompletedResponse === false) {
            Log::addIyzicoLog('iyzico 3D response false döndü', null, $orderId, Log::TYPE_ORDER);
            return redirect()->route('odemeView')->withErrors(__('lang.an_error_occurred_during_the_process'));
        }
        if (strtolower($isThreeDSCompletedResponse['status']) === "success") {
            Log::addIyzicoLog('iyzico 3D response başarılı', json_encode($isThreeDSCompletedResponse), $orderId, Log::TYPE_ORDER);
            $this->completeOrderStatusChangeToTrue($packageUser, $isThreeDSCompletedResponse);
            return redirect()->route('user.packages.index')->with('message', __('lang.the_order_has_been_received_successfully'));
        } else {
            $message = (array)$isThreeDSCompletedResponse['errorMessage'];
            İyzicoFailsJson::addLog(null, $packageUser->full_name, $packageUser->sepet_id, json_encode($isThreeDSCompletedResponse, JSON_UNESCAPED_UNICODE));
            return redirect()->route('odemeView')->withErrors($message);
        }
    }


    /**
     * sipariş tamamlandığında stok düşürme kupon silme işlemlerini yapar
     * @param Siparis $packageUser
     * @return bool
     */
    public function completeOrderStatusChangeToTrue(PackageUser $packageUser, $paymentInfo = null)
    {
        Log::addIyzicoLog('sipariş durumu tamamlandı olarak işaretlenecek', $packageUser->toJson(), $packageUser->id);


        session()->forget(['current_basket_id', 'orderId']);
        $packageUser->update(['is_payment' => true,'payment_info' => $paymentInfo]);
        $packageUser->user->update(['active_package_id' => $packageUser->package_id]);
        Log::addIyzicoLog('Sipariş is_payment tamamlandı eski sepet silindi', null, $packageUser->id, Log::TYPE_ORDER);
        return true;
    }

}

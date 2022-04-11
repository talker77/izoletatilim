<?php namespace App\Repositories\Concrete\Eloquent;

use App\Models\Ayar;
use App\Models\Package;
use App\Models\PackageUser;
use App\Models\SepetUrun;
use App\User;
use App\Models\İyzicoFailsJson;
use App\Models\KullaniciAdres;
use App\Models\Log;
use App\Models\Sepet;
use App\Models\Siparis;
use App\Repositories\Interfaces\OdemeInterface;
use Iyzipay\Model\Currency;

class ElOdemeDal extends BaseRepository implements OdemeInterface
{

    protected $model;

    public function __construct(Log $model)
    {
        parent::__construct($model);
    }

    public function getIyzicoInstallmentCount($creditCartNumber, $totalPrice)
    {
        # create request class
        $options = $this->getIyzicoOptions();
        $request = new \Iyzipay\Request\RetrieveInstallmentInfoRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId("123123");
        $request->setBinNumber($creditCartNumber);
        $request->setPrice($totalPrice);
        return \Iyzipay\Model\InstallmentInfo::retrieve($request, $options);
    }

    public function getIyzicoOptions()
    {
        $options = new \Iyzipay\Options();
        $options->setApiKey(env('IYZIPAY_API_KEY'));
        $options->setSecretKey(env('IYZIPAY_SECRET_KEY'));
        $options->setBaseUrl("https://sandbox-api.iyzipay.com");
        return $options;
    }

    /**
     * @param Siparis $order
     * @param Sepet $basket
     * @param array $cardInfo - kredi kartı bilgileri cvv,holderName,cardNumber,cardExpireDateMonth,cardExpireDateYear
     * @param User $user
     * @param KullaniciAdres $invoiceAddress
     * @return array
     */
    public function makeIyzicoPayment(PackageUser $packageUser, Package $package, array $cardInfo, User $user, KullaniciAdres $invoiceAddress)
    {
        $options = $this->getIyzicoOptions();
        $request = new \Iyzipay\Request\CreatePaymentRequest();
        $request->setLocale('tr');
        $request->setConversationId($packageUser->id);
        $request->setPrice($packageUser->price);
        $request->setPaidPrice($packageUser->price);
        $request->setCurrency(Currency::TL);
        $request->setInstallment($packageUser->installment_count);
        $request->setBasketId($packageUser->id);
        $request->setPaymentChannel(\Iyzipay\Model\PaymentChannel::WEB);
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::SUBSCRIPTION);
        // credit cart
        $paymentCard = new \Iyzipay\Model\PaymentCard();
        $paymentCard->setCardHolderName($cardInfo['holderName']);
        $paymentCard->setCardNumber(str_replace("-", "", $cardInfo['cardNumber']));
        $paymentCard->setExpireMonth($cardInfo['cardExpireDateMonth']);
        $paymentCard->setExpireYear($cardInfo['cardExpireDateYear']);
        $paymentCard->setCvc($cardInfo['cvv']);
        $paymentCard->setRegisterCard(0);
        $request->setPaymentCard($paymentCard);
        // buyer information
        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId($user->id);
        $buyer->setName($user->name);
        $buyer->setSurname($user->surname);
        $buyer->setGsmNumber($user->phone);
        $buyer->setEmail($user->email);
        $buyer->setIdentityNumber("74300864791"); //tc kimlik gelicek
        $buyer->setRegistrationAddress($invoiceAddress->address_text);
        $buyer->setIp($packageUser->ip_address);
        $buyer->setCity($invoiceAddress->state->title);
        $buyer->setCountry($invoiceAddress->country->title);
        $buyer->setZipCode("34732");
        $request->setBuyer($buyer);
        // shipping address
        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName($invoiceAddress->full_name);
        $shippingAddress->setCity($invoiceAddress->state->title);
        $shippingAddress->setCountry($invoiceAddress->country->title);
        $shippingAddress->setAddress($invoiceAddress->address_text);
        $shippingAddress->setZipCode("34742");
        $request->setShippingAddress($shippingAddress);
        // billing address
        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName($invoiceAddress->full_name);
        $billingAddress->setCity($invoiceAddress->state->title);
        $billingAddress->setCountry($invoiceAddress->country->title);
        $billingAddress->setAddress($invoiceAddress->address_text);
        $billingAddress->setZipCode("34742");
        $request->setBillingAddress($billingAddress);
        // basket items
        $basketItems = array();
        $basketItem = new \Iyzipay\Model\BasketItem();
        $basketItem->setId($packageUser->id);
        $basketItem->setName($packageUser->package->title);
        $basketItem->setCategory1('PAKET');
        $basketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
        $basketItem->setPrice($packageUser->price);
        $basketItems[] = $basketItem;
        $request->setBasketItems($basketItems);

        $request->setCallbackUrl(route('odeme.threeDSecurityResponse'));
        Log::addIyzicoLog('makeIyzicoPayment request atıldı', json_encode($request->getJsonObject()), $packageUser->id);
        $response = \Iyzipay\Model\ThreedsInitialize::create($request, $options);
        Log::addIyzicoLog('makeIyzicoPayment response alındı', $response->getRawResult(), $packageUser->id);

        return json_decode($response->getRawResult(), true);
    }

    public function logPaymentError($paymentResult, $order)
    {
        try {
            $paymentResult = json_decode($paymentResult, JSON_UNESCAPED_UNICODE);
            İyzicoFailsJson::addLog(loggedPanelUser()->id, $order['full_name'], $order['sepet_id'], $paymentResult);
        } catch (\Exception $exception) {
            Log::addLog('iyzico işlemi sırasında hata oldu' . $exception->getMessage(), $exception, Log::TYPE_IYZICO);
        }

    }

    /**
     * 3d işlemini tamamlamak için kullanılır
     * @param $conversationId
     * @param int $paymentId
     * @return false|array
     */
    public function completeIyzico3DSecurityPayment($conversationId, $paymentId)
    {
        try {
            $request = new \Iyzipay\Request\CreateThreedsPaymentRequest();
            $request->setLocale(\Iyzipay\Model\Locale::TR);
            $request->setConversationId($conversationId);
            $request->setPaymentId($paymentId);
            $response = \Iyzipay\Model\ThreedsPayment::create($request, $this->getIyzicoOptions());
            Log::addLog('3D bitirme response', $response->getRawResult(), Log::TYPE_IYZICO);
            $response = json_decode($response->getRawResult(), true);
            if ($response['status'] == 'success') {
                Log::addLog('3D bitirme success geldi', json_encode($response), Log::TYPE_IYZICO);
            }
            return $response;
        } catch (\Exception $exception) {
            Log::addLog('iyzico 3d tamamlama sırasında hata oldu' . $exception->getMessage(), $exception, Log::TYPE_IYZICO);
            return false;
        }

    }

    /**
     * kullanıcının ödemesi tamamlanmamış siparişleri siliniyor
     * @param $userId
     */
    public function deleteUserOldNotPaymentOrderTransactions($userId)
    {
        Siparis::where('is_payment', 0)->whereHas('basket', function ($query) use ($userId) {
            $query->user_id = $userId;
        })->forceDelete();
    }
}

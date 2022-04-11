<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentValidationRequest;
use App\Models\Log;
use App\Models\Package;
use App\Models\Region\State;
use App\Repositories\Interfaces\AccountInterface;
use App\Repositories\Interfaces\OdemeInterface;
use App\Repositories\Traits\IyzicoTrait;
use App\Utils\Concerns\Controllers\PaymentConcern;
use Illuminate\Support\Facades\Session;

class PackageController extends Controller
{
    use PaymentConcern;
    use IyzicoTrait;

    private OdemeInterface $paymentService;
    private AccountInterface $accountService;

    public function __construct(OdemeInterface $paymentService,AccountInterface $accountService)
    {
        $this->paymentService = $paymentService;
        $this->accountService = $accountService;
    }

    public function index()
    {
        $currentPackage = Package::getUserActivePackageUser(loggedPanelUser());

        return view('site.kullanici.packages.index', [
            'packages' => Package::orderBy('price')->get(),
            'currentPackageId' => $currentPackage ? $currentPackage->package_id : null,
            'currentPackage' => $currentPackage
        ]);
    }

    public function package(Package $package)
    {
        $currentPackage = Package::getUserActivePackageUser(loggedPanelUser());

        return view('site.kullanici.packages.show', [
            'package' => $package,
            'currentPackageId' => $currentPackage ? $currentPackage->package_id : null,
            'currentPackage' => $currentPackage,
            'states' => State::orderBy('title')->get()
        ]);
    }

    public function payment(PaymentValidationRequest $request, Package $package)
    {
        try {
            $user = loggedPanelUser();
            Log::addIyzicoLog('Ödeme işlemine başlandı', "sepet id : $package->id", $package->id);
            \DB::beginTransaction();

            $invoiceAddress = $this->getOrCreateInvoiceAddress($request, $user);
            $order = $this->createOrderFromRequest($invoiceAddress, $package);

            $creditCartInfo = $this->getCardInfoFromRequest($request);
            $payment = $this->paymentService->makeIyzicoPayment($order, $package, $creditCartInfo, $user, $invoiceAddress);
            if ($payment['status'] === "success") {
                $iyzico3DResponse = $this->getIyzico3DSecurityDetailsFromIyzicoResponseData($payment);
                Session::put('conversationId', $iyzico3DResponse['conversationId']); //basket id
                Session::put('threeDSHtmlContent', $iyzico3DResponse['threeDSHtmlContent']);
                \DB::commit();
                return redirect()->route('odeme.threeDSecurityRequest');
            } else {
                $this->paymentService->logPaymentError($payment, $order);
                error($payment['errorMessage']);
                return back()->withInput();
            }
        } catch (\Exception $exception) {
            \DB::rollBack();
            error($exception->getMessage());
            return back()->withInput();
        }

    }
}

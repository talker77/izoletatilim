<?php namespace App\Repositories\Interfaces;

use App\Models\Package;
use App\Models\PackageUser;
use App\User;
use App\Models\KullaniciAdres;
use App\Models\Sepet;
use App\Models\Siparis;

interface OdemeInterface
{
    public function getIyzicoInstallmentCount($creditCartNumber, $totalPrice);

    public function getIyzicoOptions();

    public function makeIyzicoPayment(PackageUser $packageUser, Package $package, array $cardInfo, User $user, KullaniciAdres $invoiceAddress);

    public function logPaymentError($paymentResult, $order);

    public function completeIyzico3DSecurityPayment($conversationId, $paymentId);

    public function deleteUserOldNotPaymentOrderTransactions($userId);

}

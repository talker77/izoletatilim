<?php

namespace App\Utils\Concerns\Controllers;


use App\Models\KullaniciAdres;
use App\Models\Log;
use App\Models\Package;
use App\Models\PackageUser;
use App\Models\Product\Urun;
use App\Models\Product\UrunVariant;
use App\Models\Region\Country;
use App\Models\Sepet;
use App\Models\Siparis;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait PaymentConcern
{

    /**
     *  kullanıcının invoice adresini gönderir kullanıcı farklı invoice eklemek isterse ekler
     *  yoksa param olarak gönderilen getirir
     * @param Request $request
     * @param User $user
     * @return mixed
     */
    protected function getOrCreateInvoiceAddress(Request $request, User $user)
    {
        $invoiceAddress = $this->accountService->getUserDefaultInvoiceAddress($user->id);
        if (!$invoiceAddress) {
            $invoiceAddressData = array_merge($request->only('title', 'name', 'surname', 'phone', 'state_id', 'district_id', 'address'), [
                'type' => KullaniciAdres::TYPE_INVOICE,
                'country_id' => Country::TURKEY
            ]);
            $invoiceAddress = $user->addresses()->create($invoiceAddressData);
            $this->accountService->checkUserDefaultAddress($user, $invoiceAddress);
        }
        return $invoiceAddress;
    }


    /**
     * @param KullaniciAdres $invoiceAddress
     * @param KullaniciAdres $defaultAddress
     * @param Sepet $package
     * @return Siparis
     */
    protected function createOrderFromRequest(KullaniciAdres $invoiceAddress, Package $package)
    {
        $validated = request()->only('installment_count', 'cardNumber', 'holderName', 'cardExpireDateMonth', 'cardExpireDateYear', 'ccv');

        $userHasPackage = Package::getUserActivePackageUser($invoiceAddress->user);
        $packageDayCount = $package->day + ($userHasPackage ? $userHasPackage->remaining_day : 0);
        $packageUser = PackageUser::create([
            'user_id' => $invoiceAddress->user_id,
            'price' => $package->price,
            'installment_count' => $validated['installment_count'] ?? 1,
            'ip_address' => \request()->ip(),
            'last_price' => $package->price, // todo : taksitli fiyat kaydet responsedan sonra.
            'invoice_address_id' => $invoiceAddress->id,
            'hash' => Str::uuid(),
            'package_id' => $package->id,
            'started_at' => Carbon::now(),
            'expired_at' => Carbon::now()->addDays($packageDayCount)
        ]);

        Log::addIyzicoLog('Sipariş Oluşturuldu', "Model : PackageUser id - package id : $packageUser->id", $package->id);
        session()->put('orderId', $packageUser->id);

        return $packageUser;
    }

    /**
     * iyzico kredi kartı bilgilerini gönderir
     * @param $request
     * @return array
     */
    protected function getCardInfoFromRequest(Request $request)
    {
        return $request->only([
            'holderName',
            'cardNumber',
            'cardExpireDateMonth',
            'cardExpireDateYear',
            'cvv'
        ]);
    }

    /**
     * ödeme işleminden sonra varyanta bakar ve stok durumunu günceller
     * @param int $productID
     * @param int $qty satın alınan ürün adet
     * @param int $currencyID para birimi id
     * @param array|null $subAttributeIdList ürün sub attribute id listesi
     */
    protected function checkProductVariantAndDecrementQty(int $productID, int $qty, $currencyID, ?array $subAttributeIdList)
    {
        $variant = UrunVariant::urunHasVariant($productID, $subAttributeIdList, $currencyID);
        if ($variant) {
            $variant->decrement('qty', $qty);
        } else {
            Urun::find($productID)->decrement('qty', $qty);
        }
    }

    /**
     * sipariş oluşturma esnasında gerekli bilgileri json olarak alır.
     * @param Siparis $order
     */
    private function takeSnapshot(Siparis $order)
    {
        $order = Siparis::with(['basket.basket_items.product', 'basket.user'])->find($order->id);
        $order->basket->setAppends(['total', 'sub_total', 'cargo_total', 'coupon_price']);
        foreach ($order->basket->basket_items as $basketItem) {
            $basketItem->setAppends(['total', 'sub_total', 'cargo_total']);
        }
        $orderArray = $order->toArray();
        unset($orderArray['snapshot']);
        $order->update(['snapshot' => $orderArray]);
    }

}

<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumberRule;
use Illuminate\Foundation\Http\FormRequest;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardNumber;

class PaymentValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return loggedPanelUser();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $cardNumber = str_replace("-", "", request()->get('cardNumber'));
        $phoneReplaces = ['(', ')', '-', ' '];
        request()->merge(['cardNumber' => $cardNumber]);
        request()->merge(['phone' => str_replace($phoneReplaces, "", $this->get('phone'))]);

        $rules = [
            'cardNumber' => ['required', 'min:16'],
            'holderName' => ['required', 'min:5', 'max:50'],
            'cardExpireDateYear' => ['required', new CardExpirationYear($this->get('cardExpireDateMonth'))],
            'cardExpireDateMonth' => ['required', new CardExpirationMonth($this->get('cardExpireDateYear'))],
            'cvv' => ['required', 'min:3', 'max:3'],
        ];

        $rules['title'] = ['required', 'min:2', 'max:50'];
        $rules['name'] = ['required', 'min:3', 'max:50'];
        $rules['surname'] = ['required', 'min:3', 'max:50'];
        $rules['phone'] = ['required', new PhoneNumberRule(request('phone'))];
        $rules['state_id'] = ['required', 'numeric'];
        $rules['district_id'] = ['required', 'numeric'];
        $rules['address'] = ['required', 'min:10', 'max:250'];

        return $rules;
    }
}

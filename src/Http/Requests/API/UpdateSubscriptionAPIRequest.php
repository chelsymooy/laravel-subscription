<?php

namespace Chelsymooy\Subscriptions\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

use Chelsymooy\Subscriptions\Models\Subscription;

class UpdateSubscriptionAPIRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules  = [
            'settings.recurring_toggle' => 'nullable|boolean',
            'settings.customer_name'    => 'required|string',
            'settings.customer_address' => 'required|string',
            'settings.customer_phone'   => 'required|string',
        ]; 

        return $rules;
    }
}


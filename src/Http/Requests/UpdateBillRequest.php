<?php

namespace Chelsymooy\Subscriptions\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Chelsymooy\Subscriptions\Models\Bill;

class UpdateBillRequest extends FormRequest
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
        $rules  = Bill::$rules;
        unset($rules['user_id']);
        unset($rules['subscription_id']);

        return $rules;
    }
}

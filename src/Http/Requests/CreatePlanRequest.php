<?php

namespace Chelsymooy\Subscriptions\Http\Requests;

use Str;
use Illuminate\Foundation\Http\FormRequest;

use Chelsymooy\Subscriptions\Models\Plan;
use Chelsymooy\Subscriptions\Models\PlanPrice;

class CreatePlanRequest extends FormRequest
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
        $plan   = Plan::$rules;
        $price  = PlanPrice::$rules;

        foreach ($price as $k => $v) {
            if(!Str::is($k, 'plan_id')){
                $plan['price.'.$k]   = $v;
            }
        }

        return $plan;        
    }
}

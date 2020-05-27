<?php

namespace Chelsymooy\Subscriptions\Models;

use DB, Carbon\Carbon;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Bill
 * @package Chelsymooy\Subscriptions\Models
 * @version May 2, 2020, 1:26 pm UTC
 *
 */
class Bill extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at', 'issued_at', 'due_at', 'paid_at'];

    public $fillable = [
        'user_id',
        'subscription_id',
        'no',
        'lines',
        'details',
        'issued_at',
        'due_at',
        'paid_at',
        'amount'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id'           => 'integer',
        'subscription_id'   => 'integer',
        'no'                => 'string',
        'lines'             => 'array',
        'details'           => 'array',
        'issued_at'         => 'date',
        'due_at'            => 'date',
        'paid_at'           => 'date',
        'amount'            => 'double'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id'           => 'required|exists:users,id',
        'subscription_id'   => 'required|exists:plan_prices,id',
        'no'                => 'nullable|unique:bills,no',
        'lines'             => 'required|array',
        // 'lines.*.item'      => 'required|string',
        // 'lines.*.qty'       => 'required|numeric|min:0',
        // 'lines.*.unit'      => 'required|string',
        // 'lines.*.price'     => 'required|numeric',
        // 'lines.*.discount'  => 'required|numeric|max:lines.*.price',
        'details'           => 'required|array',

        'details.period_started'   => 'required|date',
        'details.period_ended'     => 'required|date',

        'details.penalty_rate'           => 'required|numeric|min:0',
        'details.penalty_period_opt'     => 'required|string|in:day,month,year',
        'details.penalty_period_val'     => 'required|numeric|min:0',

        'details.issuer_name'      => 'required|string',
        'details.issuer_address'   => 'required|string',
        'details.issuer_phone'     => 'required|string',
        
        'details.customer_name'    => 'required|string',
        'details.customer_address' => 'required|string',
        'details.customer_phone'   => 'required|string',

        'details.bank_name'         => 'required|string',
        'details.bank_currency'     => 'required|string',
        'details.account_no'        => 'required|string',
        'details.account_name'      => 'required|string',

        'issued_at'         => 'nullable|date',
        'due_at'            => 'nullable|date|after_or_equal:issued_at',
        'paid_at'           => 'nullable|date|after_or_equal:issued_at',
        'amount'            => 'nullable|numeric'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function subscription() {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        $user  = config()->get('auth.providers.users.model');
        return $this->belongsTo(new $user());
    }
    
    /**
     * Mutator
     *
     */
    public function getTotalAttribute() {
        $total  = 0;
        foreach ($this->lines as $v) {
            $total  = $total + ($v['qty'] * ($v['price'] - $v['discount']));
        }

        return $total;
    }
}

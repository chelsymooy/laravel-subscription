<?php

namespace Chelsymooy\Subscriptions\Models;

use DB, Carbon\Carbon;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Subscription
 * @package Chelsymooy\Subscriptions\Models
 * @version May 2, 2020, 1:26 pm UTC
 *
 */
class Subscription extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at', 'started_at', 'ended_at'];

    public $fillable = [
        'user_id',
        'plan_price_id',
        'started_at',
        'ended_at',
        'settings'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id'       => 'integer',
        'plan_price_id' => 'integer',
        'started_at'    => 'date',
        'ended_at'      => 'date',
        'settings'      => 'array'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id'       => 'required|exists:users,id',
        'plan_price_id' => 'required|exists:plan_prices,id',
        'started_at'    => 'required|date',
        'ended_at'      => 'nullable|date',

        'settings.issuer_name'      => 'required|string',
        'settings.issuer_address'   => 'required|string',
        'settings.issuer_phone'     => 'required|string',
        
        'settings.recurring_toggle' => 'nullable|boolean',
        'settings.customer_name'    => 'required|string',
        'settings.customer_address' => 'required|string',
        'settings.customer_phone'   => 'required|string',
        'settings.customer_logo'    => 'nullable|string',
        'settings.customer_website' => 'required|string',

        'settings.bank_name'        => 'required|string',
        'settings.bank_currency'    => 'required|string',
        'settings.account_no'       => 'required|string',
        'settings.account_name'     => 'required|string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function price()
    {
        return $this->belongsTo(PlanPrice::class, 'plan_price_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        $user  = config()->get('auth.providers.users.model');
        return $this->belongsTo(new $user());
    }
}

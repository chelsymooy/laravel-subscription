<?php

namespace Chelsymooy\Subscriptions\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlanPrice
 * @package Chelsymooy\Subscriptions\Models
 * @version May 2, 2020, 1:26 pm UTC
 *
 */
class PlanPrice extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at', 'started_at', 'ended_at'];

    public $fillable = [
        'plan_id',
        'name',
        'price',
        'discount',
        'recurring_opt',
        'recurring_val',
        'penalty_rate',
        'penalty_period_opt',
        'penalty_period_val',
        'started_at',
        'ended_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'plan_id'           => 'integer',
        'name'              => 'string',
        'price'             => 'integer',
        'discount'          => 'integer',
        'recurring_opt'     => 'string',
        'recurring_val'     => 'integer',
        'penalty_rate'      => 'integer',
        'penalty_period_opt'=> 'string',
        'penalty_period_val'=> 'integer',
        'started_at'        => 'datetime',
        'ended_at'          => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'plan_id'                   => 'required|exists:plans,id',
        'name'                      => 'nullable|string',
        'price'                     => 'required|numeric',
        'discount'                  => 'nullable|numeric',
        'recurring_opt'             => 'required|in:day,month,year',
        'recurring_val'             => 'required|numeric',
        'penalty_rate'              => 'required|min:0',
        'penalty_period_opt'        => 'required|in:day,month,year',
        'penalty_period_val'        => 'required|numeric',
        'started_at'                => 'required|date',
        'ended_at'                  => 'nullable|date|after:started_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function plan() {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Mutator
     *
     */
    public function getNetAttribute() {
        return $this->price - $this->discount;
    }
}

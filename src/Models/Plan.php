<?php

namespace Chelsymooy\Subscriptions\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Plan
 * @package Chelsymooy\Subscriptions\Models
 * @version May 2, 2020, 1:26 pm UTC
 *
 */
class Plan extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public $fillable = [
        'project_id',
        'name',
        'features',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name'      => 'string',
        'features'  => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'project_id'                => 'required|string',
        'name'                      => 'required|string',
        'features'                  => 'nullable|array',
        // 'features.*.title'          => 'required|string',
        // 'features.*.code'           => 'required|string',
        // 'features.*.is_available'   => 'required|boolean',
        'is_active'                 => 'nullable|boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function prices()
    {
        return $this->hasMany(PlanPrice::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function price()
    {
        return $this->hasOne(PlanPrice::class)
            ->where('started_at', '<=', now())
            ->where(function($q){
                $q->wherenull('ended_at')->orwhere('ended_at', '>=', now());
            })->orderby('started_at', 'desc')
            ;
    }
}

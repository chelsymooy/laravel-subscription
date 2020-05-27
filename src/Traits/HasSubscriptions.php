<?php

namespace Chelsymooy\Subscriptions\Traits;

use Chelsymooy\Subscriptions\Models\PlanPrice;
use Chelsymooy\Subscriptions\Models\Subscription;
use Carbon\Carbon;

trait HasSubscriptions
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function subscriptions() {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Subscribe user to a new plan.
     *
     * @param \Chelsymooy\Subscriptions\Models\PlanPrice $price
     * @param Carbon                           $started_at
     * @param array                            $settings
     */
    public function subscribe(PlanPrice $price, Carbon $started_at, $settings) {
        $ended_at   = Carbon::parse($started_at)->addDays(config()->get('subscription.billing_day'));
        switch (strtolower($price->settings['recurring_opt'])) {
            case 'day':
                $ended_at->addDays($price->settings['recurring_val']);
                break;
            case 'month':
                $ended_at->addMonthsNoOverflow($price->settings['recurring_val']);
                break;
            case 'year':
                $ended_at->addYearNoOverflow($price->settings['recurring_val']);
                break;
            default:
                break;
        }

        return Subscription::create([
            'user_id'       => $this->id,
            'plan_price_id' => $price->id,
            'started_at'    => $started_at,
            'ended_at'      => $ended_at,
            'settings'      => $settings
        ]);
    }
}

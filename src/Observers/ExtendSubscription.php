<?php

namespace Chelsymooy\Subscriptions\Observers;

use Carbon\Carbon;
use Chelsymooy\Subscriptions\Models\Bill;

class ExtendSubscription
{
    /**
     * Handle the bill "saved" event.
     *
     * @param  \Chelsymooy\Subscriptions\Models\Bill  $bill
     * @return void
     */
    public function saved(Bill $bill)
    {
        //
        if(!is_null($bill->paid_at) && $bill->subscription->settings['recurring_toggle'] && $bill->subscription->ended_at < $bill->issued_at){
            $price  = $bill->subscription->price;
            switch (strtolower($price->recurring_opt)) {
                case 'day':
                    $bill->subscription->ended_at = Carbon::parse($bill->issued_at)->addDays($price->recurring_val);
                    break;
                case 'month':
                    $bill->subscription->ended_at = Carbon::parse($bill->issued_at)->addMonthsNoOverflow($price->recurring_val);
                    break;
                case 'year':
                    $bill->subscription->ended_at = Carbon::parse($bill->issued_at)->addYearsNoOverflow($price->recurring_val);
                    break;
                default:
                    $bill->subscription->ended_at = Carbon::parse($bill->issued_at);
                    break;
            }

            $bill->subscription->save();
        }
    }
}

<?php

namespace Chelsymooy\Subscriptions\Observers;

use Mail, PDF;
use Chelsymooy\Subscriptions\Models\Bill;
use Chelsymooy\Subscriptions\Mail\SendNotification;

class SubscribeEmailNotification
{
    /**
     * Handle the bill "saved" event.
     *
     * @param  \Chelsymooy\Subscriptions\Models\Bill  $bill
     * @return void
     */
    public function updated(Bill $bill)
    {
        //
        if(!is_null($bill->issued_at) || !is_null($bill->paid_at)){
            if(!is_null($bill->paid_at)){
                $data['title']       = 'Your payment has been ACCEPTED';
                $data['description'] = 'Your payment for invoice #'.$bill->no.' has been ACCEPTED by our team.';
                $data['user']        = $bill->user->toArray();
                
                $pdf    = PDF::loadView('subs::pdf.invoice', ['bill' => $bill]);
                Mail::to($data['user']['username'])->send(new SendNotification($data, $pdf));
            }elseif(!is_null($bill->issued_at)){
                $data['title']       = 'Subscription Summary (Billing date '.$bill->issued_at->format('M, d Y').')';
                $data['description'] = 'Your Subscription billing for '.$bill->issued_at->format('M, d Y').' is '.$bill->total.' in amount. Please proceed your payment before '.$bill->due_at->format('M, d Y').'.';
                $data['user']        = $bill->user->toArray();
                
                $pdf    = PDF::loadView('subs::pdf.invoice', ['bill' => $bill]);
                Mail::to($data['user']['username'])->send(new SendNotification($data, $pdf));
            }
        }
    }
}

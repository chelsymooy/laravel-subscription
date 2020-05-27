<?php

namespace Chelsymooy\Subscriptions\Observers;

use Chelsymooy\Subscriptions\Models\Bill;

class BillGeneratingNo
{
    /**
     * Handle the bill "saving" event.
     *
     * @param  \Chelsymooy\Subscriptions\Models\Bill  $bill
     * @return void
     */
    public function saving(Bill $bill)
    {
        //
        if(!is_null($bill->issued_at) && is_null($bill->no)){
            $counter_char_length = 5;

            /////////////////
            // Generate No //
            /////////////////
            $no = $bill->issued_at->format('yymm.');

            ///////////////////
            // Get latest no //
            ///////////////////
            $latest_schedule = Bill::where('no', 'like', $no . '%')->orderBy('no', 'desc')->first();
            if (!$latest_schedule)
            {
                $latest_no = 0;
            }
            else
            {
                $latest_no = intval(substr($latest_schedule->no,-1 * $counter_char_length,$counter_char_length));
            }
            $no = $no . str_pad($latest_no + 1, $counter_char_length, "0", STR_PAD_LEFT);

            ///////////////
            // Assign NO //
            ///////////////
            $bill->no       = $no;
            $bill->amount   = $bill->total;
        }
    }
}

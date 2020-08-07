<?php

namespace Chelsymooy\Subscriptions\Console\Commands;

use Illuminate\Console\Command;
use DB, Carbon\Carbon, Validator, Exception;

/*----------  Subscriptions  ----------*/
use Chelsymooy\Subscriptions\Models\Subscription;
use Chelsymooy\Subscriptions\Models\Bill;

class RecurringBill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:recurring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Issue Recurring Bill';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        try {
            $issued         = now()->startofday();
            // $issued         = Carbon::parse('tomorrow')->startofday();
            //
            $exp            = Carbon::parse($issued)->addDays(config()->get('subscription.recurring_day'));
            $active_subs    = Subscription::where('ended_at', '<=', $exp)->where('ended_at', '>=', $issued)
                ->with(['price', 'price.plan'])->get();

            foreach ($active_subs as $k => $v) {
                //1. PREPARE LINES
                $lines      = [];
                //1A. PREPARE SUBS
                $lines[]    = [
                    'item'      => $v->price->plan->name.' for '.$v->settings['customer_website'], 
                    'qty'       => $v->price->recurring_val, 
                    'unit'      => $v->price->recurring_opt,
                    'price'     => $v->price->price,
                    'discount'  => $v->price->discount
                ];
                //1B. PREPARE PENALTIES
                $last_bill  = Bill::where('issued_at', '<', $v->ended_at)->where('user_id', $v->user_id)->orderby('issued_at', 'desc')->first();
                $paid       = ($last_bill ? $last_bill->paid_at : $issued);
                if($last_bill && $last_bill->due_at->lte($paid)) {
                    $late   = 0;
                    switch (strtolower($last_bill->details['penalty_period_opt'])) {
                        case 'day':
                            $late    = $last_bill->due_at->diffInDays($paid);
                            break;
                        case 'month':
                            $late    = $last_bill->due_at->diffInMonths($paid);
                            break;
                        case 'year':
                            $late    = $last_bill->due_at->diffInYears($paid);
                            break;
                        
                        default:
                            break;
                    }
                    
                    $lines[]    = [
                        'item'      => 'Last Bill`s Penalty', 
                        'qty'       => ceil($late / $last_bill->details['penalty_period_val']), 
                        'unit'      => $last_bill->details['penalty_period_opt'],
                        'price'     => ceil($late / $last_bill->details['penalty_period_val']) * $last_bill->details['penalty_rate'],
                        'discount'  => 0
                    ];
                }

                //2. PREPARE DETAILS
                $details    = [];
                $period     = Carbon::parse($v->ended_at)->subDays(config()->get('subscription.billing_day'));
                $details['period_started']  = $period->toAtomString();
                switch (strtolower($v->price->recurring_opt)) {
                    case 'day':
                        $details['period_ended']= Carbon::parse($period)->addDays($v->price->recurring_val)->toAtomString();
                        break;
                    case 'month':
                        $details['period_ended']= Carbon::parse($period)->addMonthsNoOverflow($v->price->recurring_val)->toAtomString();
                        break;
                    case 'year':
                        $details['period_ended']= Carbon::parse($period)->addYearsNoOverflow($v->price->recurring_val)->toAtomString();
                        break;
                    default:
                        $details['period_ended']= Carbon::parse($period)->toAtomString();
                        break;
                }
                $details['penalty_rate']        = $v->price->penalty_rate;
                $details['penalty_period_opt']  = $v->price->penalty_period_opt;
                $details['penalty_period_val']  = $v->price->penalty_period_val;
                
                $details['issuer_name']         = $v->settings['issuer_name'];
                $details['issuer_address']      = $v->settings['issuer_address'];
                $details['issuer_phone']        = $v->settings['issuer_phone'];

                $details['customer_name']       = $v->settings['customer_name'];
                $details['customer_address']    = $v->settings['customer_address'];
                $details['customer_phone']      = $v->settings['customer_phone'];

                $details['bank_name']           = $v->settings['bank_name'];
                $details['bank_currency']       = $v->settings['bank_currency'];
                $details['account_no']          = $v->settings['account_no'];
                $details['account_name']        = $v->settings['account_name'];
                
                //3. ISSUE BILLS
                DB::beginTransaction();

                $bill       = Bill::where('details->period_started', $details['period_started'])
                    ->where('details->period_ended', $details['period_ended'])
                    ->where('subscription_id', $v->id)->first();

                if(!$bill){
                    //3A. IF BILLS NEVER BEEN ISSUED, WRITE DRAFT
                    $bill                   = new Bill;
                    $bill->user_id          = $v->user_id;
                    $bill->subscription_id  = $v->id;
                    $bill->lines            = $lines;
                    $bill->details          = $details;
                    $bill->save();

                }elseif($bill && is_null($bill->issued_at) && $v->ended_at <= $issued) {
                    //3B. IF THERE IS DRAFT BILL, ISSUED
                    $bill->issued_at    = $v->ended_at;
                    $bill->due_at       = Carbon::parse($v->ended_at)->addDays(config()->get('subscription.due_day'));
                    $bill->save();
                }
                
                DB::commit();
            }
        } catch (Exception $e) {
            \Log::info($e);
            DB::rollback();           
        }
    }
}
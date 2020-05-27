<?php

namespace Chelsymooy\Subscriptions\Http\Controllers;

use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Chelsymooy\Subscriptions\Models\Bill;
use Chelsymooy\Subscriptions\Models\Subscription;

/**
 * @group Dashboard
 *
 */
class DashboardController extends Controller {
    /**
     * Get
     *
     */
    public function index() {
        $users      = config()->get('auth.providers.users.model');

        $dashboard['stat']['users']     = (new $users())->count();
        $dashboard['last']['users']     = (new $users())->orderby('created_at', 'desc')->first()->created_at;
        $dashboard['stat']['invoices']  = Bill::wherenotnull('issued_at')->sum('amount');
        $dashboard['last']['invoices']  = Bill::wherenotnull('issued_at')->groupby('user_id')->count();
        $dashboard['stat']['bills']     = Bill::wherenotnull('issued_at')->wherenull('paid_at')->sum('amount');
        $dashboard['last']['bills']     = Bill::wherenotnull('issued_at')->wherenull('paid_at')->count();
        $dashboard['stat']['subs']      = Subscription::where('ended_at', '>', now())->count();
        $dashboard['last']['subs']      = Subscription::where('ended_at', '<=', now())->orderby('ended_at', 'desc')->first()->ended_at;

        $start      = now()->startofday()->subDays(6);
        $end        = now()->startofday()->addDays(1);
        $interval   = new \DateInterval('P1D');
        $period     = new \DatePeriod($start, $interval, $end);

        foreach ($period as $date) {
            $start  = Carbon::parse($date)->startofday();
            $end    = Carbon::parse($date)->endofday();
            $dashboard['label'][]          = $date->format('d');
            $dashboard['graph']['sales'][] = Bill::where('issued_at', '>=', $start)->where('issued_at', '<=', $end)->count();
            $dashboard['graph']['users'][] = (new $users())->where('created_at', '>=', $start)->where('created_at', '<=', $end)->count();
            $dashboard['graph']['unsubs'][]= Subscription::where('ended_at', '>=', $start)->where('ended_at', '<=', $end)->count();
        }
        
        if($dashboard['graph']['sales'][6] > $dashboard['graph']['sales'][5]){
            $dashboard['rate']['sales'] = ($dashboard['graph']['sales'][6]/max(1, $dashboard['graph']['sales'][5])) * 100;
        }else{
            $dashboard['rate']['sales'] = ($dashboard['graph']['sales'][5]/max(1, $dashboard['graph']['sales'][6])) * -100;
        }

        return view('subs::dashboard', compact('dashboard'));
    }
}

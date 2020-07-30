<?php

namespace Chelsymooy\Subscriptions\Http\Controllers;

use DB, Exception, Carbon\Carbon;
use App\Http\Controllers\Controller;

use Chelsymooy\Subscriptions\Models\Bill;
use Chelsymooy\Subscriptions\Models\PlanPrice;
use Chelsymooy\Subscriptions\Models\Subscription;

use Chelsymooy\Subscriptions\Http\Requests\CreateSubscriptionRequest;
use Chelsymooy\Subscriptions\Http\Requests\UpdateSubscriptionRequest;

/**
 * @group Dashboard
 *
 */
class SubscriptionController extends Controller {
    /**
     * Index
     *
     */
    public function index() {
        $subscriptions 	= Subscription::paginate();

        return view('subs::pages.subscription.index', compact('subscriptions'));
    }

    /**
     * Create
     *
     */
    public function create() {
        $users      = config()->get('auth.providers.users.model');
        $users      = (new $users())->select(['id', 'name'])->get();
        $prices     = PlanPrice::where('started_at', '<=', now())->select(['id', 'name', 'plan_id', 'price', 'discount'])
                    ->wherehas('plan', function($q){$q;})->with(['plan'])->orderby('started_at', 'desc')->get();

        $subscription   = [
            'user_id'       => null,
            'plan_price_id' => null,
            'started_at'    => now(),
            'ended_at'      => null,
            'settings'      => [
                'issuer_name'   => config()->get('subscription.issuer.issuer_name'),
                'issuer_address'=> config()->get('subscription.issuer.issuer_address'),
                'issuer_phone'  => config()->get('subscription.issuer.issuer_phone'),
                'customer_name'     => '',
                'customer_address'  => '',
                'customer_phone'    => '',
                'customer_logo'     => '',
                'customer_website'  => '',
                'recurring_toggle'  => true,
                'bank_name'     => config()->get('subscription.payment_info.bank_name'),
                'bank_currency' => config()->get('subscription.payment_info.bank_currency'),
                'account_no'    => config()->get('subscription.payment_info.account_no'),
                'account_name'  => config()->get('subscription.payment_info.account_name')
            ]
        ];
        return view('subs::pages.subscription.create', compact('prices', 'users', 'subscription'));
    }

    /**
     * Store
     *
     */
    public function store(CreateSubscriptionRequest $request)  {
        /*----------  Validate  ----------*/
        $request->validated();

        $input  = $request->only('settings');
        if(!$input['settings']['recurring_toggle']){
            $input['settings']['recurring_toggle']  = false;
        }else{
            $input['settings']['recurring_toggle']  = true;
        }

        /*----------  Process  ----------*/
        try {
	       	DB::beginTransaction();
            $price  = PlanPrice::findorfail($request->get('plan_price_id'));

            $user   = config()->get('auth.providers.users.model');
            $user   = (new $user())->where('id', $request->get('user_id'))->firstorfail();

            $sub    = $user->subscribe($price, Carbon::parse($request->get('started_at')), $input['settings']);

	       	DB::commit();

	        return redirect()->route('subs.subscriptions.show', $sub->id);
        } catch (Exception $e) {
	       	DB::rollback();
			return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Show
     *
     */
    public function show($id) {
        $subscription	= Subscription::findorfail($id);
        $bills			= Bill::where('subscription_id', $id)->paginate();

        return view('subs::pages.subscription.show', compact('subscription', 'bills'));
    }

    /**
     * Edit
     *
     */
    public function edit($id) {
        $users      = config()->get('auth.providers.users.model');
        $users      = (new $users())->select(['id', 'name'])->get();
        $prices     = PlanPrice::where('started_at', '<=', now())->select(['id', 'name', 'plan_id', 'price', 'discount'])
                    ->wherehas('plan', function($q){$q;})->with(['plan'])->orderby('started_at', 'desc')->get();

        $subscription       = Subscription::findorfail($id);

        return view('subs::pages.subscription.edit', compact('subscription', 'users', 'prices'));
    }

    /**
     * Update
     *
     */
    public function update($id, UpdateSubscriptionRequest $request)  {

        /*----------  Validate  ----------*/
        $request->validated();
        $input  = $request->only('ended_at', 'settings');
        if(!$input['settings']['recurring_toggle']){
            $input['settings']['recurring_toggle']  = false;
        }else{
            $input['settings']['recurring_toggle']  = true;
        }

        /*----------  Process  ----------*/
        try {
            DB::beginTransaction();
            $subscription       = Subscription::findorfail($id);
            $subscription->fill($input);
            $subscription->save();
            
            DB::commit();

            return redirect()->route('subs.subscriptions.show', $subscription->id);
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Delete
     *
     */
    public function destroy($id)  {
        exit;
        /*----------  Process  ----------*/
        try {
            DB::beginTransaction();
            $subscription       = Subscription::findorfail($id);
            $subscription->delete();
            
            DB::commit();

            return redirect()->route('subs.subscriptions.index');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}

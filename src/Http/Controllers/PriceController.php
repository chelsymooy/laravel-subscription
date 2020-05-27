<?php

namespace Chelsymooy\Subscriptions\Http\Controllers;

use DB, Exception;
use App\Http\Controllers\Controller;

use Chelsymooy\Subscriptions\Models\PlanPrice;

use Chelsymooy\Subscriptions\Http\Requests\CreatePriceRequest;
use Chelsymooy\Subscriptions\Http\Requests\UpdatePriceRequest;

/**
 * @group Dashboard
 *
 */
class PriceController extends Controller {

    /**
     * Create
     *
     */
    public function create($plan_id) {

        $price  = [
            'id'        => null,
            'plan_id'   => $plan_id,
            'name'      => 'Publish Rate',
            'price'     => 0,
            'discount'  => 0,
            'recurring_opt'       => 'day',
            'recurring_val'       => 1,
            'penalty_rate'        => 0,
            'penalty_period_opt'  => 'day',
            'penalty_period_val'  => 1,
            'started_at'          => now(),
            'ended_at'            => null
        ];

        return view('subs::pages.plan.price.create', compact('plan_id', 'price'));
    }

    /**
     * Store
     *
     */
    public function store($plan_id, CreatePriceRequest $request)  {

        /*----------  Validate  ----------*/
        $request->validated();

        /*----------  Process  ----------*/
        try {
	       	DB::beginTransaction();
	       	$price 		= (new PlanPrice)->fill($request->get('price'));
	       	$price->plan_id = $plan_id;
	       	$price->save();
	       	DB::commit();

	        return redirect()->route('subs.plans.show', $plan_id);
        } catch (Exception $e) {
	       	DB::rollback();
			return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Edit
     *
     */
    public function edit($plan_id, $id) {
        $price  = PlanPrice::where('id', $id)->where('plan_id', $plan_id)->firstorfail();

        return view('subs::pages.plan.price.edit', compact('price', 'plan_id'));
    }

    /**
     * Update
     *
     */
    public function update($plan_id, $id, UpdatePriceRequest $request)  {

        /*----------  Validate  ----------*/
        $request->validated();

        /*----------  Process  ----------*/
        try {
            DB::beginTransaction();
            $price  = PlanPrice::where('id', $id)->where('plan_id', $plan_id)->firstorfail();
            $price->fill($request->get('price'));
            $price->save();
            
            DB::commit();

            return redirect()->route('subs.plans.show', $plan_id);
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Delete
     *
     */
    public function destroy($plan_id, $id)  {

        /*----------  Process  ----------*/
        try {
            DB::beginTransaction();
            $price  = PlanPrice::where('id', $id)->where('plan_id', $plan_id)->firstorfail();
            $price->delete();
            
            DB::commit();

            return redirect()->route('subs.plans.show', $plan_id);
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}

<?php

namespace Chelsymooy\Subscriptions\Http\Controllers;

use DB, Exception;
use App\Http\Controllers\Controller;
use Chelsymooy\Subscriptions\Models\Plan;
use Chelsymooy\Subscriptions\Models\PlanPrice;

use Chelsymooy\Subscriptions\Http\Requests\CreatePlanRequest;
use Chelsymooy\Subscriptions\Http\Requests\UpdatePlanRequest;

/**
 * @group Dashboard
 *
 */
class PlanController extends Controller {
    /**
     * Index
     *
     */
    public function index() {
        $plans 	= Plan::paginate();

        return view('subs::pages.plan.index', compact('plans'));
    }

    /**
     * Create
     *
     */
    public function create() {
        $plan   = [
            'id'        => null, 
            'project_id'=> null, 
            'name'      => null, 
            'is_active' => true, 
            'features'  => [
                    [
                        'title'             => null,
                        'code'              => null,
                        'is_available'      => true
                    ]
                ]
            ];
        $price  = [
            'id'        => null,
            'plan_id'   => null,
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
        return view('subs::pages.plan.create', compact('plan', 'price'));
    }

    /**
     * Store
     *
     */
    public function store(CreatePlanRequest $request)  {

        /*----------  Validate  ----------*/
        $request->validated();

        /*----------  Process  ----------*/
        try {
	       	DB::beginTransaction();
	       	$plan 		= (new Plan)->fill($request->only('name', 'is_active', 'project_id'));
            //PARSING FEATURES
            $tmp        = $request->get('features');
            $features   = [];
            foreach ($tmp['title'] as $k => $v) {
                $features[]     = [
                    'title'        => $v, 
                    'code'         => $tmp['code'][$k],
                    'is_available' => (isset($tmp['is_available']) && isset($tmp['is_available'][$k]) ? true : false)
                ];
            }
            $plan->features    = $features;
            $plan->save();
	       	
	       	$price             = (new PlanPrice)->fill($request->get('price'));
	       	$price->plan_id    = $plan->id;
	       	$price->save();
	       	DB::commit();

	        return redirect()->route('subs.plans.show', $plan->id);
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
        $plan       = Plan::findorfail($id);
        $prices     = PlanPrice::where('plan_id', $id)->paginate();

        return view('subs::pages.plan.show', compact('plan', 'prices'));
    }

    /**
     * Edit
     *
     */
    public function edit($id) {
        $plan       = Plan::findorfail($id);

        return view('subs::pages.plan.edit', compact('plan'));
    }

    /**
     * Update
     *
     */
    public function update($id, UpdatePlanRequest $request)  {

        /*----------  Validate  ----------*/
        $request->validated();

        /*----------  Process  ----------*/
        try {
            DB::beginTransaction();
            $plan       = Plan::findorfail($id);
            $plan->fill($request->only('name', 'is_active'));
            //PARSING FEATURES
            $tmp        = $request->get('features');
            $features   = [];
            foreach ($tmp['title'] as $k => $v) {
                $features[]     = [
                    'title'        => $v, 
                    'code'         => $tmp['code'][$k],
                    'is_available' => (isset($tmp['is_available']) && isset($tmp['is_available'][$k]) ? true : false)
                ];
            }

            $plan->features    = $features;
            $plan->save();
            
            DB::commit();

            return redirect()->route('subs.plans.show', $plan->id);
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

        /*----------  Process  ----------*/
        try {
            DB::beginTransaction();
            $plan       = Plan::findorfail($id);
            $plan->delete();
            
            DB::commit();

            return redirect()->route('subs.plans.index');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}

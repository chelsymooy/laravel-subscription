<?php

namespace Chelsymooy\Subscriptions\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Chelsymooy\Subscriptions\Models\Plan;

/**
 * @group API
 *
 */
class PlanAPIController extends Controller {
    /**
     * Index
     *
     */
    public function index() {
        $plans 	    = Plan::where('is_active', true);

        if(request()->has('project_id')){
            $plans  = $plans->where('project_id', request()->get('project_id'));
        }

        $plans      = $plans->with(['price'])->paginate();

        return response()->json([
            'status' => true,
            'data'   => $plans,
            'message'=> 'Data successfully retrieved'
        ]);
    }
}

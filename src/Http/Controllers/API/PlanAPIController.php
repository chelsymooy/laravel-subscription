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
        $plans 	    = Plan::where('is_active', true)->with(['price'])->paginate();

        return response()->json([
            'status' => true,
            'data'   => $plans,
            'message'=> 'Data successfully retrieved'
        ]);
    }
}

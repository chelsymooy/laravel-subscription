<?php

namespace Chelsymooy\Subscriptions\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Chelsymooy\Subscriptions\Models\Bill;

/**
 * @group API
 *
 */
class BillAPIController extends Controller {
    /**
     * Index
     *
     */
    public function index($subscription_id) {
        //GET
        $bills  = [];

        return response()->json([
            'status' => true,
            'data'   => $bills,
            'message'=> 'Data successfully retrieved'
        ]);
    }
}

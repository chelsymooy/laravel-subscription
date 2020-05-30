<?php

namespace Chelsymooy\Subscriptions\Http\Controllers\API;

use Auth;
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
        $bill    = Bill::where('user_id', Auth::user()->id)->orderby('created_at', 'desc')->paginate();

        return response()->json([
            'status' => true,
            'data'   => $bill,
            'message'=> 'Data successfully retrieved'
        ]);

        return response()->json([
            'status' => true,
            'data'   => $bills,
            'message'=> 'Data successfully retrieved'
        ]);
    }
}

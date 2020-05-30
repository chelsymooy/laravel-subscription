<?php

namespace Chelsymooy\Subscriptions\Http\Controllers\API;

use DB, Exception, Auth;

use App\Http\Controllers\Controller;
use Chelsymooy\Subscriptions\Models\Subscription;

/**
 * @group API
 *
 */
class SubscriptionAPIController extends Controller {
    /**
     * Show
     *
     */
    public function show($id) {
        //GET SUBSCRIPTION
        $sub    = Subscription::where('user_id', Auth::user()->id)->orderby('created_at', 'desc')->paginate();

        return response()->json([
            'status' => true,
            'data'   => $sub,
            'message'=> 'Data successfully retrieved'
        ]);
    }

    /**
     * Update
     *
     */
    public function update($id, UpdateSubscriptionAPIRequest $request) {
        try {

            $uid    = Auth::user()->id;
            $input  = $request->only('settings');

            if(!$input['settings']['recurring_toggle']){
                $input['settings']['recurring_toggle']  = false;
            }else{
                $input['settings']['recurring_toggle']  = true;
            }

            $subscription       = Subscription::where('id', $id)->where('user_id', $uid)->firstorfail();
            $settings           = array_merge($subscription->settings, $input['settings']);

            DB::beginTransaction();

            $subscription->settings     = $settings;
            $subscription->save();
            
            DB::commit();

            return response()->json([
                'status' => true,
                'data'   => $subscription,
                'message'=> 'Data successfully updated'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data'   => [],
                'message'=> $e->getMessage()
            ]);
        }
    }
}

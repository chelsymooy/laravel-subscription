<?php

namespace Chelsymooy\Subscriptions\Http\Controllers;

use DB, Exception;
use App\Http\Controllers\Controller;

use Chelsymooy\Subscriptions\Models\Bill;

use Chelsymooy\Subscriptions\Http\Requests\CreateBillRequest;
use Chelsymooy\Subscriptions\Http\Requests\UpdateBillRequest;

/**
 * @group Dashboard
 *
 */
class BillController extends Controller {

    /**
     * Show
     *
     */
    public function show($subscription_id, $id) {
        $bill  = Bill::where('id', $id)->where('subscription_id', $subscription_id)->firstorfail();
        
        return view('subs::pdf.invoice', compact('bill', 'subscription_id'));
    }

    /**
     * Edit
     *
     */
    public function edit($subscription_id, $id) {
        $bill  = Bill::where('id', $id)->where('subscription_id', $subscription_id)->firstorfail();

        return view('subs::pages.subscription.bill.edit', compact('bill', 'subscription_id'));
    }

    /**
     * Update
     *
     */
    public function update($subscription_id, $id, UpdateBillRequest $request)  {

        /*----------  Validate  ----------*/
        $request->validated();

        /*----------  Process  ----------*/
        try {
            DB::beginTransaction();
            $bill  = Bill::where('id', $id)->where('subscription_id', $subscription_id)->firstorfail();
            $bill->fill($request->get('details'));

            $tmp        = $request->get('lines');
            $lines      = [];
            foreach ($tmp['item'] as $k => $v) {
                $lines[]     = [
                    'item'      => $v, 
                    'qty'       => $tmp['qty'][$k],
                    'unit'      => $tmp['unit'][$k],
                    'price'     => $tmp['price'][$k],
                    'discount'  => $tmp['discount'][$k],
                ];
            }

            $bill->lines    = $lines;
            $bill->save();
            
            DB::commit();

            return redirect()->route('subs.subscriptions.show', $subscription_id);
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Pay
     *
     */
    public function pay($subscription_id, $id)  {

        /*----------  Process  ----------*/
        try {
            DB::beginTransaction();
            $bill  = Bill::where('id', $id)->where('subscription_id', $subscription_id)->wherenull('paid_at')->firstorfail();
            $bill->paid_at  = now();
            $bill->save();
            
            DB::commit();

            return redirect()->route('subs.subscriptions.show', [$subscription_id, $id]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}

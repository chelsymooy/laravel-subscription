@extends('subs::layouts.app', ['activePage' => 'subscriptions', 'titlePage' => __('Detail subscription')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Detail subscriptions</h4>
            <p class="card-category"> Display specific subscription</p>
          </div>
          <div class="card-body">
            <div class="clearfix">&nbsp;</div>
            <div class="row">
              <div class="col-6 text-left">
                <a href="{{ route('subs.subscriptions.index') }}" class="btn btn-sm btn-primary">Back<div class="ripple-container"></div></a>
              </div>
              <div class="col-6 text-right">
                <a href="{{ route('subs.subscriptions.edit', $subscription->id) }}" class="btn btn-sm btn-primary">Edit<div class="ripple-container"></div></a>
              </div>
            </div>

            <div class="clearfix">&nbsp;</div>

            <div class="row">
              <div class="col-sm-2">
                Plan
              </div>
              <div class="col-sm-7">
                {{ $subscription->price->plan->name }} for {{ $subscription->user->name }} | 
                <small><i>since {{$subscription->started_at->format('Y-m-d')}}</i></small> | 
                <small><i>ended {{ $subscription->ended_at->format('Y-m-d') }} {!! ($subscription->settings['recurring_toggle'] ? '<span class="badge badge-info">recurring plan</span>' : '<span class="badge badge-warning">terminate</span>') !!}</i></small>
              </div>
            </div>
            
            <div class="clearfix">&nbsp;</div>

            <div class="row">
              <div class="col-sm-2">
                Pricing
              </div>
              <div class="col-sm-7"> 
                @if($subscription->price->discount > 0) 
                  <strike>{{ $subscription->price->price }}</strike> {{$subscription->price->net}}
                @else 
                  {{ $subscription->price->price }} 
                @endif
                ({{ $subscription->price->name }}) | 
                Fine {{ $subscription->price->penalty_rate }} every {{$subscription->price->penalty_period_val}} {{$subscription->price->penalty_period_opt}} (s)
              </div>
            </div>

            <div class="clearfix">&nbsp;</div>

            <div class="row">
              <div class="col-sm-2">
                Billing Information
              </div>
              <div class="col-sm-7"> 
                {{$subscription->settings['customer_name']}} ({{$subscription->settings['customer_name']}}) <br/>
                {{$subscription->settings['customer_address']}} 
              </div>
            </div>

            <div class="clearfix">&nbsp;</div>

            <div class="row">
              <div class="col-sm-2">
                Issuer Information
              </div>
              <div class="col-sm-7"> 
                {{$subscription->settings['issuer_name']}} ({{$subscription->settings['issuer_name']}}) <br/>
                {{$subscription->settings['issuer_address']}} 
              </div>
            </div>

            <div class="clearfix">&nbsp;</div>

            <div class="row">
              <div class="col-sm-2">
                Payment Information
              </div>
              <div class="col-sm-7"> 
                {{$subscription->settings['bank_name']}} ({{$subscription->settings['bank_currency']}}) <br/>
                {{$subscription->settings['account_no']}} - {{$subscription->settings['account_name']}} 
              </div>
            </div>

            <div class="clearfix">&nbsp;</div>

            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th> ID </th>
                  <th> # </th>
                  <th> Billed To </th>
                  <th> Amount </th>
                  <th> &nbsp; </th>
                </thead>
                <tbody>
                  @forelse($bills as $bill)
                    <tr>
                      <td>{{$bill->id}}</td>
                      <td>
                        {{ $bill->no }}
                      </td>
                      <td>
                        {{ $bill->details['customer_name'] }} ({{ $bill->details['customer_address'] }}) <br/>
                        {{ $bill->details['customer_phone'] }}
                      </td>
                      <td>
                        {{$bill->total}}
                      </td>
                      <td>
                        <form method="post" action="{{route('subs.bills.pay', [$subscription->id, $bill->id])}}">
                          @method('PATCH')
                          @if($bill->issued_at)
                            <a href="#" class="btn btn-sm btn-disabled">Edit<div class="ripple-container"></div></a>
                          @else
                            <a href="{{ route('subs.bills.edit', [$subscription->id, $bill->id]) }}" class="btn btn-sm btn-primary">Edit<div class="ripple-container"></div></a>
                          @endif

                          @if($bill->issued_at)
                            <a href="{{ route('subs.bills.show', [$subscription->id, $bill->id]) }}" class="btn btn-sm btn-primary" target="__blank">Print Invoice<div class="ripple-container"></div></a>
                          @else
                            <a href="#" class="btn btn-sm btn-disabled">Print Invoice<div class="ripple-container"></div></a>
                          @endif
                          @if($bill->issued_at && is_null($bill->paid_at))
                            <button class="btn btn-sm btn-primary">Mark as paid<div class="ripple-container"></div></button>
                          @else
                            <a href="#" class="btn btn-sm btn-disabled">Mark as Paid<div class="ripple-container"></div></a>
                          @endif
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <tr> <td colspan="7"><small><i class="text-gray">No data</i></small></td> </tr>
                    </tr>
                  @endforelse
                </tbody>
                <tfoot>
                  {{ $bills->links() }}
                </tfoot>
              </table>
            </div>
          </div>
          <div class="clearfix">&nbsp;</div>  
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

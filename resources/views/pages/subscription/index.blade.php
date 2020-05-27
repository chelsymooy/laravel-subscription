@extends('subs::layouts.app', ['activePage' => 'subscriptions', 'titlePage' => __('All subscription')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">All subscriptions</h4>
            <p class="card-category"> Display all subscriptions</p>
          </div>
          <div class="card-body">
            <div class="clearfix">&nbsp;</div>
            <div class="row">
              <div class="col-12 text-right">
                <a href="{{ route('subs.subscriptions.create') }}" class="btn btn-sm btn-primary">New subscription<div class="ripple-container"></div></a>
              </div>
            </div>

            <div class="clearfix">&nbsp;</div>

            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th> ID </th>
                  <th> User </th>
                  <th> Plan </th>
                  <th> Price </th>
                  <th> Ended </th>
                  <th> &nbsp; </th>
                </thead>
                <tbody>
                  @forelse($subscriptions as $subscription)
                    <tr>
                      <td> {{ $subscription->id }} </td>
                      <td>
                        {{ $subscription->user->name }}
                      </td>
                      <td>
                        {{ $subscription->price->plan->name }}
                      </td>
                      <td> 
                        @if($subscription->price->discount > 0) 
                          <strike>{{ $subscription->price->price }}</strike> {{$subscription->price->net}}
                        @else 
                          {{ $subscription->price->price }} 
                        @endif
                        ({{ $subscription->price->name }})
                      </td>
                      <td>
                        {{ $subscription->ended_at->format('Y-m-d') }} {!! ($subscription->settings['recurring_toggle'] ? '<span class="badge badge-info">recurring plan</span>' : '<span class="badge badge-warning">terminate</span>') !!}
                      </td>
                      <td> <a href="{{route('subs.subscriptions.show', $subscription->id)}}" class="btn btn-sm btn-primary">Detail</a> </td>
                    </tr>
                  @empty
                    <tr> <td colspan="5"><small><i class="text-gray">No data</i></small></td> </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            <div class="row">
              <div class="col-12 right-pagination">
                {{ $subscriptions->links() }}
              </div>
            </div>
          </div>
          <div class="clearfix">&nbsp;</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

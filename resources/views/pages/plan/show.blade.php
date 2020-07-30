@extends('subs::layouts.app', ['activePage' => 'plans', 'titlePage' => __('Detail Plan')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Detail Plans</h4>
            <p class="card-category"> Display specific plan</p>
          </div>
          <div class="card-body">
            <div class="clearfix">&nbsp;</div>
            <div class="row">
              <div class="col-6 text-left">
                <a href="{{ route('subs.plans.index') }}" class="btn btn-sm btn-primary">Back<div class="ripple-container"></div></a>
              </div>
              <div class="col-6 text-right">
                <form method="post" action="{{route('subs.plans.destroy', [$plan->id])}}">
                @method('DELETE')
                <button class="btn btn-sm btn-danger">Delete<div class="ripple-container"></div></button>
                <a href="{{ route('subs.plans.edit', $plan->id) }}" class="btn btn-sm btn-primary">Edit<div class="ripple-container"></div></a>
                <a href="{{ route('subs.prices.create', $plan->id) }}" class="btn btn-sm btn-primary">New Price<div class="ripple-container"></div></a>
                </form>
              </div>
            </div>

            <div class="clearfix">&nbsp;</div>

            <div class="row">
              <div class="col-sm-2">
                Name
              </div>
              <div class="col-sm-7">
                {{ $plan->name }} {!! $plan->is_active ? '<span class="badge badge-primary">active</span>' : '<span class="badge badge-default">inactive</span>' !!}</p>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                Feature
              </div>
              <div class="col-sm-7">
                @forelse($plan->features as $feature)
                  {{ $feature['title'] }} [{{ $feature['code'] }}] {!! $feature['is_available'] ? '<span class="badge badge-primary">available</span>' : '<span class="badge badge-default">unavailable</span>' !!} <br/>
                @empty
                  <small><i class="text-gray">No data</i></small>
                @endforelse
              </div>
            </div>

            <div class="clearfix">&nbsp;</div>

            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th> ID </th>
                  <th> Name </th>
                  <th> Price </th>
                  <th> Penalty </th>
                  <th> Recurring </th>
                  <th> Period </th>
                  <th> &nbsp; </th>
                </thead>
                <tbody>
                  @forelse($prices as $price)
                    <tr>
                      <td>
                        {{ $price->id }}
                      </td>
                      <td>
                        {{ $price->name }}
                      </td>
                      <td>
                        @if($price->discount > 0) <strike>{{ $price->price }}</strike> {{$price->net}}
                        @else {{ $price->price }} @endif
                      </td>
                      <td>
                        Fine {{ $price->penalty_rate }} every {{$price->penalty_period_val}} {{$price->penalty_period_opt}} (s)
                      </td>
                      <td>
                        Bill every {{$price->recurring_val}} {{$price->recurring_opt}} (s)
                      </td>
                      <td>
                        {{$price->started_at->format('Y/m/d')}} - {{($price->ended_at ? $price->ended_at->format('Y/m/d') : 'now')}}
                      </td>
                      <td>
                        <form method="post" action="{{route('subs.prices.destroy', [$plan->id, $price->id])}}">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-sm btn-danger">Delete<div class="ripple-container"></div></button>
                          <a href="{{ route('subs.prices.edit', [$plan->id, $price->id]) }}" class="btn btn-sm btn-primary">Edit<div class="ripple-container"></div></a>
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
                  {{ $prices->links() }}
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

@extends('subs::layouts.app', ['activePage' => 'plans', 'titlePage' => __('All Plan')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">All Plans</h4>
            <p class="card-category"> Display all plans</p>
          </div>
          <div class="card-body">
            <div class="clearfix">&nbsp;</div>
            <div class="row">
              <div class="col-12 text-right">
                <a href="{{ route('subs.plans.create') }}" class="btn btn-sm btn-primary">New Plan<div class="ripple-container"></div></a>
              </div>
            </div>

            <div class="clearfix">&nbsp;</div>

            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th> ID </th>
                  <th> Name </th>
                  <th> Features </th>
                  <th> Price </th>
                  <th> &nbsp; </th>
                </thead>
                <tbody>
                  @forelse($plans as $plan)
                    <tr>
                      <td> {{ $plan->id }} </td>
                      <td>
                        {{ $plan->name }} {!! $plan->is_active ? '<span class="badge badge-primary">active</span>' : '<span class="badge badge-default">inactive</span>' !!}
                      </td>
                      <td>
                        @forelse($plan->features as $feature)
                          {{ $feature['title'] }} [{{ $feature['code'] }}] {!! $feature['is_available'] ? '<span class="badge badge-primary">available</span>' : '<span class="badge badge-default">unavailable</span>' !!} <br/>
                        @empty
                          <small><i class="text-gray">No data</i></small>
                        @endforelse
                      </td>
                      <td> {{ $plan->price->price }} </td>
                      <td> <a href="{{route('subs.plans.show', $plan->id)}}" class="btn btn-sm btn-primary">Detail</a> </td>
                    </tr>
                  @empty
                    <tr> <td colspan="5"><small><i class="text-gray">No data</i></small></td> </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            <div class="row">
              <div class="col-12 right-pagination">
                {{ $plans->links() }}
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

@extends('subs::layouts.app', ['activePage' => 'plans', 'titlePage' => __('Edit Plan')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{route('subs.plans.update', [$plan->id])}}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('PATCH')
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">Edit Plan</h4>
                <p class="card-category">Edit existing plan</p>
              </div>
              <div class="card-body">
                <div class="clearfix">&nbsp;</div>
                <div class="row">
                  <div class="col-6 text-left">
                    <a href="{{ route('subs.plans.index') }}" class="btn btn-sm btn-primary">Back<div class="ripple-container"></div></a>
                  </div>
                </div>

                <div class="clearfix">&nbsp;</div>
                @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
                @endif
                @include('subs::pages.plan.fields')
                <div class="clearfix">&nbsp;</div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
              <div class="clearfix">&nbsp;</div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

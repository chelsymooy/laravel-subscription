@extends('subs::layouts.app', ['activePage' => 'plans', 'titlePage' => __('New Plan')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{route('subs.plans.store')}}" autocomplete="off" class="form-horizontal">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">New Plan</h4>
                <p class="card-category">Create new plan & price</p>
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
                <div class="row">
                  <label class="col-sm-12 col-form-label">Plan Information</label>
                </div>
                @include('subs::pages.plan.fields')
                <div class="row">
                  <label class="col-sm-12 col-form-label">Price Information</label>
                </div>
                @include('subs::pages.plan.price.fields')
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

@extends('subs::layouts.app', ['activePage' => 'subscriptions', 'titlePage' => __('Edit subscription')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{route('subs.subscriptions.update', [$subscription->id])}}" autocomplete="off" class="form-horizontal">
            @method('PATCH')
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">Edit subscription</h4>
                <p class="card-category">Edit existing subscription</p>
              </div>
              <div class="card-body ">
                <div class="clearfix">&nbsp;</div>
                <div class="row">
                  <div class="col-6 text-left">
                    <a href="{{ route('subs.subscriptions.index') }}" class="btn btn-sm btn-primary">Back<div class="ripple-container"></div></a>
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
                @include('subs::pages.subscription.fields')
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

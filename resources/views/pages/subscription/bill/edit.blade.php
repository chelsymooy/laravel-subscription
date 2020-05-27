@extends('subs::layouts.app', ['activePage' => 'subscriptions', 'titlePage' => __('Edit Bill')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{route('subs.bills.update', [$subscription_id, $bill->id])}}" autocomplete="off" class="form-horizontal">
            @method('PATCH')
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">Edit Bill</h4>
                <p class="card-category">Edit existing bill allowed before issued</p>
              </div>
              <div class="card-body ">
                @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
                @endif
                @include('subs::pages.subscription.bill.fields')
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

<div class="row">
  <label class="col-sm-2 col-form-label">User</label>
  <div class="col-sm-7">
    <div class="form-group bmd-form-group is-filled">
      <select class="form-control" name="user_id" id="input-user_id" required="true" aria-required="true">
    		@foreach($users as $v)
		        <option value="{{$v->id}}" @if($subscription['user_id'] === $v->id) selected @endif>{{$v->name}}</option>
    		@endforeach
        </select>
    </div>
  </div>
</div>

<div class="row">
  <label class="col-sm-2 col-form-label">Plan Price</label>
  <div class="col-sm-7">
    <div class="form-group bmd-form-group is-filled">
    	<select class="form-control" name="plan_price_id" id="input-plan_price_id" required="true" aria-required="true">
    		@foreach($prices as $v)
		        <option value="{{$v->id}}" @if($subscription['plan_price_id'] === $v->id) selected @endif>{{$v->name}} - {{$v->plan->name}} ({{$v->net}})</option>
    		@endforeach
        </select>
    </div>
  </div>
</div>

<div class="row">
  <label class="col-sm-2 col-form-label">Period</label>
  <div class="col-sm-3">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="started_at" id="input-started_at" type="date" value="{{$subscription['started_at']->format('Y-m-d')}}" required="true" aria-required="true">
    </div>
  </div>
  <div class="col-sm-4">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="ended_at" id="input-ended_at" type="date" value="{{$subscription['ended_at'] ? $subscription['ended_at']->format('Y-m-d') : null}}">
    </div>
  </div>
</div>

<div class="row">
  <label class="col-sm-2 col-form-label">Issuer Information</label>
  <div class="col-sm-4">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="settings[issuer_name]" id="input-settings-issuer_name" type="text" value="{{$subscription['settings']['issuer_name']}}" readonly=true>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="settings[issuer_phone]" id="input-settings-issuer_phone" type="text" value="{{$subscription['settings']['issuer_phone']}}" readonly=true>
    </div>
  </div>
</div>
<div class="row">
  <label class="col-sm-2 col-form-label">&nbsp;</label>
  <div class="col-sm-7">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="settings[issuer_address]" id="input-settings-issuer_address" type="text" value="{{$subscription['settings']['issuer_address']}}" readonly=true>
    </div>
  </div>
</div>

<div class="row">
  <label class="col-sm-2 col-form-label">Billing Information</label>
  <div class="col-sm-3">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="settings[customer_name]" id="input-settings-customer_name" type="text" placeholder="Customer" value="{{$subscription['settings']['customer_name']}}" required="true" aria-required="true">
    </div>
  </div>
  <div class="col-sm-4">
    <div class="input-group form-group bmd-form-group is-filled">
      <input class="form-control" name="settings[customer_phone]" id="input-settings-customer_phone" type="text" placeholder="081234567890" value="{{$subscription['settings']['customer_phone']}}" required="true" aria-required="true">

      <div class="input-group-append">
        <div class="form-group form-check bmd-form-group is-filled pt-2">
          <label class="form-check-label">
            @if($subscription['settings']['recurring_toggle'])
              <input class="form-check-input" name="settings[recurring_toggle]" type="checkbox" value=1 checked="true">
            @else
              <input class="form-check-input" name="settings[recurring_toggle]" type="checkbox" value=1>
            @endif
            Recurring
            <span class="form-check-sign">
              <span class="check"></span>
            </span>
          </label>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <label class="col-sm-2 col-form-label">&nbsp;</label>
  <div class="col-sm-7">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="settings[customer_address]" id="input-settings-customer_address" type="text" placeholder="Vernon Building" value="{{$subscription['settings']['customer_address']}}" required="true" aria-required="true">
    </div>
  </div>
</div>

<div class="row">
  <label class="col-sm-2 col-form-label">Payment Information</label>
  <div class="col-sm-2">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="settings[bank_name]" id="input-settings-bank_name" type="text" value="{{$subscription['settings']['bank_name']}}" readonly=true>
    </div>
  </div>
  <div class="col-sm-1">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="settings[bank_currency]" id="input-settings-bank_currency" type="text" value="{{$subscription['settings']['bank_currency']}}" readonly=true>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="settings[account_no]" id="input-settings-account_no" type="text" value="{{$subscription['settings']['account_no']}}" readonly=true>
    </div>
  </div>
</div>
<div class="row">
  <label class="col-sm-2 col-form-label">&nbsp;</label>
  <div class="col-sm-7">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="settings[account_name]" id="input-settings-account_name" type="text" value="{{$subscription['settings']['account_name']}}" readonly=true>
    </div>
  </div>
</div>

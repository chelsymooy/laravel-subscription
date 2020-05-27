<div class="row">
  <label class="col-sm-2 col-form-label">Name</label>
  <div class="col-sm-7">
    <div class="form-group bmd-form-group is-filled">
      <input class="form-control" name="price[name]" id="input-price-name" type="text" placeholder="Normal" value="{{$price['name']}}" required="true" aria-required="true">
    </div>
  </div>
</div>
<div class="row">
  <label class="col-sm-2 col-form-label">Price</label>
  <div class="col-sm-7">
    <div class="form-group bmd-form-group is-filled">
      <input class="form-control" name="price[price]" id="input-price-price" type="text" placeholder="0" value="{{$price['price']}}" required="true" aria-required="true">
    </div>
  </div>
</div>
<div class="row">
  <label class="col-sm-2 col-form-label">Discount</label>
  <div class="col-sm-7">
    <div class="form-group bmd-form-group is-filled">
      <input class="form-control" name="price[discount]" id="input-price-discount" type="text" placeholder="0" value="{{$price['discount']}}" required="true" aria-required="true">
    </div>
  </div>
</div>
<div class="row">
  <label class="col-sm-2 col-form-label">Recurring Information</label>
  <div class="col-sm-1">
    <div class="form-group bmd-form-group is-filled"> 
      <label class="form-control">Every</label>
    </div>
  </div>
  <div class="col-sm-1">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="price[recurring_val]" id="input-price-recurring_val" type="text" placeholder="1" value="{{$price['recurring_val']}}" required="true" aria-required="true">
    </div>
  </div>
  <div class="col-sm-5">
    <div class="form-group bmd-form-group is-filled"> 
      <select class="form-control" name="price[recurring_opt]" id="input-price-recurring_opt" required="true" aria-required="true">
        <option value="day" @if($price['recurring_opt'] === "day") selected @endif>Day</option>
        <option value="month" @if($price['recurring_opt'] === "month") selected @endif>Month</option>
        <option value="year" @if($price['recurring_opt'] === "year") selected @endif>Year</option>
      </select>
    </div>
  </div>
</div>
<div class="row">
  <label class="col-sm-2 col-form-label">Penalty Information</label>
  <div class="col-sm-1">
    <div class="form-group bmd-form-group is-filled"> 
      <label class="form-control">Fine</label>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="price[penalty_rate]" id="input-price-penalty_rate" type="text" placeholder="0" value="{{$price['penalty_rate']}}" required="true" aria-required="true">
    </div>
  </div>
  <div class="col-sm-1">
    <div class="form-group bmd-form-group is-filled"> 
      <label class="form-control">Every</label>
    </div>
  </div>
  <div class="col-sm-1">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="price[penalty_period_val]" id="input-price-penalty_period_val" type="text" placeholder="1" value="{{$price['penalty_period_val']}}" required="true" aria-required="true">
    </div>
  </div>
  <div class="col-sm-2">
    <div class="form-group bmd-form-group is-filled"> 
      <select class="form-control" name="price[penalty_period_opt]" id="input-price-penalty_period_opt" required="true" aria-required="true">
        <option value="day" @if($price['penalty_period_opt'] === "day") selected @endif>Day</option>
        <option value="month" @if($price['penalty_period_opt'] === "month") selected @endif>Month</option>
        <option value="year" @if($price['penalty_period_opt'] === "year") selected @endif>Year</option>
      </select>
    </div>
  </div>
</div>
<div class="row">
  <label class="col-sm-2 col-form-label">Period</label>
  <div class="col-sm-3">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="price[started_at]" id="input-price-started_at" type="date" value="{{$price['started_at']->format('Y-m-d')}}" required="true" aria-required="true">
    </div>
  </div>
  <div class="col-sm-4">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="price[ended_at]" id="input-price-ended_at" type="date" value="{{$price['ended_at'] ? $price['ended_at']->format('Y-m-d') : null }}">
    </div>
  </div>
</div>
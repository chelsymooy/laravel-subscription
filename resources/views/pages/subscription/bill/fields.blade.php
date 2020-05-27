<div class="row">
  <label class="col-sm-2 col-form-label">No</label>
  <div class="col-sm-8">
    <div class="form-group bmd-form-group is-filled">
      <input class="form-control" name="no" id="input-no" type="text" placeholder="0001" value="{{$bill->no}}" readonly="true">
    </div>
  </div>
</div>
<!-- PENDING -->
<div class="row">
  <label class="col-sm-2 col-form-label">Item(s) Information</label>
  <label class="col-sm-2 col-form-label">Item</label>
  <label class="col-sm-1 col-form-label">Qty</label>
  <label class="col-sm-1 col-form-label">Unit</label>
  <label class="col-sm-2 col-form-label">Price</label>
  <label class="col-sm-2 col-form-label">Discount</label>
</div>

<div class="form-sample">
  @foreach($bill['lines'] as $v)
  <div class="row @if($loop->first) form-block @endif">
    <label class="col-sm-2 col-form-label">&nbsp;</label>
    <div class="col-sm-2">
      <div class="form-group bmd-form-group is-filled"> 
        <input class="form-control" name="lines[item][]" type="text" placeholder="December 2019" value="{{$v['item']}}" required="true" aria-required="true">
      </div>
    </div>
    <div class="col-sm-1">
      <div class="form-group bmd-form-group is-filled"> 
        <input class="form-control" name="lines[qty][]" type="text" placeholder="1" value="{{$v['qty']}}" required="true" aria-required="true">
      </div>
    </div>
    <div class="col-sm-1">
      <div class="form-group bmd-form-group is-filled"> 
        <input class="form-control" name="lines[unit][]" type="text" placeholder="month" value="{{$v['unit']}}" required="true" aria-required="true">
      </div>
    </div>
    <div class="col-sm-2">
      <div class="form-group bmd-form-group is-filled"> 
        <input class="form-control" name="lines[price][]" type="text" placeholder="30000" value="{{$v['price']}}" required="true" aria-required="true">
      </div>
    </div>
    <div class="col-sm-2">
      <div class="form-group bmd-form-group is-filled"> 
        <input class="form-control" name="lines[discount][]" type="text" placeholder="0" value="{{$v['discount']}}" required="true" aria-required="true">
      </div>
    </div>
    <div class="col-sm-1 text-right">
      <div class="form-group bmd-form-group is-filled"> 
         <a class="btn btn-link btn-danger remove-btn">&emsp;REMOVE</a>
      </div>
    </div>
  </div>
  @endforeach
</div>
<div class="form-clones">
</div>
<div class="row text-right">
  <label class="col-sm-8 col-form-label">&nbsp;</label>
  <label class="col-sm-1 col-form-label text-right"> <a class="btn btn-link btn-primary add-more-btn">ADD LINE</a></label>
</div>

<div class="row">
  <label class="col-sm-2 col-form-label">Penalty Information</label>
  <div class="col-sm-1">
    <div class="form-group bmd-form-group is-filled"> 
      <label class="form-control">Fine</label>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="details[penalty_rate]" id="input-details-penalty_rate" type="text" placeholder="0" value="{{$bill['details']['penalty_rate']}}" required="true" aria-required="true">
    </div>
  </div>
  <div class="col-sm-1">
    <div class="form-group bmd-form-group is-filled"> 
      <label class="form-control">Every</label>
    </div>
  </div>
  <div class="col-sm-1">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="details[penalty_period_val]" id="input-details-penalty_period_val" type="text" placeholder="1" value="{{$bill['details']['penalty_period_val']}}" required="true" aria-required="true">
    </div>
  </div>
  <div class="col-sm-2">
    <div class="form-group bmd-form-group is-filled"> 
      <select class="form-control" name="details[penalty_period_opt]" id="input-details-penalty_period_opt" required="true" aria-required="true">
        <option value="day" @if($bill['details']['recurring_opt'] === "day") selected @endif>Day</option>
        <option value="month" @if($bill['details']['recurring_opt'] === "month") selected @endif>Month</option>
        <option value="year" @if($bill['details']['recurring_opt'] === "year") selected @endif>Year</option>
      </select>
    </div>
  </div>
</div>

<div class="row">
  <label class="col-sm-2 col-form-label">Issuer Information</label>
  <div class="col-sm-5">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="details[issuer_name]" id="input-details-issuer_name" type="text" value="{{$bill['details']['issuer_name']}}">
    </div>
  </div>
  <div class="col-sm-3">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="details[issuer_phone]" id="input-details-issuer_phone" type="text" value="{{$bill['details']['issuer_phone']}}">
    </div>
  </div>
</div>
<div class="row">
  <label class="col-sm-2 col-form-label">&nbsp;</label>
  <div class="col-sm-8">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="details[issuer_address]" id="input-details-issuer_address" type="text" value="{{$bill['details']['issuer_address']}}">
    </div>
  </div>
</div>

<div class="row">
  <label class="col-sm-2 col-form-label">Billing Information</label>
  <div class="col-sm-5">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="details[customer_name]" id="input-details-customer_name" type="text" placeholder="Customer" value="Customer" required="true" aria-required="true">
    </div>
  </div>
  <div class="col-sm-3">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="details[customer_phone]" id="input-details-customer_phone" type="text" placeholder="081234567890" value="081234567890" required="true" aria-required="true">
    </div>
  </div>
</div>
<div class="row">
  <label class="col-sm-2 col-form-label">&nbsp;</label>
  <div class="col-sm-8">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="details[customer_address]" id="input-details-customer_address" type="text" placeholder="Vernon Building" value="Vernon Building" required="true" aria-required="true">
    </div>
  </div>
</div>

<div class="row">
  <label class="col-sm-2 col-form-label">Payment Information</label>
  <div class="col-sm-2">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="details[bank_name]" id="input-details-bank_name" type="text" value="{{$bill['details']['bank_name']}}">
    </div>
  </div>
  <div class="col-sm-1">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="details[bank_currency]" id="input-details-bank_currency" type="text" value="{{$bill['details']['bank_currency']}}">
    </div>
  </div>
  <div class="col-sm-5">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="details[account_no]" id="input-details-account_no" type="text" value="{{$bill['details']['account_no']}}">
    </div>
  </div>
</div>
<div class="row">
  <label class="col-sm-2 col-form-label">&nbsp;</label>
  <div class="col-sm-8">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="details[account_name]" id="input-details-account_name" type="text" value="{{$bill['details']['account_name']}}">
    </div>
  </div>
</div>


<div class="row">
  <label class="col-sm-2 col-form-label"><!--Period Information--></label>
  <div class="col-sm-2">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="details[period_started]" id="input-details-period_started" type="hidden" value="{{$bill['details']['period_started']}}">
    </div>
  </div>
  <div class="col-sm-2">
    <div class="form-group bmd-form-group is-filled"> 
      <input class="form-control" name="details[period_ended]" id="input-details-period_ended" type="hidden" value="{{$bill['details']['period_ended']}}">
    </div>
  </div>
</div>

@push('js')
<script type="text/javascript">
  $('.add-more-btn').click(function() {
    var clone = $('.form-sample .form-block').clone('.form-block');
    console.log('clone', clone)
    $('.form-clones').append(clone);
  });
  $('.remove-btn').click(function() {
    var clone = this.closest('.row');
    clone.remove();
  });
</script>
@endpush
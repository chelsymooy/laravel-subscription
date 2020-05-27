<div class="row">
  <label class="col-sm-2 col-form-label">Name</label>
  <div class="col-sm-6">
    <div class="input-group form-group bmd-form-group is-filled">
      <input class="form-control" name="name" id="input-name" type="text" placeholder="Name" value="{{$plan['name']}}" required="true" aria-required="true">

	    <div class="input-group-append">
		    <div class="form-group form-check bmd-form-group is-filled pt-2">
		      <label class="form-check-label">
            @if($plan['is_active'])
  		        <input class="form-check-input" name="is_active" type="checkbox" value=1 checked="true">
            @else
              <input class="form-check-input" name="is_active" type="checkbox" value=1>
            @endif
		        Active
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
  <label class="col-sm-2 col-form-label">Feature(s) Information</label>
  <label class="col-sm-3 col-form-label">Title</label>
  <label class="col-sm-3 col-form-label">Code</label>
  <label class="col-sm-1 col-form-label">&nbsp;</label>
</div>

<div class="form-sample">
	@foreach($plan['features'] as $v)
  <div class="row @if($loop->first) form-block @endif">
    <label class="col-sm-2 col-form-label">&nbsp;</label>
    <div class="col-sm-3">
      <div class="form-group bmd-form-group is-filled"> 
        <input class="form-control" name="features[title][]" type="text" placeholder="100 Email transaction" value="{{$v['title']}}" required="true" aria-required="true">
      </div>
    </div>
    <div class="col-sm-3">
	    <div class="input-group form-group bmd-form-group is-filled">
        <input class="form-control" name="features[code][]" type="text" placeholder="A100" value="{{$v['code']}}" required="true" aria-required="true">
        <div class="input-group-append">
			    <div class="form-group form-check bmd-form-group is-filled pt-2">
			      <label class="form-check-label">
			      	@if($v['is_available'])
				        <input class="form-check-input" name="features[is_available][]" type="checkbox" value=1 checked="true">
			        @else
				        <input class="form-check-input" name="features[is_available][]" type="checkbox" value=1>
			        @endif
			        Avail
			        <span class="form-check-sign">
			          <span class="check"></span>
			        </span>
				    </label>
				  </div>
		    </div>
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
  <label class="col-sm-1 col-form-label text-right"> <a class="btn btn-link btn-primary add-more-btn">ADD FEATURE</a></label>
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
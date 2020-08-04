@extends('admin.app')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
<li class="breadcrumb-item "><a href="{{route('admin.profile.index')}}">Users</a></li>
<li class="breadcrumb-item active" aria-current="page">Add/Edit users</li>
@endsection
@section('content')
<h2 class="modal-title">Add/Edit users</h2>
<form autocomplete="off" action="@if(isset($user)) {{route('admin.profile.update',$user->profile->id)}} @else {{route('admin.profile.store')}} @endif" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<div class="row">
		@csrf
		@if(isset($user))
		@method('PUT')
		@endif
		<div class="col-lg-9">
			<div class="form-group row">
				<div class="col-sm-12">
					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif
				</div>
				<div class="col-sm-12">
					@if (session()->has('message'))
					<div class="alert alert-success">
						{{session('message')}}
					</div>
					@endif
				</div>
				<div class="col-sm-12 col-md-6">
					<label class="form-control-label">Name: </label>
				<input type="text" id="txturl" name="name" class="form-control " value="{{@$user->profile->name}}" />
					<p class="small">{{route('admin.profile.index')}}/<span id="url"></span>
					<input type="hidden" name="slug" id="slug" >
				</p>
			</div>
			<div class="col-sm-12 col-md-6">
				<label class="form-control-label">Email: </label>
				<input type="text" id="email" name="email" class="form-control " value="{{@$user->email}}"/>

			</div>
		</div>
		@if (isset($user))
		<div class="form-group row">
			<div class="col-sm-12 col-md-6">
				<label class="form-control-label">Previous Password: </label>
			<input type="password" id="password" name="previous_password" class="form-control "" />

			</div>
			<div class="col-sm-12 col-md-6">
				<label class="form-control-label">New Password: </label>
				<input type="password" id="new_password" name="new_password" class="form-control " value="" />

			</div>
		</div>	
		@else
		<div class="form-group row">
			<div class="col-sm-12 col-md-6">
				<label class="form-control-label">Password: </label>
			<input type="password" id="password" name="password" class="form-control "" />

			</div>
			<div class="col-sm-12 col-md-6">
				<label class="form-control-label">Re-Type Password: </label>
				<input type="password" id="password_confirm" name="password_confirm" class="form-control " value="" />

			</div>
		</div>	
		@endif
		
		<div class="form-group row">
			<div class="col-sm-6">
				<label class="form-control-label">Status</label>
				<div class="input-group mb-3">
					<select class="form-control" id="status" name="status">
						<option value="0" 
						@if (@$user->status == 0)
						{{'selected'}}
					@endif>Blocked</option>
						<option value="1"
						@if (@$user->status == 1)
						{{'selected'}}
					@endif
						>Active</option>
					</select>
				</div>
			</div>
			@php
			$ids = (isset($user->role) && $user->role->count() > 0 ) ? Arr::pluck($user->role->toArray(), 'id') : null;
			@endphp

			<div class="col-sm-6">
				<label class="form-control-label">Select Role</label>
				<select name="role_id" id="role" class="form-control">
					@if($roles->count() > 0)
					@foreach($roles as $role)
					<option value="{{$role->id}}"
					@if ($role->id == @$user->role->id)
						{{'selected'}}
					@endif
						>{{$role->name}}</option>
					@endforeach
					@endif
				</select>
			</div>
		</div>
		<div class="">
			<h4 class="title">Address</h4>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<label class="form-control-label">Address: </label>
				<div class="input-group mb-3">
					<input type="text" name="address" class="form-control " value="{{@$user->profile->address}}"/>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6 col-md-3">
				<label class="form-control-label">Country: </label>
				<div class="input-group mb-3">
					<select name="country_id" class="form-control" id="countries">
							<option value="0">Select a Country</option>
                        @foreach ($countries as $country)
					<option value="{{$country->id}}" 
						@if ($country->id == @$user->profile->country_id)
							{{'selected'}}
						@endif
						>{{$country->name}}
					</option>    
                        @endforeach
						
						
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<label class="form-control-label">State: </label>
				<div class="input-group mb-3">
					<select name="state_id" class="form-control" id="states">
						<option value="0">Select a State</option>
						@if(isset($user))
						@foreach ($countries as $c) 
					<option value="{{$c->states->id}}" 
						@if ($c->states->country_id == @$user->profile->state_id)
							{{'selected'}}
						@endif>{{$c->states->name}}</option>
				@endforeach		
				@endif
					</select>
				</div>
			</div>
			
				
			<div class="col-sm-6 col-md-3">
				<label class="form-control-label">City: </label>
				<div class="input-group mb-3">
					<select name="city_id" class="form-control" id="cities">
							<option value="0">Select a City</option>
							@if(isset($user))
							@foreach ($countries as $c) 
							<option value="{{$c->cities->id}}" 
								@if ($c->cities->state_id == @$user->profile->city_id)
									{{'selected'}}
								@endif>{{$c->cities->name}}</option>
					@endforeach		
					@endif
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<label class="form-control-label">Phone: </label>
				<div class="input-group mb-3">
					<input type="text" class="form-control" name="phone" placeholder="Phone" value="{{@$user->profile->phone}}" />
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<ul class="list-group row">

			<li class="list-group-item active"><h5>Profile Image</h5></li>
			<li class="list-group-item">
				<div class="input-group mb-3">
					<div class="custom-file ">
						<input type="file"  class="custom-file-input" name="thumbnail" id="thumbnail">
						<label class="custom-file-label" for="thumbnail">Choose file</label>
					</div>
				</div>
				<div class="img-thumbnail  text-center">
					
				</div>
			</li>
			<li class="list-group-item">
				<div class="form-group row">
					<div class="col-lg-12">
						@if(isset($user))
						<input type="submit" name="submit" class="btn btn-primary btn-block " value="Update user" />
						@else
						<input type="submit" name="submit" class="btn btn-primary btn-block " value="Add user" />
						@endif
					</div>

				</div>
			</li>
		</ul>
	</div>
</div>
</form>
@endsection
@section('script')

<script type="text/javascript">
$(document).ready(function() {
			const pretty_url = slugify($('#txturl').val());
			$('#url').html(slugify(pretty_url));
			$('#slug').val(pretty_url);
	
});
	$(function(){
		$('#txturl').on('keyup', function(){
			const pretty_url = slugify($(this).val());
			$('#url').html(slugify(pretty_url));
			$('#slug').val(pretty_url);
		})
$('#thumbnail').on('change', function() {
var file = $(this).get(0).files;
var reader = new FileReader();
reader.readAsDataURL(file[0]);
reader.addEventListener("load", function(e) {
var image = e.target.result;
$("#imgthumbnail").attr('src', image);
});
});
// Set up the Select2 control
$('#countries').select2().trigger('change');
$('#states').select2();
$('#cities').select2();
//On Country Change
$('#countries').on('change', function(){
	var id = $('#countries').select2('data')[0].id;
	$('#states').val(null);
	$('#states option').remove();
	// Fetch the preselected item, and add to the control
var studentSelect = $('#states');
$.ajax({
type: 'GET',
url: "{{route('admin.profile.states')}}/" + id
}).then(function (data) {
	// create the option and append to Select2
	for(i=0; i< data.length; i++){
		var item = data[i]
		var option = new Option(item.name, item.id, true, true);
		studentSelect.append(option);
	}
studentSelect.trigger('change');
	});
})
//On state Change
$('#states').on('change', function(){
	var id = $('#states').select2('data')[0].id;
	// Fetch the preselected item, and add to the control
	var studentSelect = $('#cities');
	$('#cities').val(null);
	$('#cities option').remove();
$.ajax({
type: 'GET',
url: "{{route('admin.profile.cities')}}/" + id
}).then(function (data) {
	// create the option and append to Select2
	for(i=0; i< data.length; i++){
		var item = data[i]
		var option = new Option(item.name, item.id, false, false);
		studentSelect.append(option);
	}
	});
studentSelect.trigger('change');
})
})
</script>
@endsection
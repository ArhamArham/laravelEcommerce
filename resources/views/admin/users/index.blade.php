@extends('admin.app')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
<li class="breadcrumb-item active" aria-current="page">Users</li>
@endsection
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2>Users</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a class="btn btn-sm btn-outline-secondary" href='{{route('admin.profile.create')}}'>Add Profile</a>
        </div>
    </div>
</div>
<div class="form-group row">
  <div class="col-sm-12">
    @if (session()->has('message'))
    <div class="alert alert-success">
        {{session('message')}}
    </div>
    @endif
</div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Username</th>
          <th>Email</th>
          <th>Slug</th>
          <th>Role</th>
          <th>Address</th>
          <th>Thumbnail</th>
          <th>Date Created</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @if(isset($users) && $users->count() > 0)
        @foreach($users as $user)
        <tr>
          <td>{{@$user->id}}</td>
          <td>{{@$user->profile->name}}</td>
          <td>{{@$user->email }}</td>
          <td>{{@$user->profile->slug}}</td>
          <td>{{$user->role->name}}</td>
        <td>{{@$user->getCountry()}},{{@$user->getState()}},{{@$user->getCity()}},{{@$user->profile->address}}</td>
        <td><img src="{{asset('public/storage/'.@$user->profile->thumbnail)}}" alt="{{@$user->profile->thumbnail}}" height="50"></td>

          @if (@$checktrash)
          
          <td>{{$user->deleted_at}}</td>
          @else
          <td>{{$user->created_at}}</td>
          @endif
          
          <td>
            @if (@$checktrash)
            
            {{ Form::open(array('url' => 'admin/profile/' . $user->id.'/recover' ,'style'=>'float:left')) }}
            {{ Form::hidden('_method', 'GET') }}
            {{ Form::submit('Recover', array('class' => 'btn btn-sm btn-success')) }}
            {{ Form::close() }}
            @else
            {{ Form::open(array('url' => 'admin/profile/' . $user->profile->id.'/edit' ,'style'=>'float:left')) }}
            {{ Form::hidden('_method', 'GET') }}
            {{ Form::submit('Edit', array('class' => 'btn btn-sm btn-info')) }}
            {{ Form::close() }}
            {{ Form::open(array('url' => 'admin/profile/'.$user->id.'/remove' ,'style'=>'float:left')) }}
            {{ Form::hidden('_method', 'GET') }}
            {{ Form::submit('Trash', array('class' => 'btn btn-sm btn-warning' )) }}
            {{ Form::close() }}
            @endif
            {{ Form::open(array('url' => 'admin/profile/'.$user->profile->id ,'style'=>'float:left')) }}
            {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::submit('Delete', array('class' => 'btn btn-sm btn-danger','onclick'=>"return confirm('Are you sure you want to delete the record $user->id ?')" )) }}
            {{ Form::close() }}

        </td>
        </tr>
        @endforeach
        @else
        <tr>
          <td colspan="7" class="alert alert-info">No profiles Found..</td>
        </tr>
        @endif
        
      </tbody>
      
    </table>
  </div>
  <div class="row">
    <div class="col-md-12">
      
    </div>
  </div>
@endsection
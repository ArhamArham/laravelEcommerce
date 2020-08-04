@extends('admin.app')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
<li class="breadcrumb-item active" aria-current="page">Categories</li>
@endsection
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    @if (@$checktrash)
    <h2>Trash Categories</h2>
    @else
    <h2>Categories</h2>
    @endif

    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a class="btn btn-sm btn-outline-secondary" href='{{route('admin.category.create')}}'>Add Category</a>
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
                <th>Id</th>
                <th>Title</th>
                <th>Description</th>
                <th>Slug</th>
                <th>Categories</th>
                <th>Date Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($categories->count() > 0)
            @foreach ($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->title}}</td>
                <td>{!!$category->description!!}</td>
                <td>{{$category->title}}</td>
                <td>
                    @if($category->childrens()->count() > 0)
                    @foreach ($category->childrens as $children)
                    {{$children->title}},
                    @endforeach
                    @else
                    <strong>{{"Parent Category"}}</strong>
                    @endif
                </td>
                <td>{{$category->created_at}}</td>
                <td>
                    @if (@$checktrash)
                    {{ Form::open(array('url' => 'admin/category/' . $category->id.'/recover' ,'style'=>'float:left')) }}
                    {{ Form::hidden('_method', 'GET') }}
                    {{ Form::submit('Recover', array('class' => 'btn btn-sm btn-success')) }}
                    {{ Form::close() }}
                    @else
                    {{ Form::open(array('url' => 'admin/category/' . $category->id.'/edit' ,'style'=>'float:left')) }}
                    {{ Form::hidden('_method', 'GET') }}
                    {{ Form::submit('Edit', array('class' => 'btn btn-sm btn-info')) }}
                    {{ Form::close() }}
                    {{ Form::open(array('url' => 'admin/category/'.$category->id.'/remove' ,'style'=>'float:left')) }}
                    {{ Form::hidden('_method', 'GET') }}
                    {{ Form::submit('Trash', array('class' => 'btn btn-sm btn-warning' )) }}
                    {{ Form::close() }}
                    @endif
                    {{ Form::open(array('url' => 'admin/category/'.$category->id ,'style'=>'float:left')) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete', array('class' => 'btn btn-sm btn-danger','onclick'=>"return confirm('Are you sure you want to delete the record $category->id ?')" )) }}
                    {{ Form::close() }}

                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="7">No categories found..</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-12">
        {{$categories->links()}}
    </div>
</div>

@section('scripts')

@endsection
@endsection
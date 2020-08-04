@extends('admin.app')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
<li class="breadcrumb-item active" aria-current="page">Products</li>
@endsection
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    @if (@$checktrash)
    <h2>Trash Products</h2>
    @else
    <h2>Products</h2>    
    @endif
    

    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a class="btn btn-sm btn-outline-secondary" href='{{route('admin.product.create')}}'>Add Product</a>
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
          <th>Title</th>
          <th>Description</th>
          <th>Slug</th>
          <th>Categories</th>
          <th>Price</th>
          <th>Thumbnail</th>
          <th>Date Created</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @if($products->count() > 0)
        @foreach($products as $product)
        <tr>
          <td>{{$product->id}}</td>
          <td>{{$product->title}}</td>
          <td>{!! $product->description !!}</td>
          <td>{{$product->slug}}</td>
          <td>
            @if($product->categories()->count() > 0)
            @foreach($product->categories as $children)
            {{$children->title}},
            @endforeach
            @else
            <strong>{{"product"}}</strong>
            @endif
          </td>
          <td>${{$product->price}}</td>
          <td><img src="{{ asset('public/storage/'.$product->thumbnail)}}" alt="{{$product->thumbnail}}" class="img-responsive" height="50"/></td>

          @if (@$checktrash)
          
          <td>{{$product->deleted_at}}</td>
          @else
          <td>{{$product->created_at}}</td>
          @endif
          
          <td>
            @if (@$checktrash)
            
            {{ Form::open(array('url' => 'admin/product/' . $product->id.'/recover' ,'style'=>'float:left')) }}
            {{ Form::hidden('_method', 'GET') }}
            {{ Form::submit('Recover', array('class' => 'btn btn-sm btn-success')) }}
            {{ Form::close() }}
            @else
            {{ Form::open(array('url' => 'admin/product/' . $product->slug.'/edit' ,'style'=>'float:left')) }}
            {{ Form::hidden('_method', 'GET') }}
            {{ Form::submit('Edit', array('class' => 'btn btn-sm btn-info')) }}
            {{ Form::close() }}
            {{ Form::open(array('url' => 'admin/product/'.$product->slug.'/remove' ,'style'=>'float:left')) }}
            {{ Form::hidden('_method', 'GET') }}
            {{ Form::submit('Trash', array('class' => 'btn btn-sm btn-warning' )) }}
            {{ Form::close() }}
            @endif
            {{ Form::open(array('url' => 'admin/product/'.$product->slug ,'style'=>'float:left')) }}
            {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::submit('Delete', array('class' => 'btn btn-sm btn-danger','onclick'=>"return confirm('Are you sure you want to delete the record $product->id ?')" )) }}
            {{ Form::close() }}

        </td>
        </tr>
        @endforeach
        @else
        <tr>
          <td colspan="7" class="alert alert-info">No products Found..</td>
        </tr>
        @endif
        
      </tbody>
      
    </table>
  </div>
  <div class="row">
    <div class="col-md-12">
      {{$products->links()}}
    </div>
  </div>
@endsection
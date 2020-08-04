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
    
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="formsubmit">
          <div id="formData">
            <div class="selDiv">
              <select class="opts">
                <option selected value="DEFAULT">Default</option>
                <option value="new">new</option>
                <option value="car">car</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" value="Submit">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>    

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
          <td>
            
            <!-- Button trigger modal -->
          <a id="{!! $product->description !!}+{{$product->id}}" class="model">
  {!! $product->description !!}
</a>


          </td>
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
@section('script')
<script>
$(document).ready(function(){
  $(".model").click(function(){
    $('#exampleModalCenter').modal('show');
    var data=this.id.split("+");
    // $('#formData').html(data[0]);
    var $select = $('.selDiv .opts');
    $select.children().filter(function(){
	    return this.text == data[0];
    }).prop('selected', true);

    $('#formsubmit').attr('action',data[1])
    console.log(data);
  });
});
</script>
@endsection
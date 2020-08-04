@extends('admin.app')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('admin.category.index')}}">Categories</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add/Edit Categories</li>
@endsection
@section('content')
<form action="@if(isset($category)) {{route('admin.category.update' ,$category->id)}} @else {{route('admin.category.store')}} @endif" method="post">
        @csrf
    @if (isset($category))
        @method('PUT')
    @endif
    <div class="form-group row">
        <div class="col-sm-12">
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
        <div class="col-sm-12">
                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{session('message')}}
                </div>
                @endif
            </div>
        <div class="col-sm-12">
            <label for="form-control-label">Title:</label>
        <input value="{{@$category->title}}" type="text" id="txturl" name="title" class="form-control" placeholder="" aria-describedby="helpId">
            <p class="small">{{config('app.url')}}/<span id="url">{{@$category->slug}}</span></p>
            <input type="hidden" id="slug" name="slug" value="{{@$category->slug}}">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-12">
            <label for="form-control-label">Description:</label>
            <textarea name="description"  id="editor" class="form-control" cols="80" rows="10">{!!@$category->description !!}</textarea>
        </div>
    </div>
    <div class="form-group row">
        @php
            $ids=(isset($category->childrens) && $category->childrens->count() > 0) ?
            Arr::pluck($category->childrens, 'id') : null
        @endphp
         
            <div class="col-sm-12">
                <label for="form-control-label">Select Category:</label>
                <select name="parent_id[]" id="parent_id" class="form-control" multiple='true'>
                    @if(isset($categories))
                        <option value="0">Top Level</option>
                        
                        @foreach ($categories as $cat)
                            <option value="{{$cat->id}} " @if(!is_null($ids) && in_array($cat->id,$ids)) {{'selected'}} @endif>{{$cat->title}}</option>
                        @endforeach
                        @endif
                        
                </select>

            </div>
        </div>
    <div class="form-group row">
        <div class="col-sm-12">
            @if(isset($category))
            <input type="submit" class="btn btn-primary" name="submit" value="Edit Category">
            @else
                <input type="submit" class="btn btn-primary" name="submit" value="Add Category">
            @endif
        </div>
    </div>
</form>
@endsection
@section('script')
    
    <script type="text/javascript">
        $(document).ready(function() {
            $('#parent_id').select2();
            ClassicEditor.create(document.querySelector('#editor'),{
                toolbar:['Heading','Link','bold','italic','bulletedList','numberedList','blockQuote','undo','redo'],

            }).then(editor=>{
                console.log(editor);
            }).catch(error=>{
                console.error(error);
            });
            $('#txturl').on('keyup',function() {
                var url = slugify($(this).val());
                $('#url').html(url);
                $('#slug').val(url);
            });
            
        })
    </script>
@endsection
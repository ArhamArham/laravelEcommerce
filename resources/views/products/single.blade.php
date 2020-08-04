@extends('layouts.app')
@section('content')
<section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Album example</h1>
            <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator,
                etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
            <p>
                <a href="#" class="btn btn-primary my-2">Main call to action</a>
                <a href="#" class="btn btn-secondary my-2">Secondary action</a>
            </p>
        </div>
    </section>
    <div class="album py-5 bg-light">
            <div class="container">
        
                <div class="row">
        
        
                    <div class="col-md-4">
                            <img class="img-thumbnail" src="{{ asset('public/storage/'.$product->thumbnail)}}" width="100%"
                            style="height:300px" alt="{{$product->title}}">
                    </div>
                    <div class="col-md-8">
                            <div class=" mb-4 shadow-sm">
                                    
                                    <div class="">
                                        <h4 class='card-title'>{{$product->title}}</h4>
                                        <p class="card-text">{!!$product->description!!}</p>
                                        <div class="d-block justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary">Add to Cart</button>
                                            </div>
                                            <small class="text-muted">9 mins</small>
                                        </div>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>
        
@endsection
<div class="album py-5 bg-light">
    <div class="container">

        <div class="row">
            @foreach ($products as $product)


            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img class="img-thumbnail" src="{{ asset('public/storage/'.$product->thumbnail)}}" width="100%"
                        style="height:300px" alt="{{$product->title}}">
                    <div class="card-body">
                        <h4 class='card-title'>{{$product->title}}</h4>
                        <p class="card-text">{!! Str::limit($product->description ,100) !!}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="{{route('products.single',$product->slug)}}" type="button"
                                    class="btn btn-sm btn-outline-secondary">View Product</a>
                                <a href="{{route('products.addToCart',$product)}}" class="btn btn-sm btn-outline-secondary">Add to Cart</a>
                            </div>
                            <small class="text-muted">9 mins</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

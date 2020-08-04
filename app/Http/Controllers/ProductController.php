<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\Category;
use Session;
use App\CategoryParent;
use App\Http\Requests\StoreProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::with('categories')->paginate(3);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::with('childrens')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
        //
        $validated = $request->validated();
        $extension=".".$request->thumbnail->getClientOriginalExtension();
        $name=basename($request->thumbnail->getClientOriginalName(),$extension).time();
        $name=$name.$extension;
        $path=$request->thumbnail->storeAs('images',$name,'public');
        $product = Product::create([
            'title'=>$request->title,
            'slug'=>$request->slug,
            'description'=>$request->description,
            'thumbnail'=>$path,
            'status'=> $request->status,
            'options'=>isset($request->extras) ? json_encode($request->extras) : null,
            'featured'=>($request->featured) ? $request->featured : 0,
            'price'=>$request->price,
            'discount'=>($request->discount) ? $request->discount : 0,
            'discount_price'=>($request->discount_price) ? $request->discount_price : 0,
        ]);
        
        if($product && $validated)   
        {
            $cat = $product->categories()->attach($request->category_id);
            return back()->with('message','Product added succesfully');
        }
        else
        {
            return back()->with('message','Product not added');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        //dd(Session::get('cart'));
        $categories=Category::all();
        $products=Product::all();
        return view('products.all',compact('products','categories'));
    }
    public function single(Product $product)
    {
        return view('products.single',compact('product'));
    }
    public function addToCart(Request $request, Product $product)
    {
        $oldCart=Session::has('cart') ? Session::get('cart') : null;
        $qty=$request->qty ? $request->qty : 1;
        $cart= new Cart($oldCart);
        $cart->addProduct($product, $qty);
        Session::put('cart',$cart);
        return back()->with('message','Product '.$product->title.' has been successfully added to Cart');

    }
    public function cart()
    {
        if(!Session::has('cart'))
            return view('products.cart');
        $cart=Session::get('cart');
        return view('products.cart',compact('cart'));
    }
    public function removeCart(Product $product)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeProduct($product);
        Session::put('cart' , $cart);
        return back()->with('message','Product '.$product->title.' has been successfully removed from the Cart');
    }
    public function updateCart(Product $product , Request $request)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->updateProduct($product, $request->qty);
        Session::put('cart' , $cart);
        return back()->with('message','Product '.$product->title.' has been successfully updated in the Cart');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        $categories=Category::all();
        return view('admin.products.create',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProduct $request, Product $product)
    {
        //
            if($request->has('thumbnail')){
                $extension=".".$request->thumbnail->getClientOriginalExtension();
                $name=basename($request->thumbnail->getClientOriginalName(),$extension).time();
                $name=$name.$extension;
                //$request->thumbnail->move(public_path('images'),$name);
                $path=$request->thumbnail->storeAs('images',$name,'public');
                $product->thumbnail=$path;
                }
            $product->title=$request->title;
            //$product->slug=$request->slug;
            $product->description=$request->description;
            $product->status= $request->status;
            $product->featured=($request->featured) ? $request->featured : 0;
            $product->price=$request->price;
            $product->discount=($request->discount) ? $request->discount : 0;
            $product->discount_price=($request->discount_price) ? $request->discount_price : 0;
            $product->categories()->detach();
            $product->categories()->attach($request->category_id);
            if($product->save()){
                return back()->with('message','Product Successfully Updated');
            }
            else
            {
                return back()->with('message','Product not updated');
            }
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        if ($product->categories()->detach() && $product->forceDelete()) {
            # code...
            Storage::delete('public/'.$product->thumbnail);   
            return back()->with('message','Product Successfully Deleted');
        } else {
            # code...
            return back()->with('message','Product not deleted');
        }
        
    }
    public function trash()
    {
        $product=Product::onlyTrashed()->orderBy('created_at','DESC')->paginate(3);
        return view('admin.products.index',['products'=>$product ,'checktrash'=>'Yes']);
    }
    public function recover($id)
    {
        $product=Product::withTrashed()->findOrFail($id);
        if ($product->restore()) {
            # code...
            return back()->with('message','Product Successfully recoverd');
        } else {
            # code...
            return back()->with('message','Product not recovered');
        }
    }
    public function remove(Product $id)
    {
        if ($id->delete()) {
            # code...
            return back()->with('message','Product Successfully Trash');
        } else {
            # code...
            return back()->with('message','Product not trash');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\StoreOrder;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(!Session::has('cart') || empty(Session::get('cart')->getContents()))
        {
            return redirect('products')->with('message','No Products in the cart plz by some products');
        }
        $cart=Session::get('cart');
        return view('products.checkout',compact('cart'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrder $request)
    {
        //
        Stripe::setApiKey('sk_test_WqCOGVQMJH1VV1K2nTsgaouz005CzQpftu');
        $charge=Charge::create([
            'amount'=> 999,
            'currency'=>'usd',
            'source'=>$request->stripeToken,
            'receipt_email'=>$request->email,
        ]);
        dd($request->all());
        $cart=[];
        $order='';
        $checkout='';
        if(Session::has('cart'))
        {
            $cart=Session::get('cart');
        }
        if($request->ship_address1)
        {
            $customer=[
                    "firstname" => $request->firstname,
                    "lastname" => $request->lastname,
                    "username" => $request->username,
                    "email" => $request->email,
                    "billing_address1" => $request->billing_address1,
                    "billing_address2" => $request->billing_address2,
                    "country" => $request->country,
                    "state" => $request->state,
                    "zip" => $request->zip,
                    "ship_firstname" => $request->ship_firstname,
                    "ship_lastname" => $request->ship_lastname,
                    "ship_address1" => $request->ship_address1,
                    "ship_address2" => $request->ship_address2,
                    "ship_country" => $request->ship_country,
                    "ship_state" => $request->ship_state,
                    "ship_zip" => $request->ship_zip,                 
            ];
        }
        else
        {
            $customer=[
                "firstname" => $request->firstname,
                "lastname" => $request->lastname,
                "username" => $request->username,
                "email" => $request->email,
                "billing_address1" => $request->billing_address1,
                "billing_address2" => $request->billing_address2,
                "country" => $request->country,
                "state" => $request->state,
                "zip" => $request->zip,
                      ];
        }
        DB::beginTransaction();
        $checkout=Customer::create($customer);
        foreach($cart->getContents() as $slug => $product)
        {
            $products=[
                'user_id'=>$checkout->id,
                'product_id'=>$product['product']->id,
                'qty'=>$product['qty'],
                'status'=>'Pending',
                'price'=>$product['price'],
                'payment_id'=>0,
            ];
            $order=Order::create($products);
        }
        if($checkout && $order){
            DB::commit();
            return view('products.payments');
        }
        else
        {
            DB::rollBack();
            return redirect('checkout')->with('message','Invalid Activity');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}

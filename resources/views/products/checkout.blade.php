@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">

        </div>
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill">{{$cart->getTotalQty()}}</span>
            </h4>
            <ul class="list-group mb-3">
                @foreach ($cart->getContents() as $slug => $product)

                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">{{$product['product']->title}}</h6>
                        <small class="text-muted">{{$product['qty']}}</small>
                    </div>
                    <span class="text-muted">${{$product['price']}}</span>
                </li>
                @endforeach
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (USD)</span>
                    <strong>${{$cart->getTotalPrice()}}</strong>
                </li>

            </ul>

        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Billing address</h4>
            <form class="needs-validation" novalidate="" action="{{route('checkout.store')}}" method="POST" id="payment-form">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">First name</label>
                        <input name="firstname" type="text" class="form-control" id="firstName" placeholder="" value=""
                            required="">
                        @if ($errors->has('firstname'))
                        <div class="invalid-feedback" style="display:block;">{{$errors->first('firstname')}}</div>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Last name</label>
                        <input name='lastname' type="text" class="form-control" id="lastName" placeholder="" value=""
                            required="">
                            @if ($errors->has('lastname'))
                            <div class="invalid-feedback" style="display:block;">{{$errors->first('lastname')}}</div>
                            @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="input-group-text">@</span>
                        </div>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Username"
                            required="">
                    </div>
                    @if ($errors->has('username'))
                    <div class="invalid-feedback" style="display:block;">{{$errors->first('username')}}</div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com">
                    @if ($errors->has('email'))
                        <div class="invalid-feedback" style="display:block;">{{$errors->first('email')}}</div>
                        @endif
                </div>

                <div class="mb-3">
                    <label for="address">Address 01</label>
                    <input type="text" name="billing_address1" class="form-control" id="address"
                        placeholder="1234 Main St" required="">
                        @if ($errors->has('billing_address1'))
                        <div class="invalid-feedback" style="display:block;">{{$errors->first('billing_address1')}}</div>
                        @endif
                </div>

                <div class="mb-3">
                    <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                    <input type="text" name="billing_address2" class="form-control" id="address2"
                        placeholder="Apartment or suite">
                </div>

                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="country">Country</label>
                        <select name="country" class="custom-select d-block w-100" id="country" required="">
                            <option value="">Choose...</option>
                            <option>United States</option>
                        </select>
                        @if ($errors->has('country'))
                        <div class="invalid-feedback" style="display:block;">{{$errors->first('country')}}</div>
                        @endif
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="state">State</label>
                        <select name='state' class="custom-select d-block w-100" id="state" required="">
                            <option value="">Choose...</option>
                            <option>California</option>
                        </select>
                        @if ($errors->has('state'))
                        <div class="invalid-feedback" style="display:block;">{{$errors->first('state')}}</div>
                        @endif
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="zip">Zip</label>
                        <input type="text" name="zip" class="form-control" id="zip" placeholder="" required="">
                        @if ($errors->has('zip'))
                        <div class="invalid-feedback" style="display:block;">{{$errors->first('zip')}}</div>
                        @endif
                    </div>
                </div>
                <hr class="mb-4">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="" id="same-address">
                    <label class="custom-control-label" for="same-address">Shipping address is the same as my billing
                        address</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="" id="save-info">
                    <label class="custom-control-label" for="save-info">Save this information for next time</label>
                </div>
                <hr class="mb-4">
                <div id="ship-add">
                    <h4 class="mb-3">Shipping Address</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName">First name</label>
                            <input type="text" name="ship_firstname" class="form-control" id="firstName" placeholder=""
                                value="" required="">
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName">Last name</label>
                            <input type="text" name="ship_lastname" class="form-control" id="lastName" placeholder=""
                                value="" required="">
                            <div class="invalid-feedback">
                                Valid last name is required.
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input type="text" name="ship_address1" class="form-control" id="address"
                            placeholder="1234 Main St" required="">
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                        <input type="text" name="ship_address2" class="form-control" id="address2"
                            placeholder="Apartment or suite">
                    </div>

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="country">Country</label>
                            <select name="ship_country" class="custom-select d-block w-100" id="country" required="">
                                <option value="">Choose...</option>
                                <option>United States</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="state">State</label>
                            <select name="ship_state" class="custom-select d-block w-100" id="state" required="">
                                <option value="">Choose...</option>
                                <option>California</option>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid state.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="zip">Zip</label>
                            <input type="text" name="ship_zip" class="form-control" id="zip" placeholder="" required="">
                            <div class="invalid-feedback">
                                Zip code required.
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4">


                </div>
                <script src="https://js.stripe.com/v3/"></script>
                <div class="form-row">
                    <label for="card-element">
                      Credit or debit card
                    </label>
                    <div id="card-element">
                      <!-- A Stripe Element will be inserted here. -->
                    </div>
                
                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert"></div>
                  </div>
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#same-address').click(function () {
            $('#ship-add').slideToggle(!this.checked);
        });
    });
</script>
@endsection

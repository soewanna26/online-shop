@extends('front.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop') }}">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
            <form action="" name="orderForm" id="orderForm" method="post">
                <div class="row">
                    <div class="col-md-8">
                        <div class="sub-title">
                            <h2>Shipping Address</h2>
                        </div>
                        <div class="card shadow-lg border-0">
                            <div class="card-body checkout-form">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="first_name" id="first_name" class="form-control"
                                                value="{{ !empty($customerAddress) ? $customerAddress->first_name : '' }}"
                                                placeholder="First Name">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="last_name" id="last_name" class="form-control"
                                                value="{{ !empty($customerAddress) ? $customerAddress->last_name : '' }}"
                                                placeholder="Last Name">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="email" id="email" class="form-control"
                                                value="{{ !empty($customerAddress) ? $customerAddress->email : '' }}"
                                                placeholder="Email">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <select name="country" id="country" class="form-control">
                                                <option value="">Select a Country</option>
                                                @if ($countries->isNotEmpty())
                                                    @foreach ($countries as $country)
                                                        <option
                                                            {{ !empty($customerAddress) && $customerAddress->country_id == $country->id ? 'selected' : '' }}
                                                            value="{{ $country->id }}">
                                                            {{ $country->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control">{{ !empty($customerAddress) ? $customerAddress->address : '' }}</textarea>
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="apartment" id="appartment" class="form-control"
                                                placeholder="Apartment, suite, unit, etc. (optional)">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="city" id="city" class="form-control"
                                                value="{{ !empty($customerAddress) ? $customerAddress->city : '' }}"
                                                placeholder="City">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="state" id="state" class="form-control"
                                                value="{{ !empty($customerAddress) ? $customerAddress->state : '' }}"
                                                placeholder="State">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="zip" id="zip" class="form-control"
                                                value="{{ !empty($customerAddress) ? $customerAddress->zip : '' }}"
                                                placeholder="Zip">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="mobile" id="mobile" class="form-control"
                                            value="{{ !empty($customerAddress) ? $customerAddress->mobile : '' }}"
                                                placeholder="Mobile No.">
                                            <p></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sub-title">
                            <h2>Order Summery</h3>
                        </div>
                        <div class="card cart-summery">
                            <div class="card-body">
                                @foreach (Cart::content() as $item)
                                    <div class="d-flex justify-content-between pb-2">
                                        <div class="h6">{{ $item->name }} X {{ $item->qty }}</div>
                                        <div class="h6">${{ $item->price * $item->qty }}</div>
                                    </div>
                                @endforeach
                                <div class="d-flex justify-content-between summery-end">
                                    <div class="h6"><strong>Subtotal</strong></div>
                                    <div class="h6"><strong>${{ Cart::subtotal() }}</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="h6"><strong>Shipping</strong></div>
                                    <div class="h6"><strong>$0</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2 summery-end">
                                    <div class="h5"><strong>Total</strong></div>
                                    <div class="h5"><strong>${{ Cart::subtotal() }}</strong></div>
                                </div>
                            </div>
                        </div>

                        <div class="card payment-form ">
                            <h3 class="card-title h5 mb-3">Payment Method</h3>
                            <div class="">
                                <input type="radio" name="payment_method" value="cod" id="payment_method_one"
                                    checked>
                                <label for="payment_method_one" class="form-check-label">COD</label>
                            </div>
                            <div class="">
                                <input type="radio" name="payment_method" value="cod" id="payment_method_two">
                                <label for="payment_method_two" class="form-check-label">Stripe</label>
                            </div>
                            <div class="card-body p-0 d-none" id="card-payment-form">
                                <div class="mb-3">
                                    <label for="card_number" class="mb-2">Card Number</label>
                                    <input type="text" name="card_number" id="card_number"
                                        placeholder="Valid Card Number" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="expiry_date" class="mb-2">Expiry Date</label>
                                        <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="expiry_date" class="mb-2">CVV Code</label>
                                        <input type="text" name="expiry_date" id="expiry_date" placeholder="123"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4">
                                {{-- <a href="#" class="btn-dark btn btn-block w-100">Pay Now</a> --}}
                                <button type="submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                            </div>
                        </div>


                        <!-- CREDIT CARD FORM ENDS HERE -->

                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('customJs')
    <script type="text/javascript">
        $("#payment_method_one").click(function() {
            if ($(this).is(":checked") == true) {
                $("#card-payment-form").addClass("d-none");
            }
        })
        $("#payment_method_two").click(function() {
            if ($(this).is(":checked") == true) {
                $("#card-payment-form").removeClass("d-none");
            }
        })

        $("#orderForm").submit(function(e) {
            e.preventDefault();
            $("button[type='submit']").prop('disabled', true);
            $.ajax({
                url: "{{ route('front.processCheckout') }}",
                type: "post",
                data: $(this).serializeArray(),
                dataType: "json",
                success: function(response) {
                    $("button[type='submit']").prop('disabled', false);
                    var errors = response.errors
                    if (response.status == false) {
                        if (errors.first_name) {
                            $("#first_name").siblings("p").addClass("invalid-feedback").html(errors
                                .first_name);
                            $("#first_name").addClass('is-invalid');
                        } else {
                            $("#first_name").siblings("p").removeClass("invalid-feedback").html('');
                            $("#first_name").removeClass('is-invalid');
                        }
                        if (errors.last_name) {
                            $("#last_name").siblings("p").addClass("invalid-feedback").html(errors
                                .last_name);
                            $("#last_name").addClass('is-invalid');
                        } else {
                            $("#last_name").siblings("p").removeClass("invalid-feedback").html('');
                            $("#last_name").removeClass('is-invalid');
                        }
                        if (errors.email) {
                            $("#email").siblings("p").addClass("invalid-feedback").html(errors.email);
                            $("#email").addClass('is-invalid');
                        } else {
                            $("#email").siblings("p").removeClass("invalid-feedback").html('');
                            $("#email").removeClass('is-invalid');
                        }
                        if (errors.country) {
                            $("#country").siblings("p").addClass("invalid-feedback").html(errors
                                .country);
                            $("#country").addClass('is-invalid');
                        } else {
                            $("#country").siblings("p").removeClass("invalid-feedback").html('');
                            $("#country").removeClass('is-invalid');
                        }
                        if (errors.address) {
                            $("#address").siblings("p").addClass("invalid-feedback").html(errors
                                .address);
                            $("#address").addClass('is-invalid');
                        } else {
                            $("#address").siblings("p").removeClass("invalid-feedback").html('');
                            $("#address").removeClass('is-invalid');
                        }
                        if (errors.city) {
                            $("#city").siblings("p").addClass("invalid-feedback").html(errors.city);
                            $("#city").addClass('is-invalid');
                        } else {
                            $("#city").siblings("p").removeClass("invalid-feedback").html('');
                            $("#city").removeClass('is-invalid');
                        }
                        if (errors.state) {
                            $("#state").siblings("p").addClass("invalid-feedback").html(errors.state);
                            $("#state").addClass('is-invalid');
                        } else {
                            $("#state").siblings("p").removeClass("invalid-feedback").html('');
                            $("#state").removeClass('is-invalid');
                        }
                        if (errors.zip) {
                            $("#zip").siblings("p").addClass("invalid-feedback").html(errors.zip);
                            $("#zip").addClass('is-invalid');
                        } else {
                            $("#zip").siblings("p").removeClass("invalid-feedback").html('');
                            $("#zip").removeClass('is-invalid');
                        }
                        if (errors.mobile) {
                            $("#mobile").siblings("p").addClass("invalid-feedback").html(errors.mobile);
                            $("#mobile").addClass('is-invalid');
                        } else {
                            $("#mobile").siblings("p").removeClass("invalid-feedback").html('');
                            $("#mobile").removeClass('is-invalid');
                        }
                    } else {
                        window.location.href = "{{ url('/thanks/') }}/" + response.orderId;
                    }
                }
            })
        })
    </script>
@endsection

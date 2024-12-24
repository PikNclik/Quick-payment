{{-- International code to be removed --}}
@php
    $internationalCode = "+963";
@endphp

<html>
<style>
    #invoice-POS {
        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
        padding: 2mm;
        margin: 0 auto;
        background: #fff;
        text-align: center;
        display: flex;
        flex-direction: column;
        height: 100%;
        max-width: 500px;
    }

    #invoice-POS ::selection {
        background: #f31544;
        color: #fff;
    }

    #invoice-POS ::moz-selection {
        background: #f31544;
        color: #fff;
    }

    #invoice-POS h1 {
        font-size: 1.5em;
        color: #222;
    }

    #invoice-POS h2 {
        font-size: 1em;
    }

    #invoice-POS h3 {
        font-size: 1.2em;
        font-weight: 300;
        line-height: 2em;
    }

    #invoice-POS p {
        font-size: 1em;
        color: #666;
        line-height: 1.2em;
    }

    #invoice-POS #top,
    #invoice-POS #mid,
    #invoice-POS #bot {
        /* Targets all id with 'col-' */
        border-bottom: 1px solid #eee;

    }

    #invoice-POS #top {}

    #invoice-POS #mid {}

    #invoice-POS #bot {
        flex: auto;
        display: flex;
        flex-direction: column;
    }

    #invoice-POS #top .logo {
        height: 60px;
        width: 60px;
        background-repeat: no-repeat;
        background-size: 60px 60px;
    }

    #invoice-POS .info {
        display: block;
        margin-left: 0;
    }

    #invoice-POS .title {
        float: right;
    }

    #invoice-POS .title p {
        text-align: right;
    }

    #invoice-POS table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }

    #invoice-POS .tabletitle {
        font-size: 1em;
        background: #eee;
    }

    #invoice-POS .service {
        border-bottom: 1px solid #eee;
    }

    #invoice-POS .item {
        width: 24mm;
        font-weight: bold;
        padding: 0.1rem;
    }

    #invoice-POS .payment {
        width: 24mm;
        font-weight: bold;
        padding: 0.1rem;
    }

    #invoice-POS .itemtext {
        font-size: 1em;
        padding: 0.2rem;
    }

    #invoice-POS #legalcopy {
        margin-top: 5mm;
        flex: auto;
    }

    .buy {
        width: 100%;
        height: 50px;
        position: relative;
        display: block;
        margin: 30px auto;
        border-radius: 0;
        border: none;
        background: #6C1776;
        color: white;
        font-size: 20px;
        transition: background 0.4s;
        cursor: pointer;
    }
</style>

<head>
    <meta name="viewport" content="initial-scale=1">
</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@php
    $variable = '';
@endphp
<body>
    <form method="post" action="{{ route('pay', $payment->uuid,$variable)}}">
        @csrf
    <div id="invoice-POS">
        <center id="top">
        <div class="logo" style="background-image: url({{asset('images/logo.jpg')}});"></div>
            <div class="info">
            <h2><span style="color: #6C1776">{{__('payment.payment_request_from')}}</span></h2>
            <h2>{{ $payment->user->full_name}}</h2>
            </div><!--End Info-->
        </center><!--End InvoiceTop-->
        <div id="mid">
            <div class="info">
                <h2 style="color: #6C1776">{{__('payment.contact_info')}}</h2>
                <p>
                    {{$payment->user->city ? $payment->user->city->name : '-'}}</br>
                    {{$payment->user->email ?? '-'}}</br>
                    {{-- Remove the international code --}}
                    {{ str_replace($internationalCode, '0', $payment->user->phone) }}</br>
                </p>
            </div>
        </div><!--End Invoice Mid-->

        <div id="bot">
            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td style="color: #6C1776" class="item">
                            {{__('payment.payment_details')}}
                        </td>
                    </tr>
                    <tr class="service">
                        <td class="tableitem">
                            <p class="itemtext">
                            <h2>{{$payment['details']}}</h2>
                            </p>
                        </td>
                    </tr>
                    <tr class="tabletitle" @if($language == 'ar')style="direction: rtl;" @endif>
                        <td>
                            <span style="width: 14ch; display: inline-block; color: #6C1776">{{__('payment.amount')}}</span>

                            {{number_format($payment['amount']) }} {{__('payment.currency')}}
                        </td>
                    </tr>

                    <tr class="tabletitle" @if($language == 'ar')style="direction: rtl;" @endif>
                        <td>
                            <span style="width: 14ch; display: inline-block; color: #6C1776">{{__('payment.fees')}}</span>

                            {{number_format($payment['fees_value']) }} {{__('payment.currency')}}
                        </td>
                    </tr>

                    <tr class="tabletitle" @if($language == 'ar')style="direction: rtl;" @endif>
                        <td class="payment">
                            <span style="width: 14ch; display: inline-block; color: #6C1776">{{__('payment.total')}}</span>

                            {{number_format($payment['amount'] + $payment['fees_value'])}} {{__('payment.currency')}}
                            @if($payment['payment_type'] != 'NORMAL')
                            <a class="btn" onclick="toggleDiv()"><i class="fa fa-edit"></i></a>
                            <div id="toggleDiv" class="hidden">
                                <input type="number" min="20" step="1" max="{{$payment['amount'] + $payment['fees_value']}}" id="inputVariable" >
                                <input id="part" name="part" hidden="true">
                                <button type="button" onclick="editPrice()">تعديل السعر</button>
                            </div>
                             @endif
                        </td>
                    </tr>
                    <tr id="part_payment"  class="tabletitle" style="@if($payment['actual_payment'] == null || $payment['actual_payment'] == $payment['amount']) display: none;@endif  @if($language == 'ar') direction: rtl; @endif" >
                        <td class="payment">
                            <span  style="width: 14ch; display: inline-block; color: #6C1776">المبلغ الجزئي</span>
                            <span id="partPaymentDisplay">{{$payment['actual_payment'] }}</span>
                            <span> {{__('payment.currency')}}</span>
                        </td>
                    </tr>
                    <tr id="part_fee"  class="tabletitle" style="@if($payment['actual_payment'] == null || $payment['actual_payment'] == $payment['amount']) display: none; @endif   @if($language == 'ar') direction: rtl; @endif" >
                        <td class="payment">
                            <span  style="width: 14ch; display: inline-block; color: #6C1776">الرسوم الجزئية</span>
                            <span id="partFeeDisplay">{{$payment['actual_fee'] }} </span>
                            <span> {{__('payment.currency')}}</span>

                        </td>
                    </tr>
                </table>

            </div><!--End Table-->
            <div id="legalcopy">
                <p class="legal"><strong>{{__('payment.payment_pay_button_details')}}</strong>
                </p>
                <p  style="color: #6C1776" class="legal"><strong>{{__('payment.payment_banks_details')}}</strong>
                </p>

            </div>
            <button class="buy" type="submit">{{__('payment.pay')}}</button>
        </div>
    </div>
</form><!--End InvoiceBot-->
</body>
<style>
    .hidden {
        display: none;
    }
</style>
<script>

    function toggleDiv() {
        var div = document.getElementById("toggleDiv");
        if (div.classList.contains("hidden")) {
            div.classList.remove("hidden");
        } else {
            div.classList.add("hidden");
        }
    }

    function editPrice() {
       const editedPrice = document.getElementById('inputVariable').value;
       const intPrice = Number.parseInt(editedPrice);
        if (intPrice >= {{$payment['amount'] + $payment['fees_value']}}){
            alert("لا يمكن ان يكون المبلغ الجزئي اكبر من المبلغ الاجمالي");
            return;
        }
        toggleDiv();
        document.getElementById('partPaymentDisplay').innerText = intPrice.toString();
        document.getElementById('partFeeDisplay').innerText = {{$payment['fees_percentage']}} == 0 ? 0 :  (intPrice / {{$payment['fees_percentage']}}).toString();
        document.getElementById('part').value = intPrice;
        document.getElementById('part_payment').style.display = '';
        document.getElementById('part_fee').style.display = '';

    }
</script>
</html>


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
        background: #42C2DF;
        color: white;
        font-size: 20px;
        transition: background 0.4s;
        cursor: pointer;
    }
</style>

<head>
    <meta name="viewport" content="initial-scale=1">
</head>

<body>
    <form action="{{ route('pay', $payment->uuid)}}">
    <div id="invoice-POS">
        <center id="top">
            <div class="logo" style="background-image: url({{count($payment->user->media) > 0 ? $payment->user->media[0]->original_url :'http://michaeltruong.ca/images/logo1.png'}});"></div>
            <div class="info">
                <h2>{{ $payment['payer_name'] }}</h2>
            </div><!--End Info-->
        </center><!--End InvoiceTop-->
        <div id="mid">
            <div class="info">
                <h2>{{__('payment.contact_info')}}</h2>
                <p>
                    {{$payment->user->city ? $payment->user->city->name : '-'}}</br>
                    {{$payment->user->email ?? '-'}}</br>
                    {{$payment->user->phone}}</br>
                </p>
            </div>
        </div><!--End Invoice Mid-->

        <div id="bot">
            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item">
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
                    <tr class="tabletitle">
                        <td>
                            <span style="width: 10ch; display: inline-block">{{__('payment.amount')}}</span>

                            {{$payment['amount'] }}
                        </td>
                    </tr>

                    <tr class="tabletitle">
                        <td>
                            <span style="width: 10ch; display: inline-block">{{__('payment.fees')}}</span>

                            {{$payment['fees_value'] }}
                        </td>
                    </tr>

                    <tr class="tabletitle">
                        <td class="payment">
                            <span style="width: 10ch; display: inline-block">{{__('payment.total')}}</span>

                            {{$payment['amount'] + $payment['fees_value']}}
                        </td>
                    </tr>

                </table>

            </div><!--End Table-->
            <div id="legalcopy">
                <p class="legal"><strong>{{__('payment.thank_you_for_your_business')}}</strong> {{__('payment.payment_expected_within_31_days')}}
                </p>
            </div>
            <button class="buy" type="submit">{{__('payment.pay')}}</button>
        </div>
    </div>
</form><!--End InvoiceBot-->
</body>

</html>


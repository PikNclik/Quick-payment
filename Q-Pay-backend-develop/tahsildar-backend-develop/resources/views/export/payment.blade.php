<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Claim</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('{{ storage_path("fonts/DejaVuSans.ttf") }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'DejaVu Sans', serif;
            font-size: 10px;


        }

        tr {
            line-height: 2;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <table style="width: 100%;">
            <tr>
                
                <td >
                    <h1>QPAY</h1>
                    <h2>{{ $payment->user->full_name}}</h2>
                </td>
                <td>
                <img width="100px" src="{{$img_url}}" />
                </td>
            </tr>
        </table>
    </div>

    <div>
        <h2>{{__('payment_export.claim_details')}}</h2>


        <table>
            <tr>
                <td>{{__('payment_export.invoice_number')}}</td>
                <td>{{$payment->id}}</td>
                <td>{{__('payment_export.customer_name')}}</td>
                <td>{{$payment->customer->name}}</td>
            </tr>
            <tr>
                <td>{{__('payment_export.customer_mobile')}}</td>
                <td>{{$payment->customer->phone}}</td>
                <td>{{__('payment_export.requested_payment_value')}}</td>
                <td>{{$payment->amount}}</td>
            </tr>
            <tr>
                <td>{{__('payment_export.payment_request_date')}}</td>
                <td>{{$paymentRequestDate}}</td>
                <td>{{__('payment_export.status')}}</td>
                <td>{{__('payment_export.'.$status)}}</td>
            </tr>
            <tr>
                <td>{{__('payment_export.settlement_date')}}</td>
                <td>-</td>
                <td>{{__('payment_export.hash_card')}}</td>
                <td>{{$payment->hash_card}}</td>
            </tr>
            <tr>
                <td>{{__('payment_export.transaction_date')}}</td>
                <td>{{$transactionDate}}</td>
                <td>{{__('payment_export.fees_percentage')}}</td>
                <td>{{$payment->fees_percentage}}</td>
            </tr>
            <tr>
                <td>{{__('payment_export.from')}}</td>
                <td>{{$from}}</td>
                <td>{{__('payment_export.to')}}</td>
                <td>{{$to}}</td>
            </tr>
            <tr>
                <td>{{__('payment_export.fees_value')}}</td>
                <td>{{$payment->fees_value}}</td>
                <td>{{__('payment_export.payment_details')}}</td>
                <td>{{$payment->details}}</td>
            </tr>

        </table>
    </div>
</body>

</html>
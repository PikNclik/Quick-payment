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
            <button class="buy" type="button" onclick="{{route('confirm',$payment->uuid)}}">{{__('payment.confirm')}}</button>
            <button class="buy" type="button" onclick="{{route('reverse',$payment->uuid)}}">{{__('payment.reverse')}}</button>
</form><!--End InvoiceBot-->
</body>

</html>


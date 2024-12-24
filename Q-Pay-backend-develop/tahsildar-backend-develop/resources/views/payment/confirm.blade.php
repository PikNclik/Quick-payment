<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Button Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .button-container {
            text-align: center;
        }

        .confirm-button, .reverse-button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 5px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }

        .confirm-button {
            background-color: #4caf50;
            color: white;
        }

        .reverse-button {
            background-color: #f44336;
            color: white;
        }

        .confirm-button:hover, .reverse-button:hover {
            opacity: 0.8;
        }

        a {
            text-decoration: none;
        }

        /* Responsive Styles */
        @media screen and (max-width: 600px) {
            .button-container {
                flex-direction: column;
                align-items: center;
            }

            .confirm-button, .reverse-button {
                width: 100%;
            }
        }



    </style>
</head>
<body>
<div class="button-container">
    <a href="{{route('confirm',$payment->uuid)}}" class="confirm-button">{{__('payment.confirm')}}</a>
    <a href="{{route('reverse',$payment->uuid)}}" class="reverse-button">{{__('payment.reverse')}}</a>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Link</title>
</head>
<body>
    <h1>{{ $payment->user->full_name }} merchant is requesting {{ $payment->amount }} amount from you</h1>
    <h2>Pay using this link</h2>
    <a href="{{ config('app.url').'/payForm/'.$payment->id}}">Press Here!</a>
</body>
</html>

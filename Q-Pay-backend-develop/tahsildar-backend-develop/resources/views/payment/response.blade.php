<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Success</title>
    <style>
.success-page img{
  max-width:90px;
  display: block;
  margin: 0 auto;
}
h2{
    font-weight: bold;
    color:#47c7c5;
    /*margin-top: 125px;*/

}
a{
  text-decoration: none;
}
    </style>
</head>
<body style="">
    <div class="success-page">

        <div class="inner-div" style="display: flex; justify-content: center; flex-direction: column; align-items: center;min-height: 100vh">
            <img  src="{{asset('images/green_checkmark.png')}}" class="center" style="margin: 10px" alt="" />
       <h2>تمت عملية الدفع بنجاح</h2>
        <a href="{{$link}}" target="_blank">
            <img src="{{ asset('images/done_payment.jpg') }}" alt="app link" style="margin: 10px;width: 350px!important;max-width: 350px!important; height: 200px;">
        </a>
     </div>
     </div>

</body>
</html>

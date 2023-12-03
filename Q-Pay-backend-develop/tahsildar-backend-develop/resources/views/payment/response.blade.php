<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Success</title>
    <style>
        .success-page{
  max-width:300px;
  display:block;
  margin: 0 auto;
  text-align: center;
      position: relative;
    top: 50%;
    transform: perspective(1px) translateY(50%)
}
.success-page img{
  max-width:62px;
  display: block;
  margin: 0 auto;
}
h2{
    font-weight: bold;
    color:#47c7c5;
    margin-top: 125px;

}
a{
  text-decoration: none;
}
    </style>
</head>
<body>
    <div class="success-page">
        <img  src="{{asset('images/green_checkmark.png')}}" class="center" alt="" />
       <h2>{{ $message }}</h2>
       <p>Thanks for using our app</p>
     </div>
     </div>
</body>
</html>

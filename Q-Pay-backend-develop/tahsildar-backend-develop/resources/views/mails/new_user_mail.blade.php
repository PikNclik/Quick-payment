<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>New User created</title>
    <style>
        .container {
            height: 200px;
            justify-content: center;
            text-align: center;
            margin-bottom: 100px;
        }

        .container h1 {
            font-family: Georgia, "Times New Roman", Times, serif;
            color: #2b2a27;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>New User Created</h1>

    <h2 style="color: gray">User name: {{$user->full_name}}</h2>
    <br/>
    <h2 style="color: gray">User Phone number: {{$user->phone}}</h2>

    <br/><br/>
</div>
</body>
</html>

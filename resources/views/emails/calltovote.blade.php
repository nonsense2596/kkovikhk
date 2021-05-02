<html>
<head>
    <style>
        body{
            background-color: #000000;
        }
        .mycontent{
            background-color: #ffffff !important;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body class="bg-light">
<div class="container">
    <div class="row justify-content-center m-2">
        <div class="col-md-6 col-12  border rounded">
            <h2 class="pt-4 pb-4 text-center">Kedves {{$displayName}}!</h2>
            <hr>
            <p>{!! $mailbody !!}</p>
            <br>
            <p>Üdvözlettel,<br>
                A VIK HK csapata</p>
            <img src="{{url('/imgs/vikhk.png')}}" style="width:60px; height: 90px;">
            <hr>
            <div class="text-center">
                <a href="{{$unsuburl}}" class="text-muted">Leiratkozás</a>
            </div>
            <br>
        </div>
    </div>

</div>

</body>
</html>


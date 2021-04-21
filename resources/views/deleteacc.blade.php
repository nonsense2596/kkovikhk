<!DOCTYPE html>
<html lang="en">

<head>
    <title>asd</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{url('/css/index.css')}}">
</head>
<body class="bg-dark">

<div class="container-fluid h-100">
    <div class="row h-100">
        <div class="col-lg-12 col-12 text-light align-self-center justify-content-center text-center">
            <div class="row h-100">
                <div class="img pb-5">
                    <div class="hklogo"></div>
                </div>
                <div class="col-lg-8 offset-lg-2 col-sm-10 offset-sm-1 col-md-8 offset-md-2">
                    <h1>Biztosan törölni szeretnéd a fiókodat?</h1>
                    <br><br>
                    <div class="btn-group" role="group">
                        <a href="#" class="btn btn-outline-danger" onclick="deleteacc()">Igen</a>
                        <a href="{{ url('/')}}" class="btn btn-outline-secondary">Nem</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function deleteacc(){
        $.ajax({
            type: 'POST',
            data: {_token:"{{csrf_token()}}"},
            url: '/deleteacc',
            success:function(result){
                location.href = "{{url('/')}}";
            }
        });
    }
</script>
</body>
</html>


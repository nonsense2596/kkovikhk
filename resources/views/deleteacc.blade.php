<!DOCTYPE html>
<html lang="en">

<head>
    <title>KKO | Fiók törlése</title>
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
                        <form action="/deleteacc" method="POST">
                            @csrf
                            <div class="btn-group" role="group">
                                <button type="submit" class="btn btn-outline-danger">Igen</button>
                                <a href="{{ url('/')}}" class="btn btn-outline-secondary">Nem</a>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js" integrity="sha256-x3YZWtRjM8bJqf48dFAv/qmgL68SI4jqNWeSLMZaMGA=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha256-ecWZ3XYM7AwWIaGvSdmipJ2l1F4bN9RXW6zgpeAiZYI=" crossorigin="anonymous"></script>
</body>
</html>


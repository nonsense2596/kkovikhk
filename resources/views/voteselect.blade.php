<!DOCTYPE html>
<html lang="en">

<head>
    <title>asd</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{url('/css/voteselect.css')}}">
</head>

<body class="bg-dark" id="parallax">
    </div>
    </div>
    <div class="own-container h-100">
        <a class="img-box" id="img-left" href="{{url('/vote')}}">
            <div class="img-title">
                Kar Kiváló Oktatója
                <br>
                @if($already_voted)
                    <span class="alreadyvoted">
                        (már szavaztál)
                    </span>
                @endif
            </div>
        </a>
        <a class="img-box" id="img-right" href="{{url('/youngvote')}}">
            <div class="img-title">
                Kar Kiváló Fiatal Oktatója
                <br>
                @if($already_voted_young)
                    <span class="alreadyvoted">
                        (már szavaztál)
                    </span>
                @endif
            </div>
        </a>
    </div>

    <script src="jquery-1.7.2.js"></script>
    <script src="jquery.parallax.min.js"></script>
</body>

</html>

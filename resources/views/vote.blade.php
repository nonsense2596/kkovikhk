<!DOCTYPE html>
<html lang="en">

<head>
    <title>asd</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://daemonite.github.io/material/css/material.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/css/vote.css')}}">
</head>
<body>
    <div class="container">
        <div class="row">
            <h1>Voting page</h1>
        </div>
        <div class="row">
            <h3>choose only one</h3>
        </div>

        <div class="row">
            <form method="POST" action="/votepost" id="form1">
                @foreach($teachers as $teacher)
                    <label>
                        <input type="radio" name="organization" class="card-input-element d-none" id="demo">
                        <div class="card d-flex flex-row justify-content-between">
                            <div class="card-body my-card-header">
                                {{$teacher->name}}
                            </div>
                            <div class="card-body">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vulputate eu nulla aliquet iaculis. Curabitur dictum volutpat metus, ac finibus nunc ullamcorper ut. Sed dapibus lacus eget nisi laoreet, sit amet auctor mauris maximus. Quisque ante sapien, rutrum ut porttitor eu, ornare a enim. Morbi aliquam aliquet ipsum, eu ultrices leo semper vel. Donec eu sodales lectus, vitae gravida enim. Vestibulum tristique urna neque, vel laoreet nisi finibus ac. Aliquam tempus ante augue, non ultrices purus rutrum a.
                            </div>
                        </div>
                    </label>
                @endforeach

            </form>
        </div>
        <div class="row">
            <button type="submit" class="btn btn-primary mb-5" form="form1" value="Submit">
                Vote Now
            </button>
        </div>

    </div>


</body>
</html>

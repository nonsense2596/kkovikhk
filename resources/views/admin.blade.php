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
<body>
<div class="container-fluid h-100">
    <div class="container">
        <div class="row">
            <h1>Title</h1>
        </div>
        <div class="row">
            <div class="col-12">
                teacher list
                @foreach($teachers as $teacher)
                    <div class="row">
                        <div class="form-inline mb-2">
                            <input type="text" class="form-control mr-2" id="inputPassword2" size="15" value="{{$teacher->name}}">
                            <input type="text" class="form-control mr-2" id="inputPassword2" size="70" value="{{$teacher->description}}">
                            <button type="submit" class="btn btn-primary mr-2">A</button>
                            <button type="submit" class="btn btn-danger mr-2" data-index="{{$teacher->id}}" onClick="deleteTeacher(this)">X</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <hr>
        <div class="row">
            <form class="form-inline mb-2" method="POST" action="/addteacher" id="addteacher">
                @csrf
                <input type="text" class="form-control mr-2" id="inputPassword2" size="15" placeholder="Akari Saito" name="teachername">
                <input type="text" class="form-control mr-2" id="inputPassword2" size="70" placeholder="For being the best catgirl in the world <3" name="teacherdescription">
                <button type="submit" class="btn btn-success mr-2" form="addteacher" value="Submit">A</button>
            </form>
        </div>
    </div>
</div>
<script src="/js/jquery-1.7.2.js"></script>
<script src="/js/jquery.parallax.min.js"></script>
<script>
    function deleteTeacher(param){
        //console.log(param.dataset.index);
        var teacherid = param.dataset.index;
        $.ajax({
            type: 'POST',
            data: { _token: "{{csrf_token()}}", teacherid },
            url: '/deleteteacher',
            success: function(result){
                console.log("siker mara, go to jatszani");
                window.location.reload();
            },
            error: function(result){
                console.log("work is da poop, no more");
            }
        });
    }
</script>
</body>
</html>

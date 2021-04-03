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
            <h1>Admin page</h1>
        </div>
        <!-- VOTING PERIOD -->
        <div class="row">
            <div class="col-12">
                <h3>Voting period</h3>
                <div class="row">
                    <form class="form-inline mb-2">
                        <input type="date" class="form-control mr-2" id="startdate" name="startdate" value="{{$votingperiod->start}}">
                        <input type="date" class="form-control mr-2" id="enddate" name="enddate" value="{{$votingperiod->end}}">
                        <div class="mt-1 mr-3">
                            <button type="button" class="btn btn-success" onClick="setVotingPeriod()">S</button>
                            <button type="button" class="btn btn-danger" onClick="endVotingPeriod()">X</button>
                        </div>
                        @if(($votingperiod->start==null && $votingperiod->end==null) || (date('Y-m-d')<$votingperiod->start || date('Y-m-d')>$votingperiod->end))
                            <span>The system is currently <b><u>not</u></b> accepting votes</span>
                        @endif
                        @if(!($votingperiod->start==null && $votingperiod->end==null))
                            <span>The system is accepting votes between <b>{{$votingperiod->start}}</b> (0:01) and <b>{{$votingperiod->end}}</b> (23:59)</span>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <!-- TEACHER LIST -->
        <div class="row">
            <div class="col-12">
                <h3>Teacher list</h3>
                @foreach($teachers as $teacher)
                    <form class="row mb-2">
                        <input type="text" class="form-control mr-0 mr-md-2 mt-1 col-12 col-md-2" id="name{{$teacher->id}}" value="{{$teacher->name}}">
                        <input type="text" class="form-control mr-0 mr-md-2 mt-1 col-12 col-md-8" id="description{{$teacher->id}}" value="{{$teacher->description}}">
                        <div class="div mr-0 mr-md-2 mt-1">
                            <button type="button" class="btn btn-primary" data-index="{{$teacher->id}}" onClick="modifyTeacher(this)">M</button>
                            <button type="button" class="btn btn-danger" data-index="{{$teacher->id}}" onClick="deleteTeacher(this)">X</button>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form class="row mb-2">
                    <input type="text" class="form-control mr-0 mr-md-2 mt-1 col-12 col-md-2" id="newname" size="15" placeholder="Akari Saito">
                    <input type="text" class="form-control mr-0 mr-md-2 mt-1 col-12 col-md-8" id="newdescription" size="60" placeholder="For being the best catgirl in the world <3">
                    <div class="div mr-0 mr-md-2 mt-1">
                        <button type="button" class="btn btn-success mr-2" onClick="addTeacher()">A</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- YOUNG TEACHER LIST -->
        <br>
        <div class="row">
            <div class="col-12">
                <h3>Young Teacher list</h3>
                @foreach($teachers_young as $teacher_young)
                    <form class="row mb-2">
                            <input type="text" class="form-control mr-0 mr-md-2 mt-1 col-12 col-md-2" id="name{{$teacher_young->id}}young" value="{{$teacher_young->name}}">
                            <input type="text" class="form-control mr-0 mr-md-2 mt-1 col-12 col-md-8" id="description{{$teacher_young->id}}young" value="{{$teacher_young->description}}">
                            <div class="div mr-0 mr-md-2 mt-1">
                                <button type="button" class="btn btn-primary" data-index="{{$teacher_young->id}}" onClick="modifyTeacherYoung(this)">M</button>
                                <button type="button" class="btn btn-danger" data-index="{{$teacher_young->id}}" onClick="deleteTeacherYoung(this)">X</button>
                            </div>
                    </form>
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form class="row mb-2">
                    <input type="text" class="form-control mr-0 mr-md-2 mt-1 col-12 col-md-2" id="newnameyoung" placeholder="Akari Saito">
                    <input type="text" class="form-control mr-0 mr-md-2 mt-1 col-12 col-md-8" id="newdescriptionyoung"  placeholder="For being the best catgirl in the world <3">
                    <div class="div mr-0 mr-md-2 mt-1">
                        <button type="button" class="btn btn-success mr-2" onClick="addTeacherYoung()">A</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- pie charts -->
        <br>
        <div class="row">
            <div class="col-md-8 col-12">
                <h3>Pite diagram</h3>
                    <div id="piechart" style="width:700px; height:600px;overflow-y:hidden"></div>
            </div>
            <div class="col-md-4 col-12">
                <h3>Eredmények</h3>
                <ul>
                    @foreach($votecounts as $votecount)
                        <li><b>{{$votecount->name}}</b>: {{$votecount->count}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!-- pie charts v2 -->
        <br>
        <div class="row">
            <div class="col-12">
                <h3>Pite diagram 2</h3>
                <div class="row">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-1.7.2.js"></script>
<script src="/js/jquery.parallax.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Name', 'Vote count'],
            @foreach($votecounts as $votecount)
            ['{{$votecount->name}}',{{$votecount->count}}],
            @endforeach
        ]);

        var options = {
            title: 'Bestest Miqo\'te',
            chartArea: {left:0,top:0,width:'60%',height:'75%'},
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>
<script>
    function setVotingPeriod(){
        var startdate = document.getElementById("startdate").value;
        var enddate = document.getElementById("enddate").value;
        $.ajax({
            type: 'POST',
            data: {_token:"{{csrf_token()}}", startdate, enddate},
            url: '/setvotingperiod',
            success: function(result){
                // todo modal maybe???
                window.location.reload();
            }
        });
    }
    function endVotingPeriod(){
        $.ajax({
            type: 'POST',
            data: {_token:"{{csrf_token()}}"},
            url: '/endvotingperiod',
            success: function(result){
                window.location.reload();
            }
        })
    }

    function modifyTeacher(param){
        var teacherid = param.dataset.index;
        var teachername = document.getElementById("name"+teacherid).value;
        var teacherdescription = document.getElementById("description"+teacherid).value;
        $.ajax({
           type: 'POST',
           data: {_token: "{{csrf_token()}}", teacherid, teachername, teacherdescription},
            url: '/modifyteacher',
            success: function(result){
               window.location.reload();
            }
        });
    }
    function deleteTeacher(param){
        var teacherid = param.dataset.index;
        $.ajax({
            type: 'POST',
            data: { _token: "{{csrf_token()}}", teacherid },
            url: '/deleteteacher',
            success: function(result){
                window.location.reload();
            },
        });
    }
    function addTeacher(){
        var teachername = document.getElementById("newname").value;
        var teacherdescription = document.getElementById("newdescription").value;
        $.ajax({
            type: 'POST',
            data: { _token: "{{csrf_token()}}", teachername, teacherdescription },
            url: '/addteacher',
            success: function(result){
                document.getElementById("newname").value="";
                document.getElementById("newdescription").value="";
                window.location.reload();
            },
        });
    }
    // /////////////////////////////////////
    function modifyTeacherYoung(param){
        var teacherid = param.dataset.index;
        var teachername = document.getElementById("name"+teacherid+"young").value;
        var teacherdescription = document.getElementById("description"+teacherid+"young").value;
        $.ajax({
            type: 'POST',
            data: {_token: "{{csrf_token()}}", teacherid, teachername, teacherdescription},
            url: '/modifyteacheryoung',
            success: function(result){
                window.location.reload();
            }
        });
    }
    function deleteTeacherYoung(param){
        var teacherid = param.dataset.index;
        $.ajax({
            type: 'POST',
            data: { _token: "{{csrf_token()}}", teacherid },
            url: '/deleteteacheryoung',
            success: function(result){
                window.location.reload();
            },
        });
    }
    function addTeacherYoung(){
        var teachername = document.getElementById("newnameyoung").value;
        var teacherdescription = document.getElementById("newdescriptionyoung").value;
        $.ajax({
            type: 'POST',
            data: { _token: "{{csrf_token()}}", teachername, teacherdescription },
            url: '/addteacheryoung',
            success: function(result){
                document.getElementById("newnameyoung").value="";
                document.getElementById("newdescriptionyoung").value="";
                window.location.reload();
            },
        });
    }


</script>
</body>
</html>

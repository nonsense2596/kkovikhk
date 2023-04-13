<!DOCTYPE html>
<html lang="en">
<head>
    <title>KKO | Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{url('/css/admin.css')}}">
</head>
<body>
    
<div class="container-fluid content">
    <div class="container">
        <div class="row">
            <h1>Admin</h1>
        </div>
        <!-- VOTING PERIOD -->
        <div class="row">
            <div class="col-12">
                <h3>Szavazási időszak</h3>
                <div class="row">
                    <form class="form-inline mb-2">
                        <input type="date" class="form-control mr-2" id="startdate" name="startdate" value="{{$votingperiod->start}}">
                        <input type="date" class="form-control mr-2" id="enddate" name="enddate" value="{{$votingperiod->end}}">
                        <div class="mt-1 mr-3">
                            <button type="button" class="btn btn-success" onClick="setVotingPeriod()">S</button>
                            <button type="button" class="btn btn-danger" onClick="endVotingPeriod()">X</button>
                        </div>
                        @if(($votingperiod->start==null && $votingperiod->end==null) || (date('Y-m-d')<$votingperiod->start || date('Y-m-d')>$votingperiod->end))
                            <span>A rendszer jelenleg <b><u>nem</u></b> fogad szavazatokat</span>
                        @endif
                        @if(!($votingperiod->start==null && $votingperiod->end==null))
                            <span>A szavazás <b>{{$votingperiod->start}}</b> (0:01) és <b>{{$votingperiod->end}}</b> (23:59) között él.
                            @if(date('Y-m-d')>=$votingperiod->start)
                            A szavazásból hátralévő idő: <span id="countdowntimer">X nap Y óra Z perc ZZ másodperc.</span>
                            @endif
                            </span>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <!-- TEACHER LIST -->
        <div class="row">
            <div class="col-12">
                <h3>Oktató lista</h3>
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
                    <input type="text" class="form-control mr-0 mr-md-2 mt-1 col-12 col-md-2" id="newname" size="15" placeholder="Új név hozzáadása...">
                    <input type="text" class="form-control mr-0 mr-md-2 mt-1 col-12 col-md-8" id="newdescription" size="60" placeholder="Új indoklás hozzáadása...">
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
                <h3>Fiatal oktató lista</h3>
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
                    <input type="text" class="form-control mr-0 mr-md-2 mt-1 col-12 col-md-2" id="newnameyoung" placeholder="Új név hozzáadása...">
                    <input type="text" class="form-control mr-0 mr-md-2 mt-1 col-12 col-md-8" id="newdescriptionyoung"  placeholder="Új indoklás hozzáadása...">
                    <div class="div mr-0 mr-md-2 mt-1">
                        <button type="button" class="btn btn-success mr-2" onClick="addTeacherYoung()">A</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- pie charts -->
        <br>
        <div class="row">
            <div class="col-lg-8 col-12 chartwrapper">
                <h3>Kar Kiváló Oktatója</h3>
                <div id="piechart"></div>
            </div>
            <div class="col-lg-4 col-12">
                <h3>Eredmények ({{$votenum}})</h3>
                <ul>
                    @foreach($votecounts as $votecount)
                        <li><b>{{$votecount->name}}</b>: {{$votecount->count}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!-- line chart -->
        <div class="row">
            <div class="col-12">
                <h3>Szavazatok megoszlása idővel</h3>
                <div id="linechart_material"></div>
            </div>
        </div>
        <!-- pie charts v2 -->
        <br>
        <div class="row">
            <div class="col-lg-8 col-12 chartwrapper">
                <h3>Kar Kiváló Fiatal Oktatója</h3>
                <div id="piechartyoung"></div>
            </div>
            <div class="col-lg-4 col-12">
                <h3>Eredmények ({{$votenumyoung}})</h3>
                <ul>
                    @foreach($votecountsyoung as $votecount)
                        <li><b>{{$votecount->name}}</b>: {{$votecount->count}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!-- line chart v2 -->
        <div class="row">
            <div class="col-12">
                <h3>Fiatal Szavazatok megoszlása idővel</h3>
                <div id="linechart_materialyoung"></div>
            </div>
        </div>
        <!-- voting data -->
        <br>
        <div class="row">
            <div class="col-12">
                <h3>Szavazási adatok</h3>
                <p>Összesen <b>{{$votenum+$votenumyoung}} szavazat</b> van a rendszerben. Ebből <b>{{$votenum}} oktatóra</b> és <b>{{$votenumyoung}} fiatal oktatóra</b> érkezett <b>{{$uniquevotenum}} egyedi</b> fiókból.</p>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteVotesModal">Oktató szavazatok törlése</button>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteVotesYoungModal">Fiatal oktató szavazatok törlése</button>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-12">
                <h3>Értesítő levél kiküldése</h3>
                <form class="mb-2">
                    <div class="form-group">
                        <label for="mailsubject">Email tárgy</label>
                        <input type="text" class="form-control mr-0 mr-md-2 mt-1 col-12" id="mailsubject" value="">
                    </div>
                    <div class="form-group">
                        <label for="mailbody">Email szövegtörzs (A levél automatikusan Kedves XY-nal kezdődik, azt kihagyhatod, különben meg standard szöveget, és HTML-t eszik meg. Bootstrap inkludálva van a levélben.)
                            <br>Így néz ki: <a href="{{url('/imgs/minta.png')}}">[link]</a></label>
                        <textarea type="text" class="form-control mr-0 mr-md-2 mt-1 col-12" id="mailbody" value="" rows="3"></textarea>
                    </div>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#sendMailModal">Emailek küldése</button>
                </form>
            </div>
        </div>

    </div>

    <div class="footer-spacer"></div>

</div>





<!-- Modal -->
<div class="modal fade" id="deleteVotesModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Biztos ki akarsz törölni minden [Oktató] szavazatot?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Nem</button>
                <button type="button" class="btn btn-danger" onClick="deleteVotes()">Igen</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteVotesYoungModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Biztos ki akarsz törölni minden [Fiatal Oktató] szavazatot?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Nem</button>
                <button type="button" class="btn btn-danger" onClick="deleteVotesYoung()">Igen</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="sendMailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Biztos ki akarsz küldeni {{$subscriber_count}} levelet?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Nem</button>
                <button type="button" class="btn btn-danger" onClick="sendmail()">Igen</button>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://www.gstatic.com/charts/loader.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js" integrity="sha256-qoN08nWXsFH+S9CtIq99e5yzYHioRHtNB9t2qy1MSmc=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js" integrity="sha256-x3YZWtRjM8bJqf48dFAv/qmgL68SI4jqNWeSLMZaMGA=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha256-ecWZ3XYM7AwWIaGvSdmipJ2l1F4bN9RXW6zgpeAiZYI=" crossorigin="anonymous"></script>

<script>
    function sendmail()
    {
        var mailsubject = document.getElementById("mailsubject").value;
        var mailbody = document.getElementById("mailbody").value;
        $.ajax({
            type: 'POST',
            data: {_token:"{{csrf_token()}}",mailsubject,mailbody},
            url: '/sendmail',
            success:function(result){
                window.location.reload();
            }
        });
    }
</script>
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
            chartArea: {left:10,width:'80%',height:'75%',right:'0px'},
            backgroundColor: { 'fill': '#343A40', 'fillOpacity': 0.001 },
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>
<script>
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Name', 'Vote count'],

            @foreach($votecountsyoung as $votecount)
                ['{{$votecount->name}}',{{$votecount->count}}],
            @endforeach
        ]);

        var options = {
            chartArea: {left:10,width:'80%',height:'75%',right:'0px'},
            backgroundColor: { 'fill': '#343A40', 'fillOpacity': 0.001 },
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechartyoung'));

        chart.draw(data, options);
    }
</script>
<script>
    google.charts.load('current', {'packages':['line']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'Day');
        @if(!empty($teachers) && !is_null($vote_distribution))
            @foreach($teachers as $teacher)
                data.addColumn('number','{{$teacher->name}}');
            @endforeach

            data.addRows([
                [0, @for($i = 0; $i < $teachers->count(); $i++){!! "0.0," !!}@endfor], // TODO EZT IS DINAMIKUSRA

                @foreach($vote_distribution as $key => $value)
                    [{{$key+1}}, @foreach($value as $valu) {{$valu}}, @endforeach],
                @endforeach
            ]);
        @endif

        var options = {
            chart: {
                title: 'Szavazatok megoszlása idővel',
            },
            width: 1000,
            height: 500,
            backgroundColor: { 'fill': '#343A40', 'fillOpacity': 0.001 },
            chartArea: { 'backgroundColor': { 'fill': '#343A40', 'fillOpacity': 0.001 }},
        };

        var chart = new google.charts.Line(document.getElementById('linechart_material'));

        chart.draw(data, google.charts.Line.convertOptions(options));
    }
</script>
<script>
    google.charts.load('current', {'packages':['line']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'Day');
        @if(!empty($teachers_young) && !is_null($young_vote_distribution))
            @foreach($teachers_young as $teacher)
                data.addColumn('number','{{$teacher->name}}');
            @endforeach

            data.addRows([
                [0, @for($i = 0; $i < $teachers_young->count(); $i++){!! "0.0," !!}@endfor],    // TODO EZT IS DINAMIKUSRA
                
                @foreach($young_vote_distribution as $key => $value)
                    [{{$key+1}}, @foreach($value as $valu) {{$valu}}, @endforeach],
                @endforeach
            ]);
        @endif


        var options = {
            chart: {
                title: 'Fiatal Szavazatok megoszlása idővel',
            },
            width: 1000,
            height: 500,
            backgroundColor: { 'fill': '#343A40', 'fillOpacity': 0.001 },
            chartArea: { 'backgroundColor': { 'fill': '#343A40', 'fillOpacity': 0.001 }},
        };

        var chart = new google.charts.Line(document.getElementById('linechart_materialyoung'));

        chart.draw(data, google.charts.Line.convertOptions(options));
    }
</script>
<script>
    function deleteVotes()
    {
        $.ajax({
            type: 'POST',
            data: {_token:"{{csrf_token()}}"},
            url: '/deletevotes',
            success: function(result){
                window.location.reload();
            }
        });
    }

    function deleteVotesYoung()
    {
        $.ajax({
            type: 'POST',
            data: {_token:"{{csrf_token()}}"},
            url: '/deletevotesyoung',
            success: function(result){
                window.location.reload();
            }
        });
    }

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
                window.location.reload(true);
            },
        });
    }
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
                window.location.reload(true);
            },
        });
    }
</script>
@if(!($votingperiod->start==null && $votingperiod->end==null) && date('Y-m-d')>=$votingperiod->start)
<script>
    var countDownDate = new Date("{{$votingperiod->end}} 23:59").getTime();
    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        document.getElementById("countdowntimer").innerHTML = days + " nap " + hours + " óra "
            + minutes + " perc " + seconds + " másodperc ";
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdowntimer").innerHTML = "VÉGET ÉRT";
        }
    }, 1000);
</script>
@endif
</body>
</html>

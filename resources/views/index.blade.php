<!DOCTYPE html>
<html lang="en">

<head>
    <title>KKO | Főoldal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css"  href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{url('/css/index.css')}}">
</head>
<body class="bg-dark" id="parallax">
<div class="container-fluid h-100">
    <div class="row h-100">
        <div class="col-lg-4 col-12 text-light align-self-center justify-content-center text-center">
            <div class="row h-100">
                <div class="img pb-5">
                    <div class="hklogo"></div>
                </div>
                <div class="col-lg-8 offset-lg-2 col-sm-10 offset-sm-1 col-md-8 offset-md-2">
                    <h1>Kar Kiváló Oktatója Portál</h1>
                    <br><br>
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            @auth
                                <br>
                                @if($isvotingperiod)
                                    @if($already_voted && $already_voted_young) <!-- WORKING AREA -->
                                        <h5 class="text-secondary">Már szavaztál.</h5>
                                    @else
                                        <a href="{{ url('/voteselect') }}" class="btn btn-primary col-lg-12 col-12">Tovább a szavazáshoz</a>
                                    @endif
                                @else
                                    <a href="#" class="btn btn-secondary col-lg-12 col-12 disabled" aria-disabled="true">Jelenleg nincs szavazási időszak</a>
                                @endif
                            @endauth
                            @guest
                                <a href="{{ url('auth/schonherz') }}" class="btn btn-primary col-lg-12 col-12">Authsch bejelentkezés</a>
                            @endguest
                            @auth
                                @if($current_user->isadmin)
                                    <a href="{{ url('/admin') }}" class="btn btn-success col-lg-12 col-12 mt-2">Admin</a>
                                @endif
                                <a href="{{ url('auth/schonherz/logout') }}" class="btn btn-danger col-lg-12 col-12 mt-2">Kijelentkezés</a>
                            @endauth
                            @auth
                                <div class="custom-control custom-checkbox options">
                                    <input type="checkbox" class="custom-control-input checkbox" id="customCheck1" onclick="oncheckedchange()" @if($current_user->reqmail) {!! "checked" !!} @endif>
                                    <label class="custom-control-label" for="customCheck1">E-mail új szavazásokról</label>
                                </div>
                            @endauth
                            @auth
                                <a href="{{url('/deleteacc')}}" class="options">Fiók törlése</a>
                            @endauth

                        </div>
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
        <div class="col-lg-8  bg-light" id="bgimg">
            <div class="bg">
            </div>
        </div>
    </div>
</div>


<div class="toastnotification" id="toastnotification"></div>

<script src="/js/jquery-1.7.2.js"></script>
<script src="/js/jquery.parallax.min.js"></script>


<script>
    function showtoast(message){
        document.getElementById("toastnotification").innerHTML = message;
        jQuery('.toastnotification').fadeIn(400).delay(3000).fadeOut(400);
    }

    @if(session('message'))
        showtoast("{{session('message')}}");
    @endif


    function oncheckedchange(value){
        $.ajax({
            type: 'PUT',
            data: {_token:"{{csrf_token()}}"},
            url: '/reqmailchange',
            success: function(result){
                showtoast("Sikeresen módosítottad a levelezési preferenciákat!");
            }
        });
    }
    jQuery(document).ready(function() {

        jQuery(document.body).one('mouseenter', function() {
            setTimeout(function() {
                jQuery('.bg').animate({
                    opacity: 0.3
                }, 500);
            }, 500);
        });
        jQuery('.bg').parallax({
            frameDuration: 20,
            xparallax: '25px',
            yparallax: '25px'
        });
    });

</script>
</body>

</html>

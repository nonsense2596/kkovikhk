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
                                <h5>Már be vagy jelentkezve</h5>
                                <br>
                                @if($isvotingperiod)
                                    <a href="{{ url('/voteselect') }}" class="btn btn-primary col-lg-12 col-12">Tovább a szavazáshoz</a>
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
                                    <input type="checkbox" class="custom-control-input checkbox" id="customCheck1" onclick="ohmyclick()">
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

<script src="/js/jquery-1.7.2.js"></script>
<script src="/js/jquery.parallax.min.js"></script>
@if(session('message'))
    @include('toast', array('message'=>session('message')))
@endif
<script>
    function ohmyclick(){
        alert('lol');
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

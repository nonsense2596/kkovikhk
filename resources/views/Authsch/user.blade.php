<!DOCTYPE html>
<html>
<head>
    <title>User Information</title>
    <style>
        p{
            margin:3px;
        }
        .tab{
            margin-left: 2em;
        }
    </style>
</head>

    <h1>Basic information</h1>
    <p>Name: {{$user->displayName}}</p>
    <p>Mail: {{$user->mail}}</p>
    <p>BME status: {{$user->bmeunitscope}}</p>
    <p>Address: {{$user->permanentaddress}}</p>
    <p>Date of birth: {{$user->birthdate}}</p>
</body>
</html>




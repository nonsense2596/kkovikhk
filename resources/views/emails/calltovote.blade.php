<html>
<head>
    <style>
        @media only screen and (max-width: 600px){
            table{
                width:100% !important;
            }
        }
    </style>
</head>
<body style="background-color:#f8f9fa!important">
<table style="width:50%;margin-left:auto;margin: auto;border:1px solid #d0d0d0;border-radius: 5px;background-color: white;">
    <tbody>
    <tr>
        <td>
            <h2 style="text-align: center !important;margin-top:10px;margin-bottom:10px;">Kedves {{$displayName}}!</h2>
            <hr style="border-top:1px solid lightgrey;border-bottom: 0;border-right:0;border-left:0;">
        </td>
    </tr>
    <tr>
        <td style="padding-left:20px;">
            {!! $mailbody !!}
            <p>Üdvözlettel,<br>
                A VIK HK csapata</p>
            <img src="{{$message->embed(public_path() . '/imgs/vikhk.png')}}" style="width:60px; height: 90px;">
        </td>
    </tr>
    <tr>
        <td style="text-align: center !important;padding-bottom:10px;">
            <hr style="border-top:1px solid lightgrey;border-bottom: 0;border-right:0;border-left:0;">
            <a href="{{$unsuburl}}" style="color: #6c757d !important;">Leiratkozás</a>
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>


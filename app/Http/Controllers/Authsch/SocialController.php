<?php

namespace App\Http\Controllers\Authsch;


use Illuminate\Http\Request;
use App\Models\Authsch\User;
use Validator;
use Socialite;
use Exception;
use Auth;
use App\Http\Controllers\Controller as Controller;

class SocialController extends Controller
{

    public function schonherzRedirect()
    {
        return Socialite::driver('authsch')->redirect();
    }
    public function loginWithSchonherz()
    {
        $user = Socialite::driver('authsch')->stateless()->user();

        $authuser = null;
        if($dbuser = User::where('id',$user->id)->first()){
            $authuser = $dbuser;
        }
        else{

            // ------====== BASIC USER INFORMATIONS ======------
            $authuser = User::create([
                'id' => $user->id,
                'displayName' => $user->displayName,
                'sn' => $user->sn,
                'givenName' => $user->givenName,
                'mail' =>$user->mail,
                'mobile' => $user->mobile,
                'bmeunitscope' => self::get_unit_scope($user->bmeunitscope),
                'permanentaddress' => $user->permanentaddress,
                'birthdate' => $user->birthdate,
            ]);

            $authuser->save();
        }

        Auth::login($authuser);

        return redirect('/voteselect');
    }


    public function logoutOfSchonherz()
    {
        Auth::logout();
        return redirect('/');
    }

    public function get_unit_scope($bmeunitscope){
        // ------====== BME UNIT SCOPE (BME, VIK, ACTIVE, PASSIVE...) ======------
        $bmeunitscopes = self::multi_implode($bmeunitscope,";");

        $actualscope = null;
        if(is_null($bmeunitscopes))
        {
            $actualscope = "NULL";
        }
        else {       // longest prefix match
            if (str_contains($bmeunitscopes,"BME_VIK_NEWBIE"))
                $actualscope = "VALAKI";
            else if (str_contains($bmeunitscopes,"BME_VIK_ACTIVE"))
                $actualscope = "VIKES AKTIV";
            else if (str_contains($bmeunitscopes,"BME_VIK"))
                $actualscope = "VIKES";
            else if (str_contains($bmeunitscopes,"BME"))
                $actualscope = "BMES";
            else {
                $actualscope = "NULL-else";
            }
        }
        return $actualscope;
    }

    public function multi_implode($array, $glue)
    {
        if(is_null($array)){
            return null;
        }
        $ret = '';
        foreach ($array as $item) {
            if (is_array($item)) {
                $ret .= self::multi_implode($item, $glue) . $glue;
            } else {
                $ret .= $item . $glue;
            }
        }
        $ret = substr($ret, 0, 0-strlen($glue));
        return $ret;
    }

}

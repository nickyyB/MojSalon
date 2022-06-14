<?php namespace App\Validation;

/*
 * Autor: Nikola Brkovic 0647/2014
 *
 */

class MyRules
{
    
    function username_check_blank($str, &$error=null):bool{
        $pattern = '/ /';
        $result = preg_match($pattern, $str);

        if ($result){
            $error = "Korisničko ime ne moze sadržati razmak";
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
    function special_chars($str, &$error = null):bool{
        if(preg_match('/[^a-zA-Z0-9_.]/', $str) == 0){
            return true;
        }
        else{
            $error = "Korisničko ime može sadržati samo cifre, slova, donju crtu i tačku";
            return false;
        }
    }
    
    function workingHours($str1, $str2):bool{
        $niz = explode(',', $str2);
        if(count($niz)>2) return false; //ako je neko zaobisao front validaciju i poslao nesto drugo
        if(!empty($niz[0]) and !empty($niz[1])){
            if($niz[0]>'24:00' or $niz[1]>'24:00') return false;
            if($niz[1]<=$niz[0]) return false;
            return true;
        }
        return true;
    }
    
    function check_date($str, &$error = null){
        $today = date('Y-m-d');
        $today_time = strtotime($today);
        $expire_time = strtotime($str);
        if($expire_time < $today_time){
            return true;
        }
        else {
            $error = "Datum rođenja mora biti u prošlosti";
            return false;
        }
    }
    
    function symbol_check($str, &$error = null){
        $char = substr($str, 0, 1);
        if($char == '+' or $char == '-'){
            $error = 'Broj telefona ne može sadržati + ili -';
            return false;
        }
        return true;
    }
    
}
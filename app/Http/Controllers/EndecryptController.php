<?php
namespace App\Http\Controllers;

class EndecryptController extends Controller
{

function encryptIt($sData){
    $secretKey="1234567890abcdefghijklmnopqrstuvwxyz";
    $sResult = '';
    for($i=0;$i<strlen($sData);$i++){
        $sChar    = substr($sData, $i, 1);
        $sKeyChar = substr($secretKey, ($i % strlen($secretKey)) - 1, 1);
        $sChar    = chr(ord($sChar) + ord($sKeyChar));
        $sResult .= $sChar;

    }
    return base64_encode($sResult);
} 

function decryptIt($sData){
    $secretKey="1234567890abcdefghijklmnopqrstuvwxyz";
    $sResult = '';
    $sData   = base64_decode($sData);
    for($i=0;$i<strlen($sData);$i++){
        $sChar    = substr($sData, $i, 1);
        $sKeyChar = substr($secretKey, ($i % strlen($secretKey)) - 1, 1);
        $sChar    = chr(ord($sChar) - ord($sKeyChar));
        $sResult .= $sChar;
    }
    return $sResult;
}
 }

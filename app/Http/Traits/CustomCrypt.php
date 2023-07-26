<?php

namespace App\Http\Traits;

trait CustomCrypt
{
    function encryptor($action, $string) {
        $output = FALSE;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'SecretcampaignKeyWord';
        $secret_iv  = 'SecretIV@123459635GKrroQp';
        // hash
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        //do the encryption given text/string/number
        if ($action == 'encrypt') {
          $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
          $output = base64_encode($output);
        } elseif ($action == 'decrypt') {
          //decrypt the given text/string/number
          $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
      }
      
      function encrypt($data) {
        return urlencode(self::encryptor('encrypt', $data));
      }
      
      function decrypt($data) {
        return self::encryptor('decrypt', $data);
      }
}

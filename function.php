<?php


////encryptData
if (!function_exists('encryptData')) {
    function encryptData($plaintext)
    {
        $password = "yEfHZ18ly"; //$this->objDefaultVariable->VAR_PASSWORD_CRYPTO_KEY;
        //$password = $this->objDefaultVariable->VAR_PASSWORD_CRYPTO_KEY;

        $rand_IV = date('His', time()) . mt_rand();
        $rand_IV = str_shuffle($rand_IV);
        $encrypt_method = "AES-256-CBC";
        $secret_key = $password;

        $secret_iv = $rand_IV;
        $secret_iv_first = strrev(substr($secret_iv, 0, 5));
        $secret_iv_last = strrev(substr($secret_iv, -5));
        $secret_iv = $secret_iv_last . '9' . $secret_iv_first;
        // hash
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_encrypt($plaintext, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        $d["enc_text"] = $output;
        $d["salt"] = $rand_IV;
        return $d;
    }
}


/////decryptData//////
if (!function_exists('decryptData')) {
    function decryptData($string, $salt)
    {
        $password = "yEfHZ18ly"; //$this->objDefaultVariable->VAR_PASSWORD_CRYPTO_KEY;
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = $password;
        $secret_iv = $salt;

        $secret_iv_first = strrev(substr($secret_iv, 0, 5));
        $secret_iv_last = strrev(substr($secret_iv, -5));
        $secret_iv = $secret_iv_last . '9' . $secret_iv_first;

        // hash
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }
}

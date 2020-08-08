<?php
namespace FootballBlog\Processors;

use FootballBlog\Utils\EncryptConfig;

class Encrypt {


    /**
     * @param $username
     * @param $password
     * @return string
     */
    public function encryptString($username, $password){
        try{
            $secret_key = $username;
            $string = $password;
            $encrypt_method = EncryptConfig::ENCRYPT_METHODS;
            $secret_iv = EncryptConfig::ENCRYPT_IV;
            // hash
            $key = hash('sha256', $secret_key);

            // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
            $iv = substr(hash('sha256', $secret_iv), 0, 16);

            //encrypt the string using open ssl
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);



            return $output;
        }catch(Exception $e){

        }

    }

    /**
     * @param $username
     * @param $password
     * @return string
     */
    public function decryptString($username, $password){
        try{
            $secret_key = $username;
            $string = $password;

            $encrypt_method = EncryptConfig::ENCRYPT_METHODS;
            $secret_iv = EncryptConfig::ENCRYPT_IV;
            // hash
            $key = hash('sha256', $secret_key);

            // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
            $iv = substr(hash('sha256', $secret_iv), 0, 16);

            //decrypt the string using open ssl
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

            return $output;
        }catch(Exception $e){

        }
    }
}
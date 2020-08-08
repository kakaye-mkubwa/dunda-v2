<?php


namespace FootballBlog\Processors;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Exception\BadFormatException;
use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
use Defuse\Crypto\Key;
use FootballBlog\Utils\EncryptConfig;

class EncryptHandler
{
    public function loadEncryptionKeyFromConfig()
    {
        $keyAscii = EncryptConfig::mKey;
        try {
            $output= Key::loadFromAsciiSafeString($keyAscii);
        } catch (BadFormatException $e) {
            $output = "error";
        } catch (EnvironmentIsBrokenException $e) {
            $output = "error";
        }

        return $output;
    }

    public function decrypt($ciphertext){
        $key = $this->loadEncryptionKeyFromConfig();
        // ...
        try {
            $secret_data = Crypto::decrypt($ciphertext, $key);
            $output = $secret_data;
        } catch (WrongKeyOrModifiedCiphertextException $ex) {
            // An attack! Either the wrong key was loaded, or the ciphertext has
            // changed since it was created -- either corrupted in the database or
            // intentionally modified by Eve trying to carry out an attack.

            // ... handle this case in a way that's suitable to your application ...
            $output = "error";
        } catch (EnvironmentIsBrokenException $e) {
            $output = "error";
        }
        return $output;
    }

    public function encrypt($secret_data){
        // ...
        $key = $this->loadEncryptionKeyFromConfig();
        // ...
        try {
            $output = $ciphertext = Crypto::encrypt($secret_data, $key);
        } catch (EnvironmentIsBrokenException $e) {
            $output = "error";
        }
        return $output;
    }
}
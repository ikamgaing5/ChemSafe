<?php

class IdEncryptor {
    private static $key = 'flUhRq6tzZclQEJ-Vdg-IuiaDsNc';

    public static function encode($id) {
        return urlencode(base64_encode(openssl_encrypt($id, 'AES-128-ECB', self::$key)));
    }

    public static function decode($encrypted) {
        return openssl_decrypt(base64_decode(urldecode($encrypted)), 'AES-128-ECB', self::$key);
    }
}

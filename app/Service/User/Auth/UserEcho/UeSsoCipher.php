<?php

namespace App\Service\User\Auth\UserEcho;

class UeSsoCipher
{
    const CIPHER = "AES-256-CBC";
    /**
     * @var string
     */
    private $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function encrypt($data_json): string
    {
        // add expires if does not exist
        if (!array_key_exists('expires', $data_json)){
            # add 1 hour
            $data_json['expires'] = time()+3600;
        }
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher=self::CIPHER));
        $ciphertext_raw = openssl_encrypt(json_encode($data_json), self::CIPHER, $this->key, $options=OPENSSL_RAW_DATA, $iv);
        return urlencode(base64_encode($iv . $ciphertext_raw));
    }
}

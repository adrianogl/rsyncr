<?php

namespace Rsyncr\Storage;


class Encrypter
{
    /**
     * @var string Encryption cipher
     */
    protected $cipher = 'AES-256-CBC';

    /**
     * @var int IV Size
     */
    protected $iv_size = 16;

    /**
     * @var string Encryption key
     */
    protected $key;

    /**
     * Encrypter constructor.
     *
     * @param $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Encrypt the given value.
     *
     * @param string $value
     * @return string
     * @throws \Exception
     */
    public function encrypt($value)
    {
        // Generate a IV.
        $iv = random_bytes($this->iv_size);

        // Encrypt the value.
        $value = \openssl_encrypt(serialize($value), $this->cipher, $this->key, 0, $iv);

        // If the value was not encrypted successfully.
        if ($value === false) {
            // Throw a exception.
            throw new \RuntimeException('Could not Encrypt the give value.');
        }

        // Calculate the HMAC.
        $mac = hash_hmac('sha256', $iv.$value, $this->key);

        // Encode IV into encodable format.
        $iv = base64_encode($iv);

        // Encode the IV, Value and HMAV into a JSON Payload that will be stored.
        $json = json_encode(compact('iv', 'value', 'mac'));

        // Check for the encoded json string
        if (!is_string($json)) {
            throw new \RuntimeException('Could not Encrypt the give value.');
        }

        // return the encrypted and encoded payload
        return base64_encode($json);
    }

    /**
     * Decrypt a given value.
     *
     * @param string $payload The encrypted payload
     *
     * @return mixed The Decrypted value.
     */
    public function decrypt($payload)
    {
        // Decode the json payload into a array.
        $payload = json_decode(base64_decode($payload), true);

        // Get the IV from the payload.
        $iv = base64_decode($payload['iv']);

        // Decrypt the value using the key and IV
        $decrypted = \openssl_decrypt($payload['value'], $this->cipher, $this->key, 0, $iv);

        // If the value was not correctly encrypted
        if ($decrypted === false) {
            // Throw an exception
            throw new \RuntimeException('Could not decrypt the given payload.');
        }

        // return the decrypted value.
        return unserialize($decrypted);
    }

    /**
     * Static Key generation method.
     *
     * @return string A random encryption key.
     * @throws \Exception
     */
    public static function generateKey()
    {
        return base64_encode(random_bytes(32));
    }

    /**
     * Decrypt a array of values.
     *
     * @param array $data Encrypted array payload.
     *
     * @return array Decrypted array.
     */
    public function decryptArray(array $data)
    {
        $decryptedArray = [];

        foreach ($data as $key => $payload) {
            $decryptedArray[$key] = $this->decrypt($payload);
        }

        return $decryptedArray;
    }

    /**
     * Encrypt a given array.
     *
     * @param array $data Array to be encrypted.
     *
     * @return array Encrypted array.
     */
    public function encryptArray(array $data)
    {
        $encryptedArray = [];

        foreach ($data as $key => $value) {
            $encryptedArray[$key] = $this->encrypt($value);
        }

        return $encryptedArray;
    }
}
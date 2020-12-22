<?php
/**
 * Created by Alex Negoita
 * IDE: PHP Storm
 * Date: 6/21/2019
 * Time: 5:48 PM
 * PHP Version 7
 */

namespace rpa\erektorcore;

/*
 * Unique random tokens
 */
class Token
{

    /**
     * The token value
     * @var array
     */
    protected $token;

    /**
     * Class constructor. Create a new random token or assign an existing one if passed in.
     *
     * @param null $token_value
     * @throws \Exception
     */
    public function __construct($token_value = null)
    {
        if ($token_value) {

            $this->token = $token_value;

        } else {

            $this->token = bin2hex(random_bytes(16));  // 16 bytes = 128 bits = 32 hex characters
        }
    }

    /**
     * Get the token value
     *
     * @return string The value
     */
    public function getValue()
    {
        return $this->token;
    }

    /**
     * Get the hashed token value
     *
     * @return string The hashed value
     */
    public function getHash()
    {
        return hash_hmac('sha256', $this->token, Config::SECRET_KEY);  // sha256 = 64 chars
    }
}
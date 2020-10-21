<?php


class ModelJWT
{
    private string $key;
    private string $token;

    public function __construct() {
        $this->key = "2vUpNF5tNw0Eys4yLkln-0SN7VhbXz1WWrlt1xQ_ZufEPSxlIs95X2nhaKuWB";
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }


}
<?php
require("../model/ModelJWT.php");
require_once __DIR__ . '/../lib/vendor/autoload.php';
use \Firebase\JWT\JWT;

class ControllerJWT
{
    private ModelJWT $jwt;

    /**
     * ControllerJWT constructor.
     */
    public function __construct() {
        date_default_timezone_set('America/Sao_Paulo');
        $this->jwt = new ModelJWT();
    }

    /**
     * @param $codUsuario
     * @return string
     */
    public function encode($codUsuario) {
        $payload = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => time(),
            "exp" => time()+3600,
            "sub" => $codUsuario
        );

        return JWT::encode($payload, $this->jwt->getKey(), 'HS256');
    }

    /**
     * @param $token
     * @return string
     */
    public function decode($token) {
        return JWT::decode($token , $this->jwt->getKey(), array('HS256'));
    }

    /**
     * @param $headers
     * @return string
     */
    public function validation($headers) {
        if (!empty($headers['Authorization'])) {
            $bearer = explode(" ", $headers['Authorization']);
            if($bearer[1] != 'undefined')
                return $this->decode($bearer[1]);
            else
                return false;
        }else{
            return false;
        }
    }
}
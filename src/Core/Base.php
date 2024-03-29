<?php


namespace Gomobile\GomobileNOsixBundle\Core;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class Base
{
    protected $login;
    protected $password;
    protected $isLocal;
    protected $httpClient;
    protected $url;

    const BASE_LOCAL_DOMAIN = "http://10.40.100.52:8080/external/";

    const POST_MULTIPLE_SIMPLE_CALL = "post_simple_call_v2";
    const POST_MULTIPLE_DYNAMIC_CALL = "post_dynamic_call_v2";

    const POST_FILE_CALL = "post_file_call";

    public function __construct($login, $password, HttpClientInterface $httpClient, $isLocal = false)
    {
        $this->login = $login;
        $this->password = $password;
        $this->isLocal = $isLocal;
        $this->httpClient = $httpClient;
    }

    public function error ($status, $message) {
        return [
            "status" => $status,
            "description" => $message,
        ];
    }

    public function success ($status, $message) {
        return [
            'status' => $status,
            'description' => $message
        ];
    }

}
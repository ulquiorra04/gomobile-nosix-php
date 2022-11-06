<?php


namespace Gomobile\GomobileNOsixBundle\Core;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class Base
{
    protected $login;
    protected $password;
    protected $isLocal;
    protected $httpClient;

    public function __construct($login, $password, HttpClientInterface $httpClient, $isLocal = false)
    {
        $this->login = $login;
        $this->password = $password;
        $this->isLocal = $isLocal;
        $this->httpClient = $httpClient;
    }

}
<?php


namespace Gomobile\GomobileNOsixBundle\Core;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class GomobileNOsix
{
    protected $login;
    protected $password;
    protected $isLocal;
    protected $client;

    public function __construct($login, $password, HttpClientInterface $httpClient, $isLocal = false)
    {
        $this->login = $login;
        $this->password = $password;
        $this->isLocal = $isLocal;
        $this->client = $httpClient;
    }

    public function call ()
    {
        return new Call($this->login, $this->password, $this->client, $this->isLocal);
    }

}
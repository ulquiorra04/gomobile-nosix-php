<?php


namespace Gomobile\GomobileNOsixBundle\Core;


use Symfony\Component\HttpClient\NativeHttpClient;

class GomobileNOsix
{
    protected $login;
    protected $password;
    protected $isLocal;
    protected $client;

    public function __construct($login, $password, $isLocal = false)
    {
        $this->login = $login;
        $this->password = $password;
        $this->isLocal = $isLocal;
        $this->client = new NativeHttpClient();
    }

    public function call ()
    {
        return new Call($this->login, $this->password, $this->client, $this->isLocal);
    }

}
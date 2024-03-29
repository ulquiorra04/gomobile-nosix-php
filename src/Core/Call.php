<?php


namespace Gomobile\GomobileNOsixBundle\Core;


use Gomobile\GomobileNOsixBundle\lib\NumberHelper;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Call extends Base
{
    public function __construct($login, $password, HttpClientInterface $httpClient, $isLocal = false)
    {
        parent::__construct($login, $password, $httpClient, $isLocal);
    }

    /**
     * @author ABDELHAMID RAHMAOUI
     * @version 1.0
     * @param $phones [{"phoneNumber": "0707071290"}, {"phoneNumber": "0707070136"}]
     * @param $scenarioId
     * @param array $options ["sda" => "05XXXXXXXX", "name" => "CMP_NAME", "date_time" => "2022-11-07 10:00:00", "config" => ["interval" => "04:00:00"]]
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function postMultipleSimpleCall ($phones, $scenarioId, $options=[])
    {
        $phones = json_decode($phones);
        $phones_osix = [];
        if(!is_array($phones) || empty($phones))
            return $this->error(0, "You have to send an array of phone numbers");

        if(!NumberHelper::isValidArrayPhoneNumbers($phones))
            return $this->error(-3, "You have to provide a valid phone numbers");

        foreach ($phones as $phoneNumber) {
            if(is_string($phoneNumber))
                $phoneNumber = json_decode($phoneNumber);

            if(!property_exists($phoneNumber, "phone"))
                return $this->error(-1, "Please provide a phoneNumber property for the object");

            if(!NumberHelper::isValidNationalNumber($phoneNumber->phone))
                return $this->error(-3, "incorrect format for phone number $phoneNumber->phone");

            array_push($phones_osix, ["phone" => $phoneNumber->phone]);
        }

        $params = [
            'scenarioId' => $scenarioId,
            'phones' => $phones_osix,
            'campaign'  => $options
        ];

        $this->url = parent::BASE_LOCAL_DOMAIN . parent::POST_MULTIPLE_SIMPLE_CALL;

        return $this->makeCall($this->url, $params);
    }

    /**
     * @param $phones [{"phoneNumber": "0707071290", "user_amount": 200}, {"phoneNumber": "0707070136", "user_amount": 400}]
     * @param $scenarioId
     * @param array $options ["sda" => "05XXXXXXXX", "name" => "CMP_NAME", "date_time" => "2022-11-07 10:00:00", "config" => ["interval" => "04:00:00"]]
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     *@author ABDELHAMID RAHMAOUI
     * @version 1.0
     */
    public function postMultipleDynamicCall ($phones, int $scenarioId, array $options=[])
    {
        $phones = json_decode($phones);
        $phones_osix = [];
        if(!is_array($phones) || empty($phones))
            return $this->error(0, "You have to send an array of phone numbers");

        if(!NumberHelper::isValidArrayPhoneNumbers($phones))
            return $this->error(-3, "You have to provide a valid phone numbers");

        foreach ($phones as $phoneNumber) {
            if(is_string($phoneNumber))
                $phoneNumber = json_decode($phoneNumber);

            if(!property_exists($phoneNumber, "phone"))
                return $this->error(-1, "Please provide a phoneNumber property for the object");

            if(!NumberHelper::isValidNationalNumber($phoneNumber->phone))
                return $this->error(-3, "incorrect format for phone number $phoneNumber->phone");


            array_push($phones_osix, (array) $phoneNumber);
        }

        $params = [
            'scenarioId' => $scenarioId,
            'phones' => $phones_osix,
            'campaign' => $options
        ];

        $this->url = parent::BASE_LOCAL_DOMAIN . parent::POST_MULTIPLE_DYNAMIC_CALL;

        return $this->makeCall($this->url, $params);
    }

    public function postFileCall (File $file, int $scenarioId, array $options = [])
    {
        $url = "";
        $response = $this->httpClient->request(
            "POST",
            $url,
            [
                "body" => ["file" => $file]
            ]
        );
    }

    /**
     * @param string $url
     * @param string $params
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @version 1.0
     * @author ABDELHAMID RAHMAOUI
     */
    public function makeCall ($url, $params)
    {
        $response = $this->httpClient->request(
            "POST",
            $url,
            [
                "json" => $params,
                "auth_basic" => [$this->login, $this->password]
            ]
        );

        if($response->getStatusCode() == 200) {
            $result = json_decode($response->getContent());
            if($result->status == 1)
                return $this->success($result->status, $result->message);
            else
                return $this->error($result->status, $result->message);
        } else {
            return $this->error($response->getStatusCode(), $response->getContent());
        }
    }

}
<?php

namespace App\Applozic\Drivers;

use App\Applozic\Contracts\DriverInterface;
use GuzzleHttp\Client;

class Patient implements DriverInterface
{
    private $authToken;

    private $patient;

    private $httpClient;

    public function __construct(Client $httpClient, $patient = null)
    {
        $this->httpClient = $httpClient;
        $this->patient = $patient ?? auth('patient')->user();
    }

    public function login()
    {
        $response = $this->httpClient->post('register/client', [
            'json' => [
                'userId' => $this->patient->id,
                'applicationId' => env('APPOLOZIC_ID', '25744aed3a58626ab31c92358cb032c0a')
            ]
        ]);

        $this->authToken = base64_encode($this->patient->id . ':' .json_decode($response->getBody()->getContents())->deviceKey);

        return $this;
    }

    public function updateProfile()
    {
        if (!$this->authToken) {
            $this->login();
        }

        $this->httpClient->post('user/update', [
            'json' => [
                'displayName' => $this->patient->first_name . ' ' . $this->patient->last_name,
                'imageLink' =>  $this->patient->avatar ? $this->patient->avatar->url : url(env('APPOLOZIC_DEFAULT_IMAGE', ''))
            ],
            'headers' => [
                'Application-Key' => env('APPOLOZIC_ID', '25744aed3a58626ab31c92358cb032c0a'),
                'Authorization' => 'Basic ' . $this->authToken

            ]
        ]);

        return $this;
    }

    public function deleteMessage($key)
    {
        if (!$this->authToken) {
            $this->login();
        }

        $this->httpClient->get('message/v2/delete', [
            'query' => [
                'key' => $key,
            ],
            'headers' => [
                'Application-Key' => env('APPOLOZIC_ID', '25744aed3a58626ab31c92358cb032c0a'),
                'Authorization' => 'Basic ' . $this->authToken

            ]
        ]);

        return $this;
    }

    public function sendMessage($content)
    {
        if (!$this->authToken) {
            $this->login();
        }

        $this->httpClient->post('message/v2/send', [
            'json' => [
                'to' => $this->patient->id,
                'message' => $content
            ],
            'headers' => [
                'Application-Key' => env('APPOLOZIC_ID', '25744aed3a58626ab31c92358cb032c0a'),
                'Authorization' => 'Basic ' . $this->authToken
            ]
        ]);

        return $this;
    }

}

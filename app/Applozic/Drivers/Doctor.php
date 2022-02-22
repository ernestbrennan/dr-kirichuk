<?php

namespace App\Applozic\Drivers;

use App\Applozic\Contracts\DriverInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Doctor implements DriverInterface
{
    private $authToken;
    private $doctor;

    private $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->doctor = \App\Models\Doctor::first();
        $this->authToken = Cache::get('doctor_auth_token');
    }

    public function login()
    {
        $response = $this->httpClient->post('register/client', [
            'json' => [
                'userId' => 'doctor',
                'applicationId' => env('APPOLOZIC_ID', '25744aed3a58626ab31c92358cb032c0a')
            ]
        ]);

        $this->authToken = base64_encode('doctor:' . json_decode($response->getBody()->getContents())->deviceKey);

        Cache::put('doctor_auth_token', $this->authToken, 60);
    }

    public function updateProfile()
    {
        if (!$this->authToken) {
            $this->login();
        }

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

    public function sendMessage($user_id, $content)
    {
        if (!$this->authToken) {
            $this->login();
        }

        Log::channel('mailing')->info("patient id: {$user_id} | auth token: {$this->authToken}");

        $this->httpClient->post('message/v2/send', [
            'json' => [
                'to' => $user_id,
                'message' => $content
            ],
            'headers' => [
                'Application-Key' => env('APPOLOZIC_ID', '25744aed3a58626ab31c92358cb032c0a'),
                'Authorization' => 'Basic ' . $this->authToken
            ]
        ]);

        return $this;
    }

    public function sendAttachmentMessage($user_id, $file_meta)
    {
        if (!$this->authToken) {
            $this->login();
        }

        $this->httpClient->post('message/v2/send', [
            'json' => [
                'to' => $user_id,
                'fileMeta' => $file_meta,
                'type' => 5
            ],
            'headers' => [
                'Application-Key' => env('APPOLOZIC_ID', '25744aed3a58626ab31c92358cb032c0a'),
                'Authorization' => 'Basic ' . $this->authToken
            ]
        ]);

        return $this;
    }
}

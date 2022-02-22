<?php

namespace App\Applozic;

use App\Applozic\Contracts\DriverInterface;
use App\Applozic\Drivers\Doctor;
use App\Applozic\Drivers\Patient;
use App\Models\File;
use GuzzleHttp\Client;

class ApplozicManager
{
    protected $driver;
    protected $httpClient;

    /**
     * @var DriverInterface $driverInstance
     */
    protected $driverInstance;

    protected $driverMap = [
        'doctor' => Doctor::class,
        'patient' => Patient::class,
    ];

    public function __construct()
    {
        $this->driver = 'doctor';

        $this->httpClient = new Client([
            'base_uri' => 'https://apps.applozic.com/rest/ws/',
        ]);
    }

    public function via($driver, $model = null)
    {
        $this->driver = $driver;
        $this->driverInstance = $this->getFreshDriverInstance($model);

        return $this->driverInstance;
    }

    protected function getFreshDriverInstance($model = null)
    {
        $class = $this->driverMap[$this->driver];

        return new $class($this->httpClient, $model);
    }

    public function uploadFile(File $file)
    {
        $url = $this->httpClient->get('https://applozic.appspot.com/rest/ws/aws/file/url?data=1532966195593')->getBody()->getContents();

        $response = $this->httpClient->post($url, [
            'multipart' => [
                [
                    'name' => 'files[]',
                    'filename' => $file->name,
                    'contents' => file_get_contents($file->path),
                ],
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true)['fileMeta'];
    }
}

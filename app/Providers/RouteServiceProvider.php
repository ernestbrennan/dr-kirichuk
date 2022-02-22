<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

use Dingo\Api\Routing\Router as DingoRouter;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $doctor_namespace = 'App\Http\Controllers\Doctor';
    protected $patient_namespace = 'App\Http\Controllers\Patient';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(DingoRouter $dingo_router)
    {
        $this->mapDoctorRoutes($dingo_router);

        $this->mapPatientRoutes($dingo_router);

    }

    protected function mapDoctorRoutes($router)
    {
        $router->group([
            'version' => 'v1',
            'prefix' => 'api/doctor',
            'namespace' => $this->doctor_namespace,
            'middleware' => ['api']
        ], function ($router) {
            require base_path('routes/doctor.php');
        });
    }

    protected function mapPatientRoutes($router)
    {
        $router->group([
            'version' => 'v1',
            'prefix' => 'api/patient',
            'namespace' => $this->patient_namespace,
            'middleware' => ['api']
        ], function ($router) {
            require base_path('routes/patient.php');
        });
    }
}

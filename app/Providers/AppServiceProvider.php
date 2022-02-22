<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Mailing;
use App\Models\Patient;
use App\Models\ScheduledMessage;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use L5Swagger\L5SwaggerServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->app->register(L5SwaggerServiceProvider::class);

        Relation::morphMap([
            'patient' => Patient::class,
            'visit' => Visit::class,
            'scheduled_message' => ScheduledMessage::class,
            'comment' => Comment::class,
            'mailing' => Mailing::class
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $array_path = explode('/', request()->path());

        if (count($array_path) > 1 && $array_path[0] === 'api-docs' ) {
            if ($array_path[1] === 'patient') {
                config([
                    'l5-swagger.paths.annotations' => base_path('app/Http/Controllers/Patient'),
                    'l5-swagger.paths.docs' => storage_path('api-docs/patient'),
                    'l5-swagger.routes.api' => '/api-docs/patient',
                    'l5-swagger.routes.docs' => '/api-docs/patient/docs',

                ]);
            }
            if ($array_path[1] === 'doctor') {
                config([
                    'l5-swagger.paths.annotations' => base_path('app/Http/Controllers/Doctor'),
                    'l5-swagger.paths.docs' => storage_path('api-docs/doctor'),
                    'l5-swagger.routes.api' => '/api-docs/doctor',
                    'l5-swagger.routes.docs' => '/api-docs/doctor/docs',
                ]);
            }
        }

    }
}

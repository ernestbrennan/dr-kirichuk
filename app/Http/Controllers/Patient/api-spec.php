<?php

/**
 * @SWG\Swagger(
 *   basePath="/api/patient",
 *   schemes={L5_SWAGGER_CONST_SCHEME},
 *   host=L5_SWAGGER_CONST_HOST,
 *   @SWG\Info(
 *     title="DR Kirichuk Patient 1",
 *     version="1.1",
 *     description="DR Kirichuk 1"
 *   ),
 * )
 * @SWG\SecurityScheme(
 *   securityDefinition="patient_auth",
 *   type="apiKey",
 *   in="header",
 *   name="Authorization"
 * )
 */



/**
 * @SWG\Definition(
 *   definition="PatientListFilters",
 *   description="Patint list filters",
 *   @SWG\Property(
 *     property="search",
 *     type="object",
 *     @SWG\Property(
 *       property="default",
 *       type="string",
 *       description="Search by first_name, last_name, phone",
 *       example="Patient"
 *     ),
 *     @SWG\Property(
 *       property="prescription",
 *       type="string",
 *       description="Search by visit prescription",
 *       example="Patient"
 *     ),
 *     @SWG\Property(
 *       property="comment",
 *       type="string",
 *       description="Search by visit doctor comment",
 *       example="Patient"
 *     ),
 *   ),
 *   @SWG\Property(
 *     property="cities_id",
 *     type="array",
 *     description="Cities id",
 *     @SWG\Items(
 *       type="integer",
 *       example=1
 *     ),
 *   ),
 *   @SWG\Property(
 *     property="age",
 *     type="object",
 *     description="Age from/to",
 *     @SWG\Property(property="from", type="integer", example=18),
 *     @SWG\Property(property="to", type="integer", example=40)
 *   ),
 *   @SWG\Property(
 *     property="sort_by",
 *     type="string",
 *     enum={"by_last_visit", "by_registered_at", "by_name", "by_age"},
 *     description="Sort By",
 *     default="by_last_visit"
 *   ),
 * )
 */

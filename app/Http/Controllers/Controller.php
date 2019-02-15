<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @SWG\Swagger(
 *   basePath="/api",
 *   schemes={"http", "https"},
 *   @SWG\Info(
 *     title="Pedido API",
 *     version="1.0.0",
 *     description="L5 Swagger API description",
 *     @SWG\Contact(email="darius@matulionis.lt"), 
 *   ),
 * )
 */

 /**
 * @SWG\SecurityScheme(
 *   securityDefinition="ApiKeyAuth",
 *   type="apiKey",
 *   in="header",
 *   name="Authorization" 
 * )
 */
 
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

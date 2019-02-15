<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API Mobile",
 *      description="API Mobile",
 *      @OA\Contact(
 *          email="marcos@agr-sistemas.com.br"
 *      )
 * )
 */ 

/**
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     description="Acess token",
 *     name="Authorization",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat= "JWT",
 *     securityScheme="bearerAuth"
 * )
 */ 
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

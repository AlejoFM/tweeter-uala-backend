<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Backend Uala Twitter",
 *     version="1.0.0",
 *     description="API REST para el manejo de usuarios, timelines y tweets",
 *     @OA\Contact(
 *         email="alejofranzonimanassero@gmail.com",
 *         name="Alejo Franzoni"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Servidor local de desarrollo"
 * )
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     in="header",
 *     name="X-User-Id",
 *     securityScheme="userIdHeader",
 *     description="User ID en el header para la autorización"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}

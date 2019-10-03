<?php

/**
 * @OA\Info(
 *     title="Library API documentation",
 *     version="1.0.0",
 *     @OA\Contact(
 *         email="dima.97_97@mail.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\Tag(
 *     name="Books",
 *     description="Books",
 * )
 * @OA\Tag(
 *     name="Authors",
 *     description="Authors",
 * )
 * @OA\Tag(
 *     name="Authorization",
 *     description="Authorization",
 * )
 * @OA\Server(
 *     description="Library API server",
 *     url="http://localhost:8000/api/v1"
 * )
 * @OA\SecurityScheme(
 *  securityScheme="bearerAuth",
 *  type="http",
 *  scheme="bearer"
 * )
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

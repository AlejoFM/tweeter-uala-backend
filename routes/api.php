<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * @OA\Get(
 *     path="/api/health",
 *     summary="Health check endpoint",
 *     tags={"System"},
 *     @OA\Response(
 *         response=200,
 *         description="System health status",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="healthy"),
 *             @OA\Property(property="timestamp", type="string", format="date-time"),
 *             @OA\Property(property="memory_usage", type="integer"),
 *             @OA\Property(property="cpu_usage", type="number", format="float")
 *         )
 *     )
 * )
 */
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now(),
        'memory_usage' => memory_get_usage(true),
        'cpu_usage' => sys_getloadavg()[0]
    ]);
});



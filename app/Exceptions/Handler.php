<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use src\Shared\Exceptions\RateLimitExceededException;
use Illuminate\Database\QueryException;
use src\Shared\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Lista de códigos de error MySQL y sus mensajes amigables
     */
    private const SQL_ERROR_MESSAGES = [
        '1451' => 'No se puede eliminar el registro porque está siendo utilizado.',
        '1452' => 'El registro referenciado no existe.',
        '1062' => 'Ya existe un registro con estos datos.',
        '1364' => 'El campo no puede estar vacío.',
        '1216' => 'No se puede agregar el registro porque la referencia no existe.',
        '1217' => 'No se puede eliminar el registro porque tiene dependencias.',
        '1264' => 'El valor está fuera del rango permitido.',
        '1146' => 'La tabla no existe.',
        '1054' => 'La columna no existe.',
        '1064' => 'Error en la sintaxis de la consulta.',
        '1040' => 'Demasiadas conexiones.',
        '1049' => 'Base de datos no existe.',
        '23000' => 'Error de integridad de datos.',
    ];

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        switch ($e) {
            
            case $e instanceof RateLimitExceededException:
                return response()->json([
                    'error' => $e->getMessage(),
                    'retry_after' => $e->retryAfter
                ], Response::HTTP_TOO_MANY_REQUESTS);
                
            case $e instanceof UnauthorizedException:
                return response()->json([
                    'error' => $e->getMessage()
                ], Response::HTTP_UNAUTHORIZED);

            case $e instanceof QueryException:
                $errorCode = $e->errorInfo[1] ?? '';
                $message = self::SQL_ERROR_MESSAGES[$errorCode] ?? 'Error de base de datos.';

                if (env('APP_ENV') === 'dev' || env('APP_ENV') === 'local') {
                    return response()->json([
                        'message' => $message,
                        'error_code' => $errorCode,
                        'sql_message' => $e->getMessage(),
                        'sql_error' => $e->errorInfo[2] ?? null
                    ], Response::HTTP_BAD_REQUEST);
                }
                
                return response()->json([
                    'message' => $message,
                    'error_code' => $errorCode
                ], Response::HTTP_BAD_REQUEST);
            default:
                if (env('APP_ENV') === 'dev' || env('APP_ENV') === 'local') {
                    return response()->json([
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => $e->getTrace()
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
                
                return response()->json([
                    'message' => 'Ha ocurrido un error en el servidor.'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

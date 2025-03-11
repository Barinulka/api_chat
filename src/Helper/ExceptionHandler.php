<?php 
namespace App\Helper;

use App\Exception\BaseAppException;
use PDOException;
use Throwable;

class ExceptionHandler
{

    public function handle(Throwable $e): void
    {
        $response = $this->setBaseResponse($e);

        // Вспомогательные данные добавляются, если это BaseAppException
        if ($e instanceof BaseAppException) {
            $response['code'] = $e->getCode();
            $response['data'] = $e->getData() ?? [];
        } elseif ($e instanceof PDOException) {
            $response['code'] = 400;
            $response['message'] = 'Ошибка базы данных';
            $response['data'] = ['code' => sprintf('SQLSTATE[%d]', $e->getCode())];
        } else {
            $response['message'] = 'Непредвиденная ошибка. Попробуйте позже';
            $response['data'] = ['type' => get_class($e)];
        }

        $this->printResponse($response);
    }

    private function setBaseResponse(Throwable $e): array
    {
       return [
            'code' => $e->getCode() ?? 500,
            'message' => $e->getMessage() ?? 'Что-то пошло не так',
            'data' => []
        ];
    }

    private function printResponse(array $response): void
    {
        http_response_code($response['code']);
        header('Content-Type: application/json; charset=utf8');

        echo json_encode($response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
}
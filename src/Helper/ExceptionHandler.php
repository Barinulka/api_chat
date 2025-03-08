<?php 
namespace App\Helper;

use App\Exception\BaseAppException;
use Throwable;

class ExceptionHandler
{

    public function handle(Throwable $e): void
    {
        $response = $this->setBaseResponse($e);

        // Вспомогательные данные добавляются, если это BaseAppException
        if ($e instanceof BaseAppException) {
           $response = $this->addDataToResponse($response, $e->getData());
        } 

        http_response_code($e->getCode());
        header('Content-Type: application/json; charset=utf8');

        echo json_encode($response, JSON_UNESCAPED_UNICODE);

        exit;
    }

    private function setBaseResponse(Throwable $e): array
    {
       return [
            'code' => $e->getCode() ?? 500,
            'message' => $e->getMessage() ?? 'Что-то пошло не так',
        ];
    }

    private function addDataToResponse(array $response, array $data): array
    {
        if (!empty($data)) {
            $response['data'] = $data;
        }

        return $response;
    }
}
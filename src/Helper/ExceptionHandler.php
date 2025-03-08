<?php 
namespace App\Helper;

use Exception;
use App\Exception\BaseAppException;

class ExceptionHandler
{

    public function handle(Exception $e): void
    {
        $response = $this->getBaseResponse($e);

        if ($e instanceof BaseAppException) {
            $response['data'] = $e->getData();
        } 

        http_response_code($e->getCode());
        header('Content-Type: application/json; charset=utf8');
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();

    }

    private function getBaseResponse(Exception $e): array
    {
        return [
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
        ];
    }
}
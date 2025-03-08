<?php 
declare(strict_types= 1);

namespace App\Exception;

use Exception;

class BaseAppException extends \Exception
{
    private array $data = [];
    public function __construct($message = "", $code = 0, array $data = [])
    {
        parent::__construct($message, $code);
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function sendJsonResponse(): void
    {
       http_response_code($this->getCode());
       header('Content-Type: application/json; charset=utf8');
       echo json_encode($this->prepareResponse(), JSON_UNESCAPED_UNICODE);
       exit();
    }

    protected function prepareResponse(): array
    {
        $response = [
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
        ];

        if (!empty($this->data)) {
            $response['data'] = $this->getData();
        }  

        return $response; 
    }
}
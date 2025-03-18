<?php 
namespace App\Http;

abstract class Response
{
    protected const SUCCESS = true;
    protected int $code = 500;

    public function send(): void
    {
        $data = $this->setData();

        http_response_code($this->code);

        header('Content-Type: application/json');

        if (!empty($data) && 204 !== $this->code) {
            echo json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_THROW_ON_ERROR);
        }
    }

    public function setData(): array
    {
        if (204 == $this->code) {
            return [];
        }

        return ['success' => static::SUCCESS] + $this->payload();
    }

    abstract protected function payload(): array;
}
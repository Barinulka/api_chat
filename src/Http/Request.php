<?php  
namespace App\Http;

use App\Exception\HttpException;
use JsonException;

class Request
{
    public function __construct(
        private array $get,
        private array $server,
        private string $body
    ) {

    }

    public function getPath(): string
    {
        if (!array_key_exists('REQUEST_URI', $this->server)) {
            throw new HttpException();
        }

        $componets = parse_url($this->server['REQUEST_URI']);

        if (!is_array($componets) || !array_key_exists('path', $componets)) {
            throw new HttpException();
        }

        return $componets['path'];
    }

    public function getQuery(string $param): string
    {
        
        if (!array_key_exists($param, $this->get)) {
            throw new HttpException('В запросе не найден необходимый параметр', ['param' => $param]);
        }

        $value = trim($this->get[$param]);

        if (empty($value)) {
            throw new HttpException('Пустой параметр в запросе', ['param'=> $param]);
        }

        return $value;
    }       

    public function getHeader(string $header): string
    {
        $headerName = mb_strtoupper('http_' . str_replace('-','_', $header));

        if (!array_key_exists($headerName, $this->server)) {
            throw new HttpException('Нет заголовка в ответе', ['param'=> $header]);
        }

        $value = trim($this->server[$headerName]);

        if (empty($value)) {
            throw new HttpException('Пустой заголовок в запросе', ['param'=> $header]);
        }

        return $value;
    }

    public function getMethod(): string
    {
        if (!array_key_exists('REQUEST_METHOD', $this->server)) {
            throw new HttpException('Не удалось получить метод запроса');
        }

        return $this->server['REQUEST_METHOD'];
    }
    
    public function getJsonBody(): array
    {
        try {
            $data = json_decode(
                $this->body,
                true, 
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $e) {
            throw new HttpException('Не удалось разобрать json строку');
        }

        if (!is_array($data)) {
            throw new HttpException('Не является массивом/объектом');
        }

        return $data;
    }

    public function getJsonBodyField(string $field): mixed
    {
        $data = $this->getJsonBody();

        if(!array_key_exists($field, $data)) {
            throw new HttpException("Не удалось найти значение поля $field");
        }

        if (empty($data[$field])) {
            throw new HttpException("Пустое поле $field");
        }

        return $data[$field];
    }

}
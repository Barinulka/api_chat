# Работа с комментариями

## Добавление

```
POST /posts/comment HTTP/1.1
Host: localhost:8080
Content-Type: application/json

{
    "author_uuid": "string",
    "post_uuid": "string",
    "comment": "string"
}
```

## Получение информации о статье по ее UUID
```
GET /posts/show?uuid={uuid статьи}
```

##  Удаление статьи
```
DELETE /posts/delete?uuid={uuid статьи}
```

## Возможные варианты ответа сервера

## Успешные ответы
```
HTTP/1.1 201 Created

{
    "success": (boolean) true,
    "data": {
        "uuid": (string) uuid комментария
    }
}
```

## Неуспешные ответы
```
HTTP/1.1 400 Bad Request
HTTP/1.1 404 Not Found
HTTP/1.1 500 Internal Server Error

{
    "success": (boolean) false,
    "message": (string) Описание ошибки
}
```

[Назад](/docs/API.md)
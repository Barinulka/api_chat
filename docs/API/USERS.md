# Работа с пользователями

## Добавление нового ползователя

```
POST /users/create HTTP/1.1
Host: localhost:8080
Content-Type: application/json

{
    "first_name": "string",
    "last_name": "string",
    "login": "string"
}
```

## Получение информации о пользователе по логину
```
GET /users/show?username={username}
```

## Получение списка пользователей
```
GET /users
```

## Возможные варианты ответа сервера

## Успешные ответы
### Пользователь успешно создан
```
HTTP/1.1 201 Created

{
    "success": (boolean) true,
    "data": {
        "uuid": (string) uuid созданного пользователя
    }
}
```

### Пользователь найден
```
HTTP/1.1 200 OK

{
    "success": (boolean) true,
    "data": {
        "username": "string",
        "name": "string"
    }
}
```

## Неуспешные ответы
```
HTTP/1.1 400 Bad Request
HTTP/1.1 404 Not Found
HTTP/1.1 409 Conflict
HTTP/1.1 500 Internal Server Error

{
    "success": (boolean) false,
    "message": (string) Описание ошибки
}
```

[Назад](/docs/API.md)
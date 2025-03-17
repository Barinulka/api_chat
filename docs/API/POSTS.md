# Работа со статьями

## Добавление новой статьи

```
POST /posts/create HTTP/1.1
Host: localhost:8080
Content-Type: application/json

{
    "author_uuid": "string",
    "title": "string",
    "content": "string"
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
### Статья успешно создана
```
HTTP/1.1 201 Created

{
    "success": (boolean) true,
    "data": {
        "uuid": (string) uuid созданной статьи
    }
}
```

### Статья найден
```
HTTP/1.1 200 OK

{
    "success": (boolean) true,
    "data": {
        "uuid": (string) - uuid статьи,
        "title": (string) - Заголовок,
        "content": (string) - Контент,
        "author": {
            "uudi": (string) - uuid автора статьи,
            "login": (string) - логин,
            "first_name": (string) - имя,
            "last_name": (string) - фамилия
        }
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
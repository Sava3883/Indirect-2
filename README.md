# Тестовый сайт

Небольшой статичный сайт для практики: Git, GitHub Pages и тестирование веб-приложений.

## Страницы

| Файл | Что на странице |
|---|---|
| `index.html` | Главная со ссылками |
| `products.html` | Три товара, кнопки «В корзину» и счётчик (`#cart-count`) |
| `login.html` | Форма входа (`#user-name`, `#password`, `#login-button`) и сообщение (`#message`) |

Тестовые данные для входа: `student` / `test1234` (вымышленные).

## Как открыть

Двойным щелчком по `index.html` либо локальным сервером:

```
py -m http.server 8000
```

и адрес `http://localhost:8000/`.

## Публикация

GitHub Pages: Settings → Pages → Deploy from a branch → `main` / `(root)`.

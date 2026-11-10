# Тестовый сайт

Небольшой сайт для практики: Git, GitHub Pages, GitHub Codespaces, тестирование веб-приложений и PHP с базой данных.

## Страницы

| Файл | Что на странице |
|---|---|
| `index.html` | Главная со ссылками |
| `products.html` | Три товара, кнопки «В корзину» и счётчик (`#cart-count`) |
| `login.html` | Форма входа (`#user-name`, `#password`, `#login-button`) и сообщение (`#message`) |
| `notes.php` | Заметки: форма (`#note-author`, `#note-text`, `#add-note`) и список (`#notes-list`), хранятся в базе SQLite |

Тестовые данные для входа: `student` / `test1234` (вымышленные).

## PHP и база данных

- `notes.php` работает с базой данных через `db.php` (PDO, SQLite). Файл базы `data/app.sqlite` создаётся автоматически при первом открытии страницы и **не попадает в репозиторий** (см. `.gitignore`).
- Запросы к базе выполняются через подготовленные выражения (защита от SQL-инъекций), весь вывод экранируется (защита от XSS).
- **GitHub Pages не выполняет PHP.** Статические страницы (`.html`) работают на Pages, а `notes.php` нужно запускать на PHP-сервере: локально или в Codespaces.

## Как запустить

**Локально** (нужен установленный PHP 8 с расширением `pdo_sqlite`):

```
php -S localhost:8080
```

и адрес `http://localhost:8080/notes.php`.

**В GitHub Codespaces** (ничего не нужно устанавливать): Code → Codespaces → Create codespace. Сервер запустится сам (файл `.devcontainer/devcontainer.json`), страница откроется на порту 8080 во вкладке Ports.

## Публикация статической части

GitHub Pages: Settings → Pages → Deploy from a branch → `master` / `(root)`.

<?php
declare(strict_types=1);
require __DIR__ . '/db.php';

$pdo = db();
$error = '';
$ok = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string)($_POST['action'] ?? '');
    if ($action === 'add') {
        $author = trim((string)($_POST['author'] ?? ''));
        $body = trim((string)($_POST['body'] ?? ''));
        if ($author === '' || $body === '') {
            $error = 'Заполните имя и текст заметки';
        } elseif (text_len($author) > 40 || text_len($body) > 300) {
            $error = 'Слишком длинный текст: имя до 40 символов, заметка до 300';
        } else {
            $st = $pdo->prepare('INSERT INTO notes (author, body) VALUES (:a, :b)');
            $st->execute([':a' => $author, ':b' => $body]);
            header('Location: notes.php?added=1');
            exit;
        }
    } elseif ($action === 'clear') {
        $pdo->exec('DELETE FROM notes');
        header('Location: notes.php?cleared=1');
        exit;
    }
}

if (isset($_GET['added'])) {
    $ok = 'Заметка добавлена';
}
if (isset($_GET['cleared'])) {
    $ok = 'Все заметки удалены';
}

$notes = $pdo->query(
    'SELECT id, author, body, created_at FROM notes ORDER BY id DESC'
)->fetchAll();
$msgClass = $error !== '' ? 'error' : ($ok !== '' ? 'ok' : '');
$msgText = $error !== '' ? $error : $ok;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Заметки — тестовый сайт</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <nav>
      <a href="index.html">Главная</a>
      <a href="products.html">Товары</a>
      <a href="login.html">Вход</a>
      <a href="notes.php" aria-current="page">Заметки</a>
    </nav>
  </header>
  <main>
    <h1>Заметки</h1>
    <p>Страница на PHP сохраняет заметки в базе данных SQLite (файл <code>data/app.sqlite</code>). После перезагрузки страницы заметки остаются на месте.</p>
    <form method="post" action="notes.php" id="note-form">
      <input type="hidden" name="action" value="add">
      <label for="note-author">Имя</label>
      <input id="note-author" name="author" type="text" maxlength="40" autocomplete="off" value="<?= h((string)($_POST['author'] ?? '')) ?>">
      <label for="note-text">Заметка</label>
      <textarea id="note-text" name="body" rows="3" maxlength="300"><?= h((string)($_POST['body'] ?? '')) ?></textarea>
      <button type="submit" id="add-note">Добавить заметку</button>
    </form>
    <p id="message" role="status" data-test="result" class="<?= h($msgClass) ?>"><?= h($msgText) ?></p>
    <p>Всего заметок: <strong id="notes-count"><?= count($notes) ?></strong></p>
    <?php if (count($notes) === 0): ?>
      <p class="hint" id="notes-empty">Пока нет ни одной заметки. Добавьте первую.</p>
    <?php else: ?>
      <ul class="plain notes" id="notes-list">
        <?php foreach ($notes as $n): ?>
          <li>
            <strong><?= h((string)$n['author']) ?></strong>
            <span><?= h((string)$n['body']) ?></span>
            <span class="meta"><?= h((string)$n['created_at']) ?> (UTC)</span>
          </li>
        <?php endforeach; ?>
      </ul>
      <form method="post" action="notes.php" style="margin-top:1.5rem">
        <input type="hidden" name="action" value="clear">
        <button type="submit" class="secondary" id="clear-notes">Удалить все заметки</button>
      </form>
    <?php endif; ?>
  </main>
  <footer>Тестовый сайт. Данные на страницах вымышленные.</footer>
</body>
</html>

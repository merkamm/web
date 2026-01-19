<?php
declare(strict_types=1);

$pdo = require __DIR__ . '/db.php';

// CREATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $text = trim($_POST['text'] ?? '');
  if ($text !== '') {
    $stmt = $pdo->prepare("INSERT INTO notes(text, created_at) VALUES(?, datetime('now'))");
    $stmt->execute([$text]);
  }
  header('Location: /');
  exit;
}

// DELETE (volitelné)
if (isset($_GET['delete'])) {
  $id = (int)($_GET['delete']);
  $stmt = $pdo->prepare("DELETE FROM notes WHERE id = ?");
  $stmt->execute([$id]);
  header('Location: /');
  exit;
}

// READ
$rows = $pdo->query("SELECT id, text, created_at FROM notes ORDER BY id DESC")
            ->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="cs">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHP + SQLite (mini CRUD)</title>
</head>
<body>
  <h1>PHP + SQLite (mini CRUD)</h1>

  <form method="post">
    <input name="text" placeholder="Napiš poznámku..." required>
    <button type="submit">Uložit</button>
  </form>

  <h2>Seznam poznámek</h2>
  <ul>
    <?php foreach ($rows as $r): ?>
      <li>
        <?= htmlspecialchars($r['text']) ?>
        <small>(<?= htmlspecialchars($r['created_at']) ?>)</small>
        <a href="/?delete=<?= (int)$r['id'] ?>">smazat</a>
      </li>
    <?php endforeach; ?>
  </ul>
</body>
</html>


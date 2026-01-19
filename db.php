<?php
declare(strict_types=1);

$pdo = new PDO('sqlite:' . __DIR__ . '/data.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Inicializace tabulky
$pdo->exec("
  CREATE TABLE IF NOT EXISTS notes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    text TEXT NOT NULL,
    created_at TEXT NOT NULL
  )
");

return $pdo;

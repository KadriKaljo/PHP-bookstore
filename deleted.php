<?php
require_once('./connection.php');

$stmt = $pdo->query('SELECT id, title FROM books WHERE is_deleted = 1 ORDER BY id DESC');

while ($row = $stmt->fetch()) {
    $id = (int)$row['id'];
    $title = htmlspecialchars($row['title']);
    echo "$title — <a href='restore.php?id=$id' onclick=\"return confirm('Taasta raamat?')\">Taasta</a><br>";
}
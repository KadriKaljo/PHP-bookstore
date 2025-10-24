<?php

require_once('./connection.php');     // laeb ühe korra

$stmt = $pdo->query('SELECT id, title FROM books');
while ($row = $stmt->fetch())
{
    echo "<a href='book.php?id={$row['id']}'>{$row['title']}</a> <br>";
    
}
<?php
require_once('./connection.php');

if(!isset($_GET['id']) || !$_GET['id'] ) {
  echo 'Viga: raamatut ei leitud!';
  exit();
}

$id = (int)$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'] ?? '';
  $pages = (int)($_POST['pages'] ?? 0);
  $summary = $_POST['summary'] ?? '';

  $stmt = $pdo->prepare('UPDATE books SET title = :title, pages = :pages, summary = :summary WHERE id = :id');
  $stmt->execute([
    'title' => $title,
    'pages' => $pages,
    'summary' => $summary,
    'id' => $id
  ]);

  header('Location: book.php?id='.(int)$id);
  exit();
}

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id AND is_deleted = 0');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();
if (!$book) {
  echo 'Viga: raamatut ei leitud!';
  exit();
}
?>


<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="UTF-8">
  <title>Muuda raamatut</title>
</head>
<body>
  <h1>Muuda raamatut</h1>
  <form method="post" action="edit.php?id=<?= (int)$id ?>">
    <div>
      <label>Pealkiri</label><br>
      <input type="text" name="title" value="<?= htmlspecialchars($book['title'] ?? '') ?>">
    </div>
    <div>
      <label>Lehekülgi</label><br>
      <input type="number" name="pages" value="<?= (int)($book['pages'] ?? 0) ?>">
    </div>
    <div>
      <label>Kirjeldus</label><br>
      <textarea name="summary" rows="6" cols="60"><?= htmlspecialchars($book['summary'] ?? '') ?></textarea>
    </div>
    <button type="submit">Salvesta</button>
  </form>
</body>
</html>
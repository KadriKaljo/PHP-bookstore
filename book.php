<?php

require_once('./connection.php');

if (!isset($_GET['id']) || !$_GET['id'] )
 {
  echo 'Viga: raamatut ei leitud!';
  exit();
 }


$id = $_GET['id'];


$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id AND is_deleted = 0');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();
if (!$book) {
    echo 'Viga: raamatut ei leitud!';
    exit();
}

$stmt = $pdo->prepare('SELECT first_name, last_name FROM book_authors ba LEFT JOIN authors a ON ba.author_id = a.id WHERE book_id= :book_id;');

$stmt->execute(['book_id' => $id]);
$authors = $stmt->fetchAll();


// var_dump($authors);
// raamatu info/kirjed ":ID" placeholder
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $book['title']; ?></title>
</head>
<body>
    <h1><?php echo $book['title']?></h1>
    <p><strong>Lehekülgi:</strong> <?= htmlspecialchars($book['pages'] ?? '') ?></p>
    <p><strong>Kirjeldus:</strong><br><?= nl2br(htmlspecialchars($book['summary'] ?? '')) ?></p> 

    <strong>Autorid:</strong>
    <ul>
<?php foreach( $authors as $author) { ?>
            <li><?= "{$author['first_name']} {$author['last_name']};"?></li>
        <?php } ?>
    </ul>
   
        <a href="./edit.php?id=<?= (int)$id ?>">Muuda</a>

        <a href="./delete.php?id=<?= (int)$id ?>" onclick="return confirm('Kustuta raamat?')">Kustuta</a>

   
</body>
</html>
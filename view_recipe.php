<?php
include 'database/db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->execute([$id]);
$recipe = $stmt->fetch();
?>

<h1><?php echo htmlspecialchars($recipe['title']); ?></h1>
<img src="<?php echo htmlspecialchars($recipe['image_url']); ?>" alt="Recipe Image">
<p><?php echo nl2br(htmlspecialchars($recipe['description'])); ?></p>
<p><strong>Ingredients:</strong></p>
<p><?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>
<p><strong>Steps:</strong></p>
<p><?php echo nl2br(htmlspecialchars($recipe['steps'])); ?></p>
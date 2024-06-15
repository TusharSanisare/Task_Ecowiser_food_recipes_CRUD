<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include 'database/db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $ingredients = $_POST['ingredients'];
  $steps = $_POST['steps'];

  // Handle image upload
  $image_url = '';
  if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      $image_url = $target_file;
    }
  }

  $stmt = $pdo->prepare("UPDATE recipes SET title = ?, description = ?, ingredients = ?, steps = ?, image_url = ? WHERE id = ?");
  $stmt->execute([$title, $description, $ingredients, $steps, $image_url, $id]);

  header('Location: index.php');
} else {
  $id = $_GET['id'];
  $stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ?");
  $stmt->execute([$id]);
  $recipe = $stmt->fetch();
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Recipe</title>
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      background-color: rgb(48, 24, 1);
      color: white;
      margin: 0;
      padding: 0;
      background-image: url("https://img.freepik.com/free-photo/fresh-gourmet-meal-beef-taco-salad-plate-generated-by-ai_188544-13382.jpg?t=st=1718305035~exp=1718308635~hmac=7c73ea39f1447b987c1781823a9c2d54d2a32089e3dc5f109be318f5b68745b6&w=1060");
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }

    .container {
      max-width: 600px;
      margin: 50px auto;
      position: relative;
      max-width: 800px;
      margin: 50px auto;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      background-color: rgba(0, 0, 0, 0.7);
    }

    form {
      display: grid;
      gap: 10px;
    }

    label {
      font-weight: bold;
    }

    input[type="text"],
    input[type="file"],
    textarea {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid white;
      border-radius: 5px;
      box-sizing: border-box;
      background: transparent;
      color: white;
    }

    input[type="text"]:focus,
    input[type="file"]:focus,
    textarea:focus {
      border: 2px solid orange;
      outline: none;
      background-color: rgba(0, 0, 0, 0.2);
    }

    textarea {
      resize: vertical;
      height: 150px;
    }

    .btn-submit {
      background-color: orange;
      color: #ffffff;
      border: none;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>Edit Recipe</h2>
    <form method="POST" action="edit_recipe.php" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $recipe['id']; ?>">
      <label for="title">Title:</label>
      <input type="text" id="title" name="title" value="<?php echo $recipe['title']; ?>" required>
      <label for="description">Description:</label>
      <textarea id="description" name="description" required><?php echo $recipe['description']; ?></textarea>
      <label for="ingredients">Ingredients:</label>
      <textarea id="ingredients" name="ingredients" required><?php echo $recipe['ingredients']; ?></textarea>
      <label for="steps">Steps:</label>
      <textarea id="steps" name="steps" required><?php echo $recipe['steps']; ?></textarea>
      <label for="image">Image:</label>
      <input type="file" id="image" name="image">
      <button class="btn-submit" type="submit">Update Recipe</button>
    </form>
  </div>

</body>

</html>
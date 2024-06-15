<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Recipe Details</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      box-sizing: border-box;
      font-family: Arial, Helvetica, sans-serif;
      background-color: rgb(48, 24, 1);
      color: white;
      margin: 0;
      padding: 0;
    }

    .container {
      z-index: -2;
      position: relative;
      max-width: 800px;
      margin: 50px auto;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      background-image: url("https://img.freepik.com/free-photo/fresh-gourmet-meal-beef-taco-salad-plate-generated-by-ai_188544-13382.jpg?t=st=1718305035~exp=1718308635~hmac=7c73ea39f1447b987c1781823a9c2d54d2a32089e3dc5f109be318f5b68745b6&w=1060");
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }

    .container::after {
      z-index: -1;
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
      background-color: rgba(0, 0, 0, 0.7);
      /* background-color: green; */
    }

    .text-area {
      z-index: 20;
      position: relative;
      /* border: 2px solid white; */
      /* background-color: red; */
    }

    h1 {
      text-shadow: 0px 0px 20px rgb(0, 0, 0);
      font-family: 'Pacifico', cursive;
      color: white;
      font-size: 36px;
      text-align: center;
      margin-bottom: 20px;
    }

    img {
      width: 100%;
      height: 100vh;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 20px;
    }

    h2 {
      text-shadow: 0px 0px 20px rgb(0, 0, 0);
      font-size: 30px;
      border-bottom: 2px solid white;
      padding-bottom: 5px;
      margin-bottom: 10px;
    }

    p {
      text-shadow: 0px 0px 20px rgb(0, 0, 0);
      font-size: 18px;
      line-height: 1.6;
      margin-bottom: 20px;
    }

    .btn-container {
      width: 100%;

      .form {
        justify-content: center;
        display: flex;
      }

    }

    .back-btn {

      position: fixed;
      margin: 5px;
      padding: 10px;
      border: 1px solid white;
      background-color: rgb(48, 24, 1);
      border-radius: 30px;
      top: 0px;
      color: #ffffff;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .btn {
      margin: 10px;
      display: inline;
      color: white;
      background-color: orange;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 10px 30px;
      font-size: 20px;
      font-weight: bolder;
      text-decoration: none;
      border-radius: 5px;
      box-shadow: 0px 0px 20px rgb(0, 0, 0);
      border: 2px solid orange;
      cursor: pointer;
      width: 150px;
    }

    .btn-sec {
      cursor: pointer;
      margin: 10px;
      color: orange;
      border: 2px solid orange;
      background-color: rgba(255, 255, 255, 0.126);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 10px 30px;
      font-size: 20px;
      font-weight: bolder;
      text-decoration: none;
      border-radius: 5px;
      box-shadow: 0px 0px 20px rgb(0, 0, 0)
    }
  </style>
</head>
<?php
session_start();
include 'database/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  // Redirect user to login page if not logged in
  header('Location: login.php');
  exit;
}

// Get recipe ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
  echo "Invalid recipe ID";
  exit;
}

$recipe_id = $_GET['id'];

// Fetch recipe details from database
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->execute([$recipe_id]);
$recipe = $stmt->fetch();

// Check if recipe exists
if (!$recipe) {
  echo "Recipe not found";
  exit;
}

// Check if user is logged in and is the owner of the recipe
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$is_owner = ($user_id && $recipe['user_id'] == $user_id);
?>

<body>
  <a href="index.php" class="back-btn">Back</a>
  <div class="container" style="background-image: url('<?php echo $recipe['image_url']; ?>');">
    <div class="text-area">
      <h1><?php echo htmlspecialchars($recipe['title']); ?></h1>
      <?php if (!empty($recipe['image_url'])) : ?>
        <img src="<?php echo htmlspecialchars($recipe['image_url']); ?>" alt="Recipe Image">
      <?php endif; ?>
      <p><?php echo nl2br(htmlspecialchars($recipe['description'])); ?></p>
      <h2>Ingredients</h2>
      <p><?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>
      <h2>Steps</h2>
      <p><?php echo nl2br(htmlspecialchars($recipe['steps'])); ?></p>
    </div>
  </div>
  <?php if ($is_owner) : ?>
    <div class="btn-container">
      <form class="form" method="POST" action="delete_recipe.php">
        <input type="hidden" name="id" value="<?php echo $recipe['id']; ?>">
        <a href="edit_recipe.php?id=<?php echo $recipe['id']; ?>" class="btn">Edit Recipe</a>
        <button type="submit" class="btn-sec">Delete</button>
      </form>
    </div>
  <?php endif; ?>
</body>

</html>
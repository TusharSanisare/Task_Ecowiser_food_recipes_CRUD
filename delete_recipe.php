<?php
session_start();
include 'database/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  // Redirect user to login page if not logged in
  header('Location: login.php');
  exit;
}

// Check if recipe ID is provided
if (!isset($_POST['id']) || empty($_POST['id'])) {
  echo "Invalid recipe ID";
  exit;
}

$recipe_id = $_POST['id'];
$user_id = $_SESSION['user_id'];

// Verify that the logged-in user is the owner of the recipe
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ? AND user_id = ?");
$stmt->execute([$recipe_id, $user_id]);
$recipe = $stmt->fetch();

if (!$recipe) {
  echo "Recipe not found or you do not have permission to delete this recipe";
  exit;
}

// Delete the recipe
$stmt = $pdo->prepare("DELETE FROM recipes WHERE id = ?");
$stmt->execute([$recipe_id]);

// Redirect to the index page after deletion
header('Location: index.php');
exit;

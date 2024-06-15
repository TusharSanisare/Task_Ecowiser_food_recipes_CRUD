<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>login</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicon -->
  <link href="img/favicon.ico" rel="icon">

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Libraries Stylesheet -->
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

  <!-- Customized Bootstrap Stylesheet -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">

  <!-- Template Stylesheet -->
  <link href="../css/style.css" rel="stylesheet">
</head>

<style>
  body {
    width: 100%;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    font-family: Arial, Helvetica, sans-serif;
  }

  .form-div {
    padding: 20px;
    border-radius: 3px;
    border: 1px solid gray;
  }

  .input {
    margin-bottom: 5px;
    width: 300px;
    height: 40px;
  }

  .btn {
    font-size: 18px;
    background: orange;
    color: white;
    font-weight: bolder;
    padding: 5px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  .signup-text {
    font-size: 14px;
  }

  .signup-text a {
    color: orange;
  }

  .error {
    color: red;
  }
</style>

<?php
session_start();
include 'database/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    header('Location: index.php');
    exit;
  } else {
    $error = "Invalid username or password";
  }
}
?>

<body>

  <div class="">
    <?php
    if ($error) {
      echo "<p class='error'>$error</p>";
    }
    ?>

    <form method="post" action="login.php" class="">
      <div class="form-div">
        <h1>Login</h1>
        <div class="">
          <input class="input" type="email" name="email" placeholder="Enter email" required><br>
          <input class="input" type="password" name="password" placeholder="Enter password" required><br><br>
          <input class="btn" type="submit" value="Login">
        </div>
        <p class="signup-text">Don't have an account? <a href="signup.php">Sign Up</a></p>
      </div>
    </form>
  </div>

</body>

</html>
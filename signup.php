<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>sign up</title>
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

  .signup-text,
  .login-text {
    font-size: 14px;
  }

  .signup-text a,
  .login-text a {
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
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

  // Check if the username already exists
  $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->execute([$username]);
  $existingUsername = $stmt->fetch();
  // Check if the email already exists
  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $existingUserEmail = $stmt->fetch();

  if ($existingUsername) {
    $error = "Username already exists. Please choose another username.";
  } else if ($existingUserEmail) {
    $error = "email already exists. Please choose another email.";
  } else {
    // Insert new user into the database
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $email, $password])) {
      // Log in the user immediately after signing up
      $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
      $stmt->execute([$username]);
      $user = $stmt->fetch();

      if ($user) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit;
      } else {
        $error = "Error occurred while signing up.";
      }
    } else {
      $error = "Error occurred while inserting into the database.";
    }
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

    <form method="post" action="signup.php">
      <div class="form-div">
        <h1>Sign Up</h1>
        <div class="">
          <input class="input" type="text" name="username" placeholder="Enter name" required><br>
          <input class="input" type="email" name="email" placeholder="Enter email" required><br>
          <input class="input" type="password" name="password" placeholder="Enter password" required><br><br>
          <input class="btn" type="submit" value="Submit">
        </div>
        <p class="login-text">Already have an account? <a href="login.php">Login</a></p>
      </div>
    </form>
  </div>

</body>

</html>
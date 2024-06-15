<?php
session_start();
include 'database/db.php';

// Check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);

// Handle logout if requested
if (isset($_GET['logout'])) {
  // Unset all of the session variables
  $_SESSION = [];

  // Destroy the session
  session_destroy();

  // Redirect to the index page
  header('Location: index.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recipe List</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- <link rel="stylesheet" href="css/index.css"> -->

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html,
    body {
      font-family: Arial, Helvetica, sans-serif;
      width: 100%;
      background-color: black;
    }

    .main {
      position: relative;
      height: 100vh;
      width: 100%;
      background-image: url("https://img.freepik.com/free-photo/fresh-gourmet-meal-beef-taco-salad-plate-generated-by-ai_188544-13382.jpg?t=st=1718305035~exp=1718308635~hmac=7c73ea39f1447b987c1781823a9c2d54d2a32089e3dc5f109be318f5b68745b6&w=1060");
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }

    .main::after {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .main-text {
      z-index: 1;
      padding: 10px;
      position: absolute;
      /* border: 2px solid white; */
      top: 50%;
      /* left: 50%; */
      transform: translate(0, -50%);
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;

      .title {
        font-size: 70px;
        font-weight: bolder;
        text-shadow: 0px 0px 20px rgb(0, 0, 0)
      }

      .sub-title {
        font-size: 20px;
        text-shadow: 0px 0px 20px rgb(0, 0, 0)
      }

      .btn-container {
        /* border: 2px solid white; */
        padding: 20px;


      }
    }

    .recipe-container {
      padding: 20px 0;
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background-color: #141414;
      background-color: rgba(95, 47, 1, 0.5);

      .recipe-section-title {
        text-align: center;
        padding: 10px;
        color: white;
        font-size: 30px;
      }

      .search-bar-container {
        margin-bottom: 40px;
        height: 30px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;


        .searchbar {
          border: 1px solid orange;
          border-radius: 8px;
          overflow: hidden;
          display: flex;
          align-items: center;
          justify-content: center;
          background: white;
          height: 100%;
          width: 70%;

          .searchicon {
            margin: 10px;
          }

          .search-input {
            height: 100%;
            width: 80%;
            border: none;
            padding: 20px;
          }

          .search-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            border: none;
            height: 100%;
            width: 20%;
            background: orange;
            color: white;
            font-weight: bolder;
          }

          .search-btn:focus,
          .search-input:focus {
            outline: none;
          }
        }
      }

      .recipe {
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        margin: 10px;
        border-radius: 30px 0px 30px 0px;
        overflow: hidden;
        box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.311);
        width: 350px;
        height: 200px;
        position: relative;

        .recipe-title {
          position: absolute;
          width: 100%;
          height: 100%;
          padding: 10px;
          color: white;
          background: rgba(0, 0, 0, 0.4);
        }
      }

    }

    .btn {
      margin: 10px;
      display: block;
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
      box-shadow: 0px 0px 20px rgb(0, 0, 0)
    }

    .btn-sec {
      margin: 10px;
      display: block;
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




    /* Extra Small Devices, Phones */
    @media (max-width: 575.98px) {
      /* Your CSS for phones goes here */
    }

    /* Small Devices, Tablets */
    @media (min-width: 576px) and (max-width: 767.98px) {
      /* Your CSS for tablets goes here */
    }

    /* Medium Devices, Desktops */
    @media (min-width: 768px) and (max-width: 991.98px) {

      /* Your CSS for desktops goes here */
      .main-text {
        .title {
          text-align: center;
          font-size: 80px;
        }

        .sub-title {
          text-align: center;
        }
      }

      .recipe-container {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 10px;

        .recipe-section-title {
          font-size: 60px;
        }

        .search-bar-container {
          .searchbar {
            width: 50%;
          }
        }
      }
    }

    /* Extra large devices (large laptops and desktops, 1200px and up) */
    @media only screen and (min-width: 1200px) {
      .main-text {
        padding: 0 100px;
        /* border: 2px solids white; */

        .title {
          text-align: center;
          font-size: 80px;
        }

        .sub-title {
          text-align: center;
        }

        .btn-container {
          padding: 30px;
          display: flex;
        }
      }

      .recipe-container {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 10px;

        .recipe-section-title {
          font-size: 60px;
        }

        .search-bar-container {
          .searchbar {
            width: 40%;
          }
        }
      }
    }
  </style>


</head>

<body>
  <div class="main">
    <div class="main-text">
      <h1 class="title">Discover Delicious Recipes & Share Your's</h1>
      <p class="sub-title">Join our community of food enthusiasts and explore a world of flavors. Post your favorite recipes, search for new dishes, and get inspired every day</p>
      <div class="btn-container">
        <?php if ($is_logged_in) : ?>
          <a class="btn" href="add_recipe.php">Add Recipe</a>
          <a class="btn-sec" href="index.php?logout">Logout</a>
        <?php else : ?>
          <a class="btn" href="login.php">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="recipe-container">
    <h1 class="recipe-section-title">Explore Our Delicious Recipes</h1>
    <div class="search-bar-container">
      <form class="searchbar" method="GET" action="index.php">
        <i class="fa-solid fa-magnifying-glass searchicon"></i>
        <input class="search-input" type="text" name="query" placeholder="Search recipes">
        <button class="search-btn" type="submit">Search</button>
      </form>
    </div>
    <?php
    // Fetch recipes based on search query or get all recipes
    if (isset($_GET['query'])) {
      $query = '%' . $_GET['query'] . '%';
      // $stmt = $pdo->prepare("SELECT * FROM recipes WHERE title LIKE ? OR description LIKE ?");
      $stmt = $pdo->prepare("SELECT * FROM recipes WHERE title LIKE ? OR description LIKE ? OR ingredients LIKE ?");
      $stmt->execute([$query, $query, $query]);
      // $stmt->execute([$query, $query]);
      $recipes = $stmt->fetchAll();
    } else {
      $stmt = $pdo->query("SELECT * FROM recipes");
      $recipes = $stmt->fetchAll();
    }

    foreach ($recipes as $recipe) : ?>
      <a href="recipe.php?id=<?php echo $recipe['id']; ?>">
        <div class="recipe" style="background-image: url('<?php echo $recipe['image_url']; ?>');">
          <h2 class="recipe-title"><?php echo htmlspecialchars($recipe['title']); ?></h2>
        </div>
      </a>
    <?php endforeach; ?>

  </div>
</body>

</html>
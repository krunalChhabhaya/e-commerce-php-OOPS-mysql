<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WatchWise</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand ps-2" href="#"><img src="./images/logo.png" alt="Logo" height="30"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end pe-3" id="navbarNav">
        <ul class="navbar-nav">
          <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) : ?>
            <li class="nav-item px-3 active">
              <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item px-3">
              <a class="nav-link" href="products.php">Products</a>
            </li>
            <li class="nav-item px-3">
              <a class="nav-link" href="cart.php">Cart</a>
            </li>
            <li class="nav-item px-3">
              <a class="nav-link" href="orders.php">Orders</a>
            </li>
            <li class="nav-item px-3">
              <a class="nav-link" href="create_product.php">Create Product</a>
            </li>
            <li class="nav-item px-3 dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="./images/user-png.png" alt="User Image" height="30" width="30">
              </a>
              <div class="dropdown-menu drp-right" aria-labelledby="navbarDropdown">
                <span class="dropdown-item user-select-none">Welcome, <?php echo $_SESSION["username"]; ?></span>
                <span class="dropdown-item user-select-none"><?php echo $_SESSION["email"]; ?></span>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Logout</a>
              </div>
            </li>
          <?php else : ?>
            <li class="nav-item px-1">
              <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item px-1">
              <a class="nav-link" href="register.php">Register</a>
            </li>
          <?php endif; ?>
          <li class="nav-item px-1 pt-2">
            <span class="navbar-text pe-3">
              <?php include 'weather_api.php'; ?>
              <?php
              $temperature = getWeatherTemperature();
              $imageSrc = "";
              if ($temperature !== "N/A") {
                $temperatureValue = (int)$temperature;
                if ($temperatureValue < 10) {
                  $imageSrc = "./images/cold.png";
                } else if ($temperatureValue >= 10 && $temperatureValue < 20) {
                  $imageSrc = "./images/moderate.png";
                } else {
                  $imageSrc = "./images/hot.png";
                }
              } else {
                $imageSrc = "./images/na.png";
              }
              ?>
              <img src="<?php echo $imageSrc; ?>" alt="Temperature" height="30  ">
              <?php echo $temperature; ?>
            </span>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
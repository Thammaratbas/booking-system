<?php
require_once 'db.php';
$database = new Database();
$userData = $database->getUser($_SESSION['userId']);
?>

<nav class="navbar fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="user.php">ECS Booking</a>
    <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <span class="nav-link">
              <i class="fas fa-user me-1"></i> <?php echo $userData['firstname'] . ' ' . $userData['lastname']; ?>
            </span>
          </li>
          <li class="nav-item">
            <span class="nav-link">
              <i class="fas fa-envelope me-1"></i> <?php echo $userData['email']; ?>
            </span>
          </li>
          <li class="nav-item">
            <span class="nav-link">
              <i class="fas fa-phone me-1"></i> <?php echo $userData['phone']; ?>
            </span>
          </li>
          <br>
          <li class="nav-item">
            <a class="nav-link" href="user.php">Booking</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="history_user.php">History</a>
          </li>
          <br>
          <li class="d-grid gap-4">
            <a href="logout.php" class="btn btn-danger me-2">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
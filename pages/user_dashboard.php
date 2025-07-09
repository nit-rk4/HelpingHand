<?php
// /pages/user_dashboard.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard - HelpingHand</title>
  <link rel="stylesheet" href="../css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <header class="navbar">
    <div class="nav-left">
      <img class="logo" src="../assets/logo.svg" alt="HelpingHand Logo">
      <nav>
        <ul class="nav-links">
          <li><a href="#">Home</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">About us</a></li>
        </ul>
      </nav>
    </div>
    <div class="searchbar">
      <input type="text" placeholder="Search...">
    </div>
  </header>

  <div class="container">
    <aside class="sidebar">
        <ul>
            <li class="active"><a href="user_dashboard.php">Dashboard</a></li>
            <li><a href="user_profile.php">Profile</a></li>
        </ul>
    </aside>

<main class="main-content center-request">
  <h1>Submit a New Request</h1>
  <div class="submit-request-wrapper">
    <form class="submit-request-form" action="../php/submit_request.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="title">Request Title</label>
        <input type="text" id="title" name="title" required>
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4" required></textarea>
      </div>

      <div class="form-group">
        <label for="attachment">Attachment</label>
        <input type="file" id="attachment" name="attachment">
      </div>

      <div class="form-group">
        <label for="category">Category</label>
        <select id="category" name="category" required>
          <!-- your optgroups stay unchanged -->
        </select>
      </div>

      <div class="form-group">
        <label for="deadline">Deadline</label>
        <input type="date" id="deadline" name="deadline" required>
      </div>

      <div class="button-wrapper">
        <button type="submit" class="submit-btn">Submit</button>
        <button type="reset" class="reset-btn">Reset</button>
      </div>
    </form>
  </div>
</main>
  </div>
</body>
</html>
<?php
session_start();
require_once '../../php/config.php';
require_once '../../php/request_utils.php';

if (isset($_POST['submit-request'])) {
  $userId = $_SESSION['user_id'] ?? null;
  $title = $_POST['title'];
  $description = $_POST['description'];
  $category = $_POST['category'];
  $deadline = $_POST['deadline'];
  $attachment_path = null;

  // Handle file upload if needed
  if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = '../../assets/uploads/';
    $filename = basename($_FILES['attachment']['name']);
    $targetFile = $uploadDir . $filename;
    if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFile)) {
      $attachment_path = 'assets/uploads/' . $filename;
    }
  }

  submitRequest($conn, $userId, $title, $description, $category, $deadline, $attachment_path);

  header("Location: ../user/user_profile.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>User Dashboard - HelpingHand</title>
  <link rel="stylesheet" href="../../css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <?php include "../navbar.php" ?>

  <div class="container">
    <aside class="sidebar">
      <ul>
        <li class="active"><a href="user_dashboard.php">Dashboard</a></li>
        <li><a href="user_profile.php">Profile</a></li>
        <li><a href="my_helped_requests.php">My Helped Requests</a></li>
      </ul>
    </aside>

    <main class="main-content center-request">
      <h1>Submit a New Request</h1>
      <div class="submit-request-wrapper">
        <form class="submit-request-form" action="" method="POST" enctype="multipart/form-data">
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
              <optgroup label="Category 1">
                <option value="Home/Tech Help">Home/Tech Help</option>
                <option value="Escort/Babysitting">Escort/Babysitting</option>
                <option value="Volunteer Support">Volunteer Support</option>
                <option value="Errand">Errand</option>
                <option value="Lost Item">Lost Item</option>
                <option value="Tutoring/Academic Help">Tutoring/Academic Help</option>
              </optgroup>

              <optgroup label="Category 2">
                <option value="Food & Essentials">Food & Essentials</option>
                <option value="School Supplies">School Supplies</option>
                <option value="Goods Donations">Goods Donations</option>
              </optgroup>

              <optgroup label="Category 3">
                <option value="Medical Assistance">Medical Assistance</option>
                <option value="Legal & Documents">Legal & Documents</option>
                <option value="Monetary Assistance">Monetary Assistance</option>
              </optgroup>
            </select>
          </div>

          <div class="form-group">
            <label for="deadline">Deadline</label>
            <input type="date" id="deadline" name="deadline" required>
          </div>

          <div class="button-wrapper">
            <button type="submit" class="submit-btn" name="submit-request">Submit</button>
            <button type="reset" class="reset-btn">Reset</button>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>

</html>

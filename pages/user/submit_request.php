<?php
require_once "../../php/auth_user.php";
require_once '../../php/config.php';
require_once '../../php/request_utils.php';

// Initialize error message
$attachment_error = '';

if (isset($_POST['submit-request'])) {
  $userId = $_SESSION['auth']['id'] ?? null;
  $title = $_POST['title'];
  $description = $_POST['description'];
  $category = $_POST['category'];
  $deadline = $_POST['deadline'];
  $attachment_path = null;

  // Allowed file types
  $allowed_types = [
    'application/pdf',
    'image/jpeg',
    'image/jpg',
    'image/png',
    'image/gif',
    'image/bmp',
    'image/webp'
  ];
  $allowed_exts = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];

  // Insert request first to get request id
  require_once '../../php/request_utils.php';
  $result = submitRequest($conn, $userId, $title, $description, $category, $deadline, null);
  if ($result) {
    $request_id = mysqli_insert_id($conn);
    // Handle file upload if needed
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] != UPLOAD_ERR_NO_FILE) {
      if ($_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
        $filetype = mime_content_type($_FILES['attachment']['tmp_name']);
        $ext = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));
        if (in_array($filetype, $allowed_types) && in_array($ext, $allowed_exts)) {
          $uploadDir = '../../assets/uploads/';
          $date = date('Y-m-d');
          $new_filename = "request_{$request_id}_{$userId}_{$date}.{$ext}";
          $targetFile = $uploadDir . $new_filename;
          if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFile)) {
            $attachment_path = 'assets/uploads/' . $new_filename;
            // Update request with attachment path
            $stmt = mysqli_prepare($conn, "UPDATE requests SET attachment_path=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, 'si', $attachment_path, $request_id);
            mysqli_stmt_execute($stmt);
          } else {
            $attachment_error = 'Failed to upload file.';
          }
        } else {
          $attachment_error = 'Only PDF and image files (jpg, jpeg, png, gif, bmp, webp) are allowed.';
        }
      } else {
        $attachment_error = 'File upload error.';
      }
    }
    // If no error, redirect
    if (!$attachment_error) {
      header("Location: ../user/user_requests.php");
      exit();
    }
  } else {
    $attachment_error = 'Failed to submit request.';
  }
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
        <li class="active"><a href="submit_request.php">Submit a Request</a></li>
        <li><a href="user_requests.php">My Requests</a></li>
        <li><a href="my_helped_requests.php">My Contributions</a></li>
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
            <input type="file" id="attachment" name="attachment" accept=".pdf,image/*">
            <div class="note" style="font-size:0.95em;color:#555;margin-top:4px;">
              <strong>Note:</strong> Only PDF and image files (jpg, jpeg, png, gif, bmp, webp) are accepted.
            </div>
            <?php if (!empty($attachment_error)): ?>
              <div class="error-message" style="color:red; margin-top:4px;">
                <?= htmlspecialchars($attachment_error) ?>
              </div>
            <?php endif; ?>
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

<?php
// Dummy data (replace with DB later)
$title = "Food Supplies Needed";
$desc = "Requesting rice, canned goods for family of 5.";
$category = "Basic Needs";
$status = $_GET['status'] ?? 'pending';
$deadline = "2025-07-20";
$attachment = "../uploads/sample.jpg";
$helpers = ["User A", "User B"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($title) ?> - Request Details</title>
  <link rel="stylesheet" href="../css/style.css?v=2.2">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<?php include("../navbar.php"); ?>

<main class="details-wrapper">
  <a class="back-link" href="user_profile.php">← Back to My Requests</a>

  <h1><?= htmlspecialchars($title) ?></h1>

  <div class="details-section">
    <h3>Description</h3>
    <p><?= htmlspecialchars($desc) ?></p>

    <h3>Category</h3>
    <p><?= htmlspecialchars($category) ?></p>

    <h3>Status</h3>
    <p class="status-tag"><?= ucfirst($status) ?></p>

    <h3>Deadline</h3>
    <p><?= htmlspecialchars($deadline) ?></p>

    <?php if (!empty($attachment)): ?>
      <img src="<?= $attachment ?>" alt="Request Attachment" class="request-image">
    <?php endif; ?>
  </div>

  <?php if ($status === 'ongoing'): ?>
    <a href="#fulfill-modal" class="btn-action btn-fulfill">Mark as Fulfilled</a>
  <?php elseif ($status === 'fulfilled'): ?>
    <a href="#helpers-modal" class="btn-action btn-view">View Helpers</a>
  <?php elseif ($status === 'expired'): ?>
    <a href="#renew-modal" class="btn-action btn-renew">Renew Request</a>
  <?php endif; ?>
</main>

<!-- Fulfill Modal -->
<?php if ($status === 'ongoing'): ?>
<div id="fulfill-modal" class="modal">
  <div class="modal-content">
    <a href="#" class="modal-close">&times;</a>
    <h2>Mark as Fulfilled</h2>
    <form method="post">
      <?php foreach ($helpers as $h): ?>
        <label><input type="checkbox" name="helpers[]" value="<?= $h ?>"> <?= $h ?></label><br>
      <?php endforeach; ?>
      <button type="submit" class="btn-action btn-fulfill">Confirm</button>
    </form>
  </div>
</div>
<?php endif; ?>

<!-- Fulfilled Modal -->
<?php if ($status === 'fulfilled'): ?>
<div id="helpers-modal" class="modal">
  <div class="modal-content">
    <a href="#" class="modal-close">&times;</a>
    <h2>Fulfilled By</h2>
    <ul>
      <?php foreach ($helpers as $h): ?>
        <li><?= $h ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
<?php endif; ?>

<!-- Renew Modal -->
<?php if ($status === 'expired'): ?>
<div id="renew-modal" class="modal">
  <div class="modal-content">
    <a href="#" class="modal-close">&times;</a>
    <h2>Renew Request</h2>
    <form method="post" enctype="multipart/form-data">
      <label>Why do you want to renew?</label>
      <textarea name="renew_reason" rows="4" required></textarea>

      <label>Upload proof (optional):</label>
      <input type="file" name="renew_proof">

      <button type="submit" class="btn-action btn-renew">Submit Renewal</button>
    </form>
  </div>
</div>
<?php endif; ?>
</body>
</html>
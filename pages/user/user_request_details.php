<?php
// Read values from URL
$title = $_GET['title'] ?? 'No title';
$desc = $_GET['desc'] ?? 'No description';
$category = $_GET['category'] ?? 'N/A';
$status = $_GET['status'] ?? 'pending';
$deadline = $_GET['deadline'] ?? 'No deadline';
$attachment = '../uploads/' . ($_GET['attachment'] ?? '');
$helpers = ["Juan Dela Cruz", "Maria Santos", "Pedro Reyes"]; //dummy
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($title) ?> - Request Details</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css?v=4">
</head>
<body>
<?php include("../navbar.php"); ?>

<main class="details-wrapper">
  <a href="user_profile.php" class="back-link">← Back to My Requests</a>

  <h1><?= htmlspecialchars($title) ?></h1>

  <div class="details-section">
    <p><strong>Description:</strong> <?= htmlspecialchars($desc) ?></p>
    <p><strong>Category:</strong> <?= htmlspecialchars($category) ?></p>
    <p><strong>Status:</strong> <?= ucfirst($status) ?></p>
    <p><strong>Deadline:</strong> <?= htmlspecialchars($deadline) ?></p>
    <?php if (!empty($attachment) && file_exists($attachment)): ?>
      <img src="<?= $attachment ?>" class="request-image" alt="Attachment">
    <?php endif; ?>
  </div>

  <!-- Conditional Buttons -->
  <?php if ($status === 'ongoing'): ?>
    <a href="#fulfill-modal" class="btn btn-fulfill">Mark as Fulfilled</a>
  <?php elseif ($status === 'fulfilled'): ?>
    <a href="#helpers-modal" class="btn btn-view">View Helpers</a>
  <?php elseif ($status === 'expired'): ?>
    <a href="#renew-modal" class="btn btn-renew">Renew Request</a>
  <?php endif; ?>
</main>

<!-- Fulfill Modal -->
<?php if ($status === 'ongoing'): ?>
<div id="fulfill-modal" class="modal">
  <div class="modal-content">
    <a href="#" class="modal-close">&times;</a>
    <h2>Confirm Fulfillment</h2>
    <form method="post">
      <?php foreach ($helpers as $h): ?>
        <label><input type="checkbox" name="helpers[]" value="<?= $h ?>"> <?= $h ?></label><br>
      <?php endforeach; ?>
      <button type="submit" class="btn btn-fulfill">Confirm</button>
    </form>
  </div>
</div>
<?php endif; ?>

<!-- Fulfilled Modal -->
<?php if ($status === 'fulfilled'): ?>
<div id="helpers-modal" class="modal">
  <div class="modal-content">
    <a href="#" class="modal-close">&times;</a>
    <h2>Helped By:</h2>
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
      <label>Upload Proof (optional)</label>
      <input type="file" name="renew_proof">
      <button type="submit" class="btn btn-renew">Submit Renewal</button>
    </form>
  </div>
</div>
<?php endif; ?>
</body>
</html> 
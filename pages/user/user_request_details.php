<?php
require_once "../../php/auth_user.php";
require_once "../../php/config.php";
require_once "../../php/request_utils.php";
require_once "../../php/help_utils.php";

$requestID = $_GET['id'] ?? null;
$userID = $_SESSION['auth']['id'] ?? null;


$request = getRequestDetailsForUser($conn,$requestID, $userID);

if (!$request){
  die("Request not found.");
}

$helpers = getHelpers($conn, $requestID);

$verifiedHelpers = [];
if ($request['status'] === 'fulfilled') {
    $verifiedHelpers = getVerifiedHelpers($conn, $requestID);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['verify_submit'])) {
      $toVerify = $_POST['helpers'] ?? [];
      foreach ($toVerify as $helperID) {
          verifyHelper($conn, $requestID, intval($helperID));
      }
      fulfillRequest($conn, $requestID);
      header("Location: user_request_details.php?id=$requestID");
      exit;
  }

  if (isset($_POST['renew_submit'])) {
    if ($request['status'] === 'expired' && $request['expiration_reason'] === 'visibility') {
        $renewReason = trim($_POST['renew_reason']);
        $newFile = null;

        if (!empty($_FILES['renew_proof']['name'])) {
            $uploadDir = "../../uploads/";
            $filename = basename($_FILES['renew_proof']['name']);
            $targetPath = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['renew_proof']['tmp_name'], $targetPath)) {
                $newFile = $filename;
            }
        }

        if (renewRequest($conn, $requestID, $renewReason, $newFile)) {
            header("Location: user_request_details.php?id=$requestID&renewed=1");
            exit;
        } else {
            $error = "Renewal failed. Please try again.";
        }
    } else {
        $error = "This request cannot be renewed.";
    }
}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($request['title']) ?> - Request Details</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/style.css?v=4">
  <style>
    .verified-helpers-list {
      list-style-type: none;
      padding: 0;
    }

    .verified-helper-item {
      margin-bottom: 12px;
      line-height: 1.4;
    }
  </style>
</head>
<body>
<?php include("../navbar.php"); ?>

<main class="details-wrapper">
  <a href="user_profile.php" class="back-link">← Back to My Requests</a>

  <h1><?= htmlspecialchars($request['title']) ?></h1>

<div class="details-section">
  <?php $displayStatus = $request['status'] === 'approved' ? 'Ongoing' : ucfirst($request['status']); ?>
  
  <p><span class="details-label">Description:</span> <?= htmlspecialchars($request['description']) ?></p>
  <p><span class="details-label">Category:</span> <?= htmlspecialchars($request['category']) ?></p>
  <p><span class="details-label">Status:</span> <?= $displayStatus ?></p>
  <p><span class="details-label">Deadline:</span> <?= htmlspecialchars($request['deadline']) ?></p>

  <?php if (!empty($request['attachment_path'])): ?>
    <div class="request-attachment">
      <strong>Attachment:</strong>
      <a class="attachment-link" href="../../uploads/<?= htmlspecialchars($request['attachment_path']) ?>" target="_blank" rel="noopener noreferrer">
        View Attachment
      </a>
      <?php
        $path = "../../uploads/" . $request['attachment_path'];
        if (file_exists($path)) {
          $mime = mime_content_type($path);
          if (str_starts_with($mime, "image/")) {
            echo "<div class='attachment-preview'>";
            echo "<img src='$path' alt='Attachment Preview'>";
            echo "</div>";
          }
        }
      ?>
    </div>
  <?php else: ?>
    <div class="request-attachment">
      <strong>Attachment:</strong> None
    </div>
  <?php endif; ?>
</div>

  <!-- Conditional Buttons -->
  <?php if ($request['status'] === 'approved'): ?>
    <a href="#fulfill-modal" class="btn btn-fulfill">Mark as Fulfilled</a>
  <?php elseif ($request['status'] === 'fulfilled'): ?>
    <a href="#helpers-modal" class="btn btn-view">View Helpers</a>
  <?php elseif ($request['status'] === 'expired' && $request['expiration_reason'] === 'visibility'): ?>
    <a href="#renew-modal" class="btn btn-renew">Renew Request</a>
  <?php endif; ?>
</main>

<!-- Fulfill Modal -->
<?php if ($request['status'] === 'approved'): ?>
<div id="fulfill-modal" class="modal">
  <div class="modal-content">
    <a href="#" class="modal-close">&times;</a>
    <h2>Confirm Fulfillment</h2>
    <form method="post">
      <?php if (count($helpers) > 0): ?>
        <?php foreach ($helpers as $h): ?>
          <div class="helper-entry">
            <label>
              <input type="checkbox" name="helpers[]" value="<?= $h['user_id'] ?>">
              <?= htmlspecialchars($h['name']) ?>
            </label>

            <?php if (!empty($h['proof_text'])): ?>
              <p><em><?= htmlspecialchars($h['proof_text']) ?></em></p>
            <?php endif; ?>

            <?php if (!empty($h['proof_file'])): ?>
              <a href="/uploads/<?= htmlspecialchars($h['proof_file']) ?>" target="_blank">📎 View File</a>
            <?php endif; ?>
          </div>
          <hr>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No helpers have offered assistance yet. </p>
      <?php endif; ?>
      <button type="submit" name="verify_submit" class="btn btn-fulfill">Confirm</button>
    </form>
  </div>
</div>
<?php endif; ?>

<!-- Fulfilled Modal -->
<?php if ($request['status'] === 'fulfilled'): ?>
<div id="helpers-modal" class="modal">
  <div class="modal-content">
    <a href="#" class="modal-close">&times;</a>
    <h2>Helped By:</h2>

    <?php if (count($verifiedHelpers) > 0): ?>
      <ul class="verified-helpers-list">
        <?php foreach ($verifiedHelpers as $helper): ?>
          <li class="verified-helper-item">
            <strong><?= htmlspecialchars($helper['name']) ?></strong><br>
            <?php if (!empty($helper['proof_text'])): ?>
              <em><?= htmlspecialchars($helper['proof_text']) ?></em><br>
            <?php endif; ?>
            <?php if (!empty($helper['proof_file'])): ?>
              <a href="/uploads/<?= htmlspecialchars($helper['proof_file']) ?>" target="_blank">📎 View Proof</a>
            <?php endif; ?>
          </li>
          <hr>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No verified helpers yet.</p>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>

<!-- Renew Modal -->
<?php if ($request['status'] === 'expired' && $request['expiration_reason'] === 'visibility'): ?>
<div id="renew-modal" class="modal">
  <div class="modal-content">
    <a href="#" class="modal-close">&times;</a>
    <h2>Renew Request</h2>
    <form method="post" enctype="multipart/form-data">
      <label>Why do you want to renew?</label>
      <textarea name="renew_reason" rows="4" required></textarea>
      <label>Upload Proof (optional)</label>
      <input type="file" name="renew_proof">
      <button type="submit" name= "renew_submit" class="btn btn-renew">Submit Renewal</button>
    </form>
  </div>
</div>
<?php endif; ?>
</body>
</html> 
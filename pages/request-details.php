<?php
require "../php/config.php";
require "../php/request_utils.php";

$requestID = $_GET['id'] ?? null;

if (!$requestID){
  die("Missing request ID.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  if (isset($_POST['approve'])){
    approveRequest($conn, $requestID);
  } elseif (isset($_POST['reject'])){
    rejectRequest($conn, $requestID);
  } elseif (isset($_POST['mark_interview'])){
    markForInterview($conn, $requestID);
  }

  header("Location: admin_requests.php");
  exit();
}

$details = getRequestDetails($conn, $requestID);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Request Details - HelpingHand Admin</title>
  <link rel="stylesheet" href="../css/style.css" />
</head>
<body>

  <!-- NAVBAR -->
  <?php include("navbar.php"); ?>


  <!-- DETAILS WRAPPER -->
  <main class="details-wrapper">
    <a class="back-link" href="admin_requests.php">← Back to Requests</a>

    <?php
    $status = $details['status'];
    $title = $details['title'];
    $requester = $details['requester_name'];
    $email = $details['requester_email'];
    $phone = $details['requester_contact'];
    $description = $details['description'];
    $category = $details['category'];
    $tier = $details['tier'];
    ?>

    <h2><?= $title ?></h2>

    <!-- Applicant Info -->
    <div class="details-section">
      <h3>Requester Info</h3>
      <p><span class="details-label">Name:</span><?= $requester ?></p>
      <p><span class="details-label">Email:</span><?= $email ?></p>
      <p><span class="details-label">Phone:</span><?= $phone ?></p>
    </div>

    <!-- Request Description -->
    <div class="details-section">
      <h3>Request Description</h3>
      <p><span class ="details-label">Tier:</span><?= $tier ?>  |  <span class="details-label">Category:</span><?= $category ?></p>
      <p><?= $description ?></p>
    </div>

    <div class="details-section">
      <p><strong>Status:</strong>
        <span class="status <?= htmlspecialchars($status) ?>">
          <?= ucfirst(htmlspecialchars($status)) ?>
        </span>
      </p>
    </div>


    <!-- Action Buttons or Status Display -->
    <?php if ($status === 'pending'): ?>
      <form method="post" class="details-buttons">
        <button type="submit" name="approve" class="btn-approve">APPROVE</button>
        <button type="submit" name="reject" class="btn-reject">REJECT</button>
        <button type="submit" name="mark_interview" class="btn-interview">FOR INTERVIEW</button>
      </form>
    <?php endif; ?>

  </main>

</body>
</html>

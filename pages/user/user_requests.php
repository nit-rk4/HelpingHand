<?php
session_start();
require_once "../../php/config.php";
require_once "../../php/request_utils.php";
require_once "../../php/maintenance.php";
runMaintenance($conn);

$userID = $_SESSION['user'];
$statusFilter = isset($_GET['status']) ? strtolower($_GET['status']) : 'all';
$requests = getUserRequestsByStatus($conn, $userID, $statusFilter);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile - HelpingHand</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<?php include "../navbar.php"?>

<div class="container">
  <aside class="sidebar">
    <ul>
      <li><a href="submit_request.php">Submit a Request</a></li>
      <li class="active"><a href="user_requests.php">My Requests</a></li>
      <li><a href="my_helped_requests.php">Requests I Helped On</a></li>
    </ul>
  </aside>

  <main class="main-content">
    <h1>My Submitted Requests</h1>
    <div class="tabs-filter-container">
      <div class="tabs">
        <a href="?status=all" class="tab <?= $statusFilter=='all'?'active':'' ?>">All</a>
        <a href="?status=pending" class="tab <?= $statusFilter=='pending'?'active':'' ?>">Pending</a>
        <a href="?status=approved" class="tab <?= $statusFilter=='approved'?'active':'' ?>">Ongoing</a>
        <a href="?status=rejected" class="tab <?= $statusFilter=='rejected'?'active':'' ?>">Rejected</a>
        <a href="?status=fulfilled" class="tab <?= $statusFilter=='fulfilled'?'active':'' ?>">Fulfilled</a>
        <a href="?status=expired" class="tab <?= $statusFilter=='expired'?'active':'' ?>">Expired</a>
      </div>
    </div>

    <div class="requests-table">
      <div class="request-row header">
        <span class="title">Title</span>
        <span class="desc">Description</span>
        <span class="category">Category</span>
        <span class="status">Status</span>
        <span class="deadline">Deadline</span>
      </div>

    <?php foreach ($requests as $req): ?>
      <?php if ($statusFilter == 'all' || $req['status'] == $statusFilter): ?>
        <?php $displayStatus = $req['status'] === 'approved' ? 'Ongoing' : ucfirst($req['status']);?>
        <a href="user_request_details.php?id=<?= $req['id'] ?>" class="request-row">
          <span class="title"><?= htmlspecialchars($req['title']) ?></span>
          <span class="desc"><?= htmlspecialchars($req['description']) ?></span>
          <span class="category"><?= htmlspecialchars($req['category']) ?></span>
          <span class="status"><?= $displayStatus ?></span>
          <span class="deadline"><?= htmlspecialchars($req['deadline']) ?></span>
        </a>
      <?php endif; ?>
    <?php endforeach; ?>

      <div class="details-wrapper">
      <p><span class="details-label">Total Requests Submitted:</span> <?= count($requests) ?></p>
      <p><span class="details-label">Requests Fulfilled:</span> <?= count(array_filter($requests,fn($r)=>$r['status']=='fulfilled')) ?></p>
      <p><span class="details-label">Pending Requests:</span> <?= count(array_filter($requests,fn($r)=>$r['status']=='pending')) ?></p>
    </div>
    
    </div>
  </main>
</div>
</body>
</html>
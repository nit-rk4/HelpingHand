<?php
session_start();
require_once '../../php/config.php';
require_once '../../php/request_utils.php';

$error = "";
$statusFilter = isset($_GET['status']) ? strtolower($_GET['status']) : 'all';
$userId = $_SESSION['user_id'] ?? null;

$requests = [];
if ($userId) {
  $requests = getUserRequests($conn, $userId, $statusFilter);
}
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
  <?php include "../navbar.php" ?>

  <div class="container">
    <aside class="sidebar">
      <ul>
        <li><a href="user_dashboard.php">Dashboard</a></li>
        <li class="active"><a href="user_profile.php">Profile</a></li>
        <li><a href="my_helped_requests.php">My Helped Requests</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <h1>My Submitted Requests</h1>
      <div class="tabs-filter-container">
        <div class="tabs">
          <a href="?status=all" class="tab <?= $statusFilter == 'all' ? 'active' : '' ?>">All</a>
          <a href="?status=pending" class="tab <?= $statusFilter == 'pending' ? 'active' : '' ?>">Pending</a>
          <a href="?status=ongoing" class="tab <?= $statusFilter == 'ongoing' ? 'active' : '' ?>">Ongoing</a>
          <a href="?status=rejected" class="tab <?= $statusFilter == 'rejected' ? 'active' : '' ?>">Rejected</a>
          <a href="?status=fulfilled" class="tab <?= $statusFilter == 'fulfilled' ? 'active' : '' ?>">Fulfilled</a>
          <a href="?status=expired" class="tab <?= $statusFilter == 'expired' ? 'active' : '' ?>">Expired</a>
        </div>
      </div>

      <div class="requests-table">
        <div class="request-row header">
          <span class="title">Title</span>
          <span class="desc">Description</span>
          <span class="status">Status</span>
          <span class="deadline">Deadline</span>
        </div>
        <?php
        foreach ($requests as $req) {
          if ($statusFilter == 'all' || $req['status'] == $statusFilter) {
            $query = http_build_query([
              'title' => $req['title'],
              'desc' => $req['desc'],
              'category' => 'Basic Needs',
              'status' => $req['status'],
              'deadline' => $req['deadline'],
              'attachment' => 'sample.jpg'
            ]);
            echo '<a href="user_request_details.php?' . $query . '" class="request-row">';
            echo '<span class="title">' . htmlspecialchars($req['title']) . '</span>';
            echo '<span class="desc">' . htmlspecialchars($req['desc']) . '</span>';
            echo '<span class="status">' . ucfirst($req['status']) . '</span>';
            echo '<span class="deadline">' . htmlspecialchars($req['deadline']) . '</span>';
            echo '</a>';
          }
        }
        ?>


        <div class="details-wrapper">
          <p><span class="details-label">Total Requests Submitted:</span> <?= count($requests) ?></p>
          <p><span class="details-label">Requests Fulfilled:</span> <?= count(array_filter($requests, fn($r) => $r['status'] == 'fulfilled')) ?></p>
          <p><span class="details-label">Pending Requests:</span> <?= count(array_filter($requests, fn($r) => $r['status'] == 'pending')) ?></p>
        </div>

      </div>
    </main>
  </div>
</body>

</html>

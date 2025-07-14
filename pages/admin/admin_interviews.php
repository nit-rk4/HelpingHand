<?php
require_once "../../php/auth_admin.php";
require_once "../../php/config.php";
require_once "../../php/maintenance.php";
require_once "../../php/interview_utils.php";

runMaintenance($conn);

$status = $_GET['status'] ?? 'pending';

$interviews = getInterviewsByStatus($conn, $status);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard - Interviews</title>
  <link rel="stylesheet" href="../../css/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    .tab.active {
      background-color: #ffb2b2;
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <?php include("../navbar.php"); ?>

  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <ul>
        <li><a href="admin_requests.php">User Requests</a></li>
        <li class="active"><a href="admin_interviews.php?status=pending">Interviews</a></li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <h1>Interviews</h1>

      <!-- Tabs -->
      <div class="tabs-filter-container">
        <div class="tabs">
          <button class="tab <?= $status === 'pending' ? 'active' : '' ?>" onclick="goToStatus('pending')">Pending</button>
          <button class="tab <?= $status === 'scheduled' ? 'active' : '' ?>" onclick="goToStatus('scheduled')">Scheduled</button>
          <button class="tab <?= $status === 'done' ? 'active' : '' ?>" onclick="goToStatus('done')">Completed</button>
        </div>
      </div>

      <!-- Table Header -->
      <div class="request-row header">
        <span>Requester</span>
        <span>Request Title</span>
        <?php if ($status !== 'pending'): ?>
          <span>Date</span>
          <span>Time</span>
          <span>Interviewer</span>
        <?php endif; ?>
      </div>

      <!-- Interview Rows -->
      <?php foreach ($interviews as $interview): ?>
        <a href="interview_details.php?id=<?= $interview['id'] ?>" class="request-row">
          <span><?= htmlspecialchars($interview['requester_name']) ?></span>
          <span><?= htmlspecialchars($interview['request_title']) ?></span>
          <?php if ($status !== 'pending'): ?>
            <span><?= htmlspecialchars($interview['date']) ?></span>
            <span><?= date("g:i A", strtotime($interview['time'])) ?></span>
            <span><?= htmlspecialchars($interview['interviewer']) ?></span>
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
    </main>
  </div>

  <!-- Filter logic -->
  <script>
    function goToStatus(status) {
      window.location.href = `admin_interviews.php?status=${status}`;
    }
  </script>


</body>

</html>

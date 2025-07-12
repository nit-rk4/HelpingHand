<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>HelpingHand Admin - Interviews</title>
  <link rel="stylesheet" href="../../css/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>

  <!-- Navbar -->
  <?php include("../navbar.php"); ?>

  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <ul>
        <li><a href="admin_requests.php">User Requests</a></li>
        <li class="active"><a href="admin_interviews.php">Interviews</a></li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <h1>Interviews</h1>

      <!-- Tabs -->
      <div class="tabs-filter-container">
        <div class="tabs">
          <button class="tab active" onclick="filterTab('pending', this)" data-status="pending">Pending</button>
          <button class="tab" onclick="filterTab('scheduled', this)" data-status="scheduled">Scheduled</button>
          <button class="tab" onclick="filterTab('completed', this)" data-status="completed">Completed</button>
        </div>
      </div>

      <!-- Table Headers -->
      <div id="header-pending" class="request-row header">
        <span>Requester</span>
        <span>Request Title</span>
      </div>

      <div id="header-scheduled" class="request-row header" style="display: none;">
        <span>Requester</span>
        <span>Request Title</span>
        <span>Date</span>
        <span>Time</span>
        <span>Interviewer</span>
      </div>

      <div id="header-completed" class="request-row header" style="display: none;">
        <span>Requester</span>
        <span>Request Title</span>
        <span>Date</span>
        <span>Time</span>
        <span>Interviewer</span>
      </div>

      <!-- Interview Rows -->
      <?php
      require_once "../../php/config.php";
      require_once "../../php/interview_utils.php";
      // Fetch interviews by status
      $pendingInterviews = getInterviewsByStatus($conn, 'pending');
      $scheduledInterviews = getInterviewsByStatus($conn, 'scheduled');
      $completedInterviews = getInterviewsByStatus($conn, 'done');
      ?>

      <!-- Pending Interviews -->
      <?php foreach ($pendingInterviews as $interview): ?>
        <a href="#" data-interview-id="<?= $interview['id'] ?>" class="request-row interview-item" data-status="pending">
          <span><?= htmlspecialchars($interview['requester_name']) ?></span>
          <span><?= htmlspecialchars($interview['request_title']) ?></span>
        </a>
      <?php endforeach; ?>

      <!-- Scheduled Interviews -->
      <?php foreach ($scheduledInterviews as $interview): ?>
        <a href="#" data-interview-id="<?= $interview['id'] ?>" class="request-row interview-item" data-status="scheduled" style="display: none;">
          <span><?= htmlspecialchars($interview['requester_name']) ?></span>
          <span><?= htmlspecialchars($interview['request_title']) ?></span>
          <span><?= htmlspecialchars($interview['date']) ?></span>
          <span><?= htmlspecialchars($interview['time']) ?></span>
          <span><?= htmlspecialchars($interview['interviewer']) ?></span>
        </a>
      <?php endforeach; ?>

      <!-- Completed Interviews -->
      <?php foreach ($completedInterviews as $interview): ?>
        <a href="#" data-interview-id="<?= $interview['id'] ?>" class="request-row interview-item" data-status="completed" style="display: none;">
          <span><?= htmlspecialchars($interview['requester_name']) ?></span>
          <span><?= htmlspecialchars($interview['request_title']) ?></span>
          <span><?= htmlspecialchars($interview['date']) ?></span>
          <span><?= htmlspecialchars($interview['time']) ?></span>
          <span><?= htmlspecialchars($interview['interviewer']) ?></span>
        </a>
      <?php endforeach; ?>

    </main>
  </div>

  <!-- Filter -->
  <script>
    function filterTab(status, button = null) {
      const tabs = document.querySelectorAll('.tab');
      tabs.forEach(tab => tab.classList.remove('active'));
      if (button) button.classList.add('active');

      const items = document.querySelectorAll('.interview-item');
      items.forEach(item => {
        item.style.display = item.dataset.status === status ? 'flex' : 'none';
      });

      // headers
      document.getElementById('header-pending').style.display = (status === 'pending') ? 'flex' : 'none';
      document.getElementById('header-scheduled').style.display = (status === 'scheduled') ? 'flex' : 'none';
      document.getElementById('header-completed').style.display = (status === 'completed') ? 'flex' : 'none';
    }

    // Load default tab and attach click event on page load
    window.addEventListener('DOMContentLoaded', () => {
      const defaultTab = document.querySelector('.tab[data-status="pending"]');
      filterTab('pending', defaultTab);

      // Save interview ID to session and redirect
      document.querySelectorAll('.interview-item').forEach(item => {
        item.addEventListener('click', function(e) {
          e.preventDefault();
          const interviewId = this.getAttribute('data-interview-id');
          // Directly redirect with id in URL
          window.location.href = 'interview_details.php?id=' + interviewId;
        });
      });
    });
  </script>

</body>

</html>

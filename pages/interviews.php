<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>HelpingHand Admin - Interviews</title>
  <link rel="stylesheet" href="../css/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>

  <!-- Navbar -->
  <header class="navbar" id="nav-color">
    <div class="nav-left">
      <img class="logo" src="../assets/logo.svg" alt="HelpingHand Logo" />
      <nav>
        <ul class="nav-links">
          <li><a href="#">Home</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">About us</a></li>
        </ul>
      </nav>
    </div>
    <div class="searchbar">
      <input type="text" placeholder="Search interviews..." />
    </div>
  </header>

  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <ul>
        <li><a href="admin_requests.php">User Requests</a></li>
        <li class="active"><a href="interviews.php">Interviews</a></li>
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
      <!-- Pending -->
      <a href="interview-details.php?status=pending" class="request-row interview-item" data-status="pending">
        <span>Carlos Reyes</span>
        <span>Scholarship application interview</span>
      </a>

      <!-- Scheduled -->
      <a href="interview-details.php?status=scheduled" class="request-row interview-item" data-status="scheduled" style="display: none;">
        <span>Ana Lopez</span>
        <span>Review of living conditions for aid</span>
        <span>2025-07-12</span>
        <span>10:00 AM</span>
        <span>Ms. Santos</span>
      </a>

      <!-- Completed -->
      <a href="interview-details.php?status=completed" class="request-row interview-item" data-status="completed" style="display: none;">
        <span>Juan Dela Cruz</span>
        <span>Post-support assessment</span>
        <span>2025-07-01</span>
        <span>9:00 AM</span>
        <span>Mr. Reyes</span>
      </a>

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

    // Load default tab on page load
    window.addEventListener('DOMContentLoaded', () => {
      const defaultTab = document.querySelector('.tab[data-status="pending"]');
      filterTab('pending', defaultTab);
    });
  </script>

</body>
</html>

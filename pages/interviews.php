<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>HelpingHand Admin - Interviews</title>
  <link rel="stylesheet" href="styles.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>

  <!-- Navbar -->
  <header class="navbar" id="nav-color">
    <div class="nav-left">
      <img class="logo" src="assets/logo.svg" alt="HelpingHand Logo" />
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

      <!-- Table Header -->
      <div class="request-row header">
        <span>Name</span>
        <span>Date</span>
        <span>Time</span>
        <span>Type</span>
      </div>

      <!-- Interview Rows Samples-->
      <a href="interview-details.php?status=pending" class="request-row interview-item" data-status="pending">
  <span>Carlos Reyes</span>
  <span>2025-07-10</span>
  <span>2:00 PM</span>
  <span>In-Person</span>
</a>

<a href="interview-details.php?status=scheduled" class="request-row interview-item" data-status="scheduled">
  <span>Ana Lopez</span>
  <span>2025-07-12</span>
  <span>10:00 AM</span>
  <span>In-Person</span>
</a>

<a href="interview-details.php?status=completed" class="request-row interview-item" data-status="completed">
  <span>Juan Dela Cruz</span>
  <span>2025-07-01</span>
  <span>9:00 AM</span>
  <span>Virtual</span>
</a>


  <!-- This block is for filtering interview status (pending, scheduled, or completed) when clicking on tab buttons. -->
  <script>
    function filterTab(status, button = null) {
      const tabs = document.querySelectorAll('.tab');
      tabs.forEach(tab => tab.classList.remove('active'));
      if (button) button.classList.add('active');

      const items = document.querySelectorAll('.interview-item');
      items.forEach(item => {
        item.style.display = item.dataset.status === status ? 'flex' : 'none';
      });
    }

    window.addEventListener('DOMContentLoaded', () => {
      const defaultTab = document.querySelector('.tab[data-status="pending"]');
      filterTab('pending', defaultTab);
    });
  </script>

</body>
</html>

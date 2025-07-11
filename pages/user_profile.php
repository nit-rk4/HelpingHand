<?php
// /pages/user_profile.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile - HelpingHand</title>
  <link rel="stylesheet" href="../css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <header class="navbar">
    <div class="nav-left">
      <img class="logo" src="../assets/logo.svg" alt="HelpingHand Logo">
      <nav>
        <ul class="nav-links">
          <li><a href="user_dashboard.php">Dashboard</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">About Us</a></li>
        </ul>
      </nav>
    </div>
  </header>

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
     <div class="tabs">
  <button class="tab active" data-popover="Requests you submitted that are waiting for review or action.">Pending</button>
  <button class="tab" data-popover="Requests currently being processed or receiving help.">Ongoing</button>
  <button class="tab" data-popover="Requests that were not approved or denied.">Rejected</button>
  <button class="tab" data-popover="Requests that have been successfully fulfilled.">Fulfilled</button>
  <button class="tab" data-popover="Requests that passed their deadline without being fulfilled.">Expired</button>
</div>
      </div>

      <div class="requests-table">
        <div class="request-row header">
          <span class="title">Title</span>
          <span class="desc">Description</span>
          <span class="status">Status</span>
          <span class="deadline">Deadline</span>
        </div>

        <!-- Sample Requests -->
        <div class="request-row">
          <span class="title">Food Supplies Needed</span>
          <span class="desc">Requesting rice, canned goods for my family of 5.</span>
          <span class="status">Pending</span>
          <span class="deadline">2025-07-20</span>
        </div>

        <div class="request-row">
          <span class="title">Medical Assistance</span>
          <span class="desc">Help needed for prescription refill.</span>
          <span class="status">Fulfilled</span>
          <span class="deadline">2025-07-10</span>
        </div>

        <div class="request-row">
          <span class="title">Home Repair Help</span>
          <span class="desc">Looking for assistance repairing our leaking roof.</span>
          <span class="status">Pending</span>
          <span class="deadline">2025-07-25</span>
        </div>
      </div>

      <h2 style="margin-top: 40px;">Help Count Summary</h2>
      <section class="help-count-section">
        <h2>Help Count</h2>

        <div class="donut-chart" role="img" aria-label="Help points distribution">
          <div class="segment category1" style="--value: 40;"></div>
          <div class="segment category2" style="--value: 30;"></div>
          <div class="segment category3" style="--value: 30;"></div>
          <div class="donut-center">
            <span class="total">100</span>
            <span>pts</span>
          </div>
        </div>

        <div class="donut-legend">
          <div><span class="legend-box category1"></span> Category 1 (40)</div>
          <div><span class="legend-box category2"></span> Category 2 (30)</div>
          <div><span class="legend-box category3"></span> Category 3 (30)</div>
        </div>
      </section>

      <div class="details-wrapper">
        <p><span class="details-label">Total Requests Submitted:</span> 3</p>
        <p><span class="details-label">Requests Fulfilled:</span> 1</p>
        <p><span class="details-label">Pending Requests:</span> 2</p>
      </div>
    </main>
  </div>
</body>
</html>
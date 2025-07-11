<?php
// /pages/my_helped_requests.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Helped Requests - HelpingHand</title>
  <link rel="stylesheet" href="../css/style.css?v=2.1">
</head>
<body>
  <header class="navbar">
    <a href="/HelpingHand/"><img class="logo" src="../assets/logo.svg" alt="HelpingHand Logo"></a>
    <nav>
      <ul class="nav-links">
        <li><a href="/HelpingHand/">Home</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="#">About us</a></li>
      </ul>
    </nav>
  </header>

  <div class="user-dashboard">
    <aside class="sidebar">
      <ul>
        <li><a href="user_dashboard.php">Dashboard</a></li>
        <li class="active"><a href="user_profile.php">Profile</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <h2>My Helped Requests</h2>
      <div class="my-helped-section">
        <div class="helped-requests-list">
          <!-- Example Helped Request Card -->
          <div class="request-card">
            <div class="request-title">Medical Assistance Needed</div>
            <div class="request-meta">
              <span class="status-tag fulfilled">Help Verified</span>
              <span class="requester">Requester: Maria Dela Cruz</span>
            </div>
            <div class="button-wrapper">
              <button class="submit-btn" onclick="openHelpDetails('req1')">View Details</button>
            </div>
          </div>

          <div class="request-card">
            <div class="request-title">Food Donation Campaign</div>
            <div class="request-meta">
              <span class="status-tag">Not Verified</span>
              <span class="requester">Requester: Juan Santos</span>
            </div>
            <div class="button-wrapper">
              <button class="submit-btn" onclick="openHelpDetails('req2')">View Details</button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Popover Overlays -->
  <div class="popover-overlay" id="popover-req1">
    <div class="popover-box">
      <h3>Medical Assistance Needed</h3>
      <p><strong>Requester:</strong> Maria Dela Cruz</p>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam nec erat ut felis sagittis aliquam.</p>
      <p><strong>Contact:</strong> +639123456789 | maria@gmail.com</p>
      <div class="button-wrapper">
        <button class="submit-btn">Confirm I Helped</button>
        <button class="reset-btn" onclick="closeHelpDetails('req1')">Close</button>
      </div>
    </div>
  </div>

  <div class="popover-overlay" id="popover-req2">
    <div class="popover-box">
      <h3>Food Donation Campaign</h3>
      <p><strong>Requester:</strong> Juan Santos</p>
      <p>Donec et magna nec nisl suscipit fringilla. Praesent quis arcu in lorem sodales eleifend.</p>
      <p><strong>Contact:</strong> +639987654321 | juan@gmail.com</p>
      <div class="button-wrapper">
        <button class="submit-btn">Confirm I Helped</button>
        <button class="reset-btn" onclick="closeHelpDetails('req2')">Close</button>
      </div>
    </div>
  </div>

  <script>
    function openHelpDetails(id) {
      document.getElementById('popover-' + id).style.display = 'flex';
    }

    function closeHelpDetails(id) {
      document.getElementById('popover-' + id).style.display = 'none';
    }
  </script>
</body>
</html>s
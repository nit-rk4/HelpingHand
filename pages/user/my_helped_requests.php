<?php 
// /pages/my_helped_requests.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Helped Requests - HelpingHand</title>
  <link rel="stylesheet" href="../../css/style.css?v=2.1">
</head>
<body>
  <?php include ("../navbar.php") ?>

  <div class="container">
    <aside class="sidebar">
      <ul>
        <li><a href="user_dashboard.php">Dashboard</a></li>
        <li><a href="user_profile.php">Profile</a></li>
        <li class="active"><a href="my_helped_requests.php">My Helped Requests</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <h2>My Helped Requests</h2>
      <div class="my-helped-section">
        <div class="helped-requests-list">
          
          <!-- Helped Request 1 -->
          <div class="request-card">
            <div class="request-title">Medical Assistance Needed</div>
            <div class="request-meta">
              <span class="status-tag fulfilled">Help Verified</span>
              <span class="requester">Requester: Maria Dela Cruz</span>
            </div>
            <div class="button-wrapper">
              <button class="submit-btn" onclick="toggleDetails('details-req1')">View Details</button>
            </div>
            <div class="request-details" id="details-req1" style="display: none;">
              <p><strong>Requester:</strong> Maria Dela Cruz</p>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam nec erat ut felis sagittis aliquam.</p>
              <p><strong>Contact:</strong> +639123456789 | maria@gmail.com</p>
              <img src="../uploads/sample1.jpg" alt="Request Image" style="max-width: 100%; border-radius: 10px; margin-top: 10px;">
            </div>
          </div>

          <!-- Helped Request 2 -->
          <div class="request-card">
            <div class="request-title">Food Donation Campaign</div>
            <div class="request-meta">
              <span class="status-tag">Not Verified</span>
              <span class="requester">Requester: Juan Santos</span>
            </div>
            <div class="button-wrapper">
              <button class="submit-btn" onclick="toggleDetails('details-req2')">View Details</button>
            </div>
            <div class="request-details" id="details-req2" style="display: none;">
              <p><strong>Requester:</strong> Juan Santos</p>
              <p>Donec et magna nec nisl suscipit fringilla. Praesent quis arcu in lorem sodales eleifend.</p>
              <p><strong>Contact:</strong> +639987654321 | juan@gmail.com</p>
              <img src="../../uploads/sample2.jpg" alt="Request Image" style="max-width: 100%; border-radius: 10px; margin-top: 10px;">
            </div>
          </div>

        </div>
      </div>
    </main>
  </div>

  <script>
    function toggleDetails(id) {
      const section = document.getElementById(id);
      section.style.display = (section.style.display === 'none' || section.style.display === '') ? 'block' : 'none';
    }
  </script>
</body>
</html>
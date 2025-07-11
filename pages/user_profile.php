<?php 
// /pages/my_helped_requests.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Helped Requests - HelpingHand</title>
  <link rel="stylesheet" href="../css/style.css?v=2.3">
  <style>
    details {
      margin-top: 10px;
      background-color: #fff9f9;
      border: 1px solid #ffdede;
      border-radius: 10px;
      padding: 15px;
    }

    summary {
      cursor: pointer;
      font-weight: bold;
      color: #1e2f4b;
      margin-bottom: 10px;
      list-style: none;
    }

    .category-info {
      display: inline-block;
      background-color: #ffdcdc;
      color: #7c0000;
      font-weight: bold;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      font-size: 13px;
      text-align: center;
      line-height: 20px;
      margin-left: 6px;
    }

    .category-tooltip {
      font-size: 13px;
      background-color: #fff0f0;
      border: 1px solid #ffcfcf;
      padding: 8px;
      margin-top: 6px;
      border-radius: 6px;
      max-width: 300px;
      display: block;
    }
  </style>
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
          
          <!-- Request Card 1 -->
          <div class="request-card">
            <div class="request-title">Medical Assistance Needed</div>
            <div class="request-meta">
              <span class="status-tag fulfilled">Help Verified</span>
              <span class="requester">Requester: Maria Dela Cruz</span>
              <span class="category-info" title="Medical Assistance (Category 3)">?</span>
            </div>

            <details>
              <summary>View Details</summary>
              <p><strong>Requester:</strong> Maria Dela Cruz</p>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam nec erat ut felis sagittis aliquam.</p>
              <p><strong>Contact:</strong> +639123456789 | maria@gmail.com</p>
              <img src="../uploads/sample1.jpg" alt="Request Image" style="max-width: 100%; border-radius: 10px; margin-top: 10px;">
              <span class="category-tooltip">Category 3: Medical Assistance, Legal & Documents, Monetary Support</span>
            </details>
          </div>

          <!-- Request Card 2 -->
          <div class="request-card">
            <div class="request-title">Food Donation Campaign</div>
            <div class="request-meta">
              <span class="status-tag">Not Verified</span>
              <span class="requester">Requester: Juan Santos</span>
              <span class="category-info" title="Food & Essentials (Category 2)">?</span>
            </div>

            <details>
              <summary>View Details</summary>
              <p><strong>Requester:</strong> Juan Santos</p>
              <p>Donec et magna nec nisl suscipit fringilla. Praesent quis arcu in lorem sodales eleifend.</p>
              <p><strong>Contact:</strong> +639987654321 | juan@gmail.com</p>
              <img src="../uploads/sample2.jpg" alt="Request Image" style="max-width: 100%; border-radius: 10px; margin-top: 10px;">
              <span class="category-tooltip">Category 2: Food & Essentials, School Supplies, Goods Donations</span>
            </details>
          </div>

        </div>
      </div>
    </main>
  </div>
</body>
</html>
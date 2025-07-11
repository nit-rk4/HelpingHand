<?php
// /pages/my_helped_requests.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Helped Requests - HelpingHand</title>
  <link rel="stylesheet" href="../css/style.css?v=1.2">
</head>
<body>
  <header class="navbar">
    <div class="nav-left">
      <a href="/HelpingHand/"><img class="logo" src="../assets/logo.svg" alt="HelpingHand Logo"></a>
      <nav>
        <ul class="nav-links">
          <li><a href="/HelpingHand/">Home</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">About us</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="user-dashboard">
    <section class="main-content">
      <h2>My Helped Requests</h2>

      <!-- Helped Request Entry -->
      <div class="request-card">
        <div class="request-title"><a href="#" popovertarget="view-request-1">Grocery Aid</a></div>
        <div class="request-meta">
          <span>Requester: Juan Dela Cruz</span>
          <span>Help Verified: <span class="status-tag accepted">Verified</span></span>
        </div>
      </div>

      <div class="request-card">
        <div class="request-title"><a href="#" popovertarget="view-request-2">Medical Help</a></div>
        <div class="request-meta">
          <span>Requester: Maria Santos</span>
          <span>Help Verified: <span class="status-tag">Not Verified</span></span>
        </div>
      </div>
    </section>
  </main>

  <!-- Popover: Request Details + Confirm Helped -->
  <div id="view-request-1" class="form-popup" popover>
    <h4>Grocery Aid</h4>
    <p><strong>Requester:</strong> Juan Dela Cruz</p>
    <p><strong>Description:</strong> Requesting food assistance for 3 dependents during lockdown.</p>
    <p><strong>Contact:</strong> +63 912 345 6789 | juandelacruz@gmail.com</p>
    <div class="button-wrapper">
      <button class="button">Confirm You Helped</button>
      <button class="button">Close</button>
    </div>
  </div>

  <div id="view-request-2" class="form-popup" popover>
    <h4>Medical Help</h4>
    <p><strong>Requester:</strong> Maria Santos</p>
    <p><strong>Description:</strong> Need help for prescription refill due to recent illness.</p>
    <p><strong>Contact:</strong> +63 998 765 4321 | mariasantos@gmail.com</p>
    <div class="button-wrapper">
      <button class="button">Confirm Request Completed</button>
      <button class="button">Close</button>
    </div>
  </div>

</body>
</html>
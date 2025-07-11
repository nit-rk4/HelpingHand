<?php 
require_once "../../php/config.php";
require_once "../../php/help_utils.php";
require_once "../../php/maintenance.php";
runMaintenance($conn);

session_start();
$userID = $_SESSION['user'] ?? null;

if (!$userID){
  header("Location: ../../index.php");
  exit;
}

$request = getHelpedRequests($conn, $userID);

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
  <?php include ("../navbar.php"); ?>

  <div class="container">
    <aside class="sidebar">
      <ul>
        <li><a href="submit_request.php">Submit a Request</a></li>
        <li class="active"><a href="user_requests.php">My Requests</a></li>
        <li><a href="my_helped_requests.php">Requests I Helped On</a></li>
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
<!-- 
          <?php //foreach ($requests as $index => $req): ?>
            <div class="request-card">
              <div class="request-meta">
                <?php //if ($req['is_verified']): ?>
                  <span class="status-tag fulfilled">Help Verified</span>
                <?php //else: ?>
                  <span class="status-tag">Not Verified</span>
                <?php //endif; ?>
                 //anong styles gagamitin q huhu
              </div>
            </div> -->

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
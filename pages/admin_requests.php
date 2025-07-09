<?php
  require "../php/config.php";
  require "../php/request_utils.php";
  require_once "../php/maintenance.php";
  runMaintenance($conn);
  $status = $_GET['status'] ?? 'pending';
  $tierFilter = $_GET['tier'] ?? 'all';

  $requests = getRequestsByStatus($conn, $status, $tierFilter);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>HelpingHand Admin - User Requests</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;500;700&display=swap" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    .tab.active {
      background-color: #ffb2b2;
    }

    .request-row a {
      text-decoration: none;
      color: inherit;
    }

    .filter-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-bottom: 15px;
    }

    .tabs {
      display: flex;
      gap: 10px;
    }

    .tier-dropdown-filter {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .tier-dropdown-filter label {
      font-weight: 500;
    }

    .tier-dropdown-filter select {
      padding: 5px 10px;
      border-radius: 5px;
      font-family: inherit;
      font-size: 14px;
      max-width: 140px;
    }
    </style>
</head>
<body>

  <!-- Navbar -->
  <?php include("navbar.php"); ?>

  <!-- Page Layout -->
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <ul>
        <li class="active"><a href="admin_requests.php">User Requests</a></li>
        <li><a href="interviews.php">Interviews</a></li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <h1>User Requests</h1>

      <!-- Tabs -->
      <div class="filter-bar">
        <div class="tabs">
          <button class="tab <?= $status === 'pending' ? 'active' : '' ?>" onclick="goToStatus('pending')">Pending</button>
          <button class="tab <?= $status === 'approved' ? 'active' : '' ?>" onclick="goToStatus('approved')">Approved</button>
          <button class="tab <?= $status === 'rejected' ? 'active' : '' ?>" onclick="goToStatus('rejected')">Rejected</button>
        </div>

        <div class="tier-dropdown-filter">
          <label for="tierSelect">Filter by Tier:</label>
          <select id="tierSelect" onchange="onTierChange()">
            <option value="all">All Tiers</option>
            <option value="1">Tier 1</option>
            <option value="2">Tier 2</option>
            <option value="3">Tier 3</option>
          </select>
        </div>
      </div>

      <!-- Table Header -->
      <div class="request-row header">
        <span class="Requester">Requester</span>
        <span class="title">Title</span>
        <span class="desc">Description</span>
        <span class="desc">Category</span>
        <span class="desc">Visible</span>
      </div>

      <?php
        // Load requests of all 3 statuses
        foreach ($requests as $req) {
          $visibleMark = $req['visible_since'] ? "Yes" : "No";
          echo "<a href='request-details.php?id={$req['id']}' class='request-row' data-status='{$req['status']}' data-tier='{$req['tier']}'>";
          echo "<span class='user'>" . htmlspecialchars($req['requester_name']) . "</span>";
          echo "<span class='title'>" . htmlspecialchars($req['title']) . "</span>";
          echo "<span class='desc'>" . htmlspecialchars($req['description']) . "</span>";
          echo "<span class='desc'>" . htmlspecialchars($req['category']) . "</span>";
          echo "<span class='desc'>{$visibleMark}</span>";
          echo "</a>";
        }
      ?>
    </main>
  </div>

  <!-- Script to filter user requests by status -->
  <script>
      let currentStatus = "pending";
      let currentTier = "all";

      function onTierChange() {
        const tier = document.getElementById("tierSelect").value;
        const status = new URLSearchParams(window.location.search).get('status') || 'pending';
        window.location.href = `admin_requests.php?status=${status}&tier=${tier}`;
      }

      function goToStatus(status) {
        const tier = document.getElementById("tierSelect").value;
        window.location.href = `admin_requests.php?status=${status}&tier=${tier}`;
      }

      window.addEventListener("DOMContentLoaded", () => {
        const tierSelect = document.getElementById("tierSelect");
        tierSelect.value = "<?= htmlspecialchars($tierFilter) ?>";
      });

    </script>

</body>
</html>

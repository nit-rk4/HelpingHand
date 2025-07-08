<?php
  require "../php/config.php";
  require "../php/request_utils.php";

  expireRequests($conn);
  hideTier1Requests($conn);
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

    .request-row[data-status] {
      display: none;
    }

    .request-row a {
      text-decoration: none;
      color: inherit;
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
      <div class="tabs-filter-container">
        <div class="tabs">
          <button class="tab active" onclick="filterRequests('pending', this)">Pending Requests</button>
          <button class="tab" onclick="filterRequests('approved', this)">Approved Requests</button>
          <button class="tab" onclick="filterRequests('rejected', this)">Rejected Requests</button>
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
        $statuses = ['pending', 'approved', 'rejected'];

        foreach ($statuses as $status) {
            $requests = getRequestsByStatus($conn, $status);
            foreach ($requests as $req) {
                $details = getRequestDetails($conn, $req['id']);
                $visibleMark = $req['visible_since'] ? "Yes" : "No";
                echo "<a href='request-details.php?id={$req['id']}' class='request-row' data-status='{$req['status']}'>";
                echo "<span class='user'>" . htmlspecialchars($details['requester_name']) . "</span>";
                echo "<span class='title'>" . htmlspecialchars($req['title']) . "</span>";
                echo "<span class='desc'>" . htmlspecialchars($req['description']) . "</span>";
                echo "<span class='desc'>" . htmlspecialchars($req['category']) . "</span>";
                echo "<span class='desc'>{$visibleMark}</span>";
                echo "</a>";
            }
        }
      ?>
    </main>
  </div>

  <!-- Script to filter user requests by status -->
  <script>
    function filterRequests(status, clickedBtn) {
      document.querySelectorAll(".tab").forEach(btn => btn.classList.remove("active"));
      clickedBtn.classList.add("active");

      document.querySelectorAll(".request-row[data-status]").forEach(row => {
        row.style.display = row.getAttribute("data-status") === status ? "flex" : "none";
      });
    }

    window.addEventListener("DOMContentLoaded", () => {
      filterRequests("pending", document.querySelector(".tab.active"));
    });
  </script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>HelpingHand Admin - User Requests</title>
  <link rel="stylesheet" href="styles.css" />
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
      <input type="text" placeholder="Search..." />
    </div>
  </header>

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
          <button class="tab" onclick="filterRequests('accepted', this)">Accepted Requests</button>
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

      <!-- PENDING REQUESTS -->
      <a href="request-details.php?status=pending" class="request-row" data-status="pending">
        <span class="user">Juan Dela Cruz</span>
        <span class="title">Need Help with Groceries</span>
        <span class="desc">Lorem ipsum dolor sit amet...</span>
        <span class="desc">Tier 1</span>
        <span class="desc">Yes</span>
      </a>

      <a href="request-details.php?status=pending" class="request-row" data-status="pending">
        <span class="user">Maria Santos</span>
        <span class="title">Medical Assistance</span>
        <span class="desc">Requesting support for medication.</span>
        <span class="desc">Tier 2</span>
        <span class="desc">Yes</span>
      </a>

      <!-- ACCEPTED REQUESTS -->
      <a href="request-details.php?status=accepted" class="request-row" data-status="accepted">
        <span class="user">Ana Lopez</span>
        <span class="title">School Support</span>
        <span class="desc">Approved for financial assistance. <span class="status accepted">Accepted</span></span>
        <span class="desc">Tier 2</span>
        <span class="desc">Yes</span>
      </a>

      <!-- REJECTED REQUESTS -->
      <a href="request-details.php?status=rejected" class="request-row" data-status="rejected">
        <span class="user">Mark Santos</span>
        <span class="title">Uniform Request</span>
        <span class="desc">Unable to process due to incomplete documents. <span class="status rejected">Rejected</span></span>
        <span class="desc">Tier 1</span>
        <span class="desc">No</span>
      </a>
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

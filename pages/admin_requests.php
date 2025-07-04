<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>HelpingHand Admin - User Requests</title>
  <link rel="stylesheet" href="../css/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
  
  <header class="navbar" id="nav-color">
    <div class="nav-left">
      <img class="logo" src="../assets/logo.svg" alt="HelpingHand Logo" />

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

  <!-- Page Content -->
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <ul>
        <li class="active">User Requests</li>
        <li>Manage Help Board</li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <h1>User Requests</h1>

      <!-- Tabs + Filter -->
      <div class="tabs-filter-container">
        <div class="tabs">
          <button class="tab active">Pending Requests</button>
          <button class="tab">Accepted Requests</button>
          <button class="tab">Rejected Requests</button>
        </div>

        <div class="filter-bar">
          <label for="tierFilter">Filter by Tier:</label>
          <select id="tierFilter">
            <option value="all">All Tiers</option>
            <option value="tier1">Tier 1</option>
            <option value="tier2">Tier 2</option>
            <option value="tier3">Tier 3</option>
          </select>
        </div>
      </div>

      <!-- Requests  -->
      <div class="requests-table">
        <div class="request-row header">
          <input type="checkbox" />
          <span class="user">User</span>
          <span class="title">Request Title</span>
          <span class="desc">Description</span>
        </div>

        <div class="request-row" data-tier="tier1">
          <input type="checkbox" />
          <span class="user">Juan Dela Cruz</span>
          <span class="title">Need Help with Groceries</span>
          <span class="desc">Lorem ipsum dolor sit amet...</span>
        </div>

        <div class="request-row" data-tier="tier2">
          <input type="checkbox" />
          <span class="user">Maria Santos</span>
          <span class="title">Medical Assistance</span>
          <span class="desc">Requesting support for medication.</span>
        </div>
      </div>
    </main>
  </div>

</body>
</html>

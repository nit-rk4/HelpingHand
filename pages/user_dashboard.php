<?php
// /pages/user_dashboard.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard - HelpingHand</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <header class="navbar">
    <div class="nav-left">
      <img class="logo" src="../assets/logo.svg" alt="HelpingHand Logo">
      <nav>
        <ul class="nav-links">
          <li><a href="#">Home</a></li>
          <li><a href="#">Help Board</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <div class="container">
    <aside class="sidebar">
      <ul>
        <li class="active">Dashboard</li>
        <li><a href="user_profile.php">Your Requests</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <h1>User Dashboard</h1>

      <!-- Request Form -->
      <form action="" method="post" enctype="multipart/form-data" class="details-wrapper">
        <h2>Submit a New Help Request</h2>

        <label class="details-label">Title</label>
        <input type="text" name="title" required />

        <label class="details-label">Description</label>
        <textarea name="description" rows="5" required></textarea>

        <label class="details-label">Category</label>
        <select name="category" required>
          <optgroup label="Tier 1">
            <option>Home/Tech Help</option>
            <option>Escort/Babysitting</option>
            <option>Volunteer Support</option>
            <option>Errand</option>
            <option>Lost Item</option>
            <option>Tutoring/Academic Help</option>
          </optgroup>
          <optgroup label="Tier 2">
            <option>Food & Essentials</option>
            <option>School Supplies</option>
            <option>Goods Donations</option>
          </optgroup>
          <optgroup label="Tier 3">
            <option>Medical Assistance</option>
            <option>Legal & Documents</option>
            <option>Monetary Assistance</option>
          </optgroup>
        </select>

        <label class="details-label">Deadline</label>
        <input type="date" name="deadline" required />

        <label class="details-label">Attachment (optional)</label>
        <input type="file" name="attachment" accept="image/*,.pdf">

        <div class="details-buttons">
          <button type="submit" class="btn-approve">Submit Request</button>
        </div>
      </form>

      <!-- Confirmation Message -->
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<p style='margin-top: 20px; color: green;'>✅ Request submitted (demo only).</p>";
      }
      ?>

      <!-- Request Status Section -->
      <h2 style="margin-top: 60px;">Your Submitted Requests</h2>

      <div class="request-row header">
        <span class="title">Title</span>
        <span class="desc">Description</span>
        <span>Category</span>
        <span>Status</span>
      </div>

      <!-- Example static data -->
      <div class="request-row">
        <span class="title">Medical Help Needed</span>
        <span class="desc">Need money for surgery meds...</span>
        <span>Medical Assistance</span>
        <span style="color: green;">Fulfilled</span>
      </div>

      <div class="request-row">
        <span class="title">Groceries for Lola</span>
        <span class="desc">Need rice, canned goods and milk</span>
        <span>Food & Essentials</span>
        <span style="color: orange;">Pending</span>
      </div>
    </main>
  </div>
</body>
</html>
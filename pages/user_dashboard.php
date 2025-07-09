<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>HelpingHand - User Dashboard</title>
  <link rel="stylesheet" href="../css/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
  <header class="navbar">
    <div class="nav-left">
      <img class="logo" src="../assets/logo.svg" alt="HelpingHand Logo" />
      <nav>
        <ul class="nav-links">
          <li><a href="#">Home</a></li>
          <li><a href="#">Help Board</a></li>
          <li><a href="#">About</a></li>
        </ul>
      </nav>
    </div>
    <div class="searchbar">
      <input type="text" placeholder="Search..." />
    </div>
  </header>

  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <ul>
        <li class="active">Dashboard</li>
        <li><a href="user_profile.php">Your Requests</a></li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <h1>Submit a New Request</h1>

      <form action="../php/submit_request.php" method="POST" enctype="multipart/form-data" class="details-wrapper">
        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" id="title" name="title" required />
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea id="description" name="description" rows="5" required></textarea>
        </div>

        <div class="form-group">
          <label for="category">Category</label>
          <select id="category" name="category" required>
            <option value="">-- Select Category --</option>
            <optgroup label="Tier 1">
              <option value="Home/Tech Help">Home/Tech Help</option>
              <option value="Escort/Babysitting">Escort/Babysitting</option>
              <option value="Volunteer Support">Volunteer Support</option>
              <option value="Errand">Errand</option>
              <option value="Lost Item">Lost Item</option>
              <option value="Tutoring/Academic Help">Tutoring/Academic Help</option>
            </optgroup>
            <optgroup label="Tier 2">
              <option value="Food & Essentials">Food & Essentials</option>
              <option value="School Supplies">School Supplies</option>
              <option value="Goods Donations">Goods Donations</option>
            </optgroup>
            <optgroup label="Tier 3">
              <option value="Medical Assistance">Medical Assistance</option>
              <option value="Legal & Documents">Legal & Documents</option>
              <option value="Monetary Assistance">Monetary Assistance</option>
            </optgroup>
          </select>
        </div>

        <div class="form-group">
          <label for="attachment">Attachment (optional)</label>
          <input type="file" id="attachment" name="attachment" />
        </div>

        <div class="form-group">
          <label for="deadline">Deadline</label>
          <input type="date" id="deadline" name="deadline" required />
        </div>

        <div class="form-group">
          <button type="submit">Submit Request</button>
        </div>
      </form>
    </main>
  </div>
</body>
</html>
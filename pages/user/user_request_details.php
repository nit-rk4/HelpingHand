<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Request Details - HelpingHand</title>
  <link rel="stylesheet" href="../css/style.css?v=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

  <?php include("../navbar.php"); ?>

  <main class="details-wrapper">
    <a class="back-link" href="user_profile.php">← Back to My Requests</a>

    <h1>Food Supplies Needed</h1>

    <div class="details-section">
      <h3>Description</h3>
      <p>Requesting rice, canned goods for family of 5.</p>

      <h3>Category</h3>
      <p>Basic Needs</p>

      <h3>Status</h3>
      <p class="status-tag">Pending</p>

      <h3>Deadline</h3>
      <p>July 20, 2025</p>

      <!-- Optional Attachment -->
      <img src="../uploads/sample.jpg" class="request-image" alt="Attached Proof">
    </div>

    <!-- ONGOING -->
    <div class="details-section ongoing-section">
      <h3>Mark as Fulfilled</h3>
      <form>
        <p>Select helpers who assisted:</p>
        <label><input type="checkbox" name="helpers[]" value="User A"> User A</label><br>
        <label><input type="checkbox" name="helpers[]" value="User B"> User B</label><br>
        <button type="button" class="btn-confirm">Mark as Fulfilled</button>
      </form>
    </div>

    <!-- FULFILLED -->
    <div class="details-section fulfilled-section">
      <h3>Request Fulfilled By</h3>
      <ul>
        <li>User A</li>
        <li>User B</li>
      </ul>
      <button class="btn-neutral">View Help Proof</button>
    </div>

    <!-- EXPIRED -->
    <div class="details-section expired-section">
      <h3>This request has expired.</h3>
      <button onclick="document.getElementById('renew-popup').style.display='flex'" class="btn-confirm">Renew</button>
    </div>

    <!-- RENEW POP-UP -->
    <div id="renew-popup" class="popup">
      <div class="popup-content">
        <h3>Renew Request</h3>
        <form>
          <label>Why do you want to renew?</label>
          <textarea rows="4" placeholder="Explain your reason..."></textarea>

          <label>Upload new proof (optional):</label>
          <input type="file">

          <div class="popup-buttons">
            <button type="submit" class="btn-confirm">Submit Renewal</button>
            <button type="button" class="btn-reject" onclick="document.getElementById('renew-popup').style.display='none'">Cancel</button>
          </div>
        </form>
      </div>
    </div>

    <!-- PENDING/REJECTED NOTE -->
    <div class="details-section readonly-note">
      <p>No further action available for this request.</p>
    </div>
  </main>

</body>
</html>
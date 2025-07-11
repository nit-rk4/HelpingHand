<?php
// /pages/user_profile.php

// Read status filter from URL (?status=...)
$statusFilter = isset($_GET['status']) ? strtolower($_GET['status']) : 'all';

// Example data (replace with real DB data later)
$requests = [
  ['title'=>'Food Supplies Needed','desc'=>'Requesting rice, canned goods for family of 5.','status'=>'pending','deadline'=>'2025-07-20'],
  ['title'=>'Medical Assistance','desc'=>'Help needed for prescription refill.','status'=>'fulfilled','deadline'=>'2025-07-10'],
  ['title'=>'Home Repair Help','desc'=>'Assistance repairing leaking roof.','status'=>'pending','deadline'=>'2025-07-25'],
  ['title'=>'Scholarship Request','desc'=>'Request rejected by admin.','status'=>'rejected','deadline'=>'2025-06-01'],
  ['title'=>'Ongoing Aid','desc'=>'Currently being processed.','status'=>'ongoing','deadline'=>'2025-07-30'],
  ['title'=>'Old Request','desc'=>'Expired request.','status'=>'expired','deadline'=>'2025-06-15'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile - HelpingHand</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<?php include "../navbar.php"?>

<div class="container">
  <aside class="sidebar">
    <ul>
      <li><a href="user_dashboard.php">Dashboard</a></li>
      <li class="active"><a href="user_profile.php">Profile</a></li>
      <li><a href="my_helped_requests.php">My Helped Requests</a></li>
    </ul>
  </aside>

  <main class="main-content">
    <h1>My Submitted Requests</h1>
    <div class="tabs-filter-container">
      <div class="tabs">
        <a href="?status=all" class="tab <?= $statusFilter=='all'?'active':'' ?>">All</a>
        <a href="?status=pending" class="tab <?= $statusFilter=='pending'?'active':'' ?>">Pending</a>
        <a href="?status=ongoing" class="tab <?= $statusFilter=='ongoing'?'active':'' ?>">Ongoing</a>
        <a href="?status=rejected" class="tab <?= $statusFilter=='rejected'?'active':'' ?>">Rejected</a>
        <a href="?status=fulfilled" class="tab <?= $statusFilter=='fulfilled'?'active':'' ?>">Fulfilled</a>
        <a href="?status=expired" class="tab <?= $statusFilter=='expired'?'active':'' ?>">Expired</a>
      </div>
    </div>

    <div class="requests-table">
      <div class="request-row header">
        <span class="title">Title</span>
        <span class="desc">Description</span>
        <span class="status">Status</span>
        <span class="deadline">Deadline</span>
      </div>
      <?php
      foreach($requests as $req){
        if($statusFilter=='all' || $req['status']==$statusFilter){
          echo '<div class="request-row">';
          echo '<span class="title">'.htmlspecialchars($req['title']).'</span>';
          echo '<span class="desc">'.htmlspecialchars($req['desc']).'</span>';
          echo '<span class="status">'.ucfirst($req['status']).'</span>';
          echo '<span class="deadline">'.htmlspecialchars($req['deadline']).'</span>';
          echo '</div>';
        }
      }
      ?>

      <div class="details-wrapper">
      <p><span class="details-label">Total Requests Submitted:</span> <?= count($requests) ?></p>
      <p><span class="details-label">Requests Fulfilled:</span> <?= count(array_filter($requests,fn($r)=>$r['status']=='fulfilled')) ?></p>
      <p><span class="details-label">Pending Requests:</span> <?= count(array_filter($requests,fn($r)=>$r['status']=='pending')) ?></p>
    </div>
    
    </div>
  </main>
</div>
</body>
</html>
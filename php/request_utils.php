<?php

/** 
 * ------------------------------------------
 *            FETCHING REQUESTS
 *  ------------------------------------------
*/

//Get requests from database based on status and optional tier
function getRequestsByStatus($conn, $status, $tier = null){
    if ($tier === null || $tier === 'all') {
        $sql = "SELECT 
                    requests.id, requests.title, requests.description,
                    requests.status, requests.tier, requests.category,
                    requests.visible_since, users.name AS requester_name
                FROM requests 
                JOIN users ON requests.user_id = users.id
                WHERE requests.status = ?
                ORDER BY created_at DESC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $status);
    } else {
        $sql = "SELECT 
                    requests.id, requests.title, requests.description,
                    requests.status, requests.tier, requests.category,
                    requests.visible_since, users.name AS requester_name
                FROM requests 
                JOIN users ON requests.user_id = users.id
                WHERE requests.status = ? AND requests.tier = ?
                ORDER BY created_at DESC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $status, $tier);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $requests = [];
    while ($row = mysqli_fetch_assoc($result)){
        $requests[] = $row;
    }

    return $requests;
}

//Get requests visible on the help board
function getVisibleRequests($conn){
    $sql = "SELECT 
                r.id, r.title, r.description, r.category, r.deadline, r.attachment_path,
                u.name AS requester_name    
            FROM requests r
            JOIN users u ON r.user_id = u.id
            WHERE r.visible_since IS NOT NULL
                AND (r.deadline >= CURDATE()) 
            ORDER BY r.visible_since DESC";
    $result = mysqli_query($conn, $sql);
    
    $requests = [];
    while ($row = mysqli_fetch_assoc($result)){
        $requests[] = $row;
    }

    return $requests;
}

//Get requests of a specific user by status
function getUserRequests($conn, $userID) {
    $sql = "SELECT * FROM requests WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $userID);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $requests = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $requests[] = $row;
    }

    return $requests;
}

//Get a specific request (for backend logic)
function getRequest($conn, $requestID){
    $sql = "SELECT * FROM requests WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $requestID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}

//Get full details of a request (for display purposes)
function getRequestDetails($conn, $requestID){
    $sql = "SELECT r.*, 
                u.name AS requester_name,
                u.email AS requester_email,
                u.contact_number AS requester_contact
            FROM requests r 
            JOIN users u on r.user_id = u.id
            WHERE r.id = ?"; 

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $requestID);
    mysqli_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)){
        return $row;
    } else {
        return null; 
    }
}

function getRequestDetailsForUser($conn, $requestID, $userID){
    $sql = "SELECT * FROM requests WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $requestID, $userID);
    mysqli_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}

/** 
 * ------------------------------------------
 *               ADMIN ACTIONS
 *  ------------------------------------------
*/


//Updates the status of request to 'approved'
function approveRequest($conn, $requestID){
    $request = getRequest($conn, $requestID);
    if (!$request) return false; // Request not found

    $tier = $request['tier'];
    $interviewStatus = $request['interview_status'];
    $visibleSince = $request['visible_since'];

    // Block approval if Tier 3 and interview not done
    if ($tier === '3' && $interviewStatus !== 'done') {
        return false;
    }

    // Log warning if Tier 2 marked for interview but not done
    if ($tier === '2' && in_array($interviewStatus, ['pending', 'scheduled'])) {
        error_log("[!] Approving Tier 2 request with incomplete interview.");
    }

    // Update status and visibility
    $update_sql = "UPDATE requests SET status = 'approved', visible_since = NOW() WHERE id = ?";


    $stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt, 'i', $requestID);
    return mysqli_stmt_execute($stmt);
}

function markForInterview   ($conn, $requestID){
    $request = getRequest($conn, $requestID);
    if (!$request) return false;

    // Update request interview_status
    $update_sql = "UPDATE requests SET interview_status = 'pending' WHERE id = ?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "i", $requestID);
    mysqli_stmt_execute($update_stmt);

    // Insert new interview record
    $insert_sql = "INSERT INTO interviews (request_id, user_id, status) VALUES (?, ?, 'pending')";
    $insert_stmt = mysqli_prepare($conn, $insert_sql);
    mysqli_stmt_bind_param($insert_stmt, "ii", $requestID, $request['user_id']);
    return mysqli_stmt_execute($insert_stmt);
}

//Rejects a request and sets their visibility on the Help Board to 'hidden'
function rejectRequest ($conn, $requestID){
    $request = getRequest($conn, $requestID);
    if (!$request) return false;

    $sql = "UPDATE requests SET status = 'rejected', visible_since = NULL WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $requestID);
    return mysqli_stmt_execute($stmt);
}

/** 
 * ------------------------------------------
 *              USER ACTIONS
 *  ------------------------------------------
*/

function submitRequest($conn, $userId, $title, $description, $category, $deadline, $attachment_path = null)
{
    // Assign tier based on category
    $tier1 = [
        "Home/Tech Help",
        "Escort/Babysitting",
        "Volunteer Support",
        "Errand",
        "Lost Item",
        "Tutoring/Academic Help"
    ];
    $tier2 = [
        "Food & Essentials",
        "School Supplies",
        "Goods Donations"
    ];
    $tier3 = [
        "Medical Assistance",
        "Legal & Documents",
        "Monetary Assistance"
    ];

    if (in_array($category, $tier1)) {
        $tier = "1";
        $visible_since = date('Y-m-d H:i:s'); // visible immediately

    } elseif (in_array($category, $tier2)) {
        $tier = "2";
        $visible_since = null; // needs admin approval

    } elseif (in_array($category, $tier3)) {
        $tier = "3";
        $visible_since = null; // needs admin approval & interview
    } else {
        // fallback
        $tier = "1";
        $visible_since = date('Y-m-d H:i:s');
        $interview_status = "none";
        $status = "pending";
    }

    $sql = "INSERT INTO requests (user_id, title, description, category, tier, attachment_path, deadline, visible_since, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt,"isssssss", $userId, $title, $description, $category, $tier, $attachment_path, $deadline, $visible_since);
    
    return mysqli_stmt_execute($stmt);
}
function renewRequest($conn, $originalID, $userNote, $newFile = null) {
    $sql = "SELECT * FROM requests WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $originalID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $original = mysqli_fetch_assoc($result);

    if(!$original) return false;

    $newDescription = "[RENEWAL NOTE]\n". $userNote. "\n\n[ORIGINAL]\n" . $original['description'];

    $sql = "INSERT INTO requests (user_id, title, description, category, tier, attachment_path, deadline, created_at, parent_request_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issssssi",
        $original['user_id'],
        $original['title'],
        $newDescription,
        $original['category'],
        $original['tier'],
        $newFile,
        $original['deadline'],
        $originalID
    );

    return mysqli_stmt_execute($stmt);
}

function fulfillRequest($conn, $requestID) {
    $sql = "UPDATE requests
            SET status = 'fulfilled', visible_since = NULL
            WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $requestID);
    return mysqli_stmt_execute($stmt);
}



/** 
 * ------------------------------------------
 *            BACKGROUND FUNCTIONS
 *  ------------------------------------------
*/

//Expire requests that are past its deadline or its 7-day visibility
function expireRequests($conn){
    // Deadline-based expiration
    $sql_deadline = "UPDATE requests
             SET status = 'expired', visible_since = NULL, expiration_reason = 'deadline'
             WHERE (status = 'pending' OR status = 'approved')
             AND deadline < CURDATE()";
    mysqli_query($conn, $sql_deadline);

    // Visibility-based expiration (7-day help board expiry)
    $sql_visibility = "UPDATE requests
             SET status = 'expired', visible_since = NULL, expiration_reason = 'visibility'
             WHERE (status = 'pending' OR status = 'approved')
             AND visible_since IS NOT NULL
             AND TIMESTAMPDIFF(DAY, visible_since, NOW()) >= 7";
    mysqli_query($conn, $sql_visibility);

    return true;
}

//Hide tier 1 pending requests after 2 days
function hideTier1Requests($conn){
    $sql = "UPDATE requests
            SET visible_since = NULL
            WHERE tier = '1'
                AND status = 'pending'
                AND visible_since IS NOT NULL
                AND TIMESTAMPDIFF(DAY, created_at, NOW()) >= 2";
    return mysqli_query($conn, $sql);
}
 

?>
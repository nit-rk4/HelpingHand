<?php

/** 
 * ------------------------------------------
 *            FETCHING REQUESTS
 *  ------------------------------------------
*/

//Get requests from database based on status and optional tier
function getRequestsByStatus($conn, $status, $tier = null){
    //No tier filter
    if ($tier === null){
        $sql = "SELECT * FROM requests where status = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $status);
    } else { //Yes tier filter 
        $sql = "SELECT * FROM requests WHERE status = ? AND tier = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $status, $tier);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result ($stmt);

    $requests = []; //Creates an associative array of the requests.
    while ($row = mysqli_fetch_assoc($result)){
        $requests[] = $row;
    }

    return $requests;
}

//Get requests visible on the help board
function getVisibleRequests($conn){
    $sql = "SELECT * FROM requests WHERE visible_since IS NOT NULL";
    $result = mysqli_query($conn, $sql);
    
    $requests = [];
    while ($row = mysqli_fetch_assoc($result)){
        $requests[] = $row;
    }

    return $requests;
}

//Get requests of a specific user
function getUserRequests($conn, $userID){
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
    $sql = "SELECT r.*, u.name AS requester_name 
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

//Searches for a request by keyword
function searchRequestByTitle ($conn, $titleKeyword, $status = null, $tier = null){
    $titleKeyword = '%'.$titleKeyword.'%';

    $sql = "SELECT * FROM requests WHERE title LIKE ?";
    
    if ($status !== null){ //Adds additional statement if status is specified
        $sql .= " AND STATUS = ?";
    }

    if ($tier !== null){ //Adds additional statement if tier is specified
        $sql .= " AND tier = ?";
    }

    $stmt = mysqli_prepare($conn, $sql);

    if ($status !== null && $tier !== null) { //Bind parameters if both status and tier are present
        mysqli_stmt_bind_param($stmt, "ssi", $titleKeyword, $status, $tier);
    } elseif ($status !== null){ //Bind parameters if only status is present
        mysqli_stmt_bind_param($stmt, "ss", $titleKeyword, $status);
    } elseif ($tier !== null){ //Bind parameters if only tier is present
        mysqli_stmt_bind_param($stmt, "si", $titleKeyword, $tier);
    } else { // Bind parameters if neither status nor tier is present
        mysqli_stmt_bind_param($stmt,"s",$titleKeyword);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $requests = [];
    while ($row =  mysqli_fetch_assoc($result)){
        $requests[] = $row;
    }

    //Returns requests that satisfy the title keyword
    return $requests; 
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
    if (empty($visibleSince)) {
        $update_sql = "UPDATE requests SET status = 'approved', visible_since = NOW() WHERE id = ?";
    } else {
        $update_sql = "UPDATE requests SET status = 'approved' WHERE id = ?";
    }

    $stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt, 'i', $requestID);
    return mysqli_stmt_execute($stmt);
}

function markForInterview   ($conn, $requestID, $userID){
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
    mysqli_stmt_bind_param($insert_stmt, "ii", $requestID, $userID);
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
 *            BACKGROUND FUNCTIONS
 *  ------------------------------------------
*/

//Expire requests that are past its deadline or its 7-day visibility
function expireRequests($conn){
    $sql = "UPDATE requests
            SET status = 'expired', visible_since = NULL
            WHERE (status = 'pending' OR status = 'approved')
            AND (
                deadline < CURDATE()
                OR (visible_since IS NOT NULL AND TIMESTAMPDIFF(DAY, visible_since, NOW()) >= 7)
            )";

    $stmt = mysqli_prepare($conn, $sql);
    return mysqli_stmt_execute($stmt);
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
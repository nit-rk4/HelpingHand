<?php

function getInterviews($conn, $completed){
    $sql = "SELECT i.*, u.name AS requester_name, r.title AS request_title
            FROM interviews i
            JOIN users u ON i.user_id = u.id
            JOIN requests r ON i.request_id = r.id
            WHERE i.completed = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $completed);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $interviews = [];
    while ($row = mysqli_fetch_assoc($result)){
        $interviews[] = $row;
    }
    
    return $interviews;
}

function getInterviewDetails($conn, $interviewID){
    $sql = "SELECT
                i.*,
                u.name AS requester_name,
                a.name AS admin_name,
                r.title AS request_title,
                r.tier AS request_tier,
                r.description AS request_description
            FROM interviews i
            JOIN users u on i.user_id = u.id
            JOIN requests r on i.request_id = r.id
            LEFT JOIN admins a on i.conducted_by = a.id
            WHERE i.id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $interviewID);
    mysqli_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)){
        return $row;
    } else {
        return null; 
    }
}

//Searches for a request by keyword

function markForInterview   ($conn, $requestID, $userID){
    $update_sql = "UPDATE requests SET for_interview = 1 WHERE id = ?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt,"i",$requestID);
    mysqli_stmt_execute($update_stmt);

    $insert_sql = "INSERT INTO interviews (request_id, user_id) VALUES (?, ?)";
    $insert_stmt = mysqli_prepare($conn, $insert_sql);
    mysqli_stmt_bind_param($insert_stmt, "ii", $requestID, $userID);

    return mysqli_stmt_execute($insert_stmt);
}

function completeInterview($conn, $interviewID, $notes = null){
    $check_sql = "SELECT request_id, completed FROM interviews WHERE id = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, 'i', $interviewID);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);

    if(mysqli_num_rows($result) === 0){
        return "Interview not found.";
    }

    $interview = mysqli_fetch_assoc($result);

    if($interview['completed']){
        return "Interview already marked as completed";
    }

    $requestID = $interview['request_id'];

    $update_interview_sql = "UPDATE interviews SET completed = 1, notes = ? WHERE id = ?";
    $update_interview_stmt = mysqli_prepare($conn, $update_interview_sql);
    mysqli_stmt_bind_param($update_interview_stmt, "si", $notes, $interviewID);
    $success_interviews = mysqli_stmt_execute($update_interview_stmt);

    $update_requests_sql = "UPDATE requests set interview_completed = 1 WHERE id = ?";
    $update_requests_stmt = mysqli_prepare($conn, $update_requests_sql);
    mysqli_stmt_bind_param($update_interview_stmt, "i", $requestID);
    $success_requests = mysqli_stmt_execute($update_interview_stmt);

    return $success_interviews && $success_requests;
}

function cancelInterview($conn, $interviewId) {
    $check_sql = "SELECT completed FROM interviews WHERE id = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "i", $interviewId);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($result) === 0) {
        return "[!] Interview not found.";
    }

    $interview = mysqli_fetch_assoc($result);
    if ($interview['completed']) {
        return "[X] Cannot cancel a completed interview.";
    }

    $delete_sql = "DELETE FROM interviews WHERE id = ?";
    $delete_stmt = mysqli_prepare($conn, $delete_sql);
    mysqli_stmt_bind_param($delete_stmt, "i", $interviewId);
    return mysqli_stmt_execute($delete_stmt);
}

function rescheduleInterview($conn, $interviewId, $newDatetime) {
    if (!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $newDatetime)) {
        return "[!] Invalid date format. Use YYYY-MM-DD HH:MM:SS";
    }

    $check_sql = "SELECT completed FROM interviews WHERE id = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "i", $interviewId);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($result) === 0) {
        return "[!] Interview not found.";
    }

    $interview = mysqli_fetch_assoc($result);
    if ($interview['completed']) {
        return "[X] Cannot reschedule a completed interview.";
    }

    $update_sql = "UPDATE interviews SET scheduled_at = ? WHERE id = ?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "si", $newDatetime, $interviewId);
    return mysqli_stmt_execute($update_stmt);
}

?>
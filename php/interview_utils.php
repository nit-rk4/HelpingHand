<?php

function getInterviewsByStatus($conn, $status)
{
    $statusMap = [
        'pending' => "i.status = 'pending'",
        'scheduled' => "i.status = 'scheduled'",
        'done' => "i.status = 'done'"
    ];
    if (!isset($statusMap[$status])) return [];

    $sql = "SELECT i.*, u.name AS requester_name, r.title AS request_title,
                   a.name AS interviewer
            FROM interviews i
            JOIN users u ON i.user_id = u.id
            JOIN requests r ON i.request_id = r.id
            LEFT JOIN admins a ON i.conducted_by = a.id
            WHERE {$statusMap[$status]}
            ORDER BY i.id DESC";

    $result = mysqli_query($conn, $sql);
    $interviews = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $interviews[] = $row;
        }
    }
    return $interviews;
}

function getAllAdmins($conn)
{
    $admins = [];
    $sql = "SELECT id, name FROM admins";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $admins[] = $row;
        }
    }
    return $admins;
}

function getInterviewDetails($conn, $interviewID)
{
    $sql = "SELECT i.*, u.name as applicant, u.contact_number, 
                   r.description as request_details, 
                   a.name as interviewer_name 
            FROM interviews i 
            JOIN users u ON i.user_id = u.id 
            JOIN requests r ON i.request_id = r.id 
            LEFT JOIN admins a ON i.conducted_by = a.id 
            WHERE i.id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $interviewID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $details = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $details;
}

function scheduleInterview($conn, $interviewID, $date, $time, $adminID)
{
    $sql = "UPDATE interviews 
            SET date = ?, time = ?, conducted_by = ?, status = 'scheduled' 
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssii', $date, $time, $adminID, $interviewID);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

function completeInterview($conn, $interviewID, $notes)
{
    $sql = "UPDATE interviews SET notes = ?, status = 'done' WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'si', $notes, $interviewID);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

function cancelInterview($conn, $interviewID)
{
    $sql = "DELETE FROM interviews WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $interviewID);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}
?>

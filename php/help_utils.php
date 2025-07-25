<?php
/** 
 * -------------------------------------------
 *                 HELPER
 *  ------------------------------------------
*/
function hasHelped($conn, $requestID, $userID){
    $sql = "SELECT 1 FROM helpers WHERE request_id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $requestID, $userID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    //Returns true if both request_id and user_id has a record in the table
    return mysqli_stmt_num_rows($stmt) > 0;
}

function submitHelp($conn, $requestID, $userID, $proof_text = null, $proof_file = null){
    if (hasHelped($conn, $requestID, $userID)) {
        return false; // User already submitted help for this request
    }

    $sql = "INSERT INTO helpers (request_id, user_id, proof_text, proof_file)
            VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'iiss', $requestID, $userID, $proof_text, $proof_file);
    return mysqli_stmt_execute($stmt);
}

function getVerifiedHelpCount($conn, $userID){
    $sql = "SELECT COUNT(*) FROM helpers WHERE user_id = ? AND is_verified = 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);

    mysqli_stmt_fetch($stmt);
    return $count;
}

function removeHelp($conn, $requestID, $userID){
    $sql = "DELETE FROM helpers WHERE request_id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $requestID, $userID);
    return mysqli_stmt_execute($stmt);
}

function getHelpedRequests($conn, $userID){
    $sql = "SELECT 
                r.id, r.title, r.description, r.status, r.category,
                h.is_verified, h.proof_text, h.proof_file,
                u.name AS requester_name, u.contact_number AS requester_contact, u.email AS requester_email
            FROM helpers h
            JOIN requests r ON h.request_id = r.id
            JOIN users u ON r.user_id = u.id
            WHERE h.user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $requests = [];
    while($row = mysqli_fetch_assoc($result)){
        $requests[] = $row;
    }

    return $requests;
}

function categorizeHelp($category) {
    switch ($category) {
        case 'Food & Essentials':
        case 'Goods Donations':
        case 'School Supplies':
            return 'Goods & Essentials';

        case 'Escort/Babysitting':
        case 'Volunteer Support':
        case 'Errand':
        case 'Lost Item':
            return 'Community Help';

        case 'Tutoring/Academic Help':
        case 'Home & Tech Help':
            return 'Knowledge Sharing';

        case 'Medical Assistance':
        case 'Legal & Documents':
            return 'Medical & Legal';

        case 'Monetary Assistance':
            return 'Financial Aid';

        default:
            return 'Others';
    }
}

/** 
 * -------------------------------------------
 *               REQUESTER
 *  ------------------------------------------
*/

function verifyHelper($conn, $requestID, $userID){
    $sql = "UPDATE helpers SET is_verified = 1 WHERE request_id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $requestID, $userID);
    return mysqli_stmt_execute($stmt);
}

function getHelpers($conn, $requestID){
    $sql = "SELECT h.user_id, u.name, h.proof_text, h.proof_file, h.is_verified
            FROM helpers h
            JOIN users u ON h.user_id = u.id
            WHERE h.request_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $requestID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $helpers = [];
    while($row = mysqli_fetch_assoc($result)){
        $helpers[] = $row;
    }

    return $helpers;
}

function getVerifiedHelpers($conn, $requestID){
    $sql = "SELECT h.user_id, u.name, h.proof_text, h.proof_file
            FROM helpers h
            JOIN users u ON h.user_id = u.id
            WHERE h.request_id = ? AND h.is_verified = 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $requestID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $helpers = [];
    while($row = mysqli_fetch_assoc($result)){
        $helpers[] = $row;
    }

    return $helpers;
}

?>
<?php
session_start();
require_once 'php/config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    // Check in users table
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        if ($password === $user['password']) {
            $_SESSION['user'] = $user;
            header("Location: pages/user_profile.php");
            exit;
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        // Check in admins table only if user not found
        $sql = "SELECT * FROM admins WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($admin = mysqli_fetch_assoc($result)) {
            if ($password === $admin['password']) {
                $_SESSION['admin'] = $admin;
                header("Location: pages/admin_requests.php");
                exit;
            } else {
                $error = "Invalid credentials.";
            }
        } else {
            $error = "Invalid credentials.";
        }
    }
}
?>

<!-- Login HTML -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helping Hand</title>
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <div class="index-popup">
        <div id="login" popover class="form-popup">
            <h2>Login</h2>
            <h4>Username / Email</h4>
            <form method="POST">
                <input name="username" type="text" placeholder="Username/Email" required><br />
                <h4>Password</h4>
                <input name="password" type="password" placeholder="Password" required><br />
                <button class="button" type="submit" popovertarget="login">Login</button>
                <?php if ($error): ?>
                    <p style="color:red;"><?php echo $error; ?></p>
                <?php endif; ?>
                <button class="button" popovertarget="login" popovertargetaction="hide">Close</button>
            </form>
        </div>
    </div>

    <main class="index-page">
        <img src="assets/index_logo.svg" alt="logo">

        <div class="index-buttons">
            <a class="index-page"><button class="button" popovertarget="login">LOGIN</button></a>
        </div>
    </main>


</body>

</html>

<div class="navbar" id="nav-color">
    <a href="/pages/help_board.php"><img class="logo" src="/assets/logo.svg" alt="logo"></a>
    <nav>
        <ul class="nav-links">
            <li><a href="/pages/help_board.php">Home</a></li>
            <?php if ($_SESSION['auth']['type'] === 'admin'): ?>
                <li><a href="/pages/admin/admin_requests.php">Dashboard</a></li>
            <?php else: ?>
                <li><a href="/pages/admin/user_requests.php">Dashboard</a></li>
            <?php endif;?>
            <li><a href="/pages/about-us.php">About us</a></li>
            <li><a href="/php/logout.php">Log Out</a></li>
        </ul>
    </nav>
</div>
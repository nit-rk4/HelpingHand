<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helping Hand</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <?php include("pages/navbar.php"); ?>

    <div class="index-popup">
        <div id="signup" popover class="form-popup">
            <h2>Sign up</h2>
            <h4>Username</h4>
            <input type="text" placeholder="JuanDelaCruz"></a>
            <h4>Email</h4>
            <input type="text" placeholder="juandelacruz123@gmail.com"></a>
            <h4>Password</h4>
            <input type="text" placeholder="Password"></a>
            <button class="button" popovertarget="signup" popovertargetaction="hide">Close</button>
        </div>
    </div>

    <div class="index-popup">
        <div id="login" popover class="form-popup">
            <h2>Login</h2>
            <h4>Username / Email</h4>
            <input type="text" placeholder="Username/Email"></a>
            <h4>Password</h4>
            <input type="text" placeholder="Password"></a>
            <button class = "button" popovertarget="login" popovertargetaction="hide">Close</button>
        </div>
    </div>

    <main class="index-page">
        <img src="/HelpingHand/assets/index_logo.svg" alt="logo">
        
        <div class="index-buttons">
            <a class="index-page"><button class="button" popovertarget="signup">SIGNUP</button></a>
            <a class="index-page"><button class="button" popovertarget="login">LOGIN</button></a>
        </div>    
    </main>

        
</body>
</html>

<?php
    include_once 'header.php';
?>

<body>
    <?php (isset($_SESSION["username"]))  ?>
        <div class="login_signup_container">
            <a class = "btn" href = "index.php"> Home </a>
            <a class = "btn" href = "../PHP/logout.php"> Sign Out </a>
        </div>

    <div class = "header">
    <h1> Personal Information </h1>
    </div>

    <div class = "wrapper">
        Name:
        <br>
        Email Address:
        <br>
        Change Password:
        <br>
        Change Theme: Coming Soon!
    </div>

    <script src = "index.js"> </script>
</body>
</html>
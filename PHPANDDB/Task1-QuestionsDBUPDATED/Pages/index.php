<?php
session_start();
include("..\DataAccess\Database.php");
include("..\phpActions\Signin.php");
$userData ="";
if (isset($_SESSION['user_id'])) {
    $signin = new SignIn();
    $userData = $signin->check_login($_SESSION['user_id']);
    
} else {
    header("Location:SignIn.php");
}
function formatHeader($data){
    echo "<h2 style='color:red; flex :1;'>".$data['username']."</h2>";
    echo "<h2 style='color:red;flex :1;'>".$data['email']."</h2>";
    echo "<h2><a href='logout.php'>Log-out</a></h2>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
</head>
<body>
    <header>
        <div style='display:flex; justify-content: center;align-items: center;'>

        <?php formatHeader($userData)?>
        </div>
    </header>
</body>
</html>
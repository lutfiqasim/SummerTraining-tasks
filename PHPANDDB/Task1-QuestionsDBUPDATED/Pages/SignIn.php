<?php
session_start();
include("..\DataAccess\Database.php");
include("..\phpActions\Signin.php");

$signin = new SignIn();
$result = "";
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    //If check login is successful return to index page
    $data = $signin->check_login($_SESSION['user_id']);
    // print_r($data);
    if ($data) {
        header("Location:index.php");
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $result = $signin->validateLogin($_POST);
        if ($result != "") {
            header("Location:SignIn.php?message=" . $result);
        } else {
            header("Location:index.php?");
        }
    }
}


?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login-To-Quiz-Maker</title>
    <!-- JQuery and dialogs -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- Dialog -->
    <link type="text/css" rel="stylesheet" href="..\CSS\index.css" />
    <script type="text/javascript" src="..\Scripts\signIn.js" defer="defer"></script>
</head>

<body>

    <body>
        <header>
            <h1>Login</h1>
        </header>
        <main>
            <div id="dialog" title='Alert'></div>
            <div class="no-script">
                <?php
                if (isset($_GET['message'])) {
                    echo $_GET['message'];
                }
                if (isset($_GET['email'])) {
                    $email = $_GET['email'];
                }
                ?>
            </div>
            <form method="post" action="#" class="login-form">
                <fieldset>
                    <legend>Login</legend>
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" placeholder="Enter your email" required>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <button type="submit" id="login-btn">Login</button>
                    <button type="button" id="signup-btn" onclick="window.location.href='SignUp.php';"><noscript><a
                                href="SignUp.php">Sign Up</a></noscript>Sign-UP</button>
                </fieldset>
            </form>
        </main>
    </body>
</body>

</html>
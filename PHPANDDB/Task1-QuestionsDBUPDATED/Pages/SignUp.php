<?php
include("..\DataAccess\Database.php");
include("..\phpActions\signup.php");
$userName = "";
$email = "";
$result = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $userName = $_POST['signup-username'];
    $email = $_POST['signup-email'];
    try {
        $signup = new Signup();
        $result = $signup->evaluate($_POST);
        if ($result != "") {
            header("Location:SignUp.php?message=" . $result . "&email=" . $email);
        } else {
            header("Location:SignIn.php?message= Signed Up successfully");
            die();
        }
    } catch (Exception $e) {
        $result = $e->getMessage();
        header("Location:SignUp.php?message=" . $e->getMessage());
    }

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- JQuery and dialogs -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- Dialog -->
    <link type="text/css" rel="stylesheet" href="..\CSS\index.css" />
    <script type="text/javascript" src="..\Scripts\signUp.js" defer="defer"></script>
    <title>Sign Up</title>
</head>

<body>
    <header>
        <h1>Sign Up</h1>
    </header>
    <main>
        <div id="dialog" title='Alert'></div>
        <form method="post" action="SignUp.php" class="signup-form">
            <fieldset>
                <legend>Sign Up</legend>
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
                <label for="signup-username">Username:</label>
                <input type="text" id="signup-username" name="signup-username" value="<?php echo $userName ?>"
                    placeholder="Enter your username" required>
                <label for="signup-email">Email:</label>
                <input type="email" id="signup-email" name="signup-email" value="<?php echo $email ?>"
                    placeholder="Enter your email" required>
                <label for="signup-password">Password:</label>
                <input type="password" id="signup-password" name="signup-password" placeholder="Enter your password"
                    required>
                <label for="signup-confirm-password">Confirm Password:</label>
                <input type="password" id="signup-confirm-password" name="signup-confirm-password"
                    placeholder="Re-enter your password" required>
                <button type="submit" id='signup'>Sign Up</button>
                <button type="button" id="signup-btn" onclick="window.location.href='SignIn.php';"><noscript><a
                            href="SignIn.php"></a></noscript>Sign-IN</button>
            </fieldset>
        </form>
    </main>
</body>

</html>
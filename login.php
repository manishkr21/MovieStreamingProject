<?php

    require_once("includes/classes/Formsanitizer.php");
    require_once("includes/classes/Account.php");
    require_once("includes/classes/Constants.php");
    require_once("includes/config.php");

    $account = new Account($connection);  


    if(isset($_POST["submitButton"])){
        // echo "Form was submitted";
        // double colon :: reperent static functional prop
        $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
        $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);

        $success = $account->login($username,$password);
        
        if($success){
            // store session
            $_SESSION["userLoggedIn"] = $username;

            header("Location: index.php");
        }

    }

    function getInputValue($name){
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }


    // if(isset($_POST["submitButton"])){
    //     echo "Form was submitted";
    // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Mkflix</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="assets/style/style.css"/>
</head>
<body>
   
    <div class="signInContainer">
        <div class="column">
            <div class="formheader">
                 <img src="assets/images/mkflix_logo.png" title="logo" alt="site logo">
       
                <h3>Sign In</h3>
                <span> to continue to MKflix </span>
            </div>

            <form method="POST">
                <?php echo $account->getError(Constants::$loginFailed); ?>
                <input type="text" name="username" placeholder="Username" value="<?php getInputValue("username") ?>" required>
               

                <input type="password" name="password" placeholder="Password"  required>
                <input type="submit" name="submitButton" placeholder="SUBMIT">
        

            </form>

            <a href="register.php" class="signInMessage">Need an account? Sign up here !</a>
        </div>
    </div>
</body>
</html>
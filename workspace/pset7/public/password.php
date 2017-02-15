<?php

    require("../includes/config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
        redirect("/");
    else if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_SESSION["id"])) {
        $errorDesc = "<h3>You can't change password, because:</h3>
            <ul class='list-group'>";
        $error = false;
        
        if (empty($_POST["currentpassword"])) {
            $error = true;
            $errorDesc = $errorDesc . "<li class='list-group-item list-group-item-danger'>
                <span class='glyphicon glyphicon-exclamation-sign'></span> The username field is empty.</li>";
        } else {
            $currentPassword = CS50::query("SELECT hash FROM users where id = ?", $_SESSION["id"]);
            if (!password_verify($_POST["currentpassword"], $currentPassword[0]["hash"])) {
                $error = true;
                $errorDesc = $errorDesc . "<li class='list-group-item list-group-item-danger'>
                    <span class='glyphicon glyphicon-exclamation-sign'></span> The current password doesn't match.</li>";                
            }
        }
        
        if (empty($_POST["password"])) {
            $error = true;
            $errorDesc = $errorDesc . "<li class='list-group-item list-group-item-danger'>
               <span class='glyphicon glyphicon-exclamation-sign'></span> The new password field is empty.</li>";
        }
        
        if (empty($_POST["confirmation"])) {
            $error = true;
            $errorDesc = $errorDesc . "<li class='list-group-item list-group-item-danger'>
                <span class='glyphicon glyphicon-exclamation-sign'></span> The confirm new password field is empty.</li>";
        }
        
        if (!empty($_POST["password"]) && !empty($_POST["confirmation"]) && $_POST["password"] != $_POST["confirmation"]) {
                $error = true;
                $errorDesc = $errorDesc . "<li class='list-group-item list-group-item-danger'>
                <span class='glyphicon glyphicon-exclamation-sign'></span> The new passwords don't match.</li>";            
        }
        
        if ($error)
            apologize($errorDesc . "</ul>");
        else {
            CS50::query("UPDATE users SET hash = ? WHERE id = ?", password_hash($_POST["password"], PASSWORD_DEFAULT), $_SESSION["id"]);
            render("password.php", ["title" => "Change password"]);
        } 
    }


?>
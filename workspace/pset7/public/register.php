<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // TODO
        $errorDesc = "<h3>You can't be registred, because:</h3>
            <ul class='list-group'>";
        $error = false;
        
        if (empty($_POST["username"])) {
            $error = true;
            $errorDesc = $errorDesc . "<li class='list-group-item list-group-item-danger'>
                <span class='glyphicon glyphicon-exclamation-sign'></span> The username field is empty.</li>";
        }
        
        if (empty($_POST["password"])) {
            $error = true;
            $errorDesc = $errorDesc . "<li class='list-group-item list-group-item-danger'>
               <span class='glyphicon glyphicon-exclamation-sign'></span> The password field is empty.</li>";
        }
        
        if (empty($_POST["confirmation"])) {
            $error = true;
            $errorDesc = $errorDesc . "<li class='list-group-item list-group-item-danger'>
                <span class='glyphicon glyphicon-exclamation-sign'></span> The confirm password field is empty.</li>";
        }
        
        if (!empty($_POST["username"])) {
            $rows = CS50::query("SELECT * FROM users WHERE username = ?", $_POST["username"]);
            
            if (count($rows) > 0) {
                $error = true;
                $errorDesc = $errorDesc . "<li class='list-group-item list-group-item-danger'>
                <span class='glyphicon glyphicon-exclamation-sign'></span> User {$_POST['username']} already exists.</li>";
            }
        }
        
        if (!empty($_POST["password"]) && !empty($_POST["confirmation"]) && $_POST["password"] != $_POST["confirmation"]) {
                $error = true;
                $errorDesc = $errorDesc . "<li class='list-group-item list-group-item-danger'>
                <span class='glyphicon glyphicon-exclamation-sign'></span> The passwords don't match.</li>";            
        }
        
        if ($error)
            apologize($errorDesc . "</ul>");
        else {
            if (CS50::query("INSERT IGNORE INTO users (username, hash, cash) VALUES(?, ?, 10000.0000)", 
                $_POST["username"], password_hash($_POST["password"], PASSWORD_DEFAULT)) != 0) {
                    $rows = CS50::query("SELECT LAST_INSERT_ID() AS id");
                    $id = $rows[0]["id"];
                    
                    $_SESSION["id"] = $id;
                    redirect("/");
            } 
        }
    }

?>
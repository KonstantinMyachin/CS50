<?php

    require("../includes/config.php"); 
    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
        render("buy_form.php", ["title" => "Buy"]);
    else if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $errorDesc = "<h3>Unfortunaly, you can't do it, because:</h3>
        <ul class='list-group'>";
        $error = false;
        $stock;
        $totalPrice;
        
        if (empty($_POST["symbol"])) {
            $error = true;
            $errorDesc = $errorDesc . "<li class='list-group-item list-group-item-danger'>
                <span class='glyphicon glyphicon-exclamation-sign'></span> You must specify a stock to buy.</li>";
        } else {
            $stock = lookup($_POST["symbol"]);
            if (!$stock) {
                $error = true;
                $errorDesc = $errorDesc . "<li class='list-group-item list-group-item-danger'>
                    <span class='glyphicon glyphicon-exclamation-sign'></span> Symbol not found</li>";
            }
        }
        
        if (empty($_POST["shares"])) {
            $error = true;
            $errorDesc = $errorDesc . "<li class='list-group-item list-group-item-danger'>
                <span class='glyphicon glyphicon-exclamation-sign'></span> You must specify a number of shares.</li>";
        } else {
            if (!preg_match("/^\d+$/", $_POST["shares"])) {
                $error = true;
                $errorDesc = $errorDesc . "<li class='list-group-item list-group-item-danger'>
                    <span class='glyphicon glyphicon-exclamation-sign'></span> Invalid number of shares.</li>";
            }
        }
        
        if (!empty($_POST["symbol"]) && !empty($_POST["shares"])) {
            $totalPrice = $stock["price"] * $_POST["shares"];
            $availableCash = CS50::query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
            if ($totalPrice > $availableCash[0]["cash"]) {
                $error = true;
                $errorDesc = $errorDesc . "<li class='list-group-item list-group-item-danger'>
                    <span class='glyphicon glyphicon-exclamation-sign'></span> You can't afford that.</li>";                
            }
        }
        
        if ($error)
            apologize($errorDesc . "</ul>");
        else {
            CS50::query("INSERT INTO portfolios (user_id, symbol, shares) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)", 
                $_SESSION["id"], $stock["symbol"], $_POST["shares"]);
            CS50::query("UPDATE users SET cash = cash - ? WHERE id = ?", $totalPrice, $_SESSION["id"]);
            CS50::query("INSERT INTO transactions (user_id, symbol, shares, price, type) VALUES (?, ?, ?, ?, 'BUY')", 
                $_SESSION["id"], $stock["symbol"], $_POST["shares"], $stock["price"]);
            
            redirect("/");
        }
    }
?>
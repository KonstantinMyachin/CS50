<?php
    require("../includes/config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
        render("quote_form.php", ["title" => "Get Qoute"]);
    else if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["symbol"]))
            apologize("<div class='alert alert-danger' role='alert'>You must provide a symbol.</div>");
        else {
            $stock = lookup($_POST["symbol"]);
            if (!$stock)
                apologize("<div class='alert alert-warning' role='alert'>Symbol not found.</div>");
            else
                render("quote.php", [
                    "title" => "Qoute", 
                    "result" => $stock
                    ]);
        }
    }
?>
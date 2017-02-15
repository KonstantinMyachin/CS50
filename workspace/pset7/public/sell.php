<?php
    require("../includes/config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (!empty($_SESSION["id"])) {
            $rows = CS50::query("SELECT * FROM portfolios WHERE user_id = ?", $_SESSION["id"]);
            if (count($rows) > 0) {
                $symbols = [];
                $i = 0;
                foreach ($rows as $row) {
                    $symbols[$i] = $row["symbol"];
                    $i++;
                }
                
                render("sell_form.php", [
                    "title" => "Sell",
                    "symbols" => $symbols
                    ]);
            } else
                apologize("Nothing to sell.");
        }
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_SESSION["id"])) {
            if (!empty($_POST["symbol"])) {
                $stockPrice = lookup($_POST["symbol"]);
                if ($stockPrice !== false) {
                    print
                    $stockRow = CS50::query("SELECT * FROM portfolios WHERE user_id = ? and symbol = ?", $_SESSION["id"], $_POST["symbol"]);
                    if (count($stockRow) > 0) {
                        CS50::query("DELETE FROM portfolios WHERE user_id = ? and symbol = ?", $_SESSION["id"], $_POST["symbol"]);
                        CS50::query("UPDATE users SET cash = cash + ? WHERE id = ?", $stockPrice["price"] * $stockRow[0]["shares"], $_SESSION["id"]);
                        CS50::query("INSERT INTO transactions (user_id, symbol, shares, price, type) VALUES (?, ?, ?, ?, 'SELL')", 
                            $_SESSION["id"], $_POST["symbol"], $stockRow[0]["shares"], $stockPrice["price"]);
                    } 
                }
                
                redirect("/");
                
            } else
                apologize("<div class='alert alert-warning' role='alert'>You must select a stock to sell.</div>");
        }
    }
?>
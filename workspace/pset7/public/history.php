<?php

    // configuration
    require("../includes/config.php");
    
    if (!empty($_SESSION["id"])) {
        $rows = CS50::query("SELECT * FROM transactions WHERE user_id = ?", $_SESSION["id"]);
        $transactions = [];
        if (count($rows) > 0) {
            $i = 0;
            foreach ($rows as $row) {
                $stock = lookup($row["symbol"]);
                if ($stock !== false) {
                    $transactions[] = [
                        "i" => ++$i,
                        "name" => $stock["name"],
                        "currentPrice" => $stock["price"],
                        "shares" => $row["shares"],
                        "price" => $row["price"],
                        "type" => $row["type"],
                        "date" => $row["date"],
                        "symbol" => $row["symbol"],
                    ];
                }
            }
        }
        render("history.php", [
            "title" => "History",
            "transactions" => $transactions
            ]);
    }
    
?>
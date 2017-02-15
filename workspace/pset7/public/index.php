<?php

    // configuration
    require("../includes/config.php");
    
    if (!empty($_SESSION["id"])) {
        $rows = CS50::query("SELECT * FROM portfolios WHERE user_id = ?", $_SESSION["id"]);
        $user = CS50::query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);
        $positions = [];
        if (count($rows) > 0) {
            $i = 0;
            foreach ($rows as $row) {
                $stock = lookup($row["symbol"]);
                if ($stock !== false) {
                    $positions[] = [
                        "i" => ++$i,
                        "name" => $stock["name"],
                        "price" => $stock["price"],
                        "shares" => $row["shares"],
                        "symbol" => $row["symbol"]
                    ];
                }
            }
        }
        render("portfolio.php", [
            "title" => "Portfolio",
            "positions" => $positions,
            "user" => $user[0]
            ]);
    }

?>

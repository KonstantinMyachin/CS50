<!DOCTYPE html>

<html>

    <head>

        <!-- http://getbootstrap.com/ -->
        <link href="/css/bootstrap.min.css" rel="stylesheet"/>

        <link href="/css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)): ?>
            <title>C$50 Finance: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>C$50 Finance</title>
        <?php endif ?>

        <!-- https://jquery.com/ -->
        <script src="/js/jquery-1.11.3.min.js"></script>

        <!-- http://getbootstrap.com/ -->
        <script src="/js/bootstrap.min.js"></script>

        <script src="/js/scripts.js"></script>

    </head>

    <body>

        <div class="container">

            <div id="top">
                <div>
                    <a href="/"><img alt="C$50 Finance" src="/img/logo.png"/></a>
                </div>
                <?php if (!empty($_SESSION["id"])):
                    $userName = CS50::query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);
                ?>
                    <ul class="nav nav-pills">
                        <li><a href="/"><i class="glyphicon glyphicon-home"></i></a></li>
                        <li><a href="quote.php">Quote</a></li>
                        <li><a href="buy.php">Buy</a></li>
                        <li><a href="sell.php">Sell</a></li>
                        <li><a href="history.php">History</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="glyphicon glyphicon-user"></i> <?= $userName[0]["username"] ?><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" data-toggle="modal" data-target="#changePasswordDialog"><i class="glyphicon glyphicon-wrench"></i> Change Password</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="logout.php"><i class="glyphicon glyphicon-log-in"></i><b> Log Out</b></a></li>
                            </ul>
                        </li>
                    </ul>
                <?php endif ?>
            </div>

            <div id="middle">


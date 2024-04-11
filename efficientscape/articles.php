<html>
    <?php
        session_start();
        require_once 'index-request.php';
    ?>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://kit.fontawesome.com/74d37a292d.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="script.js"></script>
        <meta name="viewport" content="width=device-width, user-scalable=no">
    </head>
    <body>
        <header class="index-header">
            <a class="navigation-phone-btn">
                <i class="fa fa-bars"></i>
            </a>
            <div class="navigation-container">
                <a href="index.php" id="index-home" class='nav-button'>Home</a>
                <a href="articles.php"class='nav-button nav-active'>Articles</a>
                <?php if (isset($_SESSION['username'])){?>
                    <a href="stats.php" class='nav-button'>Stats</a>
                    <a href="achievments.php" class='nav-button'>Achievments</a>
                    <a href="logout.php" class='nav-button'>Logout</a>
                <?php }else{?>
                    <a href="login.php" class='nav-button'>Login</a>
                <?php }?>
            </div>
        </header>
        <main>
            <?php for($i = 0; $i<$checkData; $i++){?>
                <div class="articles-main-content">
                    <h1><?php echo $articles[$i]['title'];?></h1>
                    <p><?php echo $articles[$i]['content'];?></p>
                </div>
            <?php }?>
        </main>
    </body>
</html>
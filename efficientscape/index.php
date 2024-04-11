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
        <script>
            function shorten(str, id, n){
                if (str.length > n){
                    str = str.slice(0, n-1) + '... Read more';
                }
                $('#index-content-id'+id).text(str);
            };
        </script>
    </head>
    
    <body>
        <header class="index-header">
            <a class="navigation-phone-btn">
                <i class="fa fa-bars"></i>
            </a>
            <div class="navigation-container">
                <a href="index.php" id="index-home" class='nav-button nav-active'>Home</a>
                <a href="articles.php"class='nav-button'>Articles</a>
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
            <div class="main-container">
                <div class="container-overlay"></div>
                <div class="main-container-header">
                    <div>
                    <h1 class="main-header">Start your journey now</h1>
                    <?php if (isset($_SESSION['username'])){?>
                        <form action="stats.php">
                            <button type="submit" class="main-button">START NOW</button>
                        </form>
                    <?php } else {?>
                        <form action="login.php">
                            <button type="submit" class="main-button">START NOW</button>
                        </form>
                    <?php }?>
                    </div>
                </div>
            </div>
        </main>
        <div class="index-about">
            <h1>What is EfficientScape?</h1>
            <p>EfficientScape is a website dedicated to track my own progress. Using my liking for games and deduction of what makes a game so interesting, I applied it to make myself more of a person I want to be rather then in a game. In addition, it helps to see progress made in life and what I've accomplished. As it can be easy to demotivated when progress isn't seen for a longer period of time, it's good to have a visual represntation to help yourself to improve. As most of the games are literaly just numbers on a screen and we like to see that number go up, hopefuly it'll have the same effect in this form of game - to be the greatest person you can ever be. Even though there are a lot of websites and apps already created which most likely could do what this website does even better it's more of a statement to myself that I will get better. Although it still need few changes done and more achievments created, it's rather a good starting point.</p>
        </div>
        
        <content class="index-content">
            <h1>Motivational articles</h1>
            <?php 
            if ($checkData < 3){
                $forlen = $checkData;
            }
            else{
                $forlen = 3;
            }
            for ($i = 0; $i < $forlen; $i++){?>
                <div class="index-content-container">
                    <h1 class="test"><?php echo $articles[$i]['title'];?></h1>
                    <p id="index-content-id<?php echo $i;?>"></p>
                    <script>shorten('<?php echo $articles[$i]['content'];?>', <?php echo $i;?>, 100)</script>
                    <div class="index-outer-pop-up"></div>
                    <div class="index-pop-up">
                        <a class="index-close-button">&#10006;</a>
                        <h3><?php echo $articles[$i]['title'];?></h3>
                        <p><?php echo $articles[$i]['content'];?></p>
                    </div>
                </div>
            <?php }?>
            <a href="articles.php"><button class="index-content-button">View all articles</button></a>
        </content>
        <footer class="index-footer"><p>Hope you have a great day</p></footer>
    </body>
    <script>
        $('.index-pop-up').hide();
        $('.index-outer-pop-up').hide();
    </script>
</html>
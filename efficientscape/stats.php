<html>
    <?php
        session_start();
        require_once 'stats-request.php';
    ?>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://kit.fontawesome.com/74d37a292d.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="script-stats.js"></script>
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <style id="stats-keyframes">
            @keyframes progress-animation {
                from {
                --progress: 0;
                }
                to {
                --progress: 0;
                }
            }
        </style>
    </head>
    <body>
        <header class="index-header">
            <a class="navigation-phone-btn">
                <i class="fa fa-bars"></i>
            </a>
            <div class="navigation-container">
                <a href="index.php" id="index-home" class='nav-button'>Home</a>
                <a href="articles.php"class='nav-button'>Articles</a>
                <?php if (isset($_SESSION['username'])){?>
                    <a href="stats.php" class='nav-button nav-active'>Stats</a>
                    <a href="achievments.php" class='nav-button'>Achievments</a>
                    <a href="logout.php" class='nav-button'>Logout</a>
                <?php }else{?>
                    <a href="login.php" class='nav-button'>Login</a>
                <?php }?>
            </div>
        </header>
        <main class="stats-main">
            <aside class="stats-aside">
                <ul>
                    <li id="aside-study" class=" aside-button">Study</li>
                    <li id="aside-work" class=" aside-button">Work</li>
                    <li id="aside-health" class=" aside-button">Health</li>
                    <li id="aside-sport" class=" aside-button">Sport</li>
                    <input id="aside-selector" type="hidden" name="<?php echo $_SESSION['cat'];?>"></input>
                </ul>
            </aside>
            <content class="stats-content">
                <svg viewBox="0 0 15em 15em" class="circular-progress">
                    <circle class="bg"></circle>
                    <circle class="fg"></circle>
                </svg>
                <div class="stats-procentage">
                    <p></p>
                </div>
                <div id="stats-study" class="stats-info">
                    <form action="stats.php" class="stats-info-buttons" method="POST">
                        <button name="stats-btn" value="streak" class="stats-button">Daily task</button>
                        <button name="stats-btn" value="extra" class="stats-button">Extra 1h</button>
                        <select name="study-select" class="stats-select">
                            <option value="html">HTML/CSS/JS</option>
                            <option value="php">+PHP/MYSQL</option>
                            <option value="other">Other</option>
                        </select>
                        <button name="stats-btn" value="projects" class="stats-button">Finished project</button>
                        <button name="missed-btn" value="0" class="stats-button stats-missed">Missed day</button>
                        <input type="hidden" name="btn-index" value="0"></input>
                    </form>
                    <p class="daily-task-req">Daily task: Sit down to study</p>
                </div>
                <div id="stats-work" class="stats-info">
                    <form action="stats.php" method="POST" class="stats-info-buttons">
                        <button name="stats-btn" value="streak" class="stats-button">Daily task</button>
                        <button name="stats-btn" value="extra" class="stats-button">Extra 1h</button>
                        <button name="stats-btn" value="coins" class="stats-button">100€ reached</button>
                        <button name="missed-btn" value="1" class="stats-button stats-missed">Missed day</button>
                        <input type="hidden" name="btn-index" value="1"></input>
                    </form> 
                    <p class="daily-task-req">Daily task: Work for 8 hours</p>
                </div>
                <div id="stats-health" class="stats-info">
                    <form action="stats.php" method="POST" class="stats-info-buttons">
                        <button name="stats-btn" value="streak" class="stats-button">Daily task</button>
                        <button name="stats-btn" value="smoke" class="stats-button">No smoke</button>
                        <button name="stats-btn" value="energy" class="stats-button">No energy drink</button>
                        <select name="health-select" class="stats-select">
                            <option value="streak">Daily task missed</option>
                            <option value="smoke">Smoked</option>
                            <option value="energy">Drank energy drink</option>
                        </select>
                        <button name="missed-btn" value="2" class="stats-button stats-missed">Missed day</button>
                        <input type="hidden" name="btn-index" value="2"></input>
                    </form>
                    <p class="daily-task-req">Daily task: Reach Calories</p>
                </div>
                <div id="stats-sport" class="stats-info">
                    <form action="stats.php" method="POST" class="stats-info-buttons">
                        <button name="stats-btn" value="streak" class="stats-button">Daily task</button>
                        <button name="stats-btn" value="pr" class="stats-button">1kg PR</button>
                        <button name="stats-btn" value="kg" class="stats-button">1kg Gained/Lost</button>
                        <button name="missed-btn" value="3" class="stats-button stats-missed">Missed day</button>
                        <input type="hidden" name="btn-index" value="3"></input>
                    </form>
                    <p class="daily-task-req">Daily task: Go to gym</p>
                </div>
            </content>
            <div class="stats-user-stats">
                <h1>Current Stats:</h1>
                <?php for ($i = 0; $i < 4; $i++){?>
                    <div id="stats-show-<?php echo GetCat($i);?>" class="stats-show">
                        <?php 
                        $lvl = GetXp($i, 'lvl', $conn);
                        $lowerLvl = $lvl -1;?>
                        <p>Level: <?php echo $lvl;?></p>
                        <p>XP: <span class="stats-xp-get"><?php echo GetXp($i, 'xp', $conn);?></span> / <span class="stats-xp-need"><?php echo XpReq($lvl, 1);?></span></p>
                        <input type="hidden" class="test" name="<?php echo XpReq($lowerLvl, 1);?>"/>
                        <p>Streak: <?php echo GetXp($i, 'streak', $conn)?></p>
                        <?php if ($i == 0){?>
                            <p>
                                Projects Completed: <?php
                                echo GetXp($i, 'projects', $conn);?>
                            </p>
                        <?php } if ($i == 0 || $i == 1){?>
                            <p>
                                Extra hours: <?php
                                echo GetXp($i, 'extra', $conn);?>
                            </p>
                        <?php } if ($i == 1){?>
                            <p>
                                Extra money earned: <?php
                                echo GetXp($i, 'coins', $conn);?>
                            </p>
                        <?php } else if ($i == 2){?>
                            <p>
                                Days without smoking: <?php
                                echo GetXp($i, 'smoke', $conn);?>
                            </p>
                            <p>
                                Days without energy drink: <?php
                                echo GetXp($i, 'energy', $conn);?>
                            </p>
                        <?php } else if ($i == 3){?>
                            <p>
                                Times personal records been smashed: <?php
                                echo GetXp($i, 'pr', $conn);?>
                            </p>
                            <p>
                                Kg gained/lost: <?php
                                echo GetXp($i, 'kg', $conn);?>
                            </p>
                        <?php }?>
                    </div>
                <?php }?>
            </div>
        </main>
        <div class="hidden-message">
            <p>Work: Reached Lvl <?php echo $_SESSION['lvl'];?></p>
        </div>
    </body>
    <script>
        $('.stats-info').hide();
        $('.stats-show').hide();
        $('.hidden-message').hide();
        if (<?php echo $_SESSION['lvl'];?> == 1){
            var cat = $('#aside-selector').attr('name');
            <?php 
                $hiddenCat = $_SESSION['cat'];
                $hiddenIndex = RevertCat($hiddenCat);?>
            $('.hidden-message').text(cat + ': Reached LvL <?php echo GetXp($hiddenIndex, 'lvl', $conn);?>');
            $('.hidden-message').slideDown(1000).delay(5000).slideUp(1000);
            <?php $_SESSION['lvl'] = 0;?>
        }
    </script>
</html>
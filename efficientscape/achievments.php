<html>
    <?php
        session_start();
        require_once 'achievments-request.php';
    ?>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://kit.fontawesome.com/74d37a292d.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="script-achievments.js"></script>
        <meta name="viewport" content="width=device-width, user-scalable=no">
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
                    <a href="stats.php" class='nav-button'>Stats</a>
                    <a href="achievments.php" class='nav-button nav-active'>Achievments</a>
                    <a href="logout.php" class='nav-button'>Logout</a>
                <?php }else{?>
                    <a href="login.php" class='nav-button'>Login</a>
                <?php }?>
            </div>
        </header>
        <main class="achievments-main">
            <aside class="stats-aside">
                <ul>
                    <li class="aside-button aside-button-active">All</li>
                    <li class="aside-button">Study</li>
                    <li class="aside-button">Work</li>
                    <li class="aside-button">Health</li>
                    <li class="aside-button">Sport</li>
                    <li class="aside-button">Other</li>
                    <input id="aside-selector" type="hidden" name="<?php echo $_SESSION['cat'];?>"></input>
                </ul>
            </aside>
            <content class="achievments-content">
                <h1>Achievment List</h1>
                <?php
                    CheckAchievments($conn);
                    $ac = GetAchievments($conn);
                    $userAc = GetUserAc($conn);
                    $userTotalAc = GetCompletedAc($conn);
                    $totalAc = AchievmentsTotal($ac);
                    $comArray = array();
                    for ($i = 0; $i < 6; $i++){
                        $cat = GetCat($i);?>
                        <div class="achievments-full-list" id="achievments-list-total-<?php echo $cat;?>">
                            <p><?php echo $userTotalAc[$cat];?> / <?php echo $totalAc[$cat];?></p>
                        </div>
                    <?php }
                    for ($i = 0; $i < count($ac); $i++){
                        $com = $userAc[$i]['completed'];
                        [$req, $val] = StatsReq($conn, $ac, $i);
                        if($val >= $req && $com == 0){
                            $acID = $ac[$i]['id'];
                            $com = 1;
                            array_push($comArray, $ac[$i]['title']);
                            UpdateValue($conn, $com, 'completed', $acID, $ac[$i]['cat'], $ac[$i]['reward']);
                        }?>
                        <div class="achievments-list list-cat-<?php echo $ac[$i]['cat'];?>" name="<?php echo $com;?>">
                            <h3><?php echo $ac[$i]['title'];?></h3>
                            <p><?php echo $ac[$i]['content'];?></p>
                            <p><?php echo $val;?> / <?php echo $req;?></p>
                            <p>XP Reward: <?php echo $ac[$i]['reward'];?></p>
                        </div>
                    <?php }?>
            </content>
            <div>
                <h2>Filter</h2>
                <div class="achievments-filter-container">
                    <label>Completed achievments</label>
                    <input class="filter-checkbox" id="filter-completed" type="checkbox" checked/>
                </div>
                <div class="achievments-filter-container">
                    <label>Incomplete achievments</label>
                    <input class="filter-checkbox" id="filter-incompleted" type="checkbox" checked/>
                </div>
        
            </div>
        </main>
        <div class="test"></div>
        <div class="hidden-message achievments-hidden-message">
            <p>ACHIEVMENT COMPLETED:</p>
            <p class="hidden-selector"></p>
        </div>
    </body>
    <script>
        $('.hidden-message').hide();
        $('.achievments-full-list').hide();
        var ac = [];
        <?php
            for($i = 0; $i < count($comArray); $i++){?>
                ac.push('<?php echo $comArray[$i];?>');
        <?php }?>
        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
        async function ShowAchievment() {
            for (let i = 0; i < ac.length; i++) {
                $('.hidden-message').slideDown(1000).delay(5000).slideUp(1000);
                $('.hidden-selector').text(ac[i]);
                await sleep(8000);
            }
        }
        
        ShowAchievment();
    </script>
</html>
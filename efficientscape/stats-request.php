<?php
    include_once 'database.php';
    Start($conn);
    if (!isset($_SESSION['username'])){
        header('Location: login.php');
    }
    if(isset($_POST['stats-btn'])){
        $xp = GetData($conn);
        $index = $_POST['btn-index'];
        $type = $_POST['stats-btn'];
        $cat = GetCat($index);
        if ($type == 'projects'){
            $addType = $_POST['study-select'];
            $add = GetTypes($addType);
            $mul = 5;
        }
        else{
            $add = GetTypes($type);
            $mul = 1;
        }
        [$lvl, $newXp, $streak] = Calc($xp[$index]['xp'], $xp[$index][$type], $xp[$index]['lvl'], $add, $mul);
        if ($type == 'projects'){
            [$lvl, $newXp, $val] = Calc($xp[$index]['xp'], $xp[$index][$addType], $xp[$index]['lvl'], $add, 1);
            UpdateValue($conn, $cat, $val, $addType);
        }
        UpdateValue($conn, $cat, $newXp, 'xp');
        UpdateValue($conn, $cat, $lvl, 'lvl');
        UpdateValue($conn, $cat, $streak, $type);
        $_SESSION['cat'] = $cat;
    }
    if(isset($_POST['missed-btn'])){
        $index = $_POST['missed-btn'];
        if ($index == 2){
            $type = $_POST['health-select'];
        }
        else{
            $type = 'streak';
        }
        $cat = GetCat($index);
        UpdateValue($conn, $cat, 0, $type);
        $_SESSION['cat'] = $cat;
    }
    function Calc($xp, $streak, $lvl, $dif, $mul){
        $xp = $xp + $dif;
        $streak++;
        if ($mul !== 0){
            $xp = Streak($streak, $xp, $mul);
        }
        $lvl = Levelup($lvl, $xp);
        return [$lvl, $xp, $streak];
    }
    function GetTypes($cat){
        $list = array();
        $list['streak'] = 150;
        $list['extra'] = 50;
        $list['html'] = 500;
        $list['php'] = 1000;
        $list['other'] = 1500;
        $list['coins'] = 100;
        $list['smoke'] = 100;
        $list['energy'] = 50;
        $list['pr'] = 100;
        $list['kg'] = 200;
        return $list[$cat];
    }
    function Levelup($lvl, $xp){
        $req = XpReq($lvl, 0);
        while ($lvl < 100 && $xp >= $req[$lvl]){
            $lvl++;
            $_SESSION['lvl'] = 1;
        }
        return $lvl;
    }
    function Streak($streak, $xp, $multiplier){
        if ($streak % 10 == 0){
            $xp += 500 * $multiplier;
        }
        if ($streak % 25 == 0){
            $xp += 1500 * $multiplier;
        }
        if ($streak % 100 == 0){
            $xp += 2500 * $multiplier;
        }
        if ($streak % 365 == 0){
            $xp += 5000 * $multiplier;
        }
        if ($streak % 1000 == 0){
            $xp += 10000 * $multiplier;
        }
        return $xp;
    }
    function GetID(){
       return $_SESSION['id']; 
    }
    function GetXp($i, $val, $conn){
        $xp = GetData($conn);
        return $xp[$i][$val];
    }
    function GetCat($i){
        $categories = array(
            'study',
            'work',
            'health',
            'sport'
        );
        return $categories[$i];
    }
    function RevertCat($val){
        $revertCat['study'] = 0;
        $revertCat['work'] = 1;
        $revertCat['health'] = 2;
        $revertCat['sport'] = 3;
        return $revertCat[$val];
    }
    function UpdateValue ($conn, $cat, $val, $selector){
        $id = GetID();
        $sql = "UPDATE $cat SET $selector = $val WHERE userId = '$id';";
        mysqli_query($conn, $sql);
    }
    function Start($conn){
        for ($i = 0; $i < 4; $i++){
            $xp = GetXp($i, 'xp', $conn);
            $cat = GetCat($i);
            $lvl = GetXp($i, 'lvl', $conn);
            $lvl = Levelup($lvl, $xp);
            if ($cat == 'other'){
                for ($j = 0; $j < 4; $j++){
                    $cat = GetCat($j);
                    $xp = GetXp($i, 'xp', $conn);
                    $lvl = GetXp($i, 'lvl', $conn);
                    $lvl = Levelup($lvl, $xp);
                    UpdateValue($conn, $cat, $lvl, 'lvl');
                }
            }
            else{
                UpdateValue($conn, $cat, $lvl, 'lvl');
            }
        }
    }









    function GetData($conn){
        $getData = array();
        $xp = array();
        $id = GetID();
        $getData[0] = "SELECT xp, lvl, streak, projects, html, php, other, extra
                        FROM study WHERE userid = '$id';";
        $getData[1] = "SELECT xp, lvl, streak, extra, coins
                        FROM work WHERE userid = '$id';";
        $getData[2] = "SELECT xp, lvl, streak, smoke, energy
                        FROM health WHERE userid = '$id';";
        $getData[3] = "SELECT xp, lvl, streak, pr, kg
                        FROM sport WHERE userid = '$id';";
        for ($i = 0; $i < count($getData); $i++){
            $resultData = mysqli_query($conn, $getData[$i]);
            $xp[$i] = mysqli_fetch_array($resultData, MYSQLI_ASSOC);
        }
        return $xp;
    }
    function XpReq($lvl, $set){
        $xpReq = array(
            0,
            83,
            174,
            276,
            388,
            512,
            650,
            801,
            969,
            1154,
            1358,
            1584,
            1833,
            2107,
            2411,
            2746,
            3115,
            3523,
            3973,
            4470,
            5018,
            5624,
            6291,
            7028,
            7842,
            8740,
            9730,
            10824,
            12031,
            13363,
            14833,
            16456,
            18247,
            20224,
            22406,
            24815,
            27473,
            30408,
            33648,
            37224,
            41171,
            45529,
            50339,
            55649,
            61512,
            67983,
            75127,
            83014,
            91721,
            101333,
            111945,
            123660,
            136594,
            150872,
            166636,
            184040,
            203254,
            224466,
            247886,
            273742,
            302288,
            333804,
            368599,
            407015,
            449428,
            496254,
            547953,
            605032,
            668051,
            737627,
            814445,
            899257,
            992895,
            1096278,
            1210421,
            1336443,
            1475581,
            1629200,
            1798808,
            1986068,
            2192818,
            2673114,
            2951373,
            3258594,
            3597792,
            3972294,
            4385776,
            4842295,
            5346332,
            5902831,
            6517253,
            7195629,
            7944614,
            8771558,
            9684577,
            10692629,
            11805606,
            13034431
        );
        if ($set == 1){
            return $xpReq[$lvl];
        }
        else if ($set == 0){
            return $xpReq;
        }
    }



?>
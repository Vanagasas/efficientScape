<?php 
    include_once 'database.php';



    function GetAchievments($conn){
        $ac = array();
        $sql = 'SELECT id, title, content, req, reward, cat, targets FROM achievments;';
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)){
            $ac[] = $row;
        }
        return $ac;
    }
    function GetUserAc($conn){
        $user = array();
        $id = GetID();
        $sql = "SELECT id, acid, completed FROM userAchievments WHERE userid = '$id';";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)){
            $user[] = $row;
        }
        return $user;
    }
    function GetStats($conn, $cat, $target){
        $id = GetID();
        $sql = "SELECT $target FROM $cat WHERE userid = '$id';";
        $result = mysqli_query($conn, $sql);
        $xp = mysqli_fetch_assoc($result);
        return $xp[$target];
    }
    function GetID(){
        return $_SESSION['id'];
    }
    function UpdateValue($conn, $val, $selector, $acID, $cat, $reward){
        $id = GetID();
        $sql = "UPDATE userAchievments SET $selector = $val WHERE userId = '$id' AND acid = '$acID';";
        mysqli_query($conn, $sql);
        if ($selector == 'completed'){
            if ($cat == 'other'){
                for ($i = 0; $i < 4; $i++){
                    $cat = GetCat($i);
                    CompletedUpdate($conn, $cat, $reward);
                }
            }
            else{
                CompletedUpdate($conn, $cat, $reward);
            }
           
            
        }
    }
    function CompletedUpdate($conn, $cat, $reward){
        $id = GetID();
        $sql = "SELECT xp FROM $cat WHERE userid = '$id';";
        $result = mysqli_query($conn, $sql);
        $xp = mysqli_fetch_assoc($result);
        $xpVal = $xp['xp'] + $reward;
        $sql = "UPDATE $cat SET xp = $xpVal WHERE userId = '$id';";
        $result = mysqli_query($conn, $sql);
    }
    function GetCompletedAc($conn){
        $id = GetID();
        $list = array();
        for ($i = 0; $i < 5; $i++){
            $cat = GetCat($i);
            $sql = "SELECT completed FROM userAchievments WHERE completed = 1 AND userid = '$id' AND cat = '$cat';";
            $result = mysqli_query($conn, $sql);
            $list[$cat] = mysqli_num_rows($result);
        }
        $sql = "SELECT completed FROM userAchievments WHERE completed = 1 AND userid = '$id'";
        $result = mysqli_query($conn, $sql);
        $list['all'] = mysqli_num_rows($result);
        return $list;
    }
    function GetOtherStats($conn, $target, $req){
        $rez = 0;
        for ($i = 0; $i < 4; $i++){
            $cat = GetCat($i);
            $val = GetStats($conn, $cat, $target);
            if ($val >= $req){
                $rez++;
            }
        }
        return $rez;
    }
    function StatsReq($conn, $ac, $i){
        $req = $ac[$i]['req'];
        if ($ac[$i]['cat'] !== 'other'){
            $val = GetStats($conn, $ac[$i]['cat'], $ac[$i]['targets']);
        }
        else if ($ac[$i]['cat'] == 'other'){
            $val = GetOtherStats($conn, $ac[$i]['targets'], $req);
            $req = 4;
        }
        return [$req, $val];
    }
    function GetCat($i){
        $cat = array(
            'study',
            'work',
            'health',
            'sport',
            'other',
            'all'
        );
        return $cat[$i];
    }
    function AchievmentsTotal($a){
        $list = array();
        for ($i = 0; $i < 5; $i++){
            $cat = GetCat($i);
            $list[$cat] = 0;
        }
        for ($i = 0; $i < count($a); $i++){
            for ($j = 0; $j < 5; $j++){
                if (GetCat($j) == $a[$i]['cat']){
                    $cat = GetCat($j);
                    $list[$cat]++;
                }
            }
        }
        $list['all'] = count($a);
        return $list;
    }
    function CheckAchievments($conn){
        $id = GetID();
        $ac = GetAchievments($conn);
        for ($i = 0; $i < count($ac); $i++){
            $acID = $ac[$i]['id'];
            $cat = $ac[$i]['cat'];
            $sql = "SELECT acid FROM userAchievments WHERE acid = '$acID' AND userid = '$id';";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 0){
                $sql = "INSERT INTO userAchievments (acid, userid, cat) VALUES ('$acID', '$id', '$cat');";
                $result = mysqli_query($conn, $sql);
            }

        }
    }




















?>
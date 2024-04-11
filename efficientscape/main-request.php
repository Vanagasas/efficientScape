<?php
    
    function GetID(){
        return $_SESSION['id']; 
     }
     function UpdateValue ($conn, $cat, $val, $selector){
        $id = GetID();
        $sql = "UPDATE $cat SET $selector = $val WHERE userId = '$id';";
        mysqli_query($conn, $sql);
    }
     function GetCat($i){
        $categories = array(
            'study',
            'work',
            'health',
            'sport',
            'other',
            'all'
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
    function GetStats($conn, $cat, $target){
        $id = GetID();
        $sql = "SELECT $target FROM $cat WHERE userid = '$id';";
        $result = mysqli_query($conn, $sql);
        $xp = mysqli_fetch_assoc($result);
        return $xp[$target];
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

?>
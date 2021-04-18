<?php
header('ReferrerPolicy: "unsafe-url"');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Origin: *');
$_POST = json_decode(file_get_contents('php://input'), true);
if (isset($_POST['params']['token']))
{ 
  $res = true;
    include './enterToSQL.php';
    $query = "SELECT * FROM `admins` WHERE `token` = '".$_POST['params']['token']."'";
    $result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
    
    
    if ($pers = mysql_fetch_assoc($result)){ 
      if ($_POST['method']==='getList'){
        if ($_POST['params']['sort']['field']==='id'){
          $sortField = 'idq';
        }else{
          $sortField = $_POST['params']['sort']['field'];
        }
        $query = "SELECT * FROM `questions` 
                  ORDER BY `".$sortField."` ".$_POST['params']['sort']['order']."
                  LIMIT ".+$_POST['params']['pagination']['page']-1.",".+$_POST['params']['pagination']['perPage'];
        $result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());

        //2. засовываем всё в ассоциативный массив
        $ij=0;
        while ($row = mysql_fetch_assoc($result)) {
            $r['questions'][$ij] = $row;
            $r['questions'][$ij]['id'] = $row['idq'];
            $ij++; 
        }
      }
      if ($_POST['method']==='addNewQuestion'){
        $query = "INSERT INTO `questions` (
          `theme`, 
          `parentTheme`, 
          `serialNumber`, 
          `text`, 
          `correctAnswer`, 
          `wrongAnswer`, 
          `typeAchievement`, 
          `utime`          
          ) VALUES ( '"
            .$_POST['params']['theme']."', '"
            .$_POST['params']['parentTheme']."', "
            .$_POST['params']['serialNumber'].", '"
            .$_POST['params']['text']."', '"
            .$_POST['params']['correctAnswer']."', '"
            .$_POST['params']['wrongAnswer']."', '"
            .$_POST['params']['typeAchievement']."', "
            .time()." )";
        mysql_query($query) or die('write name err: ' . mysql_error());
        include './readBase.php';  
      }
      if ($_POST['method']==='updateQuestion'){
        $query = "UPDATE `questions` 
                SET 
                `theme` = '".$_POST['params']['theme']."', 
                `parentTheme` = '".$_POST['params']['parentTheme']."', 
                `serialNumber` = ".$_POST['params']['serialNumber'].", 
                `text` = '".$_POST['params']['text']."', 
                `correctAnswer` = '".$_POST['params']['correctAnswer']."', 
                `wrongAnswer` = '".$_POST['params']['wrongAnswer']."', 
                `typeAchievement` = '".$_POST['params']['typeAchievement']."', 	
                `utime` = ".time()." 
                WHERE `idq` = ".$_POST['params']['id'];
                
              mysql_query($query) or die('write name err: ' . mysql_error());
        include './readBase.php';  
      }
      if ($_POST['method']==='deleteQuestion'){
       $query = "DELETE FROM `questions` 
                  WHERE idq = ".$_POST['params']['id'].";";
            mysql_query($query) or die('delete quickAccessKit err: ' . mysql_error());
        include './readBase.php';  
      }
    }

    $r['type'] = 'approved';
    //3.отправляем весь массив данных  
    $json = json_encode($r);
    echo $json;
    mysql_close($link);
}
?>
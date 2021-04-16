<?php
header('ReferrerPolicy: "unsafe-url"');
header('Access-Control-Allow-Headers: *');

$_POST = json_decode(file_get_contents('php://input'), true);
if (isset($_POST['params']['token']))
{ 
  $res = true;
    include './enterToSQL.php';
    $query = "SELECT * FROM `admins` WHERE `token` = '".$_POST['params']['token']."'";
    $result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
    
    
    if ($pers = mysql_fetch_assoc($result)){ 
      if ($_POST['method']==='addNewQuestion'){
        $query = "INSERT INTO `questions` (
          `theme`, 
          `parentTheme`, 
          `serialNumber`, 
          `text`, 
          `correctAnswer`, 
          `wrongAnswer`, 
          `utime`          
          ) VALUES ( '"
            .$_POST['params']['theme']."', '"
            .$_POST['params']['parentTheme']."', "
            .$_POST['params']['serialNumber'].", '"
            .$_POST['params']['text']."', '"
            .$_POST['params']['correctAnswer']."', '"
            .$_POST['params']['wrongAnswer']."', "
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
                `utime` = ".time()." 
                WHERE `idq` = ".$_POST['params']['idq'];
                
              mysql_query($query) or die('write name err: ' . mysql_error());
        include './readBase.php';  
      }
    }

    $r['type'] = 'approved';
    //3.отправляем весь массив двнных  
    $json = json_encode($r);
    echo $json;
    mysql_close($link);
}
?>
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
      if ($_POST['method']==='addNewGamer'){
        $f = openssl_random_pseudo_bytes(8);
        $hex = bin2hex($f);
        $query = "INSERT INTO `gamers` (
          `qr`, 
          `name`, 
          `color`, 
          `time`          
          ) VALUES ( '"
            .$hex."', '"
            .$_POST['params']['name']."', "
            .$_POST['params']['color'].", "
            .time()." )";
        mysql_query($query) or die('write name err: ' . mysql_error());
        include './readBase.php';  
      }
      if ($_POST['method']==='updateGamer'){
        $query = "UPDATE `gamers` 
                SET 
                `name` = '".$_POST['params']['name']."', 
                `color` = '".$_POST['params']['color']."',
                `time` = ".time()." 
                WHERE `idp` = ".$_POST['params']['id'];
                
              mysql_query($query) or die('write name err: ' . mysql_error());
        include './readBase.php';  
      }
      if ($_POST['method']==='deleteGamer'){
       $query = "DELETE FROM `gamers` 
                  WHERE idp = ".$_POST['params']['id'].";";
            mysql_query($query) or die('delete quickAccessKit err: ' . mysql_error());
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
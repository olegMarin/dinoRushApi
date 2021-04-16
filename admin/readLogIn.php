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
      include './readBase.php';  
    

    $r['type'] = 'approved';
    //3.отправляем весь массив двнных  
    $json = json_encode($r);
    echo $json;
    mysql_close($link);
}
?>
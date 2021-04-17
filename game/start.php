<?php
header('ReferrerPolicy: "unsafe-url"');
header('Access-Control-Allow-Headers: *');

$_POST = json_decode(file_get_contents('php://input'), true);
if (isset($_POST['params']['qr']))
{ 
  $res = true;
    include './enterToSQL.php';
    $query = "SELECT * FROM `gamers` WHERE `qr` = '".$_POST['params']['qr']."'";
    $result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
    
    
    if ($r['user'] = mysql_fetch_assoc($result)){ 
      if ($_POST['method']==='read'){
        //1. читаем из базы все вопросы
        $query = "SELECT * FROM `answers`";
        $result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
        //2. засовываем всё в ассоциативный массив
        $ij=0;
        while ($row = mysql_fetch_assoc($result)) {
          $r['answers'][$ij] = $row;
          $ij++; 
        }
      }
     
    }

    $r['type'] = 'approved';
    //3.отправляем весь массив данных  
    $json = json_encode($r);
    echo $json;
    mysql_close($link);
}
?>
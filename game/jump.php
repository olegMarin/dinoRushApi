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
      if ($_POST['method']==='goto'){     
        //1. читаем имена и цвета игроков, которые зашли на этот же вопрос
        $query = "SELECT `name`, `color` FROM `gamers` WHERE `idanswer` = ".$r['user']['idanswer'];
        $result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
        //2. засовываем всё в ассоциативный массив
        $ij=0;
        while ($row = mysql_fetch_assoc($result)) {
          $r['rivals'][$ij] = $row;
          $ij++; 
        }
        //3. записываем id текущего вопроса в базу


        //4. записываем новые достижения

        
        //5. записываем результат ответа на предыдущий вопрос
        

      }
     
    }

    $r['type'] = 'approved';
    //3.отправляем весь массив данных  
    $json = json_encode($r);
    echo $json;
    mysql_close($link);
}
?>
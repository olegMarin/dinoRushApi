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
        //3. записываем id текущего вопроса в базу игрока
              $query = "UPDATE `gamers` 
                SET 
                `idq` = '".$_POST['params']['idq']."'
                WHERE `idp` = ".$_POST['params']['idp'];
                
              mysql_query($query) or die('write name err: ' . mysql_error());

        //4. записываем новые достижения
        $query = "SELECT * FROM `questions` WHERE `idq` = '".$_POST['params']['idq']."'";
        $result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
        if ($q = mysql_fetch_assoc($result)){ 
          if ($q['typeAchievement']!=""){
              $query = "INSERT INTO `achievements` (
                `idp`, 
                `time`, 
                `typeAchievement`     
                ) VALUES ( "
                  .$_POST['params']['idp'].", "
                  .time().", '"
                  .$q['typeAchievement']."'
                  )";
              mysql_query($query) or die('write name err: ' . mysql_error());
            }
        }


        
        //5. записываем результат ответа на предыдущий вопрос
        
          $query = "INSERT INTO `answers` (
                `idq`, 
                `idp`, 
                `correctness`,
                `time`     
                ) VALUES ( "
                  .$_POST['params']['idq'].", "
                  .$_POST['params']['idp'].", "
                  .$_POST['params']['correctness'].", "
                  .time()." )";
              mysql_query($query) or die('write name err: ' . mysql_error());
      }
     
    }

    $r['type'] = 'approved';
    //3.отправляем весь массив данных  
    $json = json_encode($r);
    echo $json;
    mysql_close($link);
}
?>
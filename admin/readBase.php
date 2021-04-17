<?php
      $query = "SELECT * FROM `questions` ORDER BY `idq` DESC";
      $result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());

      //2. засовываем всё в ассоциативный массив
      $ij=0;
      while ($row = mysql_fetch_assoc($result)) {
          $r['questions'][$ij] = $row;
          $r['questions'][$ij]['id'] = $row['idq'];
          $ij++; 
      }

      $query = "SELECT * FROM `gamers` ORDER BY `idp` DESC";
      $result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());

      //2. засовываем всё в ассоциативный массив
      $ij=0;
      while ($row = mysql_fetch_assoc($result)) {
          $r['gamers'][$ij] = $row;
          $r['gamers'][$ij]['id'] = $row['idp'];
          $ij++; 
      }

      
      $query = "SELECT * FROM `answers` ORDER BY `idanswer` DESC";
      $result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());

      //2. засовываем всё в ассоциативный массив
      $ij=0;
      while ($row = mysql_fetch_assoc($result)) {
          $r['answers'][$ij] = $row;
          $r['answers'][$ij]['id'] = $row['idanswer'];
          $ij++; 
      }
      
      $query = "SELECT * FROM `achievements` ORDER BY `idach`";
      $result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());

      //2. засовываем всё в ассоциативный массив
      $ij=0;
      while ($row = mysql_fetch_assoc($result)) {
          $r['achievements'][$ij] = $row;
          $r['achievements'][$ij]['id'] = $row['idach'];
          $ij++; 
      }
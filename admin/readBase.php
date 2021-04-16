<?php
      $query = "SELECT * FROM `questions` ORDER BY `idq` DESC";
      $result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());

      //2. засовываем всё в ассоциативный массив
      $ij=0;
      while ($row = mysql_fetch_assoc($result)) {
          $r['base']['questions'][$ij] = $row;
          $ij++; 
      }

      $query = "SELECT * FROM `gamers` ORDER BY `idp` DESC";
      $result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());

      //2. засовываем всё в ассоциативный массив
      $ij=0;
      while ($row = mysql_fetch_assoc($result)) {
          $r['base']['gamers'][$ij] = $row;
          $ij++; 
      }

      
      $query = "SELECT * FROM `answers` ORDER BY `idanswer` DESC";
      $result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());

      //2. засовываем всё в ассоциативный массив
      $ij=0;
      while ($row = mysql_fetch_assoc($result)) {
          $r['base']['answers'][$ij] = $row;
          $ij++; 
      }
      
      $query = "SELECT * FROM `achievements` ORDER BY `idach`";
      $result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());

      //2. засовываем всё в ассоциативный массив
      $ij=0;
      while ($row = mysql_fetch_assoc($result)) {
          $r['base']['achievements'][$ij] = $row;
          $ij++; 
      }
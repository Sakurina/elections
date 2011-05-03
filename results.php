<?php
  $moddate = filemtime("cache.json");
  if ($time > ($moddate + 30)) {
    fpassthru("cache.json");
    exit;
  }

  include "simple_html_dom.php";
  $url = "http://enr.elections.ca/Provinces_e.aspx";
  $doc = file_get_html($url);

  $parties = array(
    "3" => "bloc",
    "2" => "libs",
    "1" => "ndp",
    "0" => "tories",
    "4" => "other",
    "5" => "total");

  $results = array();

  $i = 0;
  foreach($doc->find('td[headers="header1"]') as $seats) {
    $id = $parties[$i];
    $results[$id] = $seats->innertext;
    $i++; 
  }

  $i = 0;
  foreach($doc->find('td[headers="header2"]') as $pop) {
    $id = $parties[$i] . "-pop";
    $results[$id] = $pop->innertext;
    $i++;
  }

  $json = json_encode($results);

  $fhandle = fopen('cache.json', 'w');
  fwrite($fhandle, $json);
  fclose($fhandle);

  echo $json;
?>

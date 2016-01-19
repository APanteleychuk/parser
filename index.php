<?php

include_once('lib/simple_html_dom.php');
$row = 1;
$ret ='';
$allcsv = array();
if (($handle = fopen("test.csv", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    if(empty($data)){
    continue;
    }
      $id = $data[0];
      $url = $data[4];

      if(isset($url) && $url != "" && isset($id) && $id != "" ) {
        $title='';
        $img='';
        $pdd='';
        $spd='';
        $brand='';

        $html = file_get_html($url);
        $title = $html->find('.title-right');
        $img = $html->find('div#wrap] img.product-image');
        $pdd = $html->find('div[id=product-detailed-description]');
        $spd = $html->find('h2.product-description em');
        $brand = $html->find('a.brand-image-holder img');
        $brand = $brand[0]->src;
        $pdd = $pdd[0]->outertext;
        $img = $img[0]->src;
        $title = $title[0]->plaintext;
        $spd = $spd[0]->plaintext;
        $spd = iconv('UTF-8','windows-1251', $spd);
        $pdd = iconv('UTF-8','windows-1251', $pdd);
        $title = iconv('UTF-8','windows-1251', $title);
        $data[]= $title;
        $data[]= $img;
        $data[]= $pdd;
        $data[]= $spd;
        $data[]= $brand;
              echo $title . "<br />\n";
              echo $img . "<br />\n";
              echo $pdd . "<br />\n";
              echo $spd . "<br />\n";
              echo $brand . "<br />\n";
              echo $id . "<br />\n";
      }
    $allcsv[]=$data;
  }


  fclose($handle);

  $fp = fopen('file_new.csv', 'w+');
  foreach ($allcsv as $fields) {
    fputcsv($fp, $fields);
  }
  fclose($fp);

}


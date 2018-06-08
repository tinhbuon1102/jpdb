<?php

Yii::import('application.vendors.*');
require_once('vendor/autoload.php');
use Knp\Snappy\Pdf;

class GeneratePdfCommand extends CConsoleCommand
{
  public function actionIndex($id, $zoom, $zoom_building, $pdfUrl, $user, $fName)
  {
    $domain = "http://office-jpdb.com";
// 		$domain = "http://localhost:9992";


    $images_path = realpath(Yii::app()->basePath . '/../pdfArticle');


    $snappy = new Pdf('/usr/local/wkhtmltox/bin/wkhtmltopdf');

    $snappy->setOption('javascript-delay', 20000);
    $snappy->setOption('page-width', 297);
    $snappy->setOption('page-height', 210);
    $snappy->setOption('print-media-type', true);
    $snappy->setOption('margin-left', 0);
    $snappy->setOption('margin-top', 0);
    $snappy->setOption('margin-right', 0);
    $snappy->setOption('margin-bottom', 0);
    $url = urldecode($domain.$pdfUrl.'&print=true&zoom='.$zoom.'&zoombuilding='.$zoom_building.'&user='.$user);
    if ($_GET['test'])
    {
    		$url = '<html><body>abdf</body></html>'
//     		echo $url;die;
    }
    $snappy->generate($url, $images_path.'/'.$fName);

    if(file_exists($images_path.'/'.$fName)){
      $reps = array('status'=>1,'url'=>$domain.'/pdfArticle/'.$fName);
    }else{
      $reps = array('status'=>0);
    }

    touch($images_path.'/'.$fName . '.done');

  }

}
<?php
require 'protected/vendors/vendor/autoload.php';

use Knp\Snappy\Pdf;

$snappy = new Pdf('/usr/local/wkhtmltox/bin/wkhtmltopdf');
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="file.pdf"');

$snappy->setOption('javascript-delay', 10000);
$snappy->setOption('page-width', 235);
$snappy->setOption('page-height', 169);
$snappy->setOption('print-media-type', true);
$snappy->setOption('margin-left', 10);
$snappy->setOption('margin-top', 10);

//$urls = Array(
//		'http://jp-officedb.com/index.php?hdnProArticleId=65&header_name=Test&print_type=10&print_route=1&print_each_building=1&add_cover=1&header_name=&r=floor/addProposedToCart',
//		'http://localhost/work/tonni/map_whole_img.php');
// echo $snappy->getOutput(array('http://www.github.com','http://www.knplabs.com','http://www.php.net'));
// echo $snappy->getOutput(array('http://localhost/work/tonni/map.php', 'http://localhost/work/tonni/map_img.php'));
// echo $snappy->getOutput(array('http://localhost/work/tonni/map.php','http://localhost/work/tonni/map_img.php'));
//http://jp-officedb.com/index.php?hdnProArticleId=65&print_type=11&print_route=1&print_each_building=1&add_cover=1&print_time_floor=1&print_time_entrance=1&header_name=Test&r=floor%2FaddProposedToCart
//echo $snappy->getOutput($urls);
echo $snappy->getOutput('http://office-jpdb.com/index.php?hdnProArticleId=65&header_name=Test&print_type=10&print_route=1&print_each_building=1&add_cover=1&header_name=&r=floor/addProposedToCart');
?>
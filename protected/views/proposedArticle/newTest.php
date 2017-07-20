<?php
ob_start();
echo $this->renderPartial('testForPdf',array('buildCartDetails'=>$buildCartDetails,'requestData'=> $requestData,'proposedFloors'=>$allFloorIds));
$content = ob_get_clean();

Yii::import('application.extensions.HTML2PDF');

try{
	$html2pdf = new HTML2PDF('P', 'A4', 'utf-8');
	//$html2pdf->setModeDebug();
	//$html2pdf->setDefaultFont('Arial');
	$html2pdf->writeHTML($content,false);
	$html2pdf->Output("pdfdemo.pdf");
}catch(HTML2PDF_exception $e) {
	echo $e;
	exit;
}
?>
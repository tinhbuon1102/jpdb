<?php

/* @var $this BuildingController */

/* @var $model Building */

?>

<div id="main" class="single-customer">

<header class="m-title btnright">

<h1 class="main-title">ビルを新規追加</h1>

</header>

<?php $this->renderPartial('_form', array('model'=>$model,'facedStreetList'=>$facedStreetList,'constructionTypeList'=>$constructionTypeList,'quakeResistanceList'=>$quakeResistanceList,'securityList'=>$securityList,'formTypeList'=>$formTypeList)); ?>

</div>
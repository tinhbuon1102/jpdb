<?php

/* @var $this CustomerController */
/* @var $model Customer */


?>
<div id="main" class="single-customer">
<header class="m-title btnright">
<h1 class="main-title">ADD NEW CUSTOMER</h1>
</header>
<?php $this->renderPartial('_form', array('model'=>$model,'inquiry_type_details'=>$inquiry_type_details,'businessTypeDetails'=>$businessTypeDetails,'customerSource'=>$customerSource,'userAdmin'=>$userAdmin,'introducer'=>$introducer)); ?>
</div>
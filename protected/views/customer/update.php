<?php
/* @var $this CustomerController */
/* @var $model Customer */


?>
<div id="main" class="single-customer">

<?php $this->renderPartial('_form', array('model'=>$model,'inquiry_type_details'=>$inquiry_type_details,'businessTypeDetails'=>$businessTypeDetails,'customerSource'=>$customerSource,'userAdmin'=>$userAdmin,'introducer'=>$introducer)); ?>
</div>
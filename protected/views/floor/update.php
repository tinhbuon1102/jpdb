<?php
/* @var $this FloorController */
/* @var $model Floor */

?>
<!DOCTYPE html>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta name="language" content="en">

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico">

    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" media="screen">

    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/groovy.css" media="screen">

    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="//fonts.googleapis.com/earlyaccess/notosansjapanese.css">
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.js"></script>
    
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.css">
    <script type="text/javascript">
	$(function(){
		$('.tabs').tabtab({
			startSlide: 1, // スタート時のタブ
			arrows: true, // 左右矢印キーでめくらせるか
			dynamicHeight: true, // 高さ自動調整
			useAnimations: true, // アニメーション
			easing: 'ease', // イージング　http://julian.com/research/velocity/#easing
			speed: 350, // スピード
			slideDelay: 0 // スライド切り替え速度
		});
	});
	</script>
</head>

<body class="archive category category-manage-customers category-3">
<input type="hidden" name="baseUrl" class="baseUrl" id="baseUrl" value="<?php echo Yii::app()->baseUrl; ?>"/>
<?php $this->renderPartial('_form', array('model'=>$model,'tradersDetails'=>$tradersDetails,'useTypesDetails'=>$useTypesDetails,'floorSourceDetails'=>$floorSourceDetails,'userList'=>$userList,'updateHistory'=>$updateHistory)); ?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jTabs.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/datepicker-ja.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/velocity.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/tabtab.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/groovy.js?t=1"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/groovy2.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/drag_drop/jquery.knob.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/drag_drop/jquery.ui.widget.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/drag_drop/jquery.iframe-transport.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/drag_drop/jquery.fileupload.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/utils/Draggable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.4/TweenMax.min.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/grid.js"></script>
</body>

</html>
<?php /* @var $this Controller */ ?>

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

</head>

<body class="archive category category-manage-customers category-3">

	<?php include('header.php'); ?>

    <?php echo $content; ?>

    <?php include('footer.php'); ?>

</body>

</html>
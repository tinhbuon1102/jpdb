<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
<?php
$controller = Yii::app()->controller->id;
$action = Yii::app()->controller->action->id;
$activeTop = $activeCustomer = $activeBuilding = $activePropose = $activeMarket = '';

if($controller == 'site' && $action == 'index'){
	$activeTop = 'active-tab';
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jTabs.js"></script>
<?php
}
if($action == 'myProposedArticleList'){ ?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/select2.css">
<?PHP } 
if($controller == 'customer'){
?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/select2.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/select2.js"></script>
<?php
	if($action == 'admin'){
		$activeCustomer = 'active-tab';
	}
	if($action == 'create'){
		$activeCustomer = 'active-tab';
?>
<?php
}
if($action == 'update'){
	$activeCustomer = 'active-tab';
}
if($action == 'searchCustomer'){
	$activeCustomer = 'active-tab';
}
?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jTabs.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/datepicker-ja.js"></script>
<script>
$(function(){
	$("#registerDateFrom").datepicker();
	$("#registerDateFrom").datepicker("option", $.datepicker.regional["ja"]);
	$("#registerDateTo").datepicker();
	$("#registerDateTo").datepicker("option", $.datepicker.regional["ja"]);
});
</script>
<script>
$(window).load(function(){
	$("ul.tabs").jTabs({content: ".tabs_content", animate: true});
	$("ul.tabs2").jTabs({content: ".tabs_content2", animate: true});
	$("ul.tabs3").jTabs({content: ".tabs_content3", animate: true});
});
</script>

<?php
}
if($controller == 'building'){
?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/select2.css">
<?php
	if($action != 'admin'){
?>
<?php }?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/select2.js"></script>
<?php
	if($action == 'admin'){
		$activeBuilding = 'active-tab';
	}
	if($action == 'create'){
		$activeBuilding = 'active-tab';
	}
	if($action == 'update'){
		$activeBuilding = 'active-tab';
	}
	if($action == 'searchBuilding'){
		$activeBuilding = 'active-tab';
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jTabs.js"></script>
<?php
}
if($action == 'searchBuildingResult'){
	$activeBuilding = 'active-tab';
}
if($action == 'singleBuilding'){
	$activeBuilding = 'active-tab';
}

?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/grid.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/lightbox/css/lightbox.min.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/Chart.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/datepicker-ja.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jTabs.js"></script>
<script>
$(window).load(function(){
	if($("ul.tabs").length > 0){
		$("ul.tabs").jTabs({content: ".tabs_content", animate: true});
	}
	if($("ul.tabs2").length > 0){
		$("ul.tabs2").jTabs({content: ".tabs_content2", animate: true});
	}
	if($("ul.tabs3").length > 0){
		$("ul.tabs3").jTabs({content: ".tabs_content3", animate: true});
	}
});
</script>
<script>
jQuery(function($){
	$(function(){
		function accordion(){
			$(this).toggleClass("active").next().slideToggle(300);
		}
		$(".accordion .toggle").click(accordion);
	});
});
</script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/locationpicker.jquery.js"></script>
<script>
$(function(){
	$(".slider-range").each(function(index, element) {
        var minval = maxval = 0;
		if(typeof $(this).attr('min') != 'undefined' && $(this).attr('min') != '') minval = $(this).attr('min');
		if(typeof $(this).attr('max') != 'undefined' && $(this).attr('max') != '') maxval = $(this).attr('max');
		$(this).slider({
		range: true,
		min: 0,
		max: 500,
		values: [minval, maxval ],
		stop: function(event,ui){
			$("#amount").val("$"+ui.values[0]+"-$"+ui.values[1]);
			$('#minVal').val(ui.values[0]);
			$('#maxVal').val(ui.values[1]).trigger('change');
		}
	});
    });
	$(document).on('change','#minVal',function(){
		var minVal = parseInt($(this).val());
		var maxVal = parseInt($('#maxVal').val());
		$( ".slider-range" ).slider( "values",[minVal, maxVal ]);
	});
	$(document).on('change','#maxVal',function(){
		var minVal = parseInt($('#minVal').val());
		var maxVal = parseInt($(this).val());
		$( ".slider-range" ).slider( "values",[minVal, maxVal ]);
	});
	$(".slider-range-1").each(function(index, element) {
        var minval = maxval = 0;
		if(typeof $(this).attr('min') != 'undefined' && $(this).attr('min') != '') minval = $(this).attr('min');
		if(typeof $(this).attr('max') != 'undefined' && $(this).attr('max') != '') maxval = $(this).attr('max');
		$(this).slider({
		range: true,
		min: 0,
		max: 5,
		step: 0.5,
		values: [minval, maxval ],
		stop: function( event, ui ) {
			$("#amount").val("$"+ui.values[0]+"-$"+ui.values[1]);
			$('#minVal-1').val(ui.values[0]);
			$('#maxVal-1').val(ui.values[ 1 ]).trigger('change');
		}
	});
    });

	$(document).on('change','#minVal-1',function(){
		var minVal1 = parseInt($(this).val());
		var maxVal1 = parseInt($('#maxVal-1').val());
		$( ".slider-range-1" ).slider( "values",[minVal1, maxVal1 ]);
	});
	$(document).on('change','#maxVal-1',function(){
		var minVal1 = parseInt($('#minVal-1').val());
		var maxVal1 = parseInt($(this).val());
		$( ".slider-range-1" ).slider( "values",[minVal1, maxVal1 ]);
	});
});
</script>
<script>
$(function(){
	$("#expirationDate").datepicker();
	$("#expirationDate").datepicker("option", $.datepicker.regional["ja"]);
});
</script>
<?php
}
if($controller == 'floor'){
?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jTabs.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/datepicker-ja.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/velocity.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/tabtab.js"></script>
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
<link rel="stylesheet" href="//fonts.googleapis.com/earlyaccess/notosansjapanese.css">
<?php
}

if($controller == 'proposedArticle'){
	$activePropose = 'active-tab';
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/select2.js"></script>
<?php
}
if($controller == 'marketInfo'){
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jTabs.js"></script>
<script>window.symphony = window.symphony || {}; window.symphony['extension_version'] = '0.7';</script>
<?php
}
if($controller == 'wordTranslation'){
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jTabs.js"></script>
<?php
}
?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.css">

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/loadingoverlay.js"></script>
<script>
jQuery(function(){
 var header = $('#header')
 header_offset = header.offset();
 header_height = header.height();
  $(window).scroll(function () {
	  if($(window).scrollTop() > header_offset.top + header_height && jQuery(document).height() >= 1200) {
    header.addClass('scroll');
   }else {
    header.removeClass('scroll');
   }
  });
});
</script>
<?php 
/********** get google map api key **********/
$criteria=new CDbCriteria;
$criteria->order='google_map_api_key_id DESC';

$getGoogleMapKeyDetails = GoogleMapApiKey::model()->find($criteria);
$gApiKey = '';
if(count($getGoogleMapKeyDetails) > 0){
	$gApiKey = $getGoogleMapKeyDetails['api_key'];
}
?>
<script type='text/javascript' src='http://maps.googleapis.com/maps/api/js?key=<?php echo $gApiKey?>&language=ja&region=JP'></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/map.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/markerwithlabel.js"></script>

<!-- header -->
<input type="hidden" name="baseUrl" id="baseUrl" value="<?php echo Yii::app()->getBaseUrl(); ?>"/>
<div id="header" class="clearfix">
	<div class="header-wrap clearfix">
    	<h1 id="logo">
    		<a href="<?php echo Yii::app()->createUrl('site/index'); ?>">
        		<img src="images/logo.png"/>
        	</a>
    	</h1>
    	<nav class="topnv clearfix">
    		<ul>
            	<li class="">
                    <div class="bt_input_box" style="margin: 0 !important;border: none !important;">
                    	<div class="bt_input">
                        	<div class="divSearchTextBox">
                                <form name="frmSearchKeyWord" id="frmSearchKeyWord" class="frmSearchKeyWord" method="post" action="<?php echo Yii::app()->createUrl('site/globalSearch'); ?>">
                                    <input type="text" name="searchGlobal" class="bt_carry searchGlobal header-search-textbox" id="searchGlobal" placeholder="<?php echo  Yii::app()->controller->__trans('建物名・顧客名から検索'); ?>" autocomplete="off">
                                </form>
                            </div>
                            <div class="divButtonSearch">
                        		<button type="button" class="btnSearchGlobal" id="btnSearchGlobal"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->createUrl('site/settings'); ?>">
                        <i class="fa fa-cog fa-lg"></i>
                        <span>
                            <?php echo Yii::app()->controller->__trans('Setting'); ?>
                        </span>
                    </a>
                </li>
                <li class="">
                    <a href="#" class="help" id="help">
                        <i class="fa fa-question-circle fa-lg"></i>
                        <?php echo Yii::app()->controller->__trans('Help'); ?>
                    </a>
                </li>
                <li class="">
                    <span>
                        <?php
                            $userDetails = Users::model()->find('username = "'.Yii::app()->user->id.'"');
                            $userFullDetails = AdminDetails::model()->find('user_id = '.$userDetails->user_id);
                            if(isset($userFullDetails) && count($userFullDetails) > 0){
                                echo $userFullDetails['full_name'];
                            }
                        ?>
                    </span>
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->createUrl('site/logout'); ?>" class="btnLogout">
                        <i class="fa fa-sign-out fa-lg"></i>
                    </a>
                </li>
                <li class="">
                    <a href="#" class="btnChangePassowrd" id="btnChangePassowrd" data-value="<?php echo $userDetails->user_id; ?>" title="<?php echo Yii::app()->controller->__trans('Change Password'); ?>">
                        <i class="fa fa-key" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="">
                	<?php
					$siteSettingDetails = SiteSetting::model()->findByPk(1);
					if(isset($siteSettingDetails) && count($siteSettingDetails) > 0 && !empty($siteSettingDetails)){
						$compName = $siteSettingDetails['value'];
					}else{
						$compName = 'Company Name';
					}
					?>
                	<a href="<?php echo Yii::app()->createUrl('site/frontSearch'); ?>" title="<?php echo Yii::app()->controller->__trans('Company Name'); ?>">
						<?php echo Yii::app()->controller->__trans($compName); ?>
                    </a>
                </li>
        	</ul>
   		</nav>
	</div>

	<!-- /Navigation -->
	<div class="clear"></div>
    <nav class="clearfix" id="mainnv">
        <div class="header-wrap">
            <ul id="main-nav">
                <li class="<?php echo $activeTop; ?>">
                    <a href="<?php echo Yii::app()->createUrl('site/index'); ?>">
                        <span><?php echo Yii::app()->controller->__trans('TOP'); ?></span>
                    </a>
                </li>
                <li class="<?php echo $activeBuilding ?>">
                    <a href="<?php echo Yii::app()->createUrl('building/searchBuilding'); ?>">
                        <span><?php echo Yii::app()->controller->__trans('MANAGE PROPERTIES'); ?></span>
                    </a>
                </li>
                <li class="<?php echo $activeCustomer; ?>">
                    <a href="<?php echo Yii::app()->createUrl('customer/searchCustomer'); ?>">
                        <span><?php echo Yii::app()->controller->__trans('MANAGE CUSTOMERS'); ?></span>
                    </a>
                </li>
                <li class="<?php echo $activeMarket; ?>">
                    <a href="<?php echo Yii::app()->createUrl('marketInfo'); ?>">
                        <span><?php echo Yii::app()->controller->__trans('MARKET INFO'); ?></span>
                    </a>
                </li>
                <li class="<?php echo $activePropose; ?>">
                    <a href="<?php echo Yii::app()->createUrl('proposedArticle/myProposedArticleList'); ?>">
                        <span><?php echo Yii::app()->controller->__trans('PROPOSED ARTICLE'); ?></span>
                    </a>
                </li>
                <li class="list-nav">
                    <a href="<?php echo Yii::app()->createUrl('site/frontSearch'); ?>" class="po-list">
                        <span><?php echo Yii::app()->controller->__trans('LIST'); ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<!-- /header -->
<?php
$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
$logged_user_id = $user->user_id;
$cartDetails = Cart::model()->findAll(array('order'=>'`order`', 'condition'=>'user_id=:x', 'params'=>array(':x'=>$logged_user_id)));
$slideOpen = '';
if(isset($cartDetails) && count($cartDetails) > 0){
	$totalCount = count($cartDetails);
}else{
	$totalCount = 0;
	$slideOpen = 'style="display:none"';
}
?>

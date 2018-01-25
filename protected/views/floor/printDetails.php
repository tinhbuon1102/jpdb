<?php
/********** get google map api key **********/
$gApiKey = 'AIzaSyCMeCU-45BrK0vyJCc4y2TYMdDJLNGdifM';
//$gApiKey = 'AIzaSyDJlHTWIHfZsuOIZChVv0Dx9LoAl0PL7a0';

$language = isset($_GET['print_language']) ? $_GET['print_language'] : 'ja';

$glob_where = '';
if (in_array($_REQUEST['print_type'], array(10, 11)) && false)
{
	$glob_where = ' and vacancy_info = 1';
}

$glob_where .= ' ORDER BY cast(floor_down AS SIGNED) ASC, cast(floor_up AS SIGNED) ASC';
/***************** end ****************/

if(isset($_GET['proposedUsername'])) {
	$proposedUsername = Users::model()->find('user_id = '.$_GET['proposedUsername']);
	$proposedCompany = new stdClass();
	if ($proposedUsername && isset($proposedUsername->company))
	{
		$proposedCompany = Company::model()->findByPK((int)$proposedUsername->company);
	}
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style>
@import url(http://fonts.googleapis.com/earlyaccess/notosansjapanese.css);
body, html { margin: 0px; padding: 0px; }
body { counter-reset: sheet; /* カウンタの初期化 */ font-family: 'Noto Sans Japanese', sans-serif; }

@media print {
	a[href]:after { content: "" !important; }
	abbr[title]:after { content: "" !important; }
}
span.senko {
    background: #000;
    color: #FFF;
    display: inline-block;
    padding: 1px 3px;
    margin-right: 5px;
}
td.f_floor_str span.senko {
	margin: 0;
}
img { border: none; }
a img { border: none; }
img.company_name {
    width: auto;
    height: 26px;
    margin-bottom: 15px;
}
.clearfix:after { content: "."; display: block; height: 0; clear: both; visibility: hidden; }
.clearfix { display: inline-table; }
<?php if($_REQUEST['print_type']!=8) {?>
.sheet { width: <?php print (!isset($_REQUEST['print'])) ? '277mm' : '100%' ?>; height: auto; /* 1mm余裕をもたせる */ page-break-after: always; position: relative; }
<?php } else { ?>
.sheet { width: <?php print (!isset($_REQUEST['print'])) ? '179mm' : '100%' ?>; height: auto; /* 1mm余裕をもたせる */ page-break-after: always; position: relative; }
<?php } ?>
 .sheet.commercial { page-break-after: avoid; } 
.client_name {
    margin-top: 5mm;
    font-weight: bold;
}
td.f_price_t_rent { height: 16mm; }
img { max-width: 277mm; height: auto; }
table.building-profile td.center.const_th {
    width: 55mm;
}
table.building-profile td.establish_th {
    width: 45mm;
}
.build_title { margin-top: 10px; margin-bottom: 10px; font-size: 20px; }
.cover h1 { font-size: 30px; margin-top: 0; }
.headtitle-wrapper { position: absolute; left: 0; bottom: 60mm; z-index: 3; padding: 12mm 10mm; width: 150mm; min-height: 45mm; display: block; background: url(images/wht_08.png) repeat;}
.cover h4 { margin-bottom: 1mm; margin-top: 0; }
.cover h4.en { font-family: HelveticaNeue-UltraLight; font-weight: 100; }
.client { font-size: 11pt; font-weight: bold; padding-left: 5mm; position: relative; padding-bottom: 2mm; }
.client:before { position: absolute; width: 1px; height: 12mm; top: 0; left: 0; background: #000; content: ""; }
.client:after { position: absolute; width: 282mm; height: 2px; bottom: 0; left: -5mm; background: #000; content: ""; }
.author 
{ 
	background: #FFF; padding: 10mm 5mm; display: table; position: absolute; bottom: 0; left: 0; 
	width: <?php print (!isset($_REQUEST['print'])) ? '287mm' : '100%'; ?>; z-index: 2; }
.author p { margin-top: 0; font-size: 10pt; margin-bottom: 2mm; }
.author p.date { margin-top: 5mm; }
.author p.name { font-size: 20pt; font-weight: bold; }
.author p.company_name { font-size: 16pt; margin-bottom: 3mm; font-weight: bold; }
.author p { line-height: 1.2; }
.route-map { width: 219mm; height: 155mm; display: block;margin: 0 auto;}
.notice { padding-top: 5mm; width: 231mm; }
.half { width: 50%; float: left; }
.notice p { font-size: 6pt; margin: 0; }
table { border-collapse: collapse; }
td.center { text-align: center; }
td.right-align { text-align: right; }
th.building-name { width: 110mm; }
th.building-addr { width: 80mm; }
table.building-profile { border-collapse: collapse; width: <?php print (!isset($_REQUEST['print'])) ? '231mm' : '100%'; ?>;}
table.building-profile th { border-bottom: 1px solid #000; font-size: 11pt; font-weight: normal; padding-top: 8mm; }
table.building-profile td { font-size: 11pt; border-bottom: 1px solid #c9c9c9; line-height: 7mm; height: 7mm; }
caption { background: #e11b30; color: #000; text-transform: uppercase; padding: 1mm 0; font-family: HelveticaNeue-bold; }
.caption { text-align: left; background: none; color: #e11b30; font-weight: bold; border-left: 4px solid #e11b30; padding: 0; text-indent: 2mm; line-height: 1.2; font-size: 9pt; display: inline-block; }
table.single-info td.title {
    font-size: 18pt;
    padding-bottom: 10px;
}
table.building-profile.single-info td { height: auto; line-height: 1.6; border: none; }
table.building-profile.single-info th { border-color: #c9c9c9; }
table.building-profile.single-info td table caption { text-align: left; background: none; color: #e11b30; font-weight: bold; border-left: 4px solid #e11b30; padding: 0; text-indent: 2mm; line-height: 1.2; font-size: 9pt; }
table.current_status {
    border-collapse: collapse;
    table-layout: fixed;
}
table.building-profile.single-info td table th.senko_th {
    width: 14mm;
}
body.en table.building-profile.single-info td table th.senko_th {
    width: 24mm;
}
table.building-profile.single-info td table td, table.building-profile.single-info td table th { font-size: 8pt; line-height: 1; height: 4mm; padding: 0; }
table.building-profile.single-info td table th { padding: 2mm 0 1mm; }
table.building-profile.single-info td table th.calc_type { width: 8mm; }
table.building-profile.single-info td table td.notes { line-height: 1.4; }
td.td_col1_3 { width: 24%; vertical-align: top; }
td.td_col2_3 { width: 76%; }
td.td_col2_3 { padding: 0 0 0 10mm; vertical-align: top; }
td.td_col2_3 table { width: 100%; }
td.td_col1_3 img { width: 100%; }
table.building-profile.single-info td table.current_status tr:nth-child(odd) td { background-color: #ffffff; }
table.building-profile.single-info td table.current_status tr:nth-child(even) td { background-color: #f4f4f4; }
table.building-profile.single-info th { padding-top: 2mm; }
table.building-profile.single-info td table td.total { padding-left: 3mm; }
td.var-top { vertical-align: top; }
table.building-profile.single-info td.space-empty { height: 5mm; }
td.plan-img img { width: 100%; }
table.building-profile.single-info td table.summary td, table.building-profile.single-info td table.summary th { font-size: 8pt; border: none; text-align: left; padding: 0; line-height: 1.6; }
table.building-profile.single-info td table.summary.time-to-use td { font-size: 6pt; line-height: 1; }
table.building-profile.single-info td table td.pad-left { padding-left: 5mm; }
table.building-profile.single-info td table.summary th { width: 21mm; }
table.building-profile.single-info td table.summary caption { margin-bottom: 1mm; }
table.building-details { margin-top: 3mm; }
table.building-profile.single-info td.title { border-top: 5px solid #e11b30; }
table.summary.building-summary, table.summary.contract-info { margin-bottom: 4mm; }
table.summary.time-to-use { margin-bottom: 10mm; }
/*printout ver2*/
td.facility_summary > table.facility-info > tbody > tr > th {
    background: none;
    line-height: 1.2;
    padding: 0 1mm;
    font-weight: normal;
    font-size: 7pt;
    width: 18mm;
    border-bottom: 1px solid #CCC;
	text-align: left;
}
table.building-list { width: 100%; }
table.building-list th { font-size: 5pt; line-height: 1.1; background: #e11b30; padding: 2mm 0; }
table.building-list td { font-size: 7pt; border-right: 1px solid #CCC; line-height: 1.2; }
th.label_1 { width: 8mm; }
th.label_2 { width: 65mm; }
.label_3 { width: 11mm; }
.label_4, .label_5, .label_6, .label_7 { width: 22mm; }
.label_7_1, .label_7_2, .label_7_3, .label_7_4 { width: 15mm; }
.label_8 { width: 20mm; }
th.label_9 { /*width: 55mm;*/ }
th.label_10 { width: 30mm; }
table.building-list td img { max-width: 26mm; margin: 2mm auto; display: block; }
td.build_img img { width: 100%; }
table.building-list td table td { height: 5mm; line-height: 1.2; border: none; padding: 0 1mm; }
table.building-list td.summary_td td { width: 3mm; }
table.building-list td table td.build_name { height: 10.3mm; font-size: 10pt; border-bottom: 1px solid #CCC; }
table.building-list td table td.build_name span.build_no { text-align: right; font-size: 5pt; display: block; }
table.building-list td table td.build_name, table.building-list td table td.build_no { background: #efefef; }
table.building-list td table { width: 100%; }
td.summary_td { padding: 0; vertical-align: top; }
table.building-list td table.lists td { padding: 0; }
td.label_4, td.label_5, td.label_6, td.label_7 { text-align: right; }
td.label_4.center { text-align: center; }
table.lists tr:nth-child(even) td { background-color: #f4f4f4; }
table.lists tr.row_second td, table.building-list td table.lists td.center.label_3 { border-bottom: 1px solid #CCC; }
table.building-list td table.lists td.center.label_3 { border-right: 1px solid #CCC; }
table.building-list td table.facility-info td { border-bottom: 1px solid #CCC; }
th.bdata_title, td.trader_type.owner_type, td.trader_type.window_type {
    border-bottom: 1px solid #e9e9e9;
    line-height: 1.2 !important;
    padding-top: 10px !important;
}
/*table.lists tr:nth-child(odd) td {

    border-bottom: 1px solid #ffffff;

}*/
table.facility-info td.comment-texts { font-size: 5pt !important; height: auto; line-height: 1.4; }
.no-border { border: none !important; }
.building-list tr { border-bottom: 2px solid #CCC; border-left: 1px solid #CCC; }
.building-list tr table tr, .building-list tr.tr-th { border: none; }
.op-wht {
    position: absolute;
    width: 100%;
    height: 80mm;
    bottom: 0;
    background: url(images/wht_07.png) repeat;
}
/*****ver3***********/

.commercial table { width: 100%; }
td.cam_date { width: 24mm; }
th.bo_name { width: 370px; }
th.bo_fee { width: 12mm; }
th.bo_tel1 { width: 58mm;}
th.bo_upd { width: 21mm; }
td.f_emp { width: 20mm; }
td.f_price_m_shiki { width: 7mm; }
td.f_price_t_rent { width: 14mm; }
td.f_price_a_rent { width: 17mm; }
td.f_price_t_mente { width: 13mm; }
td.f_acreg_str { width: 13mm; }
td.f_price_rerent { width: 10mm; }
td.f_price_amo_str, td.f_price_keymoney_str, td.f_oa { width: 11mm; }
td.f_purpose1, td.f_purpose2, td.f_purpose3, td.f_purpose4, td.f_purpose8 { width: 8mm; }
td.f_floor_str { width: 10mm; }
table.f_info { background: #f4f4f4; border-top: 1px solid #CCC; margin-bottom: 5mm; }
section.sheet.commercial table td, section.sheet.commercial table th { font-size: 0.55em; line-height: 1.2; text-align: left; font-weight: normal; padding:2px; height:auto; }
table.bd_data { border-bottom: 1px solid #e11b30; border-top: 3px solid #e11b30; }
table.b_info.br { border-bottom: 1px solid #e9e9e9; }
span.owner_type { border: 1px solid #000; padding: 2px; line-height: 1; display: inline-block; margin-right: 5px; }
section.sheet.commercial table.b_data td, section.sheet.commercial table.b_data th { line-height: 2.1; }
p.last_update { margin: 0; padding: 2px 0; font-size: 7pt; text-align: right; border-top: 1px solid #e9e9e9; border-bottom: 1px solid #e9e9e9; }
table.f_info tr { border-bottom: 1px solid #CCC; }
section.sheet.cover {
    background: url(images/bg_pa_cover.jpg);
    background-size: cover;
    background-position: center;
	padding: 10mm 0;
    width: 297mm;
}
.text-box {
	margin-top:10px;
	margin-left:10px;
	padding-top:15px;
	padding-left:15px;
	padding-right:15px;
    position: absolute;    
    height: 40px;
    text-align: center;    
    background-color: white;
	color: black;
	box-shadow: 10px 10px 5px #888888;
}
.auth-right {
    display: table-cell;
    text-align: right;
    vertical-align: bottom;
    width: 300px;
    margin-left: auto;
}
.auth-left {
    display: table-cell;
    width: auto;
}

/* プレビュー用のスタイル */
@media screen 
{
	<?PHP if(!isset($_REQUEST['print'])) { ?> 
	body {
		background: #eee;
	}
	.sheet_wrapper 
	{
		padding: 0mm 4mm 4mm 4mm;
	}
	.sheet_wrapper:first-child {
		padding-top: 4mm;
	}
	.sheet {
		background: white; /* 背景を白く */
		background: #ffffff;
		box-shadow: 0 .5mm 2mm rgba(0,0,0,.3);
	}
	<?PHP }else{ ?> 
	.sheet_wrapper {width:100%;}
	<?php } ?>
	
	<?php if($requestData['print_type']!=8){?>
	.sheet 
	{ /* ドロップシャドウ */
		/*margin: 0mm;*/
		padding: <?php print (!isset($_REQUEST['print'])) ? '10mm' : '0'; ?>;
		/*width: <?php print (!isset($_REQUEST['print'])) ? '277mm' : '100%'; ?>;*/
		width: <?php print (!isset($_REQUEST['print'])) ? '231mm' : '100%'; ?>;
		height: auto;
		/*min-height: 190mm;*/
	}
	<?php }else {?>
	.sheet {
		padding: <?php print (!isset($_REQUEST['print'])) ? '10mm' : '0'; ?>;
	}
	<?php }?>
}

<?php if($requestData['print_type']!=8){?>
@page { size: A4 landscape; margin: 0mm; }
<?php } else {?>
@page { size: A4; margin: 8mm 15mm 8mm 15mm; }
<?php }?>

@media print 
{	
	.btnMakePdf { display:none;}
	.body { width: /*277mm*/100%; /* needed for Chrome */ }
	.sheet.commercial { height: auto !important; }		
	table tr, img, blockquote {page-break-inside: avoid !important;}
/*   	.sheet{margin:5%;width:90%;height:80%}  */
<?php if($requestData['print_type']!=8){?>
	.sheet{padding:2.5% 0 0 0; margin:5% 3% 0 3%;width:90%;}
<?php }?>
	.sheet.cover{margin:0 !important;}
}	
table tr, img, blockquote {page-break-inside: avoid !important;}
	.btnMakePdf { border: none; background: #e11b30; padding: 10px; margin: 10px 0px 10px 15px; cursor: pointer; font-weight: bold; color: #fff; }
	.spinner { margin: 0 auto; width: 50px; height: 40px; text-align: center; font-size: 10px; }
	.spinner > div { background-color: #e11b30; height: 100%; width: 6px; display: inline-block; -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out; animation: sk-stretchdelay 1.2s infinite ease-in-out; }
	.spinner .rect1 { position: absolute; left: 0; }
	.spinner .rect2 { -webkit-animation-delay: -1.1s; animation-delay: -1.1s; position: absolute; left: 7px; }
	.spinner .rect3 { -webkit-animation-delay: -1.0s; animation-delay: -1.0s; position: absolute; left: 14px; }
	.spinner .rect4 { -webkit-animation-delay: -0.9s; animation-delay: -0.9s; position: absolute; left: 21px; }
	.spinner .rect5 { -webkit-animation-delay: -0.8s; animation-delay: -0.8s; position: absolute; left: 28px; }
	@-webkit-keyframes sk-stretchdelay {
		 0%, 40%, 100% {
			-webkit-transform: scaleY(0.4)
		}
		 20% {
			-webkit-transform: scaleY(1.0)
		}
	}

	@keyframes sk-stretchdelay {
		 0%, 40%, 100% {
		 transform: scaleY(0.4);
		 -webkit-transform: scaleY(0.4);
	}
	20% {
	 transform: scaleY(1.0);
	 -webkit-transform: scaleY(1.0);
	}
}
/*.twoprint .sheet_wrapper .sheet{margin:10px;width:100% !important;}*/
</style>
</head>

<body class="<?php print (isset($_REQUEST['print'])) ? 'twoprint' : ''; ?> <?php echo $language ?>">
<?php if(!isset($_GET['print'])){ ?>
<input type="button" name="makePdf" id="makePdf" class="makePdf btnMakePdf" value="Export PDF" data-url="<?php  if(isset($_SERVER['REQUEST_URI'])) echo $_SERVER['REQUEST_URI']; else echo ""; ?>" data-pdfUrl="<?php echo Yii::app()->createUrl('proposedArticle/newPdf'); ?>" data-id="<?php echo $_GET['hdnProArticleId']; ?>"/>
<div style="width: 35px;height: 32px;position: absolute;top: 10px;left: 125px; display:none;" class="dispLoader">
  <div class="loadTraders" style="position: relative; top:-3px;left:0;">
    <div class="spinner">
      <div class="rect1"></div>
      <div class="rect2"></div>
      <div class="rect3"></div>
      <div class="rect4"></div>
      <div class="rect5"></div>
    </div>
  </div>
</div>
<?php } 
$prosalData = ProposedArticle::model()->findByPK($requestData['hdnProArticleId']);

$arr_zoom = Array();
if(isset($requestData['zoombuilding'])) {
	$zoombuilding = $requestData['zoombuilding'];
	$arr_zoom = explode(',', $zoombuilding);
}
//---------------------type->10-----------------------
if($requestData['print_type'] == 10){
	if(isset($requestData['add_cover']) && $requestData['add_cover'] == 1) {
?>
<div class="sheet_wrapper">
  <section class="sheet cover" style="height: 177mm;background: url(images/bg_pa_cover.jpg);background-size: cover;margin:0 !important;">
    <div class="headtitle-wrapper">
    <h1><?php echo $requestData['header_name']; ?><?php if($requestData['header_name']=='') echo '','オフィスビルご紹介資料' ?></h1>
    
    <!--title of article *editable-->
    
    <!--common sub title-->
    <h4 class="subtitle en"><?php echo Yii::app()->controller->__trans('office building information'); ?></h4>
    <!--common sub title-->
    <div class="client_name">
		<?php
			$prosalData = ProposedArticle::model()->findByPK($requestData['hdnProArticleId']);
			$companyName = Customer::model()->findByPk($prosalData['customer_id']);
			if(trim($companyName['company_name'])!="")
				echo $companyName['company_name']."様";
			
			
			if(isset($_GET['user']))
				$user = $_GET['user'];
			else 
				$user = Yii::app()->user->getId();
			$user = Users::model()->findByAttributes(array('username'=>$user));
			$company_id = $user->company;
			$company = Company::model()->findByPK($company_id);
			
			if(isset($_GET['proposedUsername']))
			{
				$proposedUsername = Users::model()->find('user_id = '.$_GET['proposedUsername']);
				$userDetail = AdminDetails::model()->findByAttributes(array('user_id'=>$proposedUsername->user_id));
				$company['phone'] = $userDetail->contact_number;
				$company['email'] = $userDetail->email;
			}
		?>
    </div>
    <!--client company name-->
    </div>
    <div class="author">
    <div class="auth-left">
    <?php 
     if($company_id==1) {
    ?>
     <img src="images/pa_logo.png" width="230px" height="auto" style="margin-bottom:20px;" />
    <?php 
     } else {
    ?>
      <p class="company_name"><?php echo $company->name; ?></p>
 <?php 
     }
    ?>
      <!--author company name *common-->
      <p class="address"><?php echo $language == 'ja' ? $company->address : $company->address_en; ?></p>      
      <!--author company address *common-->
      <p class="tel"><?php echo $company->phone; ?></p>
      <!--author company tel *common-->
      <p class="email"><?php echo $company->email; ?></p>
      <!--author company email *common-->
      <?php 
	      if(isset($_GET['proposedUsername'])) {
	      	$user = AdminDetails::model()->find('user_id = '.$_GET['proposedUsername']);
	      	echo '<p class="username">' . Yii::app()->controller->__trans('担当者：', 'ja') .$user['full_name'].'</p>';
	      }
	  ?>      
      </div>
      <div class="auth-right">
		<p class="date"><?php echo Yii::app()->controller->__trans('日付', 'ja'); ?>：<?php echo  date('Y.m.d'); ?></p>
      <!--author date to publish --> 
      </div>
      <div class="clear" style="clear:both;"></div>
    </div>
    <div class="op-wht"></div>
  </section>
</div>
<?php } ?>
<?php if(isset($requestData['print_route']) && $requestData['print_route'] == 1 && $language == 'ja') {?>
<div class="client"></div>
<div class="sheet_wrapper">
  <section class="sheet"> <img src="images/new_route_map.jpg" class="route-map"><!--image of route map-->
    
  </section>
</div>
<?php }?>
<!--<td colspan="2" class="title">AAA Building</td><!--one of building name--> 
<!--<td class="td_col1_3"><img src="images/aaa_building.jpg" /></td><!--one of building main image-->
<div class="sheet_wrapper" style="">
  <section class="sheet">
    <table class="building-list" style="page-break-inside: avoid !important;">
      <tr class="tr-th">
        <th class="label_1"> <?php echo Yii::app()->controller->__trans('Map'); ?><br/>
          No. </th>
        <!--fixed texts-->
        <th class="label_2"><?php echo Yii::app()->controller->__trans('ビル概要', 'ja'); ?></th>
        <!--fixed texts-->
        <th class="label_3"><?php echo Yii::app()->controller->__trans('募集階', 'ja'); ?></th>
        <!--fixed texts-->
        <th class="label_4"><?php echo Yii::app()->controller->__trans('面積(坪)', 'ja'); ?><br/>
          (<?php echo Yii::app()->controller->__trans('m'); ?>&sup2;)</th>
        <!--fixed texts-->
        <th class="label_5"><?php echo Yii::app()->controller->__trans('賃料(坪単価)', 'ja'); ?><br/>
          <?php echo Yii::app()->controller->__trans('総額', 'ja'); ?></th>
        <!--fixed texts-->
        <th class="label_6"><?php echo Yii::app()->controller->__trans('共益費(坪単価)', 'ja'); ?><br/>
          <?php echo Yii::app()->controller->__trans('総額', 'ja'); ?></th>
        <!--fixed texts-->
        <th class="label_7"><?php echo Yii::app()->controller->__trans('預託金', 'ja'); ?></th>
        <!--fixed texts-->
        <th class="label_8"><?php echo Yii::app()->controller->__trans('入居可能日', 'ja'); ?></th>
        <!--fixed texts-->
        <th class="label_9"><?php echo Yii::app()->controller->__trans('設備概要', 'ja'); ?></th>
        <!--fixed texts-->
        <th class="label_10"><?php echo Yii::app()->controller->__trans('ビル外観', 'ja'); ?></th>
        <!--fixed texts--> 
      </tr>
      <?php
			if(isset($buildCartDetails) && count($buildCartDetails) > 0){
				$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
				$logged_user_id = $user->user_id;
				$buildingNumber = 1;
				$indexFloor = 0;
				$indexBuildCart = 0;
				foreach($buildCartDetails as $buildCart){
					$indexBuildCart++;
			?>
      <tr>
        <td class="center">No.<?php echo $buildingNumber; ?></td>
        <?php include('_print_summary.php');?>
        <td colspan="6" class="list_floor var-top"><table class="lists">
            <?php
				$floorDetails = Floor::model()->findAll('building_id = '.$buildCart['building_id'] . $glob_where );
				
// 				for ($j=0; $j<20; $j++) {
// 					$floorDetails[] = $floorDetails[0];
// 				}
				$pFloors = $proposedFloors;//explode(',',$prosalData['floor_id']);
				$floorDetailsTmp = $floorDetails;
				foreach($floorDetailsTmp as $floorKey => $floor){
					if(!in_array($floor['floor_id'],$pFloors)){
						unset($floorDetails[$floorKey]);
					}
				}
				
				if (count($floorDetails) < 4)
				{
					for($i=0; $i < 4 ; $i++)
					{
// 						$floorDetails[] = array();
					}
					$countFloor = count($floorDetails);
				}
				$breakFloorDetails = false;
				foreach($floorDetails as $indexFloorPrint => $floorPrintDetail){
					$indexFloor ++;
					
					if (($indexBuildCart == count($buildCartDetails)) && empty($floorPrintDetail))
					{
						break;
					}
					
					if($indexFloor && ($indexFloor % 16 == 0 )) {
						echo '</table></td>';
					    include('_print_facility_summary.php');
						include('_print_type2_bldimg.php');
						echo '</tr></table></section>
						</div>
						<div class="sheet_wrapper">
							<section class="sheet">
								<table class="building-list">
									<tr class="tr-th">
										<th class="label_1">
											'. Yii::app()->controller->__trans("Map") .'<br/>
											No.
										</th><!--fixed texts-->
										<th class="label_2">'.Yii::app()->controller->__trans('ビル概要', 'ja').'</th><!--fixed texts-->
										<th class="label_3">'.Yii::app()->controller->__trans('募集階', 'ja').'</th><!--fixed texts-->
										<th class="label_4">'.Yii::app()->controller->__trans('面積(坪)', 'ja').'<br/>('. Yii::app()->controller->__trans("m") .'&sup2;)</th>
										<!--fixed texts-->
										<th class="label_5">'.Yii::app()->controller->__trans('賃料(坪単価)', 'ja').'<br/>'.Yii::app()->controller->__trans('総額', 'ja').'</th><!--fixed texts-->
										<th class="label_6">'.Yii::app()->controller->__trans('共益費(坪単価)', 'ja').'<br/>'.Yii::app()->controller->__trans('総額', 'ja').'</th><!--fixed texts-->
										<th class="label_7">'.Yii::app()->controller->__trans('預託金', 'ja').'<br/>'.Yii::app()->controller->__trans('総額', 'ja').'</th><!--fixed texts-->
										<th class="label_8">'.Yii::app()->controller->__trans('入居可能日', 'ja').'</th><!--fixed texts-->
										<th class="label_9">'.Yii::app()->controller->__trans('設備概要', 'ja').'</th><!--fixed texts-->
										<th class="label_10">'.Yii::app()->controller->__trans('ビル外観', 'ja').'</th><!--fixed texts-->
									</tr>';
						if (!empty($floorPrintDetail))
						{
							echo '<tr><td class="center">No.'. $buildingNumber .'</td></td>';
							
							include('_print_summary.php');
							echo '<td colspan="6" class="list_floor var-top">
								<table class="lists">';
						}
						
						if (empty($floorPrintDetail))
						{
							$floorPrintDetail = $floorDetails[$countFloor-1];
							$breakFloorDetails = true;
							break;
						}
					}
					
					if (empty($floorPrintDetail)) continue;
					
					$floorId = Floor::model()->findByPk($floorPrintDetail['floor_id']);
			?>
            <tr class="row_fst">
              <td rowspan="2" class="center label_3"><?php
			  	if(isset($floorId['preceding_user']) && $floorId['preceding_user'] != 0){
					echo '<span class="senko">'.Yii::app()->controller->__trans('先行有', 'ja').'</span>';
				}
				if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
					if(strpos($floorId['floor_down'], '-') !== false){
						$floorDown = Yii::app()->controller->__trans("地下", 'ja').' '.str_replace("-", "", $floorId['floor_down']);
					}else{
						$floorDown = $floorId['floor_down'];
					}
					if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
						echo $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階', 'ja');
					}else{
						echo $floorDown.' '.Yii::app()->controller->__trans('階', 'ja');
					}
				}
				if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
					echo '&nbsp;'.$floorId['roomname'];
				}
				?></td>
	              <td class="label_4 center"><?php
				if(isset($floorId['area_ping']) && $floorId['area_ping'] != ""){
					echo $floorId['area_ping']." ".Yii::app()->controller->__trans('坪', 'ja');
				}else{
					echo '-';
				}
				?>
                <?php
					if(isset($floorId['payment_by_installments']) && $floorId['payment_by_installments'] == 1){
						echo Yii::app()->controller->__trans('分割例 :', 'ja');
					}else if(isset($floorId['payment_by_installments']) && $floorId['payment_by_installments'] == 2){
						echo Yii::app()->controller->__trans('分割可 :', 'ja');
					}
				?>
                <?php if(isset($floorId['floor_partition']) && $floorId['floor_partition'] != ""){
					  $expFloorParts = explode(',',$floorId['floor_partition']);
						if(!empty($expFloorParts)){
							foreach($expFloorParts as $part){
								echo $part.Yii::app()->controller->__trans('坪', 'ja').',<br/>';
							}
						}
						
				}
				?>
                <?php
					if(isset($floorId['area_net']) && $floorId['area_net'] != ""){
						echo Yii::app()->controller->__trans('ネット:', 'ja').$floorId['area_net'].Yii::app()->controller->__trans('坪', 'ja');
					}else{
						echo '';
					}
				?></td>
              <td class="label_5"><font><font>
                <?php
					if($floorId['rent_unit_price_opt'] != ''){
						if($floorId['rent_unit_price_opt'] == -1){
							echo Yii::app()->controller->__trans('未定', 'ja');
						}else if($floorId['rent_unit_price_opt'] == -2){
							echo Yii::app()->controller->__trans('相談', 'ja');
						}
					}else{
						echo '-';
					}
				?>
                </font></font> <font><font>
                <?php
					if(isset($floorId['rent_unit_price']) && $floorId['rent_unit_price'] != "" && $floorId['rent_unit_price'] != 0){
						echo Yii::app()->controller->renderPrice($floorId['rent_unit_price'])/*.Yii::app()->controller->__trans('yen / tsubo')*/;
					}else{
						echo '';
					}
				?>
                </font></font></td>
              <td class="label_6"><font><font>
                <?php
					if($floorId['unit_condo_fee'] == ""){
						if($floorId['unit_condo_fee_opt'] != ''){
							if($floorId['unit_condo_fee_opt'] == 0){
								echo Yii::app()->controller->__trans('無し', 'ja');
							}else if($floorId['unit_condo_fee_opt'] == -1){
								echo Yii::app()->controller->__trans('未定', 'ja');
							}else if($floorId['unit_condo_fee_opt'] == -2){
								echo Yii::app()->controller->__trans('相談', 'ja');
							}else if($floorId['unit_condo_fee_opt'] == -3){
								echo Yii::app()->controller->__trans('賃料に込み (含む)', 'ja');
							}
						}else{
							echo '-';
						}
					}
				?>
                </font></font> <font><font>
                <?php
					if(isset($floorId['unit_condo_fee']) && $floorId['unit_condo_fee'] != ""){
						echo Yii::app()->controller->renderPrice($floorId['unit_condo_fee'])/*.Yii::app()->controller->__trans('yen / tsubo')*/;
					}else{
						echo '';
					}
				?>
                </font></font></td>
              <td class="label_7">
               <?php
				if(isset($floorId['rent_unit_price']) && $floorId['rent_unit_price'] != "" && $floorId['rent_unit_price'] != 0){
				?>
                <font><font>
                <?php
					if($floorId['deposit_opt'] != ''){
						echo '<br/>';
						if($floorId['deposit_opt'] == -1){
							echo Yii::app()->controller->__trans('未定', 'ja');
						}else if($floorId['deposit_opt'] == -3){
							echo Yii::app()->controller->__trans('無し', 'ja');
						}else if($floorId['deposit_opt'] == -2){
							echo Yii::app()->controller->__trans('相談', 'ja');
						}
					}
					if(isset($floorId['deposit_month']) &&  $floorId['deposit_month'] != ''){
						echo $floorId['deposit_month'].Yii::app()->controller->__trans('ヶ月', 'ja');
					}
				?>
                </font></font><br>
                <font><font>
                <?php
// 					if(isset($floorId['deposit']) && $floorId['deposit'] != ""){
// 						echo Yii::app()->controller->renderPrice($floorId['deposit'])/*.Yii::app()->controller->__trans('yen / tsubo')*/;
// 					}else{
// 						echo '';
// 					}
				?>
                </font></font>
                <?php
				}
				?>
				</td>
              <td class="label_8 center">
              <?php  echo HelperFunctions::translateBuildingValue('move_in_date', $buildCart, $floorId); ?>
			</td>
            </tr>
            <tr class="row_second">
              <td class="label_4 center"><?php echo $floorId['area_m'] != "" && $floorId['area_m'] != 0 ? $floorId['area_m'].'m&sup2;' : '-'; ?></td>
              <!--area of space by meter-->
              <td class="label_5">
              <?php 
	              if(isset($floorId['total_rent_price']) && $floorId['total_rent_price'] != ""){
	              	echo Yii::app()->controller->renderPrice($floorId['total_rent_price']).Yii::app()->controller->__trans('円', 'ja');
	              }else if($floorId['rent_unit_price_opt']==-1 || $floorId['rent_unit_price_opt']==-2) {
	              	$rentNegotiationDetails = RentNegotiation::model()->findAll('building_id = '.$buildCart["building_id"].' AND allocate_floor_id='.$floorId['floor_id'].' order by rent_negotiation_id desc LIMIT 1');
	              	$rentNegotiationDetails = $rentNegotiationDetails[0];
	              	$rentNegotiationValue = HelperFunctions::translateBuildingValue('negotiation', $buildCart, $floorId);
	              	
	              	if($rentNegotiationDetails['negotiation_type']==1) {
	              		echo Yii::app()->controller->__trans('low price').': '.$rentNegotiationValue.Yii::app()->controller->__trans('円', 'ja')  . ' ' . Yii::app()->controller->__trans($rentNegotiationDetails['negotiation_range'], 'ja');
	              	} else if($rentNegotiationDetails['negotiation_type']==5) {
	              		echo Yii::app()->controller->__trans('目安値', 'ja').': '.$rentNegotiationValue.Yii::app()->controller->__trans('円', 'ja')  . ' ' . Yii::app()->controller->__trans($rentNegotiationDetails['negotiation_range'], 'ja');
	              	} else{
	              		echo Yii::app()->controller->__trans('目安値', 'ja').': '.$rentNegotiationValue.Yii::app()->controller->__trans('円', 'ja') . ' ' . Yii::app()->controller->__trans($rentNegotiationDetails['negotiation_range'], 'ja');
	              	}
	              }
	              else{
	              	echo '-';
	              }              
              ?>
              </td>
              <!--total rent fee-->
              <td class="label_6"><?php echo $floorId['total_condo_fee'] != "" && $floorId['total_condo_fee'] != 0 ? Yii::app()->controller->renderPrice($floorId['total_condo_fee'])/*.'円'*/ : '-'; ?></td>
              <!--total condo fee-->
              <td class="label_7"><?php /*echo $floorId['total_deposit'] != "" && $floorId['total_deposit'] != 0 ? Yii::app()->controller->renderPrice($floorId['total_deposit'])/*.'円'*/ /*: '-'; */?></td>
              <!--total deposit-->
              <td class="label_8 center"></td>
              <!--always blank--> 
            </tr>
            <?php
				}
			?>
        <?php 
        echo '</table></td>';
        if (!$breakFloorDetails) {
	        include('_print_facility_summary.php');
	        include('_print_type2_bldimg.php');
        }
        ?>
        
      </tr>
      <?php
				$buildingNumber++;
				$array[] = $buildCart['map_lat'].','.$buildCart['map_long'];
				$buildNameArray[] = ($language == 'ja' ? $buildCart['name'] : $buildCart['name_en']);
				}
			}
			?>
    </table>
  </section>
</div>
<?php
	if(isset($requestData['print_each_building']) && $requestData['print_each_building'] == 1){
		if(isset($buildCartDetails) && count($buildCartDetails) > 0){
			$buildingNumber = 0;
			foreach($buildCartDetails as $buildCart){
				$buildingNumber++;
				$address = HelperFunctions::translateBuildingValue('address', $buildCart);
				$lat = $buildCart['map_lat'];
				$lng = $buildCart['map_long'];
				$zoom = isset($arr_zoom[$buildingNumber-1])?$arr_zoom[$buildingNumber-1]:16;
	?>
<div class="sheet_wrapper">
  <section class="sheet"> <?php echo '<span class="build_title">'.$buildingNumber.'.'. ($language == 'ja' ? $buildCart['name'] : $buildCart['name_en'])."<span>"; 
//($buildCart['bill_check']==1?'':' ビル').
  ?><br>
	<iframe id="map_<?=$buildingNumber?>" name="map_<?=$buildingNumber?>" src="http://office-jpdb.com/buildingmap.php?key=<?=$gApiKey?>&lat=<?=$lat?>&lng=<?=$lng?>&zoom=<?=$zoom?>&print_language=<?php echo $language?>" style="width:277mm;height:179mm;"></iframe>
<!-- <img style="width: 277mm; height:180mm" src = "https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $address;?>&zoom=15.5&scale=2&size=640x480&maptype=roadmap&markers=color:red%7C<?php echo $lat.','.$lng?>&key=<?php echo $gApiKey;?>" /> -->
  </section>
</div>
<?php
			}
		}
	}
}
?>
<?php
//-------------------print_type->8----------------
if($requestData['print_type']==8){
	if(isset($buildCartDetails) && count($buildCartDetails) > 0){
		//$proposedFloors = array();
		$proposedDetails = ProposedArticle::model()->findByPk($requestData['hdnProArticleId']);
		//$proposedFloors = explode(',',$proposedDetails['floor_id']);
		
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;
		
		if(isset($requestData['add_cover']) && $requestData['add_cover'] == 1) {
?>
<div class="sheet_wrapper">
  <section class="sheet cover" style="height: 177mm;">
    <div class="headtitle-wrapper">
    <h1><?php echo $requestData['header_name']; ?><?php if($requestData['header_name']=='') echo '',Yii::app()->controller->__trans('オフィスビルご紹介資料', 'ja') ?></h1>
    <h4 class="subtitle en"><?php echo Yii::app()->controller->__trans('office building information'); ?></h4>
    <!--common sub title-->
    <div class="client_name">
      <?php
		$prosalData = ProposedArticle::model()->findByPK($requestData['hdnProArticleId']);
        $companyName = Customer::model()->findByPk($prosalData['customer_id']);
        if(trim($companyName['company_name'])!="") {
        	echo $companyName['company_name'].Yii::app()->controller->__trans('様', 'ja');
        }
        
		if(isset($_GET['user']))
			$user = $_GET['user'];
		else 
			$user = Yii::app()->user->getId();
		
		$user = Users::model()->findByAttributes(array('username'=>$user));

        $company_id = $user->company;
        $company = Company::model()->findByPK($company_id);
        
        if(isset($_GET['proposedUsername']))
        {
        	$proposedUsername = Users::model()->find('user_id = '.$_GET['proposedUsername']);
        	$userDetail = AdminDetails::model()->findByAttributes(array('user_id'=>$proposedUsername->user_id));
        	$company['phone'] = $userDetail->contact_number;
        	$company['email'] = $userDetail->email;
        }
      ?>
    </div>
    <!--client company name-->
    </div>
    <div class="author">
    <div class="auth-left">
      <?php 
     if($company_id==1) {
    ?>
     <img src="images/pa_logo.png" width="230px" height="auto" style="margin-bottom:20px;" />
    <?php 
     } else {
    ?>
      <p class="company_name"><?php echo $company->name; ?></p>
 <?php 
     }
    ?>
      <!--author company name *common-->
      <p class="address"><?php echo $language == 'ja' ? $company->address : $company->address_en; ?></p>
      <!--author company address *common-->     
      <p class="tel"><?php echo $company->phone; ?></p>
      <!--author company tel *common-->
      <p class="email"><?php echo $company->email; ?></p>
      <!--author company email *common-->
      <?php 
	      if(isset($_GET['proposedUsername'])) {
	      	$user = AdminDetails::model()->find('user_id = '.$_GET['proposedUsername']);
	      	echo '<p class="username">'.Yii::app()->controller->__trans('担当者', 'ja').' : '.$user['full_name'].'</p>';
	      }
	  ?>      
      </div>
      <div class="auth-right">
      <p class="date">
        <?php echo Yii::app()->controller->__trans('日付', 'ja'); ?>：<?php  echo  date('Y.m.d'); ?>
      </p>
      <!--author date to publish --> 
      </div>
      <div class="clear" style="clear:both;"></div>
    </div>
    <div class="op-wht"></div>
  </section>
</div>
<?php
		}
		if(isset($requestData['print_route']) && $requestData['print_route'] == 1 && $language == 'ja') {
		?>
<div class="sheet_wrapper">
  <section class="sheet"> <img src="images/new_route_map.jpg" class="route-map"><!--image of route map-->
    
  </section>
</div>
<?php
        } ?>
<div class="sheet_wrapper">
	<input type="hidden" id="total_bulidings" value="<?= count($buildCartDetails)?>">
<?php         
		$buildingNumber = 1;
		$count=0;
		$prv=0;
		foreach($buildCartDetails as $buildCart){
			$count++;
		?>
        <?php
         if($count>1){
            $margin= "25px !important";
         }
         else{
              $margin= "0";
         	}
         if($prv == $count){
         	$count = $count+1;
         }
		?>

        
  <section class="sheet commercial" id='sheet_commercial_<?=$count ?>' style="padding:25px;  margin-top:<?= $margin ?>">
  	<?php $prv=$count;?>
    <table class="bd_data">
      <tbody>
        <tr>
          <td class="b_no"><span style=""><?php echo $buildCart['buildingId']; ?></span></td>
          <td class="b_nm"><?php echo $buildingNumber.'.'. ($language == 'ja' ? $buildCart['name'] : $buildCart['name_en']);
          //.($buildCart['bill_check']?"":" ビル"); ?></td>
          <td class="b_address"><?php echo HelperFunctions::translateBuildingValue('address', $buildCart); ?></td>
        </tr>
      </tbody>
    </table>
    <table class="b_info br">
      <tbody>
        <tr>
          <td class="b_build_str"><?php echo HelperFunctions::translateBuildingValue('built_year', $buildCart); ?></td>
          <td class="st_data station">
          <?PHP
   $nearestSt = BuildingStation::model()->getNearestStations($buildCart['building_id']);
   if(isset($nearestSt) && count($nearestSt) > 0){
    foreach($nearestSt as $nStation){
     if(isset($nStation['name']) && isset($nStation['time'])){
      echo $nStation['name'].Yii::app()->controller->__trans('駅', 'ja').$nStation['time'].Yii::app()->controller->__trans('分', 'ja').$break;
   break;
     }
    }
   }
   ?>
          </td>
          <td class="b_scale_str">
          <?php
          	$typeDetails = ConstructionType::model()->findByPk($buildCart['construction_type_id']);
            echo $typeDetails['construction_type_name'];
          ?></td>
          <td class="f_oa"></td>
          <td class="f_lightline_str">
          <?php echo Yii::app()->controller->__trans('光', 'ja');?>：
          <?php
				if($buildCart['opticle_cable'] == 0){
					echo Yii::app()->controller->__trans('不明', 'ja');
				}else if($buildCart['opticle_cable'] == 1){
					echo Yii::app()->controller->__trans('引き込み有', 'ja');
				}else if($buildCart['opticle_cable'] == 2){
					echo Yii::app()->controller->__trans('無し', 'ja');
				}else{
					echo '-';
				}
			?></td>
          <!--electonic cable value-->
          <td class="f_air">
          <?php echo Yii::app()->controller->__trans('空調', 'ja');?>：
          <?php
//					if($buildCart['air_control_type'] == 0){
//						echo Yii::app()->controller->__trans('不明');
//					}else if($buildCart['air_control_type'] == 2){
//						echo Yii::app()->controller->__trans('Individual control');
//					}else if($buildCart['air_control_type'] == 1){
//						echo Yii::app()->controller->__trans('Zone control');
//					}
					$fDetails = Floor::model()->findAll('building_id = '.$buildCart['building_id']. $glob_where );
					$pFloors = $proposedFloors;
					$fDetailsTmp = (array)$floorDetails;
					foreach($fDetailsTmp as $floorKey => $floor){
						if(!in_array($floor['floor_id'],$pFloors)){
							unset($fDetails[$floorKey]);
						}
					}
					
					$res = Array(0=>'', 1=>'', 2=>'', 3=>'', 4=>'');
					foreach($fDetails as $floor){
						if($floor['air_conditioning_facility_type']=="個別・セントラル") $res[0]=Yii::app()->controller->__trans('個別・セントラル', 'ja');
						if($floor['air_conditioning_facility_type']=="個別") $res[1]=Yii::app()->controller->__trans('個別', 'ja');
						if($floor['air_conditioning_facility_type']=="セントラル") $res[2]=Yii::app()->controller->__trans('セントラル', 'ja');
						if($floor['air_conditioning_facility_type']=="不明" || $floor['air_conditioning_facility_type']=="unknown") $res[3]=Yii::app()->controller->__trans('不明', 'ja');
						if($floor['air_conditioning_facility_type']=="無し") $res[4]=Yii::app()->controller->__trans('無し', 'ja');
					}
					
					$result = '-';
					foreach($res AS $row) {
						if($row!=''){
							$result=$row;
							break;
						}
					}
					
					echo $result;
				?></td>
          <!--air condition facility value-->
          <td class="b_usetime">24H</td>
          <!--use of time value-->
          <td class="b_ev_num">
          EV
          <?php
			$elevatorExp = explode('-',$buildCart['elevator']);
            if($elevatorExp[0] == 1){
            	echo '有';
				if($elevatorExp[1] != "" || $elevatorExp[2] != "" || $elevatorExp[3] != "" || $elevatorExp[4] != "" || $elevatorExp[5] != "") echo '(';
					echo isset($elevatorExp[1]) && $elevatorExp[1] != "" ? $elevatorExp[1].Yii::app()->controller->__trans('基', 'ja') : "";
					//echo isset($elevatorExp[2]) && $elevatorExp[2] != "" ? '/'.$elevatorExp[2].Yii::app()->controller->__trans('人乗', 'ja') : "";
					//echo isset($elevatorExp[3]) && $elevatorExp[3] != "" ? $elevatorExp[3].Yii::app()->controller->__trans('基・人荷用', 'ja') : "";
					//echo isset($elevatorExp[4]) && $elevatorExp[4] != "" ? $elevatorExp[4].Yii::app()->controller->__trans('人乗', 'ja') : "";
					//echo isset($elevatorExp[5]) && $elevatorExp[5] != "" ? $elevatorExp[5].Yii::app()->controller->__trans('基', 'ja') : "";
					if($elevatorExp[1] != "" || $elevatorExp[2] != "" || $elevatorExp[3] != "" || $elevatorExp[4] != "" || $elevatorExp[5] != "") echo ')';
                }else if($elevatorExp[0] == -2){
                	echo '不明';
                }else if($elevatorExp[0] == 2){
                	echo '無';
                }else{
                	echo '-';
                }
          ?></td>
          <!--elevetor value-->
          <td class="b_parking_num">
          P<?php
          	$parkingUnitNo = explode('-',$buildCart['parking_unit_no']);
			if($parkingUnitNo[0] == 1){
				echo Yii::app()->controller->__trans('有', 'ja').($parkingUnitNo[1] != "" ? '('.$parkingUnitNo[1].' '.Yii::app()->controller->__trans('台', 'ja').')' : "");
			}else if($parkingUnitNo[0] == 2){
				echo Yii::app()->controller->__trans('無', 'ja');
			}else if($parkingUnitNo[0] == 3){
				echo Yii::app()->controller->__trans('有るが台数不明', 'ja');
			}
		  ?></td>
          <!--parking value--> 
          
          <!-- Building Note-->
          <td>
          	<?php echo $buildCart['notes']?>
          </td>
          <!-- Building Note End-->
          
        </tr>
      </tbody>
    </table>
    <?php 
    $negotiationDetails = RentNegotiation::model()->findAll('building_id = '.$buildCart['building_id'].' order by rent_negotiation_id desc');
    echo HelperFunctions::generateTableNegotiation($negotiationDetails, array('no_button' => 1, 'header' => 1));
    if ($_GET['hdnProArticleId'])
    {
    	$all_fllors=HelperFunctions::floor_array(HelperFunctions::buildQuery('proposed', $_GET['hdnProArticleId']), $buildCart['building_id']);
    }
    else {
    	$all_fllors=HelperFunctions::floor_array(HelperFunctions::buildQuery('cart'), $buildCart['building_id']);
    }
    if(!empty($all_fllors['comparted_array'])){
    	foreach ($all_fllors['comparted_array'] as $floorDetails_allfloor) {
    		include 'table_print.php';
    	}
   	 
    }
    if(!empty($all_fllors['multi_window_array'])){
    	//echo "<pre>";
    	//var_dump($all_fllors['multi_window_array']);
    	//die();
    	foreach ($all_fllors['multi_window_array'] as $floorDetails_allfloor) {
    		include 'table_print.php';
    	}
   	 
    }
    if(!empty($all_fllors['single_owner_window_array'])){
    	foreach ($all_fllors['single_owner_window_array'] as $floorDetails_allfloor) {
    		include 'table_print.php';
    	}
   	 
    }
    if(!empty($all_fllors['multi_owner_array'])){
    	foreach ($all_fllors['multi_owner_array'] as $floorDetails_allfloor) {
    		include 'table_print.php';
    	}
   	 
    }
    if(!empty($all_fllors['no_owner_window'])){
   	 include 'table_print2.php';
    }
    ?>
    
    <p class="last_update"><!--label--><?php echo Yii::app()->controller->__trans('ビル情報最終更新', 'ja'); ?>：<!--/label--> 
      <?php echo $buildCart['modified_on']; ?><!--latest updated date of building info--> 
    </p>
    <!--history of updated things-->
    <?php
		$addedOnArray = array();
		$transmissionMattersDetails = TransmissionMatters::model()->findAll('building_id = '.$buildCart['building_id']);
		
			?>
	
			<table class="camp_info">
				<tbody>
				<?php
				        if(isset($transmissionMattersDetails) && count($transmissionMattersDetails) > 0){
				            foreach($transmissionMattersDetails as $list){ 
				        ?>
				        <tr>
				            <td class="cam_date">
				                <?php
				                $days = array('月'=>'Mon','火'=>'Tue','水'=>'Wed','木'=>'Thu','金'=>'Fri','土'=>'Sat','日'=>'Sun');
				                $day = array_search((date('D',strtotime($list['added_on']))), $days);
				                echo date('Y.m.d',strtotime($list['added_on']));
				                ?>
				                (<?php echo $day; ?>)
				            </td>
				            <td>
				                <?php
				                echo (strlen($list['note']) > 28 ? mb_substr($list['note'], 0, 28,'UTF-8').' ...' : $list['note']); ?>
				            </td>
				        </tr>
				        <?php
				            $i++;
				            }
				        }
				        ?>
				    </tbody>
			</table>
  </section>
<?php
			$buildingNumber++;
        	$array[] = $buildCart['map_lat'].','.$buildCart['map_long'];
			$buildNameArray[] = $buildCart['name'];
		} ?>
		</div>
		<?php 
        if(isset($requestData['print_each_building']) && $requestData['print_each_building'] == 1){
			if(isset($buildCartDetails) && count($buildCartDetails) > 0){
				$buildingNumber = 0;
				foreach($buildCartDetails as $buildCart){
					$buildingNumber++;
					$address = HelperFunctions::translateBuildingValue('address', $buildCart);
					$lat = $buildCart['map_lat'];
					$lng = $buildCart['map_long'];
					$zoom = isset($arr_zoom[$buildingNumber-1])?$arr_zoom[$buildingNumber-1]:16;
		?>
<div class="sheet_wrapper">
  <section class="sheet"> <?php //echo '<span class="build_title">'.$buildingNumber.'.'.$buildCart['name']."</span>"; ?>
	<iframe id="map_<?=$buildingNumber?>" name="map_<?=$buildingNumber?>" src="http://office-jpdb.com/buildingmap.php?key=<?=$gApiKey?>&lat=<?=$lat?>&lng=<?=$lng?>&zoom=<?=$zoom?>" style="width:277mm;height:179mm;"></iframe>	
  </section>
</div>
<?php
        		}
			}
		}
	}
}
?>
<?php
//-------------------print_type->11---------------------
if($requestData['print_type'] == 11){
	if(isset($requestData['add_cover']) && $requestData['add_cover'] == 1) {
	?>
<div class="sheet_wrapper">
  <section class="sheet cover" style="height: 177mm;">
    <div class="headtitle-wrapper">
    <!--client company name-->
    <h1><?php echo $requestData['header_name']; ?><?php if($requestData['header_name']=='') echo '',Yii::app()->controller->__trans('オフィスビルご紹介資料', 'ja') ?></h1>
    <!--title of article *editable-->
    <!--common sub title-->
    <h4 class="subtitle en"><?php echo Yii::app()->controller->__trans('office building information'); ?></h4>
    <!--common sub title-->
    <div class="client_name">
      <?php
      if(isset($requestData['hdnProArticleId'])) {
	      $prosalData = ProposedArticle::model()->findByPK($requestData['hdnProArticleId']);
	      $companyName = Customer::model()->findByPk($prosalData['customer_id']);
	      if(trim($companyName['company_name'])!="")
	      {
	      	if ($language == 'ja')
	      	{
	      		echo $companyName['company_name'].Yii::app()->controller->__trans('様', 'ja');
	      	}
	      	else {
	      		echo 'Dear ' . $companyName['company_name'];
	      	}
	      }
      }
      
	if(isset($_GET['user']))
	  $user = $_GET['user'];
	else 
	  $user = Yii::app()->user->getId();
	
	$user = Users::model()->findByAttributes(array('username'=>$user));
    $company = $proposedCompany;
    if(isset($_GET['proposedUsername']))
    {
    	$proposedUsername = Users::model()->find('user_id = '.$_GET['proposedUsername']);
    	$userDetail = AdminDetails::model()->findByAttributes(array('user_id'=>$proposedUsername->user_id));
    	$company['phone'] = $userDetail->contact_number;
    	$company['email'] = $userDetail->email;
    }
      ?>
    </div>
    </div>
    <div class="author">
    <div class="auth-left">
      <?php 
     if($company_id==1) {
    ?>
     <img src="http://office-jpdb.com/images/pa_logo.png" width="230px" height="auto" style="margin-bottom:20px;" />
    <?php 
     } else {
     	if($company['company_logo'] && $company['company_logo'] != "company_logo/") :
    ?>
    <img class="company_name" src="<?php echo Yii::app()->baseUrl.$company['company_logo']?>" width="auto" height="26px" />
    <br/>
    	<?php else : ?>
      <p class="company_name"><?php echo $company['name']; // echo $company->name; ?></p>

      <?php endif; ?>

 <?php 
     }
    ?>

      <p class="address"><?php echo $language == 'ja' ? $company['address'] : $company['address_en']; ?></p>
      
      <p class="tel"><?php echo $company['phone'];  ?></p>
      
      <p class="email"><?php echo $company['email'];   ?></p>
      
      <?php 
	      if(isset($_GET['proposedUsername'])) {
	      	$user = AdminDetails::model()->find('user_id = '.$_GET['proposedUsername']);
	      	echo '<p class="username">'.Yii::app()->controller->__trans('担当者', 'ja').': '.$user['full_name'].'</p>';
	      }
	  ?>   
      </div>
      <div class="auth-right">
      <p class="date">
        <?php echo Yii::app()->controller->__trans('日付', 'ja'); ?>：<?php  echo  date('Y.m.d'); ?>
      </p>
      <!--author date to publish --> 
      </div>
      <div class="clear" style="clear:both;"></div>
    </div>
    <div class="op-wht"></div>
  </section>
</div>
<?php
	}
	if(isset($requestData['print_route']) && $requestData['print_route'] == 1 && $language == 'ja'){
	?>
<div class="sheet_wrapper">
  <section class="sheet"> <img src="images/new_route_map.jpg" class="route-map"><!--image of route map--></section>
</div>
<?php
	}
	?>
<div class="sheet_wrapper">
  <section class="sheet">
    <table class="building-profile">
      <caption>
      <?php echo Yii::app()->controller->__trans('office building profile'); ?>
      </caption>
      <tr>
        <th class="center">No</th>
        <th class="building-name"><?php echo Yii::app()->controller->__trans('ビル名', 'ja'); ?></th>
        <th class="building-addr"><?php echo Yii::app()->controller->__trans('所在地', 'ja'); ?></th>
        <th class="est-date"><?php echo Yii::app()->controller->__trans('竣工', 'ja'); ?></th>
        <th class="floor-space"><?php echo Yii::app()->controller->__trans('延床面積', 'ja'); ?></th>
        <th class="floor-construction"><?php echo Yii::app()->controller->__trans('構造', 'ja'); ?></th>
      </tr>
      <tr>
        <?php
        if(isset($buildCartDetails) && count($buildCartDetails) > 0){
        	$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
        	$logged_user_id = $user->user_id;
        	$buildingNumber = 1;
        	foreach($buildCartDetails as $buildCart){
        ?>
        <td class="center"><?php echo $buildingNumber; ?></td>
        <td class="center"><?php echo ($language == 'ja' ? $buildCart['name'] : $buildCart['name_en']); 
        //if($buildCart['bill_check']==0) echo " ビル";?></td>
        <td class="center"><?php  echo HelperFunctions::translateBuildingValue('address', $buildCart); ?></td>
        <td class="center establish_th"><?php echo HelperFunctions::translateBuildingValue('built_year', $buildCart); ?></td>
        <td class="center"><?php echo $buildCart['total_floor_space'] != "" ? $buildCart['total_floor_space'].'m&sup2;' : "-"; ?></td>
        <?php /*?><td class="center"><?php echo $buildCart['total_floor_space'] != "" ? $buildCart['total_floor_space'].'坪' : "-"; ?></td><?php */?>
        <td class="center const_th">
        <?php
        /*$typeDetails = ConstructionType::model()->findByPk($buildCart['construction_type_id']);
        echo $typeDetails['construction_type_name'];*/
				$typeDetails = ConstructionType::model()->findByPk($buildCart['construction_type_id']);
                                                            echo $typeDetails['construction_type_name'] !='' ? Yii::app()->controller->__trans($typeDetails['construction_type_name'], 'ja') : '-';
        ?></td>
      </tr>
      <?php
		      $array[] = $buildCart['map_lat'].','.$buildCart['map_long'];
		      $buildNameArray[] = ($language == 'ja' ? $buildCart['name'] : $buildCart['name_en']);
		      $buildingNumber++;
	      }
      }
      ?>
    </table>
    <div class="notice clearfix">
      <div class="half left">
        <p><?php echo Yii::app()->controller->__trans('※契約面積・金額が㎡表示の物件は坪に換算しています。(坪換算値=3.30578)。', 'ja'); ?></p>
        <!--fixed texts-->
        <p><?php echo Yii::app()->controller->__trans('※賃貸条件や建物設備は変更する可能性があります。正式正確な内容につきましては重要事項説明書をもってご説明致します。', 'ja'); ?></p>
        <!--fixed texts-->
        <p><?php echo Yii::app()->controller->__trans('※ご紹介致しました物件が既に商談又は決定済みの際はご了承の程お願い申し上げます。', 'ja'); ?></p>
        <!--fixed texts-->
        <p><?php echo Yii::app()->controller->__trans('※賃料等課税対象となる金額には別途消費税が加算されます。', 'ja'); ?></p>
        <!--fixed texts--> 
      </div>
      <div class="half right">
       <p><?php echo Yii::app()->controller->__trans('※目安値及び底値は想定される共益費込の坪単価で表示されております。契約坪単価を保証するものではございませんので、予めご了承ください。', 'ja'); ?></p>
        <!--fixed texts--> 
        <p><?php echo Yii::app()->controller->__trans('※契約が成立した場合仲介手数料として賃料の１カ月分を申し受けます。', 'ja'); ?></p>
        <!--fixed texts--> 
      </div>
    </div>
  </section>
</div>
<?php
	if(isset($buildCartDetails) && count($buildCartDetails) > 0){
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;
		$buildingNumber = 1;
		foreach($buildCartDetails as $buildCart){
			$floorDetails = Floor::model()->findAll('building_id = '.$buildCart['building_id']. $glob_where );
			$pFloors = $proposedFloors;//explode(',',$prosalData['floor_id']);
			$floorDetailsTmp = $floorDetails;
			foreach($floorDetailsTmp as $floorKey => $floor){
				if(!in_array($floor['floor_id'],$pFloors)){
					unset($floorDetails[$floorKey]);
				}
			}
			
			$iNoSenko = 0;
			$bHasSenko = true;
			foreach($floorDetails as $indexFloor => $floor){
				$floorId = Floor::model()->findByPk($floor['floor_id']);
				if(!isset($floorId['preceding_user']) || $floorId['preceding_user'] == 0){
					$iNoSenko ++;
				}
				
				if (count($floorDetails) == $iNoSenko)
				{
					$bHasSenko = false;
				}
			}
			
			$sum_arem = 0;
			$sum_are_net = 0;
			if(count($floorDetails) <= 9 || true){
			?>
<div class="sheet_wrapper">
  <section class="sheet">
    <table class="building-profile single-info">
      <tr>
        <td colspan="2" class="title"><?php echo $buildingNumber.'-'. ($language == 'ja' ? $buildCart['name'] : $buildCart['name_en']); 
        //if($buildCart['bill_check']==0) echo " ビル";?></td>
      </tr>
      <tr>
        <?php
	        $buildPics = BuildingPictures::model()->find('building_id = '.$buildCart['building_id']);
	        $main_img = $buildPics['main_image'];
	        if($main_img != ""){
	        	$buildPics = 'front/'.$main_img;
	        }else{
	        	$buildPics = explode(',',$buildPics['front_images']);
	        	$buildPics = 'front/'.$buildPics[0];
	        }
	        
	        if($buildPics == "front/"){
	        	$buildPics = 'noimg_building.png';
	        }
        ?>
        <td rowspan="2" class="td_col1_3">
        <img src="<?php echo Yii::app()->baseUrl.'/buildingPictures/'.$buildPics; ?>"/>
        
        <?php
        	if (count($floorDetails) > 1)
        	{
        		// Show Plan from article field
        		$plan_id = $buildCart['plan_standard_id'];
        	}
        	else {
        		// Show Plan for current floor
        		$floorDetail = reset($floorDetails);
        		$plan_id = $floorDetail->plan_picture_id;
        	}
        	$planPictureDetails = PlanPicture::model()->findAll('plan_picture_id = ' . (int)$plan_id);
        	if ( isset($planPictureDetails) && count($planPictureDetails) > 0 )
        	{
        		$planName = $planPictureDetails[0]->name;
        	}
        	else
        	{
        		$planName = 'no_plan.jpg';
        	}
			?>
			<?php //if ( isset($planPictureDetails) && count($planPictureDetails) > 0 ) { ?>
			<div style="padding-top:15px" class="plan-img"><img src="<?php echo Yii::app()->baseUrl.'/planPictures/'.$planName; ?>" /></div>
			<?php //} else { ?>
			<?php //} ?>
          
        </td>
        <td class="td_col2_3">
        <table class="current_status">
            <span class="caption"><?php echo Yii::app()->controller->__trans('募集状況', 'ja'); ?></span>
            <tr>
            	<?php if ($bHasSenko) {?>
				<th class="senko_th senko_<?php echo $buildCart['building_id']?>"></th>
				<?php }?>
              <th class="stairs"><?php echo Yii::app()->controller->__trans('階数', 'ja'); ?></th>
              <th colspan="2"><?php echo Yii::app()->controller->__trans('面積', 'ja'); ?></th>
              <th class="calc_type"></th>
              <th><?php echo Yii::app()->controller->__trans('預託金', 'ja'); ?></th>
              <th><?php echo Yii::app()->controller->__trans('賃料', 'ja'); ?></th>
              <th><?php echo Yii::app()->controller->__trans('共益費', 'ja'); ?></th>
              <th><?php echo Yii::app()->controller->__trans('入居予定日/備考', 'ja'); ?></th>
            </tr>
            <?php
// 				$pFloors = explode(',',$prosalData['floor_id']);
            	$pFloors = $proposedFloors;
            	$aRentPrice = array();
				foreach($floorDetails as $indexFloor => $floor){
					$aRentPrice[$floor['rent_unit_price_opt']] = isset($aRentPrice[$floor['rent_unit_price_opt']]) ? $aRentPrice[$floor['rent_unit_price_opt']] : 0;
					$aRentPrice[$floor['rent_unit_price_opt']]++;
                	$floorId = Floor::model()->findByPk($floor['floor_id']);
                    if($indexFloor && $indexFloor<=20 && ($indexFloor % 19 == 0 || ($indexFloor > 20 && $indexFloor % 20 == 11))) {
                    	echo '</table></td></tr></table></section></div>
							<div class="sheet_wrapper">
								<section class="sheet">
									<table class="building-profile single-info">
										<tr>
											<td colspan="2" class="title"></td>
							            </tr>
										<tr>
											<td class="td_col1_3">
							            </td>
							             <td class="td_col2_3">
							             	<table class="current_status" style="margin-top: 10px">
												<span class="caption">'. Yii::app()->controller->__trans("募集状況", 'ja').'</span>
		                                        <tr>';
												echo $bHasSenko ? '<th class="senko_th senko_'.$buildCart['building_id'].'"></th>' : '';
		                                            echo '<th class="stairs">'. Yii::app()->controller->__trans("階数", 'ja').'</th>
		                                            <th colspan="2">'. Yii::app()->controller->__trans("面積", 'ja').'('. Yii::app()->controller->__trans("ネット", 'ja').')</th>
													<th class="calc_type"></th>
		                                            <th>'. Yii::app()->controller->__trans("預託金", 'ja').'</th>
		                                            <th>'. Yii::app()->controller->__trans("賃料", 'ja').'</th>
		                                            <th>'. Yii::app()->controller->__trans("共益費", 'ja').'</th>
		                                            <th>'. Yii::app()->controller->__trans("入居予定日/備考", 'ja').'</th>
		                                        </tr>';
					}
            ?>
            <tr>
            	<?php if ($bHasSenko) {?>
				<td class="senko_td center senko_<?php echo $buildCart['building_id']?>">
					<?php
					if(isset($floorId['preceding_user']) && $floorId['preceding_user'] != 0){
						echo '<span class="senko">'.Yii::app()->controller->__trans('先行有', 'ja').'</span>';
					}
					?>
				</td>
				<?php }?>
              <td class="stairs center">
			  	<?php
				
				
				if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
					if(strpos($floorId['floor_down'], '-') !== false){
						$floorDown = Yii::app()->controller->__trans("地下", 'ja').' '.str_replace("-", "", $floorId['floor_down']);
					}else{
						$floorDown = $floorId['floor_down'];
					}
					if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
						echo $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階', 'ja');
					}else{
						echo $floorDown.' '.Yii::app()->controller->__trans('階', 'ja');
					}
				}
				if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
					echo '&nbsp;'.$floorId['roomname'];
				}
				?></td>
              <td class="space center"><font> <font>
                <?php
                                                        if(isset($floorId['area_ping']) && $floorId['area_ping'] != ""){
                                                            echo $floorId['area_ping']." ".Yii::app()->controller->__trans('坪', 'ja');
                                                        }else{
                                                            echo '-';
                                                        }echo "<br/>";
                                                        ?>
                <?php
                                                            if(isset($floorId['payment_by_installments']) && $floorId['payment_by_installments'] == 1){
                                                                echo Yii::app()->controller->__trans('分割例', 'ja').' :';
                                                            }else if(isset($floorId['payment_by_installments']) && $floorDetails['payment_by_installments'] == 2){
                                                                echo Yii::app()->controller->__trans('分割可', 'ja').' :';
                                                            }
                                                        ?>
                <?php if(isset($floorId['floor_partition']) && $floorId['floor_partition'] != ""){
                                                              $expFloorParts = explode(',',$floorId['floor_partition']);
                                                                if(!empty($expFloorParts)){
                                                                    foreach($expFloorParts as $part){
                                                                        echo $part.Yii::app()->controller->__trans('坪', 'ja').','.'<br/>';
                                                                    }
                                                                }
                                                                
                                                        }
                                                        ?>
                </font> </font></td>
              <td class="space center"><font> <font>
                <?php
                                                    if(isset($floorId['area_m']) && $floorId['area_m'] != ""){
                                                        echo $floorId['area_m']." ".Yii::app()->controller->__trans('m&sup2;');
                                                    }else{
                                                        echo '-';
                                                    }
                                                    ?>
                </font> </font> <font> <font>
                <?php
                                                    if(isset($floorId['area_net']) && $floorId['area_net'] != ""){
                                                        echo Yii::app()->controller->__trans('ネット', 'ja').": ".$floorId['area_net'].Yii::app()->controller->__trans('坪', 'ja');
                                                    }else{
                                                        echo '';
                                                    }
                                                    ?>
                </font> </font></td>
              <td class="center">
              <?php 
              	if((int)$floorId['calculation_method']==1) echo "N";
              	else if((int)$floorId['calculation_method']==2) echo "G";
              ?>
              </td>  
              <td class="deposit center"><font><font>
                <?php
                                                        if(isset($floorId['deposit']) && $floorId['deposit'] != "" && $floorId['deposit'] != 0){
//                                                         	if(isset($floorId['rent_unit_price_opt']) && ($floorId['rent_unit_price_opt'] == -1 || $floorId['rent_unit_price_opt'] == -2)) {
//                                                         		echo $floorId['deposit_month'].Yii::app()->controller->__trans('month');
//                                                         	}else 
                                                        	{
// 																echo Yii::app()->controller->renderPrice($floorId['deposit']).Yii::app()->controller->__trans('yen / tsubo');
                                                        	}
                                                        }else{
//                                                         	if(isset($floorId['rent_unit_price_opt']) && ($floorId['rent_unit_price_opt'] == -1 || $floorId['rent_unit_price_opt'] == -2)) {
//                                                         		if(isset($floorId['deposit_month']) && $floorId['deposit_month'] != "" && $floorId['deposit_month'] != 0)
//                                                         			echo $floorId['deposit_month'].Yii::app()->controller->__trans('month');
//                                                         	}else
//                                                             	echo '';
                                                        }
														if($floorId['deposit_opt'] != ''){
															if($floorId['deposit_opt'] == -1){
																echo Yii::app()->controller->__trans('未定', 'ja');
															}else if($floorId['deposit_opt'] == -3){
																echo Yii::app()->controller->__trans('無し', 'ja');
															}else if($floorId['deposit_opt'] == -2){
																echo Yii::app()->controller->__trans('相談', 'ja');
															}
														}
														
														if(isset($floorId['deposit_month']) &&  $floorId['deposit_month'] != ''){
															echo $floorId['deposit_month'].Yii::app()->controller->__trans('ヶ月', 'ja');
														}														
                                                    ?>
                </font></font></td>
              <td class="rent-fee center"><font><font>
                <?php
                                                        if(isset($floorId['rent_unit_price']) && $floorId['rent_unit_price'] != "" && $floorId['rent_unit_price'] != 0){
                                                            echo Yii::app()->controller->renderPrice($floorId['rent_unit_price']).Yii::app()->controller->__trans('円 / 坪', 'ja');
                                                        }else{
                                                            echo '';
                                                        }
														if($floorId['rent_unit_price_opt'] != ''){
															if($floorId['rent_unit_price_opt'] == -1){
																echo Yii::app()->controller->__trans('未定', 'ja');
															}else if($floorId['rent_unit_price_opt'] == -2){
																if ($language == 'ja')
																{
																	echo Yii::app()->controller->__trans('相談', 'ja');
																}
																else {
																	echo Yii::app()->controller->__trans('POA', 'ja');
																}
															}
														}else{
															echo '';
														}
                                                    ?>
                </font></font></td>
              <td class="condo-fee center"><font><font>
                <?php
                                                        if(isset($floorId['unit_condo_fee']) && $floorId['unit_condo_fee'] != ""){
                                                            echo Yii::app()->controller->renderPrice($floorId['unit_condo_fee']).Yii::app()->controller->__trans('円 / 坪', 'ja');
                                                        }else{
                                                            if($floorId['unit_condo_fee_opt'] != ''){
																if($floorId['unit_condo_fee_opt'] == 0){
																	echo Yii::app()->controller->__trans('無し', 'ja');
																}else if($floorId['unit_condo_fee_opt'] == -1){
																	echo Yii::app()->controller->__trans('未定', 'ja');
																}else if($floorId['unit_condo_fee_opt'] == -2){
																	echo Yii::app()->controller->__trans('相談', 'ja');
																}else if($floorId['unit_condo_fee_opt'] == -3){
																	echo Yii::app()->controller->__trans('賃料に込み (含む)', 'ja');
																}
															}else{
																echo '-';
															}
                                                        }
                                                    ?>
                </font></font></td>
              <td class="date-move center">
              	<?php  echo HelperFunctions::translateBuildingValue('move_in_date', $buildCart, $floorId); ?>
			</td>
              <?php $sum_arem += $floorId['area_ping']; ?>
              <?php $sum_are_net += $floorId['area_m']; ?>
            </tr>
            <tr>
            	<?php if ($bHasSenko) {?>
				<td class="senko_td center senko_<?php echo $buildCart['building_id']?>"></td>
				<?php }?>
              <td class="stairs center"></td>
              <td class="space center"></td>
              <td class="space center"></td>
              <td class="space center"></td>
              <td class="deposit center"><font><font>
                <?php/*
                                                        if(isset($floorId['total_deposit']) && $floorId['total_deposit'] != "0" && $floorId['total_deposit'] != ""){
                                                            echo Yii::app()->controller->renderPrice($floorId['total_deposit']).' 円';
                                                        }else{
															echo '';
														}*/
                                                    ?>
                </font></font></td>
              <td class="rent-fee center"><font><font>
                <?php
				                                        if(isset($floorId['total_rent_price']) && $floorId['total_rent_price'] != ""){
                                                            echo Yii::app()->controller->renderPrice($floorId['total_rent_price']).Yii::app()->controller->__trans('円', 'ja');
                                                        }else if($floorId['rent_unit_price_opt']==-1 || $floorId['rent_unit_price_opt']==-2) { 
                                                        	
                                                        	$rentNegotiationDetails = RentNegotiation::model()->findAll('building_id = '.$buildCart["building_id"].' AND allocate_floor_id='.$floorId['floor_id'].' order by rent_negotiation_id desc LIMIT 1');
                                                        	$rentNegotiationDetails = $rentNegotiationDetails[0];
                                                        	$rentNegotiationValue = HelperFunctions::translateBuildingValue('negotiation', $buildCart, $floorId);
                                                        	
                                                        	if($rentNegotiationDetails['negotiation_type']==1) {
                                                        		echo Yii::app()->controller->__trans('low price').': '.$rentNegotiationValue.Yii::app()->controller->__trans('円', 'ja')  . ' ' . Yii::app()->controller->__trans($rentNegotiationDetails['negotiation_range'], 'ja');
                                                        	} else if($rentNegotiationDetails['negotiation_type']==5) {
                                                        		echo Yii::app()->controller->__trans('目安値', 'ja').': '.$rentNegotiationValue.Yii::app()->controller->__trans('円', 'ja') . ' ' . Yii::app()->controller->__trans($rentNegotiationDetails['negotiation_range'], 'ja');
                                                        	} else{
                                                        		echo Yii::app()->controller->__trans('目安値', 'ja').': '.$rentNegotiationValue.Yii::app()->controller->__trans('円', 'ja') . ' ' . Yii::app()->controller->__trans($rentNegotiationDetails['negotiation_range'], 'ja');
                                                        	}
                                                        }
                                                        else{
                                                            echo '-';
                                                        }
                                                    ?>
                </font></font></td>
              <td class="condo-fee center"><font><font>
                <?php
                                                        if(isset($floorId['total_condo_fee']) && $floorId['total_condo_fee'] != ""){
                                                            echo Yii::app()->controller->renderPrice($floorId['total_condo_fee']).Yii::app()->controller->__trans('円', 'ja');
                                                        }else{
                                                            
                                                        }
                                                    ?>
                </font></font></td>
              <td class="date-move center"></td>
            </tr>
            <?php
                                        }
                                        ?>
            <!--blank cell *if there are 3 floors that you choose-->
            <?php for($i=0; $i< 15 - (count($floorDetails) * 2) - 1; $i++) {?>
            <tr>
            	<?php if ($bHasSenko) {?>
				<td class="senko_td center senko_<?php echo $buildCart['building_id']?>"></td>
				<?php }?>
              <td class="stairs center"></td>
              <td class="space center"></td>
              <td class="space center"></td>
              <td class="space center"></td>
              <td class="deposit center"></td>
              <td class="rent-fee center"></td>
              <td class="condo-fee center"></td>
              <td class="date-move center"></td>
            </tr>
            <?php }?>
            <tr>
              <td class="total" <? if ($bHasSenko) { echo 'colspan="2"'; }?>><?php echo Yii::app()->controller->__trans('計', 'ja'); ?></td>
              <td class="space center"><?php echo $sum_arem; ?><?php echo Yii::app()->controller->__trans('坪', 'ja'); ?></td>
              <td class="space center"><?php echo $sum_are_net; ?><?php echo Yii::app()->controller->__trans('m'); ?>&sup2;</td>
              <td class="space center"></td>
              <td class="deposit center"></td>
              <td class="rent-fee center"></td>
              <td class="condo-fee center"></td>
              <td class="date-move center"></td>
            </tr>
            
            
           <?php 
           if ($aRentPrice[-2] != count($floorDetails)) {?>
            <tr>
              <td class="right-align notes" colspan="8"><?php echo Yii::app()->controller->__trans('上段：坪単価 下段：総額', 'ja'); ?><br/>
                <?php echo Yii::app()->controller->__trans('賃料等課税対象となる金額には別途消費税が加算されます', 'ja'); ?></td>
            </tr>
            <?php }?>
          </table></td>
      </tr>
      
      <?php 
                        if (count($floorDetails) > 13 && count($floorDetails) <= 19) {
                        	echo '</table></section></div>
									<div class="sheet_wrapper">
									<section class="sheet manyfloors">
									<table class="building-profile single-info casemore">
									
									';
                        }?>
                        <tr>
							<? if (count($floorDetails) > 19) { ?>
                        <td class="td_col1_3"></td>
						<? } ?>
                        
      
									
      
        <td class="var-top td_col2_3 details"><table class="building-details">
            <tr>
              <td class="var-top"><table class="summary building-summary">
                  <span class="caption"><?php echo Yii::app()->controller->__trans('ビル概要', 'ja'); ?></span>
                  <tr>
                    <th><?php echo Yii::app()->controller->__trans('所在地', 'ja'); ?></th>
                    <td><?php  echo HelperFunctions::translateBuildingValue('address', $buildCart); ?>
                  </tr>
                  <tr>
                    <th><?php echo Yii::app()->controller->__trans('交通', 'ja'); ?></th>
                    <td>
                    	<?php  echo HelperFunctions::translateBuildingValue('station_access', $buildCart); ?>
                    </td>
                  </tr>
                  <tr>
                    <th><?php echo Yii::app()->controller->__trans('竣工年月', 'ja'); ?></th>
                    <td><?php  echo HelperFunctions::translateBuildingValue('built_year', $buildCart); ?>
                    </td>
                  </tr>
                  <tr>
                    <th><?php echo Yii::app()->controller->__trans('規模', 'ja'); ?></th>
                    <td><?php
                                                        	if(isset($buildCart['floor_scale']) && $buildCart['floor_scale'] != ""){
																$scaleExp = explode('-',$buildCart['floor_scale']);
																$floorGround = $scaleExp[0];
																$floorUnderGround = $scaleExp[1];
																if($floorGround != "" && $floorUnderGround != ""){
																	echo $floorGround.'F/B'.$floorUnderGround;
																}else{
																	if($floorGround != ""){
																		echo $floorGround.'F';	
																	}elseif($floorUnderGround != ""){
																		echo 'B'.$floorUnderGround;
																	}else{
																		echo '-';
																	}
																}
															}else{
																echo '-';
															}
														?></td>
                  </tr>
                  <tr>
                    <th><?php echo Yii::app()->controller->__trans('リニューアル', 'ja'); ?></th>
                    <td>
                    <?php  echo HelperFunctions::translateBuildingValue('renewal_data', $buildCart); ?>
                  </tr>
                  <tr>
                    <th><?php echo Yii::app()->controller->__trans('構造', 'ja'); ?></th>
                    <td><?php
                                                            $typeDetails = ConstructionType::model()->findByPk($buildCart['construction_type_id']);
                                                            echo $typeDetails['construction_type_name'] !='' ? Yii::app()->controller->__trans($typeDetails['construction_type_name'], 'ja') : '-';
                                                        ?></td>
                  </tr>
                  <tr>
                    <th><?php echo Yii::app()->controller->__trans('延床面積', 'ja'); ?></th>
                    <td><?php echo $buildCart['total_floor_space'] != "" ? $buildCart['total_floor_space'].' m&sup2;' : "-"; ?></td>
                  </tr>
                  <tr>
                    <th><?php echo Yii::app()->controller->__trans('基準階面積', 'ja'); ?></th>
                    <td><?php echo $buildCart['std_floor_space'] != "" ? $buildCart['std_floor_space'].Yii::app()->controller->__trans('坪', 'ja') : "-"; ?></td>
                  </tr>
                  <tr>
                    <th><?php echo Yii::app()->controller->__trans('共用率', 'ja'); ?></th>
                    <td><?php echo $buildCart['shared_rate'] != "" ? $buildCart['shared_rate'].'%' : "-"; ?></td>
                  </tr>
                </table>
                <table class="summary facility-summary">
                  <span class="caption"><?php echo Yii::app()->controller->__trans('設備概要', 'ja'); ?></span>
                  <tr>
                    <th><?php echo Yii::app()->controller->__trans('空調制御', 'ja'); ?></th>
                    <td><?php
		                    $fDetails = Floor::model()->findAll('building_id = '.$buildCart['building_id']. $glob_where );
		                    $pFloors = $proposedFloors;
		                    $fDetailsTmp = $floorDetails;
		                    foreach($fDetailsTmp as $floorKey => $floor){
		                    	if(!in_array($floor['floor_id'],$pFloors)){
		                    		unset($fDetails[$floorKey]);
		                    	}
		                    }
		                    
		                    $res = Array(0=>'', 1=>'', 2=>'', 3=>'', 4=>'');
		                    foreach($fDetails as $floor){
		                    	if($floor['air_conditioning_facility_type']=="個別・セントラル") $res[0]=Yii::app()->controller->__trans('個別・セントラル', 'ja');
		                    	if($floor['air_conditioning_facility_type']=="個別") $res[1]=Yii::app()->controller->__trans('個別', 'ja');
		                    	if($floor['air_conditioning_facility_type']=="セントラル") $res[2]=Yii::app()->controller->__trans('セントラル', 'ja');
		                    	if($floor['air_conditioning_facility_type']=="不明" || $floor['air_conditioning_facility_type']=="unknown") $res[3]=Yii::app()->controller->__trans('不明', 'ja');
		                    	if($floor['air_conditioning_facility_type']=="無し") $res[4]=Yii::app()->controller->__trans('無し', 'ja');
		                    }
		                    
		                    $result = '-';
		                    foreach($res AS $row) {
		                    	if($row!=''){
		                    		$result=$row;
		                    		break;
		                    	}
		                    }
		                    
		                    echo $result;
                    
//                                                             if($buildCart['air_control_type'] == 0){
//                                                                 echo Yii::app()->controller->__trans('不明');
//                                                             }else if($buildCart['air_control_type'] == 2){
//                                                                 echo Yii::app()->controller->__trans('Individual control');
//                                                             }else if($buildCart['air_control_type'] == 1){
//                                                                 echo Yii::app()->controller->__trans('Zone control');
//                                                             }
                                                        ?></td>
                  </tr>
                  <tr>
                    <th><?php echo Yii::app()->controller->__trans('天井高', 'ja'); ?></th>
                    <td><?php 
                    $res = Array();
                    foreach($fDetails as $floor){
                    	$res[] = intval($floor['ceiling_height']);
                    }
                    rsort($res);
                    echo ($res[0] != 0? $res[0].'mm' : "-");
//                     echo '基準階：'.($buildCart['ceiling_height'] != "" ? $buildCart['ceiling_height'].'mm' : "-"); 
                    ?></td>
                  </tr>
                  <tr>
                    <th><?php echo Yii::app()->controller->__trans('OAフロア', 'ja'); ?></th>
                    <td><?php
                                                            $floorOAList = Floor::model()->findAll('building_id = '.$buildCart['building_id']. $glob_where);
                                                            $oaDefaultArrayOriginal = array(Yii::app()->controller->__trans('フリーアクセス', 'ja'),Yii::app()->controller->__trans('3WAY'),Yii::app()->controller->__trans('2WAY'),Yii::app()->controller->__trans('1WAY'),Yii::app()->controller->__trans('引き込み可', 'ja'),Yii::app()->controller->__trans('1WAY'),Yii::app()->controller->__trans('非対応', 'ja'));
                                                            $oaDefaultArray = array('フリーアクセス','3WAY','2WAY','1WAY','引き込み可','非対応');
															$oaFloor = array();
															$oaHeight = array();
                                                            foreach($floorOAList as $floorOA){
                                                                $oaFloor[] = $floorOA['oa_type'];
                                                                $oaHeight[] = $floorOA['oa_height'];
                                                            }
                                                            
                                                            $break = true;
                                                            for($i=0;$i<count($oaFloor);$i++) {
                                                            	if(in_array($oaFloor[$i],$oaDefaultArray)){
                                                            		if (strpos($oaFloor[$i], 'WAY') !== false)
                                                            		{
                                                            			echo Yii::app()->controller->__trans($oaFloor[$i]);
                                                            		}
                                                            		else {
                                                            			echo Yii::app()->controller->__trans($oaFloor[$i], 'ja') . ' - ';
                                                            		}
                                                            		if($oaHeight[$i]!="" || (int)$oaHeight[$i]!=0) {
                                                            			echo Yii::app()->controller->__trans('フリアク高', 'ja').":".$oaHeight[$i]."mm";
                                                            		}
                                                            		$break = false;
                                                            		break;
                                                            	}
                                                            }
                                                            if($break) echo '-';/*
                                                            foreach($oaDefaultArray as $oa){
                                                                if(in_array($oa,$oaFloor)){
                                                                    echo $oa;
                                                                    break;
                                                                }
                                                            } */
                                                            /*if(isset( $buildCart['oa_floor']) &&  $buildCart['oa_floor'] != ''){
                                                                $oaExplode = explode('-',$buildCart['oa_floor']);
                                                                if($oaExplode[0] == 0){
                                                                    echo Yii::app()->controller->__trans('不明');
                                                                }else if($oaExplode[0] == 2){
                                                                    echo $oaExplode[1] != "" ? $oaExplode[1].'mm' : "-";
                                                                }else if($oaExplode[0] == 1){
                                                                    echo Yii::app()->controller->__trans('無');
                                                                }else {
                                                                    echo '-';
                                                                }
                                                            }*/
                                                        ?></td>
                  </tr>
                  <tr>
                    <th><?php echo Yii::app()->controller->__trans('セキュリティ', 'ja'); ?></th>
                    <td><?php
                                                            $securityDetails = Security::model()->findByPk($buildCart['security_id']);
                                                            echo $securityDetails['security_name']!=''?Yii::app()->controller->__trans($securityDetails['security_name'], 'ja'):'-';
                                                        ?></td>
                  </tr>
                  <tr>
                    <th><?php echo Yii::app()->controller->__trans('光ケーブル', 'ja'); ?></th>
                    <td><?php
                                                            if($buildCart['opticle_cable'] == 0){
                                                                echo Yii::app()->controller->__trans('不明', 'ja');
                                                            }else if($buildCart['opticle_cable'] == 1){
                                                                echo Yii::app()->controller->__trans('引き込み有', 'ja');
                                                            }else if($buildCart['opticle_cable'] == 2){
                                                                echo Yii::app()->controller->__trans('無', 'ja');
                                                            }else{
                                                                echo '-';
                                                            }
                                                        ?></td>
                  </tr>
                  <tr>
                    <th><?php echo Yii::app()->controller->__trans('エレベーター', 'ja'); ?></th>
                    <td><?php
                                                            if(isset($buildCart['elevator']) && $buildCart['elevator'] != ''){
                                                                if(strlen($buildCart['elevator']) > 2){
                                                                    $elevatorExp = explode('-',$buildCart['elevator']);
                                                                    if($elevatorExp[0] == 1){
                                                                        echo Yii::app()->controller->__trans('有り', 'ja');
																		if($elevatorExp[1] != "" || $elevatorExp[2] != "" || $elevatorExp[3] != "" || $elevatorExp[4] != "" || $elevatorExp[5] != "") echo '(';
																		
																		echo isset($elevatorExp[1]) && $elevatorExp[1] != "" ? $elevatorExp[1].Yii::app()->controller->__trans('基', 'ja') : "";
																		//echo isset($elevatorExp[2]) && $elevatorExp[2] != "" ? '/'.$elevatorExp[2].Yii::app()->controller->__trans('人乗', 'ja') : "";
																		//echo isset($elevatorExp[3]) && $elevatorExp[3] != "" ? $elevatorExp[3].Yii::app()->controller->__trans('基・人荷用', 'ja') : "";
																		//echo isset($elevatorExp[4]) && $elevatorExp[4] != "" ? $elevatorExp[4].Yii::app()->controller->__trans('人乗', 'ja') : "";
																		//echo isset($elevatorExp[5]) && $elevatorExp[5] != "" ? $elevatorExp[5].Yii::app()->controller->__trans('基', 'ja') : "";
																		if($elevatorExp[1] != "" || $elevatorExp[2] != "" || $elevatorExp[3] != "" || $elevatorExp[4] != "" || $elevatorExp[5] != "") echo ')';
                                                                    }else{
                                                                        echo '-';
                                                                    }
                                                                }else{
                                                                    if($buildCart['elevator'] == -2){
                                                                        echo Yii::app()->controller->__trans('不明', 'ja');
                                                                    }else if($buildCart['elevator'] == 2){
                                                                        echo Yii::app()->controller->__trans('無し', 'ja');
                                                                    }
                                                                }
                                                            }else{
                                                                echo '-';
                                                            }
                                                        ?></td>
                  </tr>
                  <tr>
                    <th><?php echo Yii::app()->controller->__trans('駐車場', 'ja'); ?></th>
                    <td><?php
                                                            if(isset($buildCart['parking_unit_no']) && count($buildCart['parking_unit_no']) > 0){
                                                                $parkingUnitNo = explode('-',$buildCart['parking_unit_no']);
                                                                if($parkingUnitNo[0] == 1){
                                                                   echo Yii::app()->controller->__trans('exist').($parkingUnitNo[1] != "" ? '('.$parkingUnitNo[1].' '.Yii::app()->controller->__trans('台', 'ja').')' : "");
                                                                }else if($parkingUnitNo[0] == 2){
                                                                    echo Yii::app()->controller->__trans('無', 'ja');
                                                                }else if($parkingUnitNo[0] == 3){
//                                                                     echo Yii::app()->controller->__trans('exist but unknown unit number');
                                                                	echo Yii::app()->controller->__trans('有', 'ja');
                                                                }else echo '-';
                                                            } else echo '-';
                                                        ?></td>
                  </tr>
                </table></td>
              <td class="pad-left var-top">
              	<table class="summary contract-info">
					<?php
                    	$contractArray = $renewalArray = $renewalFeeMonthArray = $keymoneyArray = $keyMoneyMonthArray = $amortizationArray = $repaymentMonthArray = array();
						$fName = $renewalDetails = $renewalOpt = $keyMoneyDetails =  $keyMoneyOpt = $amortizationDetails = $repaymentOpt = '';
						$contractPeriodOptChk = '';
						foreach($floorDetails as $floor){
							if($floorId['renewal_fee_opt'] != 0){
								$renewalArray[$floor['floor_id']] = $floorId['renewal_fee_opt'];
							}
							$renewalFeeMonthArray[$floor['floor_id']] = $floorId['renewal_fee_recent'];
							if($floorId['key_money_opt'] != 0){
								$keymoneyArray[$floor['floor_id']] = $floorId['key_money_opt'];
							}
							$keyMoneyMonthArray[$floor['floor_id']] = $floorId['key_money_month'];
							if($floorId['repayment_opt'] != 0){
								$amortizationArray[$floor['floor_id']] = $floorId['repayment_opt'];
							}
							$repaymentMonthArray[$floor['floor_id']] = $floorId['repayment_amt'];
                            if((isset($floorId['repayment_amt_opt'])) && ($floorId['repayment_amt_opt'] != 0)){
                                $repaymentAmtOptArray[$floor['floor_id']]=$floorId['repayment_amt_opt'];
                            }
                            if(isset($floorId['contract_period_optchk']) && $floorId['contract_period_optchk'] == 1){
                            	$contractPeriodOptChk =  Yii::app()->controller->__trans('年数相談', 'ja');
                            }
						}
                        //print_r($amortizationArray); echo "<br/><br/>END";
						$renewalArray = array_unique($renewalArray);
						$keymoneyArray = array_unique($keymoneyArray);
						$amortizationArray = array_unique($amortizationArray);
						
						$renewalFeeMonthArray = array_unique($renewalFeeMonthArray);
						$keyMoneyMonthArray = array_unique($keyMoneyMonthArray);
                        //Emphes
                        $MaxOccAmt = (count($repaymentMonthArray)>0) ? array_search(max(array_count_values($repaymentMonthArray)), array_count_values($repaymentMonthArray)) : '';
                        $MaxOccUnit = (count($repaymentAmtOptArray)>0) ? array_search(max(array_count_values($repaymentAmtOptArray)), array_count_values($repaymentAmtOptArray)) : '';
                        if(isset($repaymentAmtOptArray[array_search($MaxOccAmt,$repaymentMonthArray)])){
                            $MaxOccUnit = $repaymentAmtOptArray[array_search($MaxOccAmt,$repaymentMonthArray)];
                        }
                        //print_r($repaymentMonthArray); echo "<br/><br/>----";
                        //print_r($repaymentAmtOptArray);
                        //echo "Count ".@array_count_values($repaymentAmtOptArray)."<br/>";
                        //Emphes
						$repaymentMonthArray = array_unique($repaymentMonthArray);
                        
                        //echo $MaxOccAmt.'-'.$MaxOccUnit.'</br>';
						
						$k = 0;
						if(count($renewalArray) > 0){
							foreach($renewalArray as $key=>$val){
								if($k == count($renewalArray)-1){
									$slsh = '';
								}else{
									$slsh = '/';
								}
								$floorId = Floor::model()->findByPk($key);
								if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
									if(strpos($floorId['floor_down'], '-') !== false){
										$floorDown = Yii::app()->controller->__trans("地下", 'ja').' '.str_replace("-", "", $floorId['floor_down']);
									}else{
										$floorDown = $floorId['floor_down'];
									}
									if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
										$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階', 'ja');
									}else{
										$fName =  $floorDown.' '.Yii::app()->controller->__trans('階', 'ja');
									}
								}
								if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
									$fName .= '&nbsp;'.$floorId['roomname'];
								}
								if($val != 0 && $val != ""){
									if($val == 2){
										$renewalOpt = Yii::app()->controller->__trans('無し', 'ja');
									}else if($val == -1){
										$renewalOpt = Yii::app()->controller->__trans('不明', 'ja');
									}else if($val == -2){
										$renewalOpt = Yii::app()->controller->__trans('未定', 'ja');
									}
									$renewalDetails .= $renewalOpt.(count($renewalArray) > 2 ? '('.$fName.')'.$slsh : '');
								}
								$k++;
							}
						}else{
							foreach($renewalFeeMonthArray as $key=>$val){
								if($k == count($renewalFeeMonthArray)-1){
									$slsh = '';
								}else{
									$slsh = '/';
								}
								$floorId = Floor::model()->findByPk($key);
								if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
									if(strpos($floorId['floor_down'], '-') !== false){
										$floorDown = Yii::app()->controller->__trans("地下", 'ja').' '.str_replace("-", "", $floorId['floor_down']);
									}else{
										$floorDown = $floorId['floor_down'];
									}
									if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
										$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階', 'ja');
									}else{
										$fName =  $floorDown.' '.Yii::app()->controller->__trans('階', 'ja');
									}
								}
								if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
									$fName .= '&nbsp;'.$floorId['roomname'];
								}
								$renewalDetails .= $val.(count($renewalFeeMonthArray) > 2 ? '('.$fName.')'.$slsh : '');
								$k++;
							}
							if($renewalDetails!="")
								$renewalDetails .= Yii::app()->controller->__trans('ヶ月', 'ja');;
						}
						$j = 0;
						if(count($keymoneyArray) > 0){
							foreach($keymoneyArray as $key=>$val){
								if($j == count($keymoneyArray)-1){
									$slsh = '';
								}else{
									$slsh = '/';
								}
								$floorId = Floor::model()->findByPk($key);
								if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
									if(strpos($floorId['floor_down'], '-') !== false){
										$floorDown = Yii::app()->controller->__trans("地下", 'ja').' '.str_replace("-", "", $floorId['floor_down']);
									}else{
										$floorDown = $floorId['floor_down'];
									}
									if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
										$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階', 'ja');
									}else{
										$fName =  $floorDown.' '.Yii::app()->controller->__trans('階', 'ja');
									}
								}
								if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
									$fName .= '&nbsp;'.$floorId['roomname'];
								}
								if($val != 0 && $val != ""){
									if($val == 2){
										$keyMoneyOpt = Yii::app()->controller->__trans('無し', 'ja');
									}else if($val == -1){
										$keyMoneyOpt = Yii::app()->controller->__trans('不明', 'ja');
									}else if($val == -2){
										$keyMoneyOpt = Yii::app()->controller->__trans('未定', 'ja');
									}
									$keyMoneyDetails .= $keyMoneyOpt.(count($keymoneyArray) > 2 ? '('.$fName.')'.$slsh : '');
								}
								$j++;
							}
						}else{
							foreach($keyMoneyMonthArray as $key=>$val){
								if($j == count($keyMoneyMonthArray)-1){
															$slsh = '';
														}else{
															$slsh = '/';
														}
														$floorId = Floor::model()->findByPk($key);
														if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
															if(strpos($floorId['floor_down'], '-') !== false){
																$floorDown = Yii::app()->controller->__trans("地下", 'ja').' '.str_replace("-", "", $floorId['floor_down']);
															}else{
																$floorDown = $floorId['floor_down'];
															}									
															if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
																$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階', 'ja');
															}else{
																$fName =  $floorDown.' '.Yii::app()->controller->__trans('階', 'ja');
															}
														}
														
														if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
															$fName .= '&nbsp;'.$floorId['roomname'];
														}
														$keyMoneyDetails .= ($val!=''?$val.'ヶ月':'').(count($keyMoneyMonthArray) > 2 ? '('.$fName.')'.$slsh : '');
														$j++;
													}
												}
												
												$z = 0;
												if(count($amortizationArray) > 0){
													foreach($amortizationArray as $key=>$val){
														if($z == count($amortizationArray)-1){
															$slsh = '';
														}else{
															$slsh = '/';
														}
														$floorId = Floor::model()->findByPk($key);
														if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
															if(strpos($floorId['floor_down'], '-') !== false){
																$floorDown = Yii::app()->controller->__trans("地下", 'ja').' '.str_replace("-", "", $floorId['floor_down']);
															}else{
																$floorDown = $floorId['floor_down'];
															}									
															if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
																$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階', 'ja');
															}else{
																$fName =  $floorDown.' '.Yii::app()->controller->__trans('階', 'ja');
															}
														}
														
														if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
															$fName .= '&nbsp;'.$floorId['roomname'];
														}
														if($val != 0 && $val != ""){
															if($val == -3){
																$repaymentOpt = Yii::app()->controller->__trans('無し', 'ja');
															}else if($val == -4){
																$repaymentOpt = Yii::app()->controller->__trans('不明', 'ja');
															}else if($val == -1){
																$repaymentOpt = Yii::app()->controller->__trans('未定', 'ja');
															}else if($val == -2){
																$repaymentOpt = Yii::app()->controller->__trans('相談', 'ja');
															}else if($val == -5){
																$repaymentOpt = Yii::app()->controller->__trans('スライド式', 'ja');
															}
															$amortizationDetails .= $repaymentOpt.(count($amortizationArray) > 2 ? '('.$fName.')'.$slsh : '');
														}
														$z++;
													}
												}else{
													foreach($repaymentMonthArray as $key=>$val){
														if($z == count($repaymentMonthArray)-1){
															$slsh = '';
														}else{
															$slsh = '/';
														}
														$floorId = Floor::model()->findByPk($key);
														if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
															if(strpos($floorId['floor_down'], '-') !== false){
																$floorDown = Yii::app()->controller->__trans("地下", 'ja').' '.str_replace("-", "", $floorId['floor_down']);
															}else{
																$floorDown = $floorId['floor_down'];
															}									
															if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
																$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階', 'ja');
															}else{
																$fName =  $floorDown.' '.Yii::app()->controller->__trans('階', 'ja');
															}
														}
														
														if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
															$fName .= '&nbsp;'.$floorId['roomname'];
														}
														$amortizationDetails .= ($val != "" ? $val : "").(count($repaymentMonthArray) > 2 ? '('.$fName.')'.$slsh : '');
														$z++;
													}
												}
												$contractOptArray = array();
                                                foreach($floorDetails as $floor){
                                                    $floorId = Floor::model()->findByPk($floor['floor_id']);
                                                    if(isset( $floorId['contract_period_duration']) &&  $floorId['contract_period_duration'] != ''){
                                                        $contractArray[] = $floorId['contract_period_duration'];
														$contractOptArray[] =  $floorId['contract_period_opt'];
                                                    }
                                                }
												
												
                                                $contractdiff= array_diff_assoc($contractArray, array_unique($contractArray));
                                            ?>
                 	<span class="caption">
						<?php echo Yii::app()->controller->__trans('契約内容', 'ja'); ?>
                    </span>
                    <tbody>
                    	<tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('契約年数', 'ja'); ?>
                            </th>
                            <!--fixed texts-->
                            <td>
								<?php
									$temp = '';
                                	if(count($contractdiff) > 0){
										$temp = min($contractArray).(min($contractArray) != max($contractArray) ? ' ~ '.max($contractArray).Yii::app()->controller->__trans('年', 'ja') : ' '.Yii::app()->controller->__trans('年', 'ja'));
									}else{
										$contactVar = array_values($contractArray);
										if($contactVar[0] != ""){
											$temp = $contactVar[0].Yii::app()->controller->__trans('年', 'ja');
										}else{
											$temp = '-';
										}
									}
								?>
								<?php
									$contractDefaultArray = array('1'=>Yii::app()->controller->__trans('普通借家', 'ja'),'2'=>Yii::app()->controller->__trans('定借', 'ja'),'3'=>Yii::app()->controller->__trans('定借希望', 'ja'));
									foreach($contractDefaultArray as $key=>$val){
										if(in_array($key,$contractOptArray)){
											$temp .= ' - '.$val;
											break;
										}
									}
									
									if($temp=='-' && $contractPeriodOptChk!='')
										echo $contractPeriodOptChk;
									else if($contractPeriodOptChk=='')
										echo $temp;
									else 
										echo $temp.':'.$contractPeriodOptChk;
								?>
                            </td>
                        </tr>
                        <tr>
                        	<th><?php echo Yii::app()->controller->__trans('更新費', 'ja'); ?></th>
                            <td>
								<?php
// 									echo count($floorDetails);
// 									if(substr($renewalDetails, -1)=="" || substr($renewalDetails, -1)==" ")
										echo $renewalDetails!=''?$renewalDetails:'-'; 
// 									else
// 										echo $renewalDetails.Yii::app()->controller->__trans('ヶ月', 'ja');
								?>
                            </td>
                        </tr>
                        <tr>
                        	<th><?php echo Yii::app()->controller->__trans('礼金', 'ja'); ?></th>
                            <td>
								<?php echo $keyMoneyDetails!=''?$keyMoneyDetails:'-'; ?>
                            </td>
                        </tr>
                        <tr>
                        	<th><?php echo Yii::app()->controller->__trans('償却費', 'ja'); ?></th>
                            <td>
								<?php 
								if($amortizationDetails!='') {
									echo $amortizationDetails.' '; 
	                                if($MaxOccUnit && $MaxOccAmt){
										if($MaxOccUnit == 1){
											echo Yii::app()->controller->__trans('ヶ月', 'ja');
										}elseif($MaxOccUnit == 2){
											echo Yii::app()->controller->__trans('%');
										}else{
											echo '';
										}
	                                }
								}  else echo '-';
                                ?>
                           	</td>
                        </tr>
                    </tbody>
                </table>
                <table class="summary time-to-use">
                  <?php
					if(isset($requestData['print_time_floor']) || isset($requestData['print_time_entrance'])){
                  ?>
                  <span class="caption"><?php echo Yii::app()->controller->__trans('使用時間', 'ja'); ?></span>
                  <?php
					}
                                                if(isset($requestData['print_time_floor']) == 1){
                                                    $limit_of_usage_time =  array();
                                                    if(isset($buildCart['limit_of_usage_time']) && $buildCart['limit_of_usage_time'] != ''){
                                                ?>
                  <tr>
                    <th rowspan="3"><?php echo Yii::app()->controller->__trans('使用時間', 'ja'); ?></th>
                    <td><?php
                                                            $limit_of_usage_time = explode(',',$buildCart['limit_of_usage_time']);
                                                            $limitTimeExplode = explode('-',$limit_of_usage_time[0]);
                                                            if($limitTimeExplode[0] == 1){
                                                                echo Yii::app()->controller->__trans('平日', 'ja').': '.Yii::app()->controller->__trans('無し', 'ja');
                                                            }else if($limitTimeExplode[0] == 2){
                                                                echo Yii::app()->controller->__trans('平日', 'ja').'： '.Yii::app()->controller->__trans('制限有り', 'ja').'('.$limitTimeExplode[1].')';
                                                            }else if($limitTimeExplode[0] == 3){
                                                                echo Yii::app()->controller->__trans('平日', 'ja').' : '.Yii::app()->controller->__trans('不明', 'ja');
                                                            }else{
                                                                echo '-';
                                                            }
                                                        ?></td>
                  </tr>
                  <tr>
                    <td><?php
                                                            if(isset($limit_of_usage_time[1]) && count($limit_of_usage_time[1]) > 0){
                                                                $limitTimeExplode2 = explode('-',$limit_of_usage_time[1]);
                                                                if($limitTimeExplode2[0] == 1){
                                                                    echo Yii::app()->controller->__trans('土曜', 'ja').' : '.Yii::app()->controller->__trans('無し', 'ja');
                                                                }else if($limitTimeExplode2[0] == 2){
                                                                    echo Yii::app()->controller->__trans('土曜', 'ja').'： '.Yii::app()->controller->__trans('制限有り', 'ja').'('.$limitTimeExplode2[1].')';
                                                                }else if($limitTimeExplode2[0] == 3){
                                                                    echo Yii::app()->controller->__trans('土曜', 'ja').' : '.Yii::app()->controller->__trans('不明', 'ja');
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            }
                                                        ?></td>
                  </tr>
                  <tr>
                    <td><?php
                                                            if(isset($limit_of_usage_time[2]) && count($limit_of_usage_time[2]) > 0){
                                                                $limitTimeExplode3 = explode('-',$limit_of_usage_time[2]);
                                                                if($limitTimeExplode3[0] == 1){
                                                                    echo Yii::app()->controller->__trans('休日', 'ja').'： '.Yii::app()->controller->__trans('無し', 'ja');
                                                                }else if($limitTimeExplode3[0] == 2){
                                                                    echo Yii::app()->controller->__trans('休日', 'ja').'： '.Yii::app()->controller->__trans('制限有り', 'ja').'('.$limitTimeExplode3[1].')';
                                                                }else if($limitTimeExplode3[0] == 3){
                                                                    echo Yii::app()->controller->__trans('休日', 'ja').'： '.Yii::app()->controller->__trans('不明', 'ja');
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            }
                                                        ?></td>
                  </tr>
                  <br/>
                  <?php
                                                    }
                                                }
                                                if(isset($requestData['print_time_entrance'] ) == 1){
                                                ?>
                  <tr>
                    <th rowspan="3"><?php echo Yii::app()->controller->__trans('正面玄関', 'ja'); ?></th>
                    <td><?php
                                                            $opTimeExp = $opTimeExplode = array();
                                                            if(isset($buildCart['ent_op_cl_time']) && $buildCart['ent_op_cl_time'] != ''){
                                                                $opTimeExp = explode(',',$buildCart['ent_op_cl_time']);
                                                                $opTimeExplode = explode('-',$opTimeExp[0]);
                                                                if($opTimeExplode[0] == 1){
                                                                    echo Yii::app()->controller->__trans('平日', 'ja').'： '.Yii::app()->controller->__trans('無し', 'ja');
                                                                }else if($opTimeExplode[0] == 2){
                                                                    echo Yii::app()->controller->__trans('平日', 'ja').'： '.Yii::app()->controller->__trans('制限有り', 'ja').'('.$opTimeExplode[1].')';
                                                                }else if($opTimeExplode[0] == 3){
                                                                    echo Yii::app()->controller->__trans('平日', 'ja').'：'.Yii::app()->controller->__trans('不明', 'ja');
                                                                }else{
                                                                    echo '-';
                                                                }
                                                        ?></td>
                  </tr>
                  <tr>
                    <td><?php
                                                            if(isset($opTimeExp[1]) && count($opTimeExp[1]) > 0){
                                                                $opTimeExplode2= explode('-',$opTimeExp[1]);
                                                                if($opTimeExplode2[0] == 1){
                                                                    echo Yii::app()->controller->__trans('土曜', 'ja').'：'.Yii::app()->controller->__trans('無し', 'ja');
                                                                }else if($opTimeExplode2[0] == 2){
                                                                    echo Yii::app()->controller->__trans('土曜', 'ja').'：'.Yii::app()->controller->__trans('制限有り', 'ja').'('.$opTimeExplode2[1].')';
                                                                }else if($opTimeExplode2[0] == 3){
                                                                    echo Yii::app()->controller->__trans('土曜', 'ja').'：'.Yii::app()->controller->__trans('不明', 'ja');
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            }
                                                        ?></td>
                  </tr>
                  <tr>
                    <td><?php
                                                            if(isset($opTimeExp[2]) && count($opTimeExp[2])>0){
                                                                $opTimeExplode3= explode('-',$opTimeExp[2]);
                                                                if($opTimeExplode3[0] == 1){
                                                                    echo Yii::app()->controller->__trans('休日', 'ja').'： '.Yii::app()->controller->__trans('無し', 'ja');
                                                                }else if($opTimeExplode3[0] == 2){
                                                                    echo Yii::app()->controller->__trans('休日', 'ja').'： '.Yii::app()->controller->__trans('制限有り', 'ja').'('.$opTimeExplode3[1].')';
                                                                }else if($opTimeExplode3[0] == 3){
                                                                    echo Yii::app()->controller->__trans('休日', 'ja').'： '.Yii::app()->controller->__trans('不明', 'ja');
                                                                }else{
                                                                    echo '-';
                                                                }
                                                            }
                                                        ?></td>
                    <?php
                                                            }
                                                    }
                                                    ?>
                  </tr>
                  <br/>
                </table>
                <?php
                                            if($buildCart['exp_rent_disabled'] != 1){
                                                $expRent = array();
                                                if(isset($buildCart['exp_rent']) && $buildCart['exp_rent'] != ''){
                                                    $expRent = explode('-',$buildCart['exp_rent']);
                                                    if($expRent[0] != ""){
                                                        $expVal = explode('~',$expRent[0]);
                                                        if($expVal[0] != "" || $expVal[1] != ""){
                                            ?>
                <table class="summary memo">
                  <span class="caption"><?php echo Yii::app()->controller->__trans('備考', 'ja'); ?></span>
                  <tr>
                    <th><?php echo Yii::app()->controller->__trans('見込賃料', 'ja'); ?></th>
                    <td><?php														
                                                            if($expVal[0] != ""){
                                                                echo Yii::app()->controller->renderPrice($expVal[0]);
                                                                if($expVal[1] != ""){
                                                                    echo " ~";
                                                                }else{
                                                                    echo Yii::app()->controller->__trans('円', 'ja');
                                                                }
                                                            }
                                                            if($expVal[1] != ""){
                                                                echo Yii::app()->controller->renderPrice($expVal[1]).Yii::app()->controller->__trans('円', 'ja');
                                                            }
                                                            echo isset($expRent[1]) && $expRent[1] == 1 ? Yii::app()->controller->__trans('(共益費含む)', 'ja') : Yii::app()->controller->__trans('(共益費含まない)', 'ja');
                                                        ?></td>
                  </tr>
                  <tr>
                    <td colspan="2"><?php														
                                                            if($buildCart['notes'] != ""){
																echo $buildCart['notes'];
															}
                                                        ?></td>
                  </tr>
                </table>
                <?php
                                                        }
                                                    }
                                                }
                                            }
                                            ?></td>
            </tr>
          </table></td>
      </tr>
    </table>
  </section>
</div>
<?php
			}
			elseif(count($floorDetails) > 9  && count($floorDetails)  <= 22 ) {}
			elseif(count($floorDetails)  > 22 ) {}			
			
			if(isset($requestData['print_each_building']) && $requestData['print_each_building'] == 1){
				if(isset($buildCartDetails) && count($buildCartDetails) > 0){
						$address = HelperFunctions::translateBuildingValue('address', $buildCart);
						$lat = $buildCart['map_lat'];
						$lng = $buildCart['map_long'];
						$zoom = isset($arr_zoom[$buildingNumber-1])?$arr_zoom[$buildingNumber-1]:16;
					?>
<div class="sheet_wrapper">
  <section class="sheet"> <?php echo '<span class="build_title">'.$buildingNumber.'.'.($buildCart['bill_check']==1?$buildCart['name']:$buildCart['name'].Yii::app()->controller->__trans('ビル', 'ja'))."<span>"; ?>
	<iframe id="map_<?=$buildingNumber?>" name="map_<?=$buildingNumber?>" src="/buildingmap.php?key=<?=$gApiKey?>&lat=<?=$lat?>&lng=<?=$lng?>&zoom=<?=$zoom?>" style="width:277mm;height:179mm;"></iframe>
  </section>
</div>
<?php
				}
			}
			$buildingNumber++;
		}
	}
}
?>
<?php 
$array = Array();
$buildNameArray = Array();
if(isset($_GET['print_map'])) {
	if(isset($buildCartDetails) && count($buildCartDetails) > 0){
		foreach($buildCartDetails as $buildCart){
			$array[] = $buildCart['map_lat'].','.$buildCart['map_long'];
			$buildNameArray[] = $buildCart['bill_check']==1?$buildCart['name']:$buildCart['name'].Yii::app()->controller->__trans('ビル', 'ja');
		}
	}

	$type = isset($_GET['show_numbering'])?1:0;
	$zoom = isset($_GET['zoom'])?$_GET['zoom']:16;
?>
<script>
	var locations = <?=json_encode($array)?>;
	var buildings =<?=json_encode($buildNameArray)?>;
</script>

<div class="sheet_wrapper">
  <section class="sheet" style="page-break-before:always;"> 
	<?php if($_GET['print_type']==8) {?>
	<iframe id="map_whole" name="map_whole" src="/wholemap_portrait.php?key=<?=$gApiKey?>&zoom=<?=$zoom?>&type=<?=$type?>&print_language=<?php echo $language?>" style="width:179mm;height:277mm;"></iframe>
	<?php } else {?>
	<iframe id="map_whole" name="map_whole" src="/wholemap.php?key=<?=$gApiKey?>&zoom=<?=$zoom?>&type=<?=$type?>&print_language=<?php echo $language?>" style="width:277mm;height:179mm;"></iframe>
	<?php } ?>
  </section>
</div>	
<?php } ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
<script>
$(document).ready(function(e) {
    /*************** print to pdf export ******************/
    <?php if($_GET['print_type']!=8) {?>
    function isFileExists(fName) {
      var url = '<?php echo Yii::app()->createUrl('proposedArticle/isPdfExists'); ?>';
      call({url:url,params:{fname:fName},type:'POST',dataType : 'json'},function(resp){
        if (resp.status == 1) {
          $('.dispLoader').css('display','none');
          var win = window.open(resp.url, '_blank');
          if (win) {
            //Browser has allowed it to be opened
            win.focus();
          } else {
            //Browser has blocked it
            alert('Please allow popups for this website');
          }
          //location.href = reps.url;
        } else{
          setTimeout(function() { isFileExists(fName); }, 500);
        }
      });
    }

	$(document).on('click','.makePdf',function(){
		var url = '<?php echo Yii::app()->createUrl('proposedArticle/newPdf'); ?>';
		var _postUrl = btoa($(this).data('url'));		
		var _id = $(this).data('id');
		var zoom = (typeof $("#map_whole")[0] !== 'undefined')?$("#map_whole")[0].contentWindow.getZoom():'16';

		var zoom_cnt = <?=count($buildCartDetails)?>;
		var zoom_arr = new Array();
		for(i=1;i<=zoom_cnt;i++) {
			console.log($("#map_"+i));
			if(typeof $("#map_"+i)[0] !== 'undefined') {		
	 			z = $("#map_"+i)[0].contentWindow.getZoom();
	 			zoom_arr.push(z);
			} 			
		}
		var zoomBuildings = zoom_arr.toString();
		console.log(zoom, zoomBuildings);
		console.log(_postUrl);


		$('.dispLoader').css('display','block');
		call({url:url,params:{id:_id,pdfUrl:_postUrl, zoom:zoom, zoom_building:zoomBuildings},type:'POST',dataType : 'json'},function(resp){
      isFileExists(resp.filename);
		});
	});
	<?php } else { ?>
	$(document).on('click','.makePdf',function(){
		window.print();  
	});
	<?php }?>
	/*********************** end **************************/
});
var call = function(data,callback){
	var ajxOpts = {
		url: data.url,
		data: data.params,
		dataType: 'json',
		//crossDomain: true,
		cache:false,
		type: (typeof data.type != 'undefined' ? data.type : 'Get'),
	};	
	if(typeof data.progress != 'undefined'){
		ajxOpts.xhr = function() {
			var myXhr = $.ajaxSettings.xhr();
			if(myXhr.upload){
				myXhr.upload.addEventListener('progress',progress, false);
			}
			return myXhr;
		};
	}
	$.ajax(ajxOpts).success(function(res) {
		callback(res);
	}).fail(function(r) {
	}).comple
}


// $(document).ready(function() {
// 	var tt_bulid = $('#total_bulidings').val();
// 	tt_bulid=parseInt(tt_bulid);
// 	var jk =1;
// 	for (var i = 1; tt_bulid >= i; i++) {
// 		 while(jk >= 1){
// 		 	if($('#sheet_commercial_'+jk).length){
// 				var height = $('#sheet_commercial_'+jk).height();
// 				if((height/1000)>1){
// 				   var new_hei = (height%1000);
// 				   new_hei=parseInt(new_hei);
// 				   new_hei=1000-new_hei;
// 				   $('#sheet_commercial_'+jk).css('margin-bottom', new_hei);
// 				}
// 				else{
// 				     new_hei=parseInt(height);
// 				     new_hei=1000-new_hei;
// 				     $('#sheet_commercial_'+jk).css('margin-bottom', new_hei);

// 				}
// 				jk++;
// 				break;
	   			 
// 			}
// 			else{
				
// 				jk++;
// 			}

// 		 }
// 		}	
// });
</script>
</body>

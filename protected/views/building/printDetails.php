<?php
/********** get google map api key **********/
$gApiKey = 'AIzaSyCMeCU-45BrK0vyJCc4y2TYMdDJLNGdifM';
//$gApiKey = 'AIzaSyDJlHTWIHfZsuOIZChVv0Dx9LoAl0PL7a0';
/***************** end ****************/
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
img { border: none; }
a img { border: none; }
.clearfix:after { content: "."; display: block; height: 0; clear: both; visibility: hidden; }
.clearfix { display: inline-table; }
.sheet { width: <?php print (!isset($_REQUEST['print'])) ? '277mm' : '100%' ?>; height: auto; /* 1mm余裕をもたせる */ page-break-after: always; position: relative; }
.sheet.commercial { page-break-after: avoid; }
.client_name {
    margin-top: 5mm;
    font-weight: bold;
}
td.f_price_t_rent { height: 16mm; }
img { max-width: 277mm; height: auto; }
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
.notice { padding-top: 5mm; width: 277mm; }
.half { width: 50%; float: left; }
.notice p { font-size: 6pt; margin: 0; }
table { border-collapse: collapse; }
td.center { text-align: center; }
td.right-align { text-align: right; }
th.building-name { width: 110mm; }
th.building-addr { width: 80mm; }
table.building-profile { border-collapse: collapse; width: <?php print (!isset($_REQUEST['print'])) ? '277mm' : '100%'; ?>;}
table.building-profile th { border-bottom: 1px solid #000; font-size: 11pt; font-weight: normal; padding-top: 8mm; }
table.building-profile td { font-size: 11pt; border-bottom: 1px solid #c9c9c9; line-height: 7mm; height: 7mm; }
caption { background: #e11b30; color: #000; text-transform: uppercase; padding: 1mm 0; font-family: HelveticaNeue-bold; }
.caption { text-align: left; background: none; color: #e11b30; font-weight: bold; border-left: 4px solid #e11b30; padding: 0; text-indent: 2mm; line-height: 1.2; font-size: 9pt; display: inline-block; }
table.single-info td.title { font-size: 24pt; }
table.building-profile.single-info td { height: auto; line-height: 1.6; border: none; }
table.building-profile.single-info th { border-color: #c9c9c9; }
table.building-profile.single-info td table caption { text-align: left; background: none; color: #e11b30; font-weight: bold; border-left: 4px solid #e11b30; padding: 0; text-indent: 2mm; line-height: 1.2; font-size: 9pt; }
table.building-profile.single-info td table td, table.building-profile.single-info td table th { font-size: 8pt; line-height: 1; height: 4mm; padding: 0; }
table.building-profile.single-info td table th { padding: 2mm 0 1mm; }
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

table.building-list { width: 100%; }
table.building-list th { font-size: 5pt; line-height: 1.1; background: #e11b30; padding: 2mm 0; }
table.building-list td { font-size: 7pt; border-right: 1px solid #CCC; line-height: 1.2; }
th.label_1 { width: 8mm; }
th.label_2 { width: 65mm; }
.label_3 { width: 11mm; }
.label_4, .label_5, .label_6, .label_7 { width: 22mm; }
.label_8 { width: 20mm; }
th.label_9 { /*width: 55mm;*/ }
th.label_10 { width: 30mm; }
table.building-list td img { max-width: 26mm; margin: 2mm auto; display: block; }
td.build_img img { width: 100%; }
table.building-list td table td { height: 5mm; line-height: 1.2; border: none; padding: 0 1mm; }
table.building-list td table td.build_name { height: 10.3mm; font-size: 10pt; border-bottom: 1px solid #CCC; }
table.building-list td table td.build_name span.build_no { text-align: right; font-size: 5pt; display: block; }
table.building-list td table td.build_name, table.building-list td table td.build_no { background: #efefef; }
table.building-list td table { width: 100%; }
td.summary_td { padding: 0; vertical-align: top; }
table.building-list td table.lists td { padding: 0; }
td.label_4, td.label_5, td.label_6, td.label_7 { text-align: right; }
table.lists tr:nth-child(even) td { background-color: #f4f4f4; }
table.lists tr.row_second td, table.building-list td table.lists td.center.label_3 { border-bottom: 1px solid #CCC; }
table.building-list td table.lists td.center.label_3 { border-right: 1px solid #CCC; }
table.building-list td table.facility-info td { border-bottom: 1px solid #CCC; }
/*table.lists tr:nth-child(odd) td {

    border-bottom: 1px solid #ffffff;

}*/
table.facility-info td.comment-texts { font-size: 5pt !important; height: auto; line-height: 1.4; }
td.no-border { border: none !important; }
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
td.cam_date { width: 20mm; }
th.bo_name { width: 180mm; }
th.bo_fee { width: 12mm; }
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
section.sheet.commercial table td, section.sheet.commercial table th { font-size: 8pt; line-height: 1.8; text-align: left; font-weight: normal; }
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
	.sheet 
	{ /* ドロップシャドウ */
		/*margin: 0mm;*/
		padding: <?php print (!isset($_REQUEST['print'])) ? '10mm' : '0'; ?>;
		width: <?php print (!isset($_REQUEST['print'])) ? '277mm' : '100%'; ?>;
		height: auto;
	}
}

@page { size: A4 landscape; margin: 0mm; }

@media print 
{	
	.btnMakePdf { display:none;}
	.body { width: /*277mm*/100%; /* needed for Chrome */ }
	.sheet.commercial { height: auto !important; }		
	table tr, img, blockquote {page-break-inside: avoid !important;}
	.sheet{padding:2.5% 0; margin:5%;width:90%;}
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

<body class="<?php print (isset($_REQUEST['print'])) ? 'twoprint' : ''; ?>">
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
      <p class="address"><?php echo $company->address; ?></p>
      <!--author company address *common-->
      <p class="tel"><?php echo $company->phone; ?></p>
      <!--author company tel *common-->
      <p class="email"><?php echo $company->email; ?></p>
      <!--author company email *common-->
      </div>
      <div class="auth-right">
		<p class="date">日付：<?php echo  date('Y.m.d'); ?></p>
      <!--author date to publish --> 
      </div>
      <div class="clear" style="clear:both;"></div>
    </div>
    <div class="op-wht"></div>
  </section>
</div>
<?php } ?>
<?php if(isset($requestData['print_route']) && $requestData['print_route'] == 1) {?>
<div class="client"></div>
<div class="sheet_wrapper">
  <section class="sheet"> <img src="images/new_route_map.jpg" class="route-map"><!--image of route map-->
    <div class="notice clearfix">
      <div class="half left">
        <p>※契約面積・金額が㎡表示の物件は坪に換算しています。(坪換算値=3.3058)。</p>
        <!--fixed texts-->
        <p>※賃貸条件や建物設備は変更する可能性があります。正式な内容につきましては重要事項説明書をもってご説明致します。</p>
        <!--fixed texts-->
        <p>※ご紹介致しました物件が既に商談又は決定済みの節はご了承の程お願い申し上げます。</p>
        <!--fixed texts-->
        <p>※賃料等課税対象となる金額には別途消費税が加算されます。</p>
        <!--fixed texts--> 
      </div>
      <div class="half right">
        <p>※共用率はワンフロア当りです。</p>
        <!--fixed texts-->
        <p>※(案)の表示階は、分割例とします。</p>
        <!--fixed texts-->
        <p>※★マークは想定価格を表しています。</p>
        <!--fixed texts-->
        <p>※契約が成立した場合仲介手数料として賃料の１カ月分を申し受けます。</p>
        <!--fixed texts--> 
      </div>
    </div>
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
        <th class="label_2">ビル概要</th>
        <!--fixed texts-->
        <th class="label_3">募集階</th>
        <!--fixed texts-->
        <th class="label_4">面積(坪)<br/>
          (<?php echo Yii::app()->controller->__trans('m'); ?>&sup2;)</th>
        <!--fixed texts-->
        <th class="label_5">賃料(坪単価)<br/>
          総額</th>
        <!--fixed texts-->
        <th class="label_6">共益費(坪単価)<br/>
          総額</th>
        <!--fixed texts-->
        <th class="label_7">預託金<br/>
          総額</th>
        <!--fixed texts-->
        <th class="label_8">入居可能日</th>
        <!--fixed texts-->
        <th class="label_9">設備概要</th>
        <!--fixed texts-->
        <th class="label_10">ビル外観</th>
        <!--fixed texts--> 
      </tr>
      <?php
			if(isset($buildCartDetails) && count($buildCartDetails) > 0){
				$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
				$logged_user_id = $user->user_id;
				$buildingNumber = 1;
				$indexFloor = 0;
				foreach($buildCartDetails as $buildCart){
			?>
      <tr>
        <td class="center">No.<?php echo $buildingNumber; ?></td>
        <?php include('_print_summary.php');?>
        <td colspan="6" class="list_floor var-top"><table class="lists">
            <?php
				$floorDetails = Floor::model()->findAll('building_id = '.$buildCart['building_id'].' And vacancy_info = 1' );
				
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
				foreach($floorDetails as $floor){
					$indexFloor ++;
					$floorId = Floor::model()->findByPk($floor['floor_id']);
					if($indexFloor && ($indexFloor % 18 == 0 )) {
						echo '</table></td>';
						include('_print_facility_summary.php');
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
										<th class="label_2">ビル概要</th><!--fixed texts-->
										<th class="label_3">募集階</th><!--fixed texts-->
										<th class="label_4">面積(坪)<br/>('. Yii::app()->controller->__trans("m") .'&sup2;)</th>
										<!--fixed texts-->
										<th class="label_5">賃料(坪単価)<br/>総額</th><!--fixed texts-->
										<th class="label_6">共益費(坪単価)<br/>総額</th><!--fixed texts-->
										<th class="label_7">預託金<br/>総額</th><!--fixed texts-->
										<th class="label_8">入居可能日</th><!--fixed texts-->
										<th class="label_9">設備概要</th><!--fixed texts-->
										<th class="label_10">ビル外観</th><!--fixed texts-->
									</tr>
									<tr><td class="center">No.'. $buildingNumber .'</td></td>';
						include('_print_summary.php');
						echo '<td colspan="6" class="list_floor var-top">
							<table class="lists">';
					}
			?>
            <tr class="row_fst">
              <td rowspan="2" class="center label_3"><?php
			  	if(isset($floorId['preceding_user']) && $floorId['preceding_user'] != 0){
					echo '<span class="senko">先行有</span>';
				}
				if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
					if(strpos($floorId['floor_down'], '-') !== false){
						$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
					}else{
						$floorDown = $floorId['floor_down'];
					}
					if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
						echo $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
					}else{
						echo $floorDown.' '.Yii::app()->controller->__trans('階');
					}
				}
				if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
					echo '&nbsp;'.$floorId['roomname'];
				}
				?></td>
	              <td class="label_4"><?php
				if(isset($floorId['area_ping']) && $floorId['area_ping'] != ""){
					echo $floorId['area_ping']/*." ".Yii::app()->controller->__trans('Ping')*/;
				}else{
					echo '-';
				}
				?>
                <?php
					if(isset($floorId['payment_by_installments']) && $floorId['payment_by_installments'] == 1){
						echo '分割例 :';
					}else if(isset($floorId['payment_by_installments']) && $floorId['payment_by_installments'] == 2){
						echo '分割可 :';
					}
				?>
                <?php if(isset($floorId['floor_partition']) && $floorId['floor_partition'] != ""){
					  $expFloorParts = explode(',',$floorId['floor_partition']);
						if(!empty($expFloorParts)){
							foreach($expFloorParts as $part){
								echo $part/*.'坪'*/.',<br/>';
							}
						}
						
				}
				?>
                <?php
					if(isset($floorId['area_net']) && $floorId['area_net'] != ""){
						echo "ネット: ".$floorId['area_net']/*." 坪"*/;
					}else{
						echo '';
					}
				?></td>
              <td class="label_5"><font><font>
                <?php
					if($floorId['rent_unit_price_opt'] != ''){
						if($floorId['rent_unit_price_opt'] == -1){
							echo Yii::app()->controller->__trans('undecided');
						}else if($floorId['rent_unit_price_opt'] == -2){
							echo Yii::app()->controller->__trans('ask');
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
								echo Yii::app()->controller->__trans('none');
							}else if($floorId['unit_condo_fee_opt'] == -1){
								echo Yii::app()->controller->__trans('undecided');
							}else if($floorId['unit_condo_fee_opt'] == -2){
								echo Yii::app()->controller->__trans('ask');
							}else if($floorId['unit_condo_fee_opt'] == -3){
								echo '賃料に込み (含む)';
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
              <td class="label_7"><?php
				if(isset($floorId['rent_unit_price']) && $floorId['rent_unit_price'] != "" && $floorId['rent_unit_price'] != 0){
				?>
                <font><font>
                <?php
					if($floorId['deposit_opt'] != ''){
						echo '<br/>';
						if($floorId['deposit_opt'] == -1){
							echo Yii::app()->controller->__trans('undecided');
						}else if($floorId['deposit_opt'] == -3){
							echo Yii::app()->controller->__trans('none');
						}else if($floorId['deposit_opt'] == -2){
							echo Yii::app()->controller->__trans('undecided･ask');
						}
					}
					if(isset($floorId['deposit_month']) &&  $floorId['deposit_month'] != ''){
						//echo '<br/>'.$floorId['deposit_month'].' ヶ月';
					}
				?>
                </font></font><br>
                <font><font>
                <?php
					if(isset($floorId['deposit']) && $floorId['deposit'] != ""){
						echo Yii::app()->controller->renderPrice($floorId['deposit'])/*.Yii::app()->controller->__trans('yen / tsubo')*/;
					}else{
						echo '';
					}
				?>
                </font></font>
                <?php
				}
				?></td>
              <td class="label_8 center">即入居</td>
            </tr>
            <tr class="row_second">
              <td class="label_4"><?php echo $floorId['area_m'] != "" && $floorId['area_m'] != 0 ? $floorId['area_m']/*.'m&sup2;'*/ : '-'; ?></td>
              <!--area of space by meter-->
              <td class="label_5">
              <?php 
	              if(isset($floorId['total_rent_price']) && $floorId['total_rent_price'] != ""){
	              	echo Yii::app()->controller->renderPrice($floorId['total_rent_price']).'円';
	              }else if($floorId['rent_unit_price_opt']==-1 || $floorId['rent_unit_price_opt']==-2) {
	              	$rentNegotiationDetails = RentNegotiation::model()->findAll('building_id = '.$buildCart["building_id"].' AND allocate_floor_id='.$floorId['floor_id'].' order by rent_negotiation_id desc LIMIT 1');
	              	$rentNegotiationDetails = $rentNegotiationDetails[0];
	              	//print_r($rentNegotiationDetails);
	              	if($rentNegotiationDetails['negotiation_type']==1) {
	              		echo Yii::app()->controller->__trans('low price').': '.Yii::app()->controller->renderPrice($rentNegotiationDetails['negotiation']).Yii::app()->controller->__trans('yen');
	              	} else if($rentNegotiationDetails['negotiation_type']==5) {
	              		echo Yii::app()->controller->__trans('standard price').': '.Yii::app()->controller->renderPrice($rentNegotiationDetails['negotiation']).Yii::app()->controller->__trans('yen');
	              	} else{
	              		echo '-';
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
              <td class="label_7"><?php echo $floorId['total_deposit'] != "" && $floorId['total_deposit'] != 0 ? Yii::app()->controller->renderPrice($floorId['total_deposit'])/*.'円'*/ : '-'; ?></td>
              <!--total deposit-->
              <td class="label_8 center"></td>
              <!--always blank--> 
            </tr>
            <?php
				}
			?>
          </table></td>
        <!--list of the floor-->
        <?php include('_print_facility_summary.php');?>
      </tr>
      <?php
				$buildingNumber++;
				$array[] = $buildCart['map_lat'].','.$buildCart['map_long'];
				$buildNameArray[] = $buildCart['name'];
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
				$address = $buildCart['address'];
				$lat = $buildCart['map_lat'];
				$lng = $buildCart['map_long'];
				$zoom = isset($arr_zoom[$buildingNumber-1])?$arr_zoom[$buildingNumber-1]:16;
	?>
<div class="sheet_wrapper">
  <section class="sheet"> <?php echo '<span class="build_title">'.$buildingNumber.'.'.$buildCart['name']."<span>"; ?><br>
	<iframe id="map_<?=$buildingNumber?>" name="map_<?=$buildingNumber?>" src="http://office-jpdb.com/buildingmap.php?key=<?=$gApiKey?>&lat=<?=$lat?>&lng=<?=$lng?>&zoom=<?=$zoom?>" style="width:277mm;height:179mm;"></iframe>
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
    <h1><?php echo $requestData['header_name']; ?><?php if($requestData['header_name']=='') echo '','オフィスビルご紹介資料' ?></h1>
    <h4 class="subtitle en"><?php echo Yii::app()->controller->__trans('office building information'); ?></h4>
    <!--common sub title-->
    <div class="client_name">
      <?php
		$prosalData = ProposedArticle::model()->findByPK($requestData['hdnProArticleId']);
        $companyName = Customer::model()->findByPk($prosalData['customer_id']);
        if(trim($companyName['company_name'])!="") {
        	echo $companyName['company_name']."様";
        }
        
		if(isset($_GET['user']))
			$user = $_GET['user'];
		else 
			$user = Yii::app()->user->getId();
		
		$user = Users::model()->findByAttributes(array('username'=>$user));

        $company_id = $user->company;
        $company = Company::model()->findByPK($company_id);
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
      <p class="address"><?php echo $company->address; ?></p>
      <!--author company address *common-->
      <p class="tel"><?php echo $company->phone; ?></p>
      <!--author company tel *common-->
      <p class="email"><?php echo $company->email; ?></p>
      <!--author company email *common-->
      </div>
      <div class="auth-right">
      <p class="date">
        日付：<?php  echo  date('Y.m.d'); ?>
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
		if(isset($requestData['print_route']) && $requestData['print_route'] == 1) {
		?>
<div class="sheet_wrapper">
  <section class="sheet"> <img src="images/new_route_map.jpg" class="route-map"><!--image of route map-->
    <div class="notice clearfix">
      <div class="half left">
        <p>※契約面積・金額が㎡表示の物件は坪に換算しています。(坪換算値=3.3058)。</p>
        <p>※賃貸条件や建物設備は変更する可能性があります。正式な内容につきましては重要事項説明書をもってご説明致します。</p>
        <p>※ご紹介致しました物件が既に商談又は決定済みの節はご了承の程お願い申し上げます。</p>
        <p>※賃料等課税対象となる金額には別途消費税が加算されます。</p>
      </div>
      <div class="half right">
        <p>※共用率はワンフロア当りです。</p>
        <p>※(案)の表示階は、分割例とします。</p>
        <p>※★マークは想定価格を表しています。</p>
        <p>※契約が成立した場合仲介手数料として賃料の１カ月分を申し受けます。</p>
      </div>
    </div>
  </section>
</div>
<?php
        } ?>
<div class="sheet_wrapper">
<?php         
		$buildingNumber = 1;
		foreach($buildCartDetails as $buildCart){
		?>

  <section class="sheet commercial">
    <table class="bd_data">
      <tbody>
        <tr>
          <td class="b_no"><span style=""><?php echo $buildCart['buildingId']; ?></span></td>
          <td class="b_nm"><?php echo $buildingNumber.'.'.$buildCart['name']; ?></td>
          <td class="b_address"><?php echo $buildCart['address']; ?></td>
        </tr>
      </tbody>
    </table>
    <table class="b_info br">
      <tbody>
        <tr>
          <td class="b_build_str"><?php echo date('Y年 m月',strtotime($buildCart['built_year'])); ?></td>
          <td class="st_data">表参道駅 9分</td>
          <td class="b_scale_str">
          <?php
          	$typeDetails = ConstructionType::model()->findByPk($buildCart['construction_type_id']);
            echo $typeDetails['construction_type_name'];
          ?></td>
          <td class="f_oa"></td>
          <td class="f_lightline_str">
          <?php
				if($buildCart['opticle_cable'] == 0){
					echo Yii::app()->controller->__trans('unknown');
				}else if($buildCart['opticle_cable'] == 1){
					echo Yii::app()->controller->__trans('Pull Yes');
				}else if($buildCart['opticle_cable'] == 2){
					echo Yii::app()->controller->__trans('Nothing');
				}else{
					echo '-';
				}
			?></td>
          <!--electonic cable value-->
          <td class="f_air">
          <?php
				$typeDetails = ConstructionType::model()->findByPk($buildCart['construction_type_id']);
				echo $typeDetails['construction_type_name'];
			?></td>
          <!--air condition facility value-->
          <td class="b_usetime">24H</td>
          <!--use of time value-->
          <td class="b_ev_num">
          <?php
			$elevatorExp = explode('-',$buildCart['elevator']);
            if($elevatorExp[0] == 1){
            	echo Yii::app()->controller->__trans('Exist');
				if($elevatorExp[1] != "" || $elevatorExp[2] != "" || $elevatorExp[3] != "" || $elevatorExp[4] != "" || $elevatorExp[5] != "") echo '(';
					echo isset($elevatorExp[1]) && $elevatorExp[1] != "" ? $elevatorExp[1].Yii::app()->controller->__trans('基') : "";
					echo isset($elevatorExp[2]) && $elevatorExp[2] != "" ? '/'.$elevatorExp[2].Yii::app()->controller->__trans('人乗') : "";
					echo isset($elevatorExp[3]) && $elevatorExp[3] != "" ? $elevatorExp[3].Yii::app()->controller->__trans('基・人荷用') : "";
					echo isset($elevatorExp[4]) && $elevatorExp[4] != "" ? $elevatorExp[4].Yii::app()->controller->__trans('人乗') : "";
					echo isset($elevatorExp[5]) && $elevatorExp[5] != "" ? $elevatorExp[5].'基' : "";
					if($elevatorExp[1] != "" || $elevatorExp[2] != "" || $elevatorExp[3] != "" || $elevatorExp[4] != "" || $elevatorExp[5] != "") echo ')';
                }else if($elevatorExp[0] == -2){
                	echo Yii::app()->controller->__trans('unknown');
                }else if($elevatorExp[0] == 2){
                	echo Yii::app()->controller->__trans('noexist');
                }else{
                	echo '-';
                }
          ?></td>
          <!--elevetor value-->
          <td class="b_parking_num">
          <?php
          	$parkingUnitNo = explode('-',$buildCart['parking_unit_no']);
			if($parkingUnitNo[0] == 1){
				echo Yii::app()->controller->__trans('exist').($parkingUnitNo[1] != "" ? '('.$parkingUnitNo[1].' '.Yii::app()->controller->__trans('台').')' : "");
			}else if($parkingUnitNo[0] == 2){
				echo Yii::app()->controller->__trans('noexist');
			}else if($parkingUnitNo[0] == 3){
				echo Yii::app()->controller->__trans('exist but unknown unit number');
			}
		  ?></td>
          <!--parking value--> 
        </tr>
      </tbody>
    </table>
    <table class="b_data">
      <tbody>
        <?php
			$count2RowAbove = 0;
			$managementArray = array('1'=>'オーナー','6'=>'サブリース','7'=>'貸主代理','8'=>Yii::app()->controller->__trans('AM'),'10'=>'業者','4'=>'仲介業者','2'=>'管理会社','9'=>Yii::app()->controller->__trans('PM'),													'3'=>'ゼネコン','-1'=>'不明',);
            $ownerDetails = OwnershipManagement::model()->findAllByAttributes(array('building_id' => (array)$buildCart['building_id']), array('order' => 'modified_on DESC', 'limit' => 10, 'group' => 'owner_company_name'));
//                 	$ownerDetails = OwnershipManagement::model()->findAll('building_id = '. $buildCart['building_id']);
//                 	echo '<pre>'; print_r($ownerDetails);die;
			foreach($ownerDetails as $owner){
				$count2RowAbove++;
		?>
        <tr>
          <th class="bo_name"> <span class="owner_type ">
            <?php
				if($owner['ownership_type'] != 0){
					echo $managementArray[$owner['ownership_type']];
				}
			?>
            <!--業--> 
            </span><!--owner type--> 
            <?php echo $owner['owner_company_name']; ?> </th>
          <!--name of owner-->
          <th class="bo_tel1"> <?php echo $owner['company_tel']; ?> </th>
          <!--phone no of the owner-->
          <th class="bo_fee"> 
          <?php
			if(isset($owner['charge']) && $owner['charge'] != ""){
				if (is_numeric($owner['charge'])){
					echo number_format($owner['charge'],1,'.','');
				}else{
					echo $owner['charge'];
				}
			}else{
				echo '-';
			}
			?>
          </th>
          <!--commision fee-->
          <th class="bo_upd">更新
            <?php  echo date('y-m-d',strtotime($owner['modified_on'])); ?>
          </th>
          <!--updated date--> 
        </tr>
        <?php
        	}
		?>
        <!--/loop of owner if owners are multiple-->
      </tbody>
    </table>
    <p class="last_update"><!--label-->ビル情報最終更新：<!--/label--> 
      <?php echo $buildCart['modified_on']; ?><!--latest updated date of building info--> 
    </p>
    <!--history of updated things-->
    <?php
		$addedOnArray = array();
		$transmissionMattersDetails = TransmissionMatters::model()->findAll('building_id = '.$buildCart['building_id']);
		$negotiationDetails = RentNegotiation::model()->findAll('building_id = '.$buildCart['building_id'].' order by rent_negotiation_id desc');
		$mergeArray = array_merge_recursive($transmissionMattersDetails,$negotiationDetails);
		foreach($mergeArray as $merge){
			$addedOnArray[] = date('Y.m.d',strtotime($merge['added_on']));
		}
		array_multisort($addedOnArray,SORT_DESC,$mergeArray);
			
// 			for ($j=0; $j<20; $j++) {
// 				$mergeArray[] = $mergeArray[0];
// 			}
			?>
    <?php
            	//$buildLogDetails = BuildingUpdateLog::model()->findAll('building_id ='.$buildCart['building_id'].' order by building_update_log_id desc limit 10');
		foreach($mergeArray as $indexLog => $log){
//		if ($indexLog >= 18) {
//			if ($indexLog == 18) {
//				echo '</section></div>';
//				echo '<div class="sheet_wrapper"><section class="sheet commercial">';
//			}
//			continue;
//		}
//		$count2RowAbove ++;
	?>
    <table class="camp_info">
      <tbody>
        <tr>
          <td class="cam_date"><?php  echo date('y-m-d',strtotime($log['added_on'])); ?></td>
          <!--date of updated-->
          <td colspan="10">
          <?php
			//echo $log['change_content'];
			if(isset($log['note'])){
				if($log['note'] != ""){
					echo $log['note'];
				}else{
					echo '-';
				}
			}
			if(isset($log['negotiation_type'])){
				$allocateFloorDetails = Floor::model()->findAllByAttributes(array('floor_id'=>explode(',',$log['allocate_floor_id'])));
				if(isset($allocateFloorDetails) && count($allocateFloorDetails) > 0){
					$floorName = '';
					foreach($allocateFloorDetails as $floor){
						if(strpos($floor['floor_down'], '-') !== false){
							$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floor['floor_down']);
						}else{
							$floorDown = $floor['floor_down'];
						}
						if($floor['floor_up'] != ""){
							$floorName .= $floorDown." ~ ".$floor['floor_up'].' '.Yii::app()->controller->__trans('階');
						}else{
							$floorName .= $floorDown.' '.Yii::app()->controller->__trans('階');
						}
						/*if($merge['negotiation_type'] == 4){
							$negUnitList = '';
						}else{
							$negUnitList = '¥';
						}
						*/
						$negUnitB = '';
						$negUnit = '';
						if($log['negotiation_type'] == 1){
							$negUnit = '(共益費込み)';
							$negUnitB = ' | ¥';
						}elseif($log['negotiation_type'] == 5){
							$negUnit = '(共益費込み)';
							$negUnitB = ' | ¥';
						}elseif($log['negotiation_type'] == 2 || $log['negotiation_type'] == 3){
							$negUnit = 'ヶ月';
						}
						
						//$floorName .= " / ".$floor['area_ping'].Yii::app()->controller->__trans('tsubo').' | '.$negUnitB.Yii::app()->controller->renderPrice($log['negotiation']).' '.$negUnit;
						$floorName .= " / ".$floor['area_ping'].Yii::app()->controller->__trans('tsubo').''.$negUnitB.$negUnit;
					}									
				}else{
					$floorName = '';
				}
				
				if($log['negotiation_type'] == 1){
					echo '坪単価(底値)';
				}elseif($log['negotiation_type'] == 2){									
					echo Yii::app()->controller->__trans('Deposit negotiation value');
				}elseif($log['negotiation_type'] == 3){
					echo Yii::app()->controller->__trans('Key money negotiation value');
				}elseif($log['negotiation_type'] == 5){
					echo '坪単価(目安値)';
				}									
				else{
					echo Yii::app()->controller->__trans('Other negotiations information');
				}
				echo " ".$log['negotiation'].'<br/>'.$floorName;
			}
		?></td>
          <!--updated thing--> 
        </tr>
      </tbody>
    </table>
    <?php
    	}
	?>
    <!--floor info-->
    <table class="f_info">
      <tbody>
        <?php
			$floorDetails = Floor::model()->findAll('building_id = '.$buildCart['building_id']);
			$floorDetailsTmp = $floorDetails;
			foreach($floorDetailsTmp as $floorKey => $floor){
				if(!in_array($floor['floor_id'],$proposedFloors)){
					unset($floorDetails[$floorKey]);
				}
			}
// 							for ($i=0; $i<20; $i++) {
// 								$floorDetails[] = $floorDetails[0];
// 							}
				
			$countFloor = 0;
			foreach($floorDetails as $floor){
				$countFloor++;
				$floorId = Floor::model()->findByPk($floor['floor_id']);
//				if($countFloor % 12 == 0 || ($countFloor < 12 && $count2RowAbove < 28 && $countFloor == ceil(28 - $count2RowAbove)/3)) {
//					$countFloor = 12;
//					echo '</tbody></table></section></div>';
//					echo '<div class="sheet_wrapper"><section class="sheet commercial"><table class="f_info"><tbody>';
//				}
		?>
        <!--if multiple floors,loop-->
        <tr style="border-bottom:1px solid #fff;">
          <td class="f_emp" style="width:45px;"><span style=""><?php echo $floorId['floorId']; ?></span></td>
          <!--floor ID-->
          <td class="f_floor_str" style="width:30px;"><?php
		  if(isset($floorId['preceding_user']) && $floorId['preceding_user'] != 0){
			echo '<span class="senko">先行有</span>';
			}
            if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
				if(strpos($floorId['floor_down'], '-') !== false){
					$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
				}else{
					$floorDown = $floorId['floor_down'];
				}
				if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
					echo $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
				}else{
					echo $floorDown.' '.Yii::app()->controller->__trans('階');
				}
			}
			if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
				echo '&nbsp;'.$floorId['roomname'];
			}
		?></td>
          <!--stair of the floor-->
          <td class="f_acreg_str" style="width:42px;">
          <?php
			if(isset($floorId['area_ping']) && $floorId['area_ping'] != ""){
				echo $floorId['area_ping']." ".Yii::app()->controller->__trans('Ping');
			}else{
				echo '-';
			}
		 ?></td>
          <!--area space of the floor-->
          <td class="f_rentstart" style="width:50px;">
          <?php
			if(isset($floorId['move_in_date']) && $floorId['move_in_date'] != "" && (string)$floorId['move_in_date'] != '0'){
				echo $floorId['move_in_date'];
			}else{
				echo '-';
			}
			?></td>
          <!--date to rent start for the floor-->
          <td class="f_price_m_shiki" style="width:25px;">償
            <?php
				if(isset($floorId['total_deposit']) && $floorId['total_deposit'] != "0" && $floorId['total_deposit'] != ""){
					echo Yii::app()->controller->renderPrice($floorId['total_deposit']).' 円';
				}
				if($floorId['deposit_opt'] != ''){
					echo '<br/>';
					if($floorId['deposit_opt'] == -1){
						echo Yii::app()->controller->__trans('undecided');
					}else if($floorId['deposit_opt'] == -3){
						echo Yii::app()->controller->__trans('none');
					}else if($floorId['deposit_opt'] == -2){
						echo Yii::app()->controller->__trans('undecided･ask');
					}
				}
				if(isset($floorId['deposit_month']) &&  $floorId['deposit_month'] != ''){
					echo '<br/>'.$floorId['deposit_month'].' ヶ月';
				}
			?>
            <br>
            <?php
				if(isset($floorId['deposit']) && $floorId['deposit'] != "" && $floorId['deposit'] != 0){
					echo Yii::app()->controller->renderPrice($floorId['deposit']).Yii::app()->controller->__trans('yen / tsubo');
				}else{
					echo '';
				}
			?></td>
          <!--deposit fee of the floor-->
          <td class="f_price_t_rent" style="width:50px;">
          <?php
				if($floorId['rent_unit_price_opt'] != ''){
					if($floorId['rent_unit_price_opt'] == -1){
						echo Yii::app()->controller->__trans('undecided');
					}else if($floorId['rent_unit_price_opt'] == -2){
						echo Yii::app()->controller->__trans('ask');
					}
				}else{
					echo '-';
				}
			?>
            <?php
				if(isset($floorId['rent_unit_price']) && $floorId['rent_unit_price'] != "" && $floorId['rent_unit_price'] != 0){
					echo Yii::app()->controller->renderPrice($floorId['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo');
				}else{
					echo '';
				}
			?></td>
          <!--rent fee per 1 tsubo of the floor-->
          <td class="f_price_a_rent" style="width:60px;"><?php echo $floorId['total_rent_price'] ? Yii::app()->controller->renderPrice($floorId['total_rent_price']).'円' : ''; ?></td>
          <!--total rent fee of the floor-->
          <td class="f_price_rerent" style="width:45px;">更
            <?php 
            if(isset($floorId['renewal_fee_opt']) && $floorId['renewal_fee_opt'] != ""){
            	if($floorId['renewal_fee_opt'] == 2){
            		echo Yii::app()->controller->__trans('None');
            	}elseif($floorId['renewal_fee_opt'] == -1){
            		echo Yii::app()->controller->__trans('Unknown');
            	}elseif($floorId['renewal_fee_opt'] == -2){
            		echo Yii::app()->controller->__trans('Undecided･ask');
            	}else{
            		echo '';
            	}
            }
            
            if(isset($floorId['renewal_fee_reason']) && $floorId['renewal_fee_reason'] != ""){
            	if($floorId['renewal_fee_reason'] == 1){
            		echo Yii::app()->controller->__trans('現賃料の');
            	}elseif($floorId['renewal_fee_reason'] == 2){
            		echo Yii::app()->controller->__trans('新賃料の');
            	}else{
            		echo '';
            	}
            }
            
            if(isset($floorId['renewal_fee_recent']) && $floorId['renewal_fee_recent'] != ""){
            	echo $floorId['renewal_fee_recent'].Yii::app()->controller->__trans('month');
            }
            ?></td>
          <!--renewal fee-->
          <td class="f_price_amo_str" style="width:50px;">償
            <?php
				if(isset($floorId['repayment_opt']) && $floorId['repayment_opt'] != ""){
					if($floorId['repayment_opt'] == -3){
						echo Yii::app()->controller->__trans('None');
					}elseif($floorId['repayment_opt'] == -4){
						echo Yii::app()->controller->__trans('Unknown');
					}elseif($floorId['repayment_opt'] == -1){
						echo Yii::app()->controller->__trans('Undecided');
					}elseif($floorId['repayment_opt'] == -2){
						echo Yii::app()->controller->__trans('Ask');
					}elseif($floorId['repayment_opt'] == -5){
						echo Yii::app()->controller->__trans('Sliding');
					}else{
						echo '';
					}
				}
				
				if(isset($floorId['repayment_reason']) && $floorId['repayment_reason'] != ""){
					if($floorId['repayment_reason'] == 1){
						echo Yii::app()->controller->__trans('現賃料の');
					}elseif($floorId['repayment_reason'] == 2){
						echo Yii::app()->controller->__trans('解約時賃料の');
					}else{
						echo '';
					}
				}
				
				if(isset($floorId['repayment_amt']) && $floorId['repayment_amt'] != ""){
					echo Yii::app()->controller->renderPrice($floorId['repayment_amt']);
				}
				if(isset($floorId['repayment_amt_opt']) && $floorId['repayment_amt_opt'] != ""){
					if($floorId['repayment_amt_opt'] == 1){
						echo Yii::app()->controller->__trans('ヶ月');
					}elseif($floorId['repayment_amt_opt'] == 2){
						echo Yii::app()->controller->__trans('%');
					}else{
						echo '';
					}
				}
				?></td>
          <!--repayment-->
          <td class="f_price_keymoney_str" style="width:30px;">礼
            <?php
				if(isset($floorId['key_money_opt']) && $floorId['key_money_opt'] != ""){
					if($floorId['key_money_opt'] == 2){
						echo Yii::app()->controller->__trans('None');
					}elseif($floorId['key_money_opt'] == -1){
						echo Yii::app()->controller->__trans('Unknown');
					}elseif($floorId['key_money_opt'] == -2){
						echo Yii::app()->controller->__trans('undecided･ask');
					}else{
						echo '';
					}
				}else{
					echo '';
				}
				
				if(isset($floorId['key_money_month']) && $floorId['key_money_month'] != ""){
					echo $floorId['key_money_month'].Yii::app()->controller->__trans('month');
				}
				?></td>
          <!--key money-->
          <td class="f_oa" style="width:30px;">
          <?php
				if($floorId['oa_type'] == '非対応'){
					echo 'OA 非対応';
				}else if($floorId['oa_type'] == 'フリーアクセス'){
					echo 'フリーアクセス';
				}else if($floorId['oa_type'] == '1WAY'){
					echo 'OA '.Yii::app()->controller->__trans('1WAY');
				}else if($floorId['oa_type'] == '2WAY'){
					echo 'OA '.Yii::app()->controller->__trans('2WAY');
				}else if($floorId['oa_type'] == '3WAY'){
					echo 'OA '.Yii::app()->controller->__trans('3WAY');
				}else if($floorId['oa_type'] == '引き込み可'){
					echo 'OA 引き込み可';
				}else{
					echo '-';
				}
		 ?></td>
          <!--OA-->
          <td class="f_height" style="width:45px;">
          <?php
          if(isset($floorId['contract_period_opt']) && $floorId['contract_period_opt'] != ""){
          	if($floorId['contract_period_opt'] == 1){
          		echo '通常';
          	}elseif($floorId['contract_period_opt'] == 2){
          		echo '定借';
          	}elseif($floorId['contract_period_opt'] == 3){
          		echo '定借希望';
          	}else{
          		echo '-';
          	}
          }else{
          	echo '-';
          }
          
          if(isset($floorId['contract_period_optchk']) && $floorId['contract_period_optchk'] == 1){
          	echo '<br>年数相談';
          }
          
          if(isset($floorId['contract_period_duration']) && $floorId['contract_period_duration'] != ''){
          	echo '<br>'.$floorId['contract_period_duration'].' 年';
          }
          ?>
          </td>
          <!--type of contract-->
          <?php
			$floorTypeUseArray = array();
			$floorTypeUse = $floorId['type_of_use'];
			$floorTypeUseArray = explode(',',$floorTypeUse);
		  ?>
          <td class="f_purpose1" style="width:20px;"><?php
							$opt1Val = '×事';
							if(in_array('1',$floorTypeUseArray)){
								$opt1Val = '○事';
							}
							echo $opt1Val;
							?></td>
          <!--use for office-->
          <td class="f_purpose2" style="width:20px;"><?php
							$opt1Val = '×店';
							if(in_array('2',$floorTypeUseArray)){
								$opt1Val = '○店';
							}
							echo $opt1Val;
							?></td>
          <!--use for shop-->
          <td class="f_purpose4" style="width:20px;"><?php
							$opt2Val = '×倉';
							if(in_array('5',$floorTypeUseArray)){
								$opt2Val = '○倉';
							}
							echo $opt2Val;
							?></td>
          <!--use for warehouse-->
          <td class="f_purpose8" style="width:20px;"><?php
							$opt3Val = '×他';
							$otherArray = array();
							$useOfType = UseTypes::model()->findAll('is_active = 1');
							foreach($useOfType as $uType){
								if($uType['user_type_id'] == '1' || $uType['user_type_id'] == '2' || $uType['user_type_id'] == '5'){
									continue;
								}else{
									$otherArray[] = $uType['user_type_id'];
								}
							}
							$intersect = array_intersect($floorTypeUseArray,$otherArray);
							
							if(!empty($intersect)){
								$opt3Val = '○他';
							}
							echo $opt3Val;
							?></td>
          <!--use for other--> 
        </tr>
        <?php
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
					$address = $buildCart['address'];
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
    <h1><?php echo $requestData['header_name']; ?><?php if($requestData['header_name']=='') echo '','オフィスビルご紹介資料' ?></h1>
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
	      	echo $companyName['company_name']."様";	      
      }
      
	if(isset($_GET['user']))
	  $user = $_GET['user'];
	else 
	  $user = Yii::app()->user->getId();
	
	$user = Users::model()->findByAttributes(array('username'=>$user));
    $company_id = $user->company;
    $company = Company::model()->findByPK($company_id);
      ?>
    </div>
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
      <p class="address"><?php echo $company->address; ?></p>
      <!--author company address *common-->
      <p class="tel"><?php echo $company->phone; ?></p>
      <!--author company tel *common-->
      <p class="email"><?php echo $company->email; ?></p>
      <!--author company email *common-->
      </div>
      <div class="auth-right">
      <p class="date">
        日付：<?php  echo  date('Y.m.d'); ?>
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
	if(isset($requestData['print_route']) && $requestData['print_route'] == 1){
	?>
<div class="sheet_wrapper">
  <section class="sheet"> <img src="images/new_route_map.jpg" class="route-map"><!--image of route map-->
    <div class="notice clearfix">
      <div class="half left">
        <p>※契約面積・金額が㎡表示の物件は坪に換算しています。(坪換算値=3.3058)。</p>
        <p>※賃貸条件や建物設備は変更する可能性があります。正式な内容につきましては重要事項説明書をもってご説明致します。</p>
        <p>※ご紹介致しました物件が既に商談又は決定済みの節はご了承の程お願い申し上げます。</p>
        <p>※賃料等課税対象となる金額には別途消費税が加算されます。</p>
      </div>
      <div class="half right">
        <p>※共用率はワンフロア当りです。</p>
        <p>※(案)の表示階は、分割例とします。</p>
        <p>※★マークは想定価格を表しています。</p>
        <p>※契約が成立した場合仲介手数料として賃料の１カ月分を申し受けます。</p>
      </div>
    </div>
  </section>
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
        <th class="building-name">ビル名</th>
        <th class="building-addr">所在地</th>
        <th class="est-date">竣工</th>
        <th class="floor-space">延床面積</th>
        <th class="floor-construction">構造</th>
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
        <td class="center"><?php echo $buildCart['name']; ?></td>
        <td class="center"><?php echo $buildCart['address']; ?></td>
        <td class="center"><?php echo date('Y年 m月',strtotime($buildCart['built_year'])); ?></td>
        <td class="center"><?php echo $buildCart['total_floor_space'] != "" ? $buildCart['total_floor_space'].'m&sup2;' : "-"; ?></td>
        <?php /*?><td class="center"><?php echo $buildCart['total_floor_space'] != "" ? $buildCart['total_floor_space'].'坪' : "-"; ?></td><?php */?>
        <td class="center">
        <?php
        $typeDetails = ConstructionType::model()->findByPk($buildCart['construction_type_id']);
        echo $typeDetails['construction_type_name'];
        ?></td>
      </tr>
      <?php
		      $array[] = $buildCart['map_lat'].','.$buildCart['map_long'];
		      $buildNameArray[] = $buildCart['name'];
		      $buildingNumber++;
	      }
      }
      ?>
    </table>
  </section>
</div>
<?php
	if(isset($buildCartDetails) && count($buildCartDetails) > 0){
		$user = Users::model()->findByAttributes(array('username'=>Yii::app()->user->getId()));
		$logged_user_id = $user->user_id;
		$buildingNumber = 1;
		foreach($buildCartDetails as $buildCart){
			$floorDetails = Floor::model()->findAll('building_id = '.$buildCart['building_id'].' And vacancy_info = 1' );
			$pFloors = $proposedFloors;//explode(',',$prosalData['floor_id']);
			$floorDetailsTmp = $floorDetails;
			foreach($floorDetailsTmp as $floorKey => $floor){
				if(!in_array($floor['floor_id'],$pFloors)){
					unset($floorDetails[$floorKey]);
				}
			}
// 			for ($i=0; $i<20; $i++) {
// 				$floorDetails[] = $floorDetails[0];
// 			}
// 			echo '<pre>'; print_r($floorDetails);die;
			$sum_arem = 0;
			$sum_are_net = 0;
			if(count($floorDetails) <= 9 || true){
			?>
<div class="sheet_wrapper">
  <section class="sheet">
    <table class="building-profile single-info">
      <tr>
        <td colspan="2" class="title"><?php echo $buildingNumber.'-'.$buildCart['name']; ?></td>
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
        <div style="padding-top:15px" class="plan-img">
        <?php
			                                    $planPictureDetails = PlanPicture::model()->findAll('building_id = '.$buildCart['building_id'].' order by plan_picture_id desc');
									
                                    $latesPlan = array();
                                    if(isset($floorDetails) && count($floorDetails) > 0){                                    	
                                    	foreach($floorDetails as $plan){
                                    		if($plan->plan_picture_id==0) continue;
                                    		$latesPlan[] = $plan->plan_picture_id;
                                    	}
                                    	//$latesPlan = end($latesPlan);
                                    	
                                    	if(count($latesPlan)>0) {
                                    		$latesPlan = reset($latesPlan);
                                    		$planPictureDetails = PlanPicture::model()->findAll('plan_picture_id = '.$latesPlan);
                                    		if(isset($planPictureDetails) && count($planPictureDetails) > 0){
                                    			$latesPlan = array();
                                    			foreach($planPictureDetails as $plan){
                                    				$latesPlan[] = $plan->name;
                                    			}
                                    			$latesPlan = reset($latesPlan);
                                    		}
                                    	}
                                    	else{
                                    		$plan_standard_id = $buildCart['plan_standard_id'];
                                    		$planPictureDetails = PlanPicture::model()->findAll('plan_picture_id = '.$plan_standard_id);
                                    		if(isset($planPictureDetails) && count($planPictureDetails) > 0){
                                    			$latesPlan = array();
                                    			foreach($planPictureDetails as $plan){
                                    				$latesPlan[] = $plan->name;
                                    			}
                                    			//$latesPlan = end($latesPlan);
                                    			$latesPlan = reset($latesPlan);
                                    		} else {
                                    			$latesPlan = 'no_plan.jpg';
                                    		}
                                    	}                                    	
                                    } else {
                                    	$plan_standard_id = $buildCart['plan_standard_id'];
                                    	$planPictureDetails = PlanPicture::model()->findAll('plan_picture_id = '.$plan_standard_id);
                                    	if(isset($planPictureDetails) && count($planPictureDetails) > 0){
                                    		$latesPlan = array();
                                    		foreach($planPictureDetails as $plan){
                                    			$latesPlan[] = $plan->name;
                                    		}
                                    		//$latesPlan = end($latesPlan);
                                    		$latesPlan = reset($latesPlan);
                                    	} else {
                                    		$latesPlan = 'no_plan.jpg';
                                    	}
                                    }
									
									$areFloor = array();
                            $unk = $netk = $grosk = 0;
                            foreach($floorDetails as $areFloor){
                                if(isset($areFloor['calculation_method'])):
                                switch($areFloor['calculation_method']){
                                    case 0:
                                        $unk += 1;
                                        break;
                                    case 1:
                                        $netk +=1;
                                        break;
                                    case 2:
                                        $grosk +=1;
                                        break;
                                }
                                endif;
                            }                            
                            $callAre = array('確認中','ネット','グロス');
                            $aArr = array($unk,$netk,$grosk);
                            $aMax = max($aArr);
                            $aAllRepeat = array_count_values($aArr);
                            $indexMax = array_search($aMax,$aArr);
                            if($aAllRepeat[$aMax] > 1){
                                $label = $callAre[0];
                            }else{
                                $label = $callAre[$indexMax];
                            }
                                ?>
          <img src="<?php echo Yii::app()->baseUrl.'/planPictures/'.$latesPlan; ?>" /></div>
        </td>
        <td class="td_col2_3">
        <table class="current_status">
            <span class="caption"> 募集状況 </span>
            <tr>
              <th>階数</th>
              <th colspan="2">面積(<?php echo $label; ?>)</th>
              <th>預託金</th>
              <th>賃料</th>
              <th>共益費</th>
              <th>入居予定日/備考</th>
            </tr>
            <?php
// 				$pFloors = explode(',',$prosalData['floor_id']);
            	$pFloors = $proposedFloors;
				foreach($floorDetails as $indexFloor => $floor){
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
												<span class="caption">募集状況</span>
		                                        <tr>
		                                            <th>階数</th>
		                                            <th colspan="2">面積('. Yii::app()->controller->__trans("NET").')</th>
		                                            <th>預託金</th>
		                                            <th>賃料</th>
		                                            <th>共益費</th>
		                                            <th>入居予定日/備考</th>
		                                        </tr>';
					}
            ?>
            <tr>
              <td class="stairs center">
			  	<?php
				if(isset($floorId['preceding_user']) && $floorId['preceding_user'] != 0){
					echo '<span class="senko">先行有</span>';
				}
				
				if(isset($floorId['floor_down']) && $floorId['floor_down'] != ""){
					if(strpos($floorId['floor_down'], '-') !== false){
						$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
					}else{
						$floorDown = $floorId['floor_down'];
					}
					if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
						echo $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
					}else{
						echo $floorDown.' '.Yii::app()->controller->__trans('階');
					}
				}
				if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
					echo '&nbsp;'.$floorId['roomname'];
				}
				?></td>
              <td class="space center"><font> <font>
                <?php
                                                        if(isset($floorId['area_ping']) && $floorId['area_ping'] != ""){
                                                            echo $floorId['area_ping']." ".Yii::app()->controller->__trans('Ping');
                                                        }else{
                                                            echo '-';
                                                        }echo "<br/>";
                                                        ?>
                <?php
                                                            if(isset($floorId['payment_by_installments']) && $floorId['payment_by_installments'] == 1){
                                                                echo '分割例 :';
                                                            }else if(isset($floorId['payment_by_installments']) && $floorDetails['payment_by_installments'] == 2){
                                                                echo '分割可 :';
                                                            }
                                                        ?>
                <?php if(isset($floorId['floor_partition']) && $floorId['floor_partition'] != ""){
                                                              $expFloorParts = explode(',',$floorId['floor_partition']);
                                                                if(!empty($expFloorParts)){
                                                                    foreach($expFloorParts as $part){
                                                                        echo $part.'坪,'.'<br/>';
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
                                                        echo "ネット: ".$floorId['area_net']." 坪";
                                                    }else{
                                                        echo '';
                                                    }
                                                    ?>
                </font> </font></td>
              <td class="deposit right-align"><font><font>
                <?php
                                                        if(isset($floorId['deposit']) && $floorId['deposit'] != "" && $floorId['deposit'] != 0){
//                                                         	if(isset($floorId['rent_unit_price_opt']) && ($floorId['rent_unit_price_opt'] == -1 || $floorId['rent_unit_price_opt'] == -2)) {
//                                                         		echo $floorId['deposit_month'].Yii::app()->controller->__trans('month');
//                                                         	}else 
                                                        	{
																echo Yii::app()->controller->renderPrice($floorId['deposit']).Yii::app()->controller->__trans('yen / tsubo');
                                                        	}
                                                        }else{
                                                        	if(isset($floorId['rent_unit_price_opt']) && ($floorId['rent_unit_price_opt'] == -1 || $floorId['rent_unit_price_opt'] == -2)) {
                                                        		if(isset($floorId['deposit_month']) && $floorId['deposit_month'] != "" && $floorId['deposit_month'] != 0)
                                                        			echo $floorId['deposit_month'].Yii::app()->controller->__trans('month');
                                                        	}else
                                                            	echo '';
                                                        }
														if($floorId['deposit_opt'] != ''){
															if($floorId['deposit_opt'] == -1){
																echo Yii::app()->controller->__trans('undecided');
															}else if($floorId['deposit_opt'] == -3){
																echo Yii::app()->controller->__trans('none');
															}else if($floorId['deposit_opt'] == -2){
																echo Yii::app()->controller->__trans('undecided･ask');
															}
														}
														
														/*if(isset($floorId['deposit_month']) &&  $floorId['deposit_month'] != ''){
															echo '<br/>'.$floorId['deposit_month'].' ヶ月';
														}*/
                                                    ?>
                </font></font></td>
              <td class="rent-fee right-align"><font><font>
                <?php
                                                        if(isset($floorId['rent_unit_price']) && $floorId['rent_unit_price'] != "" && $floorId['rent_unit_price'] != 0){
                                                            echo Yii::app()->controller->renderPrice($floorId['rent_unit_price']).Yii::app()->controller->__trans('yen / tsubo');
                                                        }else{
                                                            echo '';
                                                        }
														if($floorId['rent_unit_price_opt'] != ''){
															if($floorId['rent_unit_price_opt'] == -1){
																echo Yii::app()->controller->__trans('undecided');
															}else if($floorId['rent_unit_price_opt'] == -2){
																echo Yii::app()->controller->__trans('ask');
															}
														}else{
															echo '';
														}
                                                    ?>
                </font></font></td>
              <td class="condo-fee right-align"><font><font>
                <?php
                                                        if(isset($floorId['unit_condo_fee']) && $floorId['unit_condo_fee'] != ""){
                                                            echo Yii::app()->controller->renderPrice($floorId['unit_condo_fee']).Yii::app()->controller->__trans('yen / tsubo');
                                                        }else{
                                                            if($floorId['unit_condo_fee_opt'] != ''){
																if($floorId['unit_condo_fee_opt'] == 0){
																	echo Yii::app()->controller->__trans('none');
																}else if($floorId['unit_condo_fee_opt'] == -1){
																	echo Yii::app()->controller->__trans('undecided');
																}else if($floorId['unit_condo_fee_opt'] == -2){
																	echo Yii::app()->controller->__trans('ask');
																}else if($floorId['unit_condo_fee_opt'] == -3){
																	echo '賃料に込み (含む)';
																}
															}else{
																echo '-';
															}
                                                        }
                                                    ?>
                </font></font></td>
              <td class="date-move center"><?php
                                                    if(isset($floorId['move_in_date']) && $floorId['move_in_date'] != "" && (string)$floorId['move_in_date'] != '0'){
                                                        echo $floorId['move_in_date'];
                                                    }else{
                                                        echo '-';
                                                    }
                                                ?></td>
              <?php $sum_arem += $floorId['area_ping']; ?>
              <?php $sum_are_net += $floorId['area_m']; ?>
            </tr>
            <tr>
              <td class="stairs center"></td>
              <td class="space center"></td>
              <td class="space center"></td>
              <td class="deposit right-align"><font><font>
                <?php
                                                        if(isset($floorId['total_deposit']) && $floorId['total_deposit'] != "0" && $floorId['total_deposit'] != ""){
                                                            echo Yii::app()->controller->renderPrice($floorId['total_deposit']).' 円';
                                                        }else{
															echo '';
														}
                                                    ?>
                </font></font></td>
              <td class="rent-fee right-align"><font><font>
                <?php
				                                        if(isset($floorId['total_rent_price']) && $floorId['total_rent_price'] != ""){
                                                            echo Yii::app()->controller->renderPrice($floorId['total_rent_price']).'円';
                                                        }else if($floorId['rent_unit_price_opt']==-1 || $floorId['rent_unit_price_opt']==-2) { 
//                                                         	echo $buildCart["building_id"].','.$floorId['floor_id'];
                                                        	
                                                        	$rentNegotiationDetails = RentNegotiation::model()->findAll('building_id = '.$buildCart["building_id"].' AND allocate_floor_id='.$floorId['floor_id'].' order by rent_negotiation_id desc LIMIT 1');
//                                                         	print_r($rentNegotiationDetails);
                                                        	$rentNegotiationDetails = $rentNegotiationDetails[0];
//                                                         	print_r($rentNegotiationDetails);
                                                        	if($rentNegotiationDetails['negotiation_type']==1) {
                                                        		echo Yii::app()->controller->__trans('low price').': '.Yii::app()->controller->renderPrice($rentNegotiationDetails['negotiation']).Yii::app()->controller->__trans('yen');
                                                        	} else if($rentNegotiationDetails['negotiation_type']==5) {
                                                        		echo Yii::app()->controller->__trans('standard price').': '.Yii::app()->controller->renderPrice($rentNegotiationDetails['negotiation']).Yii::app()->controller->__trans('yen');
                                                        	} else{
                                                            	echo '-';
                                                        	}
                                                        }
                                                        else{
                                                            echo '-';
                                                        }
                                                    ?>
                </font></font></td>
              <td class="condo-fee right-align"><font><font>
                <?php
                                                        if(isset($floorId['total_condo_fee']) && $floorId['total_condo_fee'] != ""){
                                                            echo Yii::app()->controller->renderPrice($floorId['total_condo_fee']).Yii::app()->controller->__trans('yen');
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
              <td class="stairs center"></td>
              <td class="space center"></td>
              <td class="space center"></td>
              <td class="deposit right-align"></td>
              <td class="rent-fee right-align"></td>
              <td class="condo-fee right-align"></td>
              <td class="date-move center"></td>
            </tr>
            <?php }?>
            <tr>
              <td class="total">計</td>
              <td class="space center"><?php echo $sum_arem; ?>坪</td>
              <td class="space center"><?php echo $sum_are_net; ?><?php echo Yii::app()->controller->__trans('m'); ?>&sup2;</td>
              <td class="deposit right-align"></td>
              <td class="rent-fee right-align"></td>
              <td class="condo-fee right-align"></td>
              <td class="date-move center"></td>
            </tr>
            <tr>
              <td class="right-align notes" colspan="7">上段：坪単価 下段：総額<br/>
                賃料等課税対象となる金額には別途消費税が加算されます</td>
            </tr>
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
                  <span class="caption">ビル概要</span>
                  <tr>
                    <th>所在地</th>
                    <td><?php echo $buildCart['address']; ?></td>
                  </tr>
                  <tr>
                    <th>交通</th>
                    <td><?php
							$trafficDetails = BuildingStation::model()->find('building_id = '.$buildCart['building_id'].' order by time');
                            echo $trafficDetails['name'].' 駅'.$trafficDetails['line'].' 徒歩'.$trafficDetails['time'].'分';
                        ?></td>
                  </tr>
                  <tr>
                    <th>竣工年月</th>
                    <td><?php echo date('Y年 m月',strtotime($buildCart['added_on'])); ?></td>
                  </tr>
                  <tr>
                    <th>規模</th>
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
																		echo '';
																	}
																}
															}else{
																echo '-';
															}
														?></td>
                  </tr>
                  <tr>
                    <th>リニューアル</th>
                    <td><?php echo $buildCart['renewal_data'] != "" ? $buildCart['renewal_data'] : "-"; ?></td>
                  </tr>
                  <tr>
                    <th>構造</th>
                    <td><?php
                                                            $typeDetails = ConstructionType::model()->findByPk($buildCart['construction_type_id']);
                                                            echo $typeDetails['construction_type_name'];
                                                        ?></td>
                  </tr>
                  <tr>
                    <th>延床面積</th>
                    <td><?php echo $buildCart['total_floor_space'] != "" ? $buildCart['total_floor_space'].' m&sup2;' : "-"; ?></td>
                  </tr>
                  <tr>
                    <th>基準階面積</th>
                    <td><?php echo $buildCart['std_floor_space'] != "" ? $buildCart['std_floor_space'].' 坪' : "-"; ?></td>
                  </tr>
                  <tr>
                    <th>共用率</th>
                    <td><?php echo $buildCart['shared_rate'] != "" ? $buildCart['shared_rate'].'%' : "-"; ?></td>
                  </tr>
                </table>
                <table class="summary facility-summary">
                  <span class="caption">設備概要</span>
                  <tr>
                    <th>空調制御</th>
                    <td><?php
		                    $fDetails = Floor::model()->findAll('building_id = '.$buildCart['building_id'].' And vacancy_info = 1' );
		                    $pFloors = $proposedFloors;
		                    $fDetailsTmp = $floorDetails;
		                    foreach($fDetailsTmp as $floorKey => $floor){
		                    	if(!in_array($floor['floor_id'],$pFloors)){
		                    		unset($fDetails[$floorKey]);
		                    	}
		                    }
		                    
		                    $res = Array(0=>'', 1=>'', 2=>'', 3=>'', 4=>'');
		                    foreach($fDetails as $floor){
		                    	if($floor['air_conditioning_facility_type']=="個別・セントラル") $res[0]="個別・セントラル";
		                    	if($floor['air_conditioning_facility_type']=="個別") $res[1]="個別";
		                    	if($floor['air_conditioning_facility_type']=="セントラル") $res[2]="セントラル";
		                    	if($floor['air_conditioning_facility_type']=="不明" || $floor['air_conditioning_facility_type']=="unknown") $res[3]="不明";
		                    	if($floor['air_conditioning_facility_type']=="無し") $res[4]="無し";
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
//                                                                 echo Yii::app()->controller->__trans('unknown');
//                                                             }else if($buildCart['air_control_type'] == 2){
//                                                                 echo Yii::app()->controller->__trans('Individual control');
//                                                             }else if($buildCart['air_control_type'] == 1){
//                                                                 echo Yii::app()->controller->__trans('Zone control');
//                                                             }
                                                        ?></td>
                  </tr>
                  <tr>
                    <th>天井高</th>
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
                    <th>OAフロア</th>
                    <td><?php
                                                            $floorOAList = Floor::model()->findAll('building_id = '.$buildCart['building_id'].' AND vacancy_info = 1');
                                                            $oaDefaultArray = array('フリーアクセス','3WAY','2WAY','1WAY','引き込み可','非対応');
															$oaFloor = array();
															$oaHeight = array();
                                                            foreach($floorOAList as $floorOA){
                                                                $oaFloor[] = $floorOA['oa_type'];
                                                                $oaHeight[] = $floorOA['oa_height'];
                                                            }
                                                            for($i=0;$i<count($oaFloor);$i++) {
                                                            	if(in_array($oaFloor[$i],$oaDefaultArray)){
                                                            		echo $oaFloor[$i];
                                                            		if($oaHeight[$i]!="" || (int)$oaHeight[$i]!=0) {
                                                            			echo " ".$oaHeight[$i]."mm";
                                                            		}
                                                            		break;
                                                            	}
                                                            } /*
                                                            foreach($oaDefaultArray as $oa){
                                                                if(in_array($oa,$oaFloor)){
                                                                    echo $oa;
                                                                    break;
                                                                }
                                                            } */
                                                            /*if(isset( $buildCart['oa_floor']) &&  $buildCart['oa_floor'] != ''){
                                                                $oaExplode = explode('-',$buildCart['oa_floor']);
                                                                if($oaExplode[0] == 0){
                                                                    echo Yii::app()->controller->__trans('unknown');
                                                                }else if($oaExplode[0] == 2){
                                                                    echo $oaExplode[1] != "" ? $oaExplode[1].'mm' : "-";
                                                                }else if($oaExplode[0] == 1){
                                                                    echo Yii::app()->controller->__trans('Nothing');
                                                                }else {
                                                                    echo '-';
                                                                }
                                                            }*/
                                                        ?></td>
                  </tr>
                  <tr>
                    <th>セキュリティ</th>
                    <td><?php
                                                            $securityDetails = Security::model()->findByPk($buildCart['security_id']);
                                                            echo $securityDetails['security_name'];
                                                        ?></td>
                  </tr>
                  <tr>
                    <th>光ケーブル</th>
                    <td><?php
                                                            if($buildCart['opticle_cable'] == 0){
                                                                echo Yii::app()->controller->__trans('unknown');
                                                            }else if($buildCart['opticle_cable'] == 1){
                                                                echo Yii::app()->controller->__trans('Pull Yes');
                                                            }else if($buildCart['opticle_cable'] == 2){
                                                                echo Yii::app()->controller->__trans('Nothing');
                                                            }else{
                                                                echo '-';
                                                            }
                                                        ?></td>
                  </tr>
                  <tr>
                    <th>エレベーター</th>
                    <td><?php
                                                            if(isset($buildCart['elevator']) && $buildCart['elevator'] != ''){
                                                                if(strlen($buildCart['elevator']) > 2){
                                                                    $elevatorExp = explode('-',$buildCart['elevator']);
                                                                    if($elevatorExp[0] == 1){
                                                                        echo Yii::app()->controller->__trans('Exist');
																		if($elevatorExp[1] != "" || $elevatorExp[2] != "" || $elevatorExp[3] != "" || $elevatorExp[4] != "" || $elevatorExp[5] != "") echo '(';
																		
																		echo isset($elevatorExp[1]) && $elevatorExp[1] != "" ? $elevatorExp[1].Yii::app()->controller->__trans('基') : "";
																		echo isset($elevatorExp[2]) && $elevatorExp[2] != "" ? '/'.$elevatorExp[2].Yii::app()->controller->__trans('人乗') : "";
																		echo isset($elevatorExp[3]) && $elevatorExp[3] != "" ? $elevatorExp[3].Yii::app()->controller->__trans('基・人荷用') : "";
																		echo isset($elevatorExp[4]) && $elevatorExp[4] != "" ? $elevatorExp[4].Yii::app()->controller->__trans('人乗') : "";
																		echo isset($elevatorExp[5]) && $elevatorExp[5] != "" ? $elevatorExp[5].'基' : "";
																		if($elevatorExp[1] != "" || $elevatorExp[2] != "" || $elevatorExp[3] != "" || $elevatorExp[4] != "" || $elevatorExp[5] != "") echo ')';
                                                                    }else{
                                                                        echo '-';
                                                                    }
                                                                }else{
                                                                    if($buildCart['elevator'] == -2){
                                                                        echo Yii::app()->controller->__trans('unknown');
                                                                    }else if($buildCart['elevator'] == 2){
                                                                        echo Yii::app()->controller->__trans('noexist');
                                                                    }
                                                                }
                                                            }else{
                                                                echo '-';
                                                            }
                                                        ?></td>
                  </tr>
                  <tr>
                    <th>駐車場</th>
                    <td><?php
                                                            if(isset($buildCart['parking_unit_no']) && count($buildCart['parking_unit_no']) > 0){
                                                                $parkingUnitNo = explode('-',$buildCart['parking_unit_no']);
                                                                if($parkingUnitNo[0] == 1){
                                                                   echo Yii::app()->controller->__trans('exist').($parkingUnitNo[1] != "" ? '('.$parkingUnitNo[1].' '.Yii::app()->controller->__trans('台').')' : "");
                                                                }else if($parkingUnitNo[0] == 2){
                                                                    echo Yii::app()->controller->__trans('noexist');
                                                                }else if($parkingUnitNo[0] == 3){
//                                                                     echo Yii::app()->controller->__trans('exist but unknown unit number');
                                                                	echo Yii::app()->controller->__trans('exist');
                                                                }
                                                            }
                                                        ?></td>
                  </tr>
                </table></td>
              <td class="pad-left var-top">
              	<table class="summary contract-info">
					<?php
                    	$contractArray = $renewalArray = $renewalFeeMonthArray = $keymoneyArray = $keyMoneyMonthArray = $amortizationArray = $repaymentMonthArray = array();
						$fName = $renewalDetails = $renewalOpt = $keyMoneyDetails =  $keyMoneyOpt = $amortizationDetails = $repaymentOpt = '';
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
										$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
									}else{
										$floorDown = $floorId['floor_down'];
									}
									if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
										$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
									}else{
										$fName =  $floorDown.' '.Yii::app()->controller->__trans('階');
									}
								}
								if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
									$fName .= '&nbsp;'.$floorId['roomname'];
								}
								if($val != 0 && $val != ""){
									if($val == 2){
										$renewalOpt = Yii::app()->controller->__trans('None');
									}else if($val == -1){
										$renewalOpt = Yii::app()->controller->__trans('unknown');
									}else if($val == -2){
										$renewalOpt = Yii::app()->controller->__trans('Undecided');
									}
									$renewalDetails .= $renewalOpt.(count($renewalArray) > 2 ? '('.$fName.')'.$slsh : ' ');
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
										$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
									}else{
										$floorDown = $floorId['floor_down'];
									}
									if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
										$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
									}else{
										$fName =  $floorDown.' '.Yii::app()->controller->__trans('階');
									}
								}
								if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
									$fName .= '&nbsp;'.$floorId['roomname'];
								}
								$renewalDetails .= $val.(count($renewalFeeMonthArray) > 2 ? '('.$fName.')'.$slsh : ' ');
								$k++;
							}
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
										$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
									}else{
										$floorDown = $floorId['floor_down'];
									}
									if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
										$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
									}else{
										$fName =  $floorDown.' '.Yii::app()->controller->__trans('階');
									}
								}
								if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
									$fName .= '&nbsp;'.$floorId['roomname'];
								}
								if($val != 0 && $val != ""){
									if($val == 2){
										$keyMoneyOpt = Yii::app()->controller->__trans('None');
									}else if($val == -1){
										$keyMoneyOpt = Yii::app()->controller->__trans('unknown');
									}else if($val == -2){
										$keyMoneyOpt = Yii::app()->controller->__trans('Undecided');
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
																$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
															}else{
																$floorDown = $floorId['floor_down'];
															}									
															if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
																$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
															}else{
																$fName =  $floorDown.' '.Yii::app()->controller->__trans('階');
															}
														}
														
														if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
															$fName .= '&nbsp;'.$floorId['roomname'];
														}
														$keyMoneyDetails .= $val.'ヶ月'.(count($keyMoneyMonthArray) > 2 ? '('.$fName.')'.$slsh : '');
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
																$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
															}else{
																$floorDown = $floorId['floor_down'];
															}									
															if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
																$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
															}else{
																$fName =  $floorDown.' '.Yii::app()->controller->__trans('階');
															}
														}
														
														if(isset($floorId['roomname']) && $floorId['roomname'] != ""){
															$fName .= '&nbsp;'.$floorId['roomname'];
														}
														if($val != 0 && $val != ""){
															if($val == -3){
																$repaymentOpt = Yii::app()->controller->__trans('None');
															}else if($val == -4){
																$repaymentOpt = Yii::app()->controller->__trans('unknown');
															}else if($val == -1){
																$repaymentOpt = Yii::app()->controller->__trans('Undecided');
															}else if($val == -2){
																$repaymentOpt = Yii::app()->controller->__trans('Consultation');
															}else if($val == -5){
																$repaymentOpt = Yii::app()->controller->__trans('Sliding');
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
																$floorDown = Yii::app()->controller->__trans("地下").' '.str_replace("-", "", $floorId['floor_down']);
															}else{
																$floorDown = $floorId['floor_down'];
															}									
															if(isset($floorId['floor_up']) && $floorId['floor_up'] != ''){
																$fName =  $floorDown.' - '.$floorId['floor_up'].' '.Yii::app()->controller->__trans('階');
															}else{
																$fName =  $floorDown.' '.Yii::app()->controller->__trans('階');
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
						<?php echo Yii::app()->controller->__trans('Contractual coverage'); ?>
                    </span>
                    <tbody>
                    	<tr>
                        	<th>
								<?php echo Yii::app()->controller->__trans('Contractual life'); ?>
                            </th>
                            <!--fixed texts-->
                            <td>
								<?php
                                	if(count($contractdiff) > 0){
										echo min($contractArray).(min($contractArray) != max($contractArray) ? ' ~ '.max($contractArray).' 年' : ' 年');
									}else{
										$contactVar = array_values($contractArray);
										if($contactVar[0] != ""){
											echo $contactVar[0].' 年';
										}else{
											echo '-';
										}
									}
								?>
								<?php
									$contractDefaultArray = array('1'=>'普通借家','2'=>'定借','3'=>'定借希望');
									foreach($contractDefaultArray as $key=>$val){
										if(in_array($key,$contractOptArray)){
											echo ' - '.$val;
											break;
										}
									}
								?>
                            </td>
                        </tr>
                        <tr>
                        	<th>更新費</th>
                            <td>
								<?php
									if(substr($renewalDetails, -1)=="" || substr($renewalDetails, -1)==" ")
										echo $renewalDetails; 
									else
										echo $renewalDetails.Yii::app()->controller->__trans('ヶ月');
								?>
                            </td>
                        </tr>
                        <tr>
                        	<th>礼金</th>
                            <td>
								<?php echo $keyMoneyDetails; ?>
                            </td>
                        </tr>
                        <tr>
                        	<th>償却費</th>
                            <td>
								<?php echo $amortizationDetails; ?>&nbsp;
                                <?php
                                if($MaxOccUnit && $MaxOccAmt){
								if($MaxOccUnit == 1){
									echo Yii::app()->controller->__trans('ヶ月');
								}elseif($MaxOccUnit == 2){
									echo Yii::app()->controller->__trans('%');
								}else{
									echo '';
								}
							}
                                ?>
                           	</td>
                        </tr>
                    </tbody>
                </table>
                <table class="summary time-to-use">
                  <?php
					if(isset($requestData['print_time_floor']) || isset($requestData['print_time_entrance'])){
                  ?>
                  <span class="caption">使用時間</span>
                  <?php
					}
                                                if(isset($requestData['print_time_floor']) == 1){
                                                    $limit_of_usage_time =  array();
                                                    if(isset($buildCart['limit_of_usage_time']) && $buildCart['limit_of_usage_time'] != ''){
                                                ?>
                  <tr>
                    <th rowspan="3">使用時間</th>
                    <td><?php
                                                            $limit_of_usage_time = explode(',',$buildCart['limit_of_usage_time']);
                                                            $limitTimeExplode = explode('-',$limit_of_usage_time[0]);
                                                            if($limitTimeExplode[0] == 1){
                                                                echo '平日 : '.Yii::app()->controller->__trans('Nothing');
                                                            }else if($limitTimeExplode[0] == 2){
                                                                echo '平日： 制限有り('.$limitTimeExplode[1].')';
                                                            }else if($limitTimeExplode[0] == 3){
                                                                echo ' 平日 : '.Yii::app()->controller->__trans('unknown');
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
                                                                    echo '土曜 : '.Yii::app()->controller->__trans('Nothing');
                                                                }else if($limitTimeExplode2[0] == 2){
                                                                    echo '土曜： 制限有り('.$limitTimeExplode2[1].')';
                                                                }else if($limitTimeExplode2[0] == 3){
                                                                    echo '土曜 : '.Yii::app()->controller->__trans('unknown');
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
                                                                    echo '休日： '.Yii::app()->controller->__trans('Nothing');
                                                                }else if($limitTimeExplode3[0] == 2){
                                                                    echo '休日： 制限有り('.$limitTimeExplode3[1].')';
                                                                }else if($limitTimeExplode3[0] == 3){
                                                                    echo '休日： '.Yii::app()->controller->__trans('unknown');
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
                    <th rowspan="3">正面玄関</th>
                    <td><?php
                                                            $opTimeExp = $opTimeExplode = array();
                                                            if(isset($buildCart['ent_op_cl_time']) && $buildCart['ent_op_cl_time'] != ''){
                                                                $opTimeExp = explode(',',$buildCart['ent_op_cl_time']);
                                                                $opTimeExplode = explode('-',$opTimeExp[0]);
                                                                if($opTimeExplode[0] == 1){
                                                                    echo '平日： '.Yii::app()->controller->__trans('Nothing');
                                                                }else if($opTimeExplode[0] == 2){
                                                                    echo '平日： 制限有り('.$opTimeExplode[1].')';
                                                                }else if($opTimeExplode[0] == 3){
                                                                    echo '平日：'.Yii::app()->controller->__trans('unknown');
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
                                                                    echo '土曜 : '.Yii::app()->controller->__trans('Nothing');
                                                                }else if($opTimeExplode2[0] == 2){
                                                                    echo '土曜： 制限有り('.$opTimeExplode2[1].')';
                                                                }else if($opTimeExplode2[0] == 3){
                                                                    echo '土曜 : '.Yii::app()->controller->__trans('unknown');
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
                                                                    echo '休日： '.Yii::app()->controller->__trans('Nothing');
                                                                }else if($opTimeExplode3[0] == 2){
                                                                    echo '休日： 制限有り('.$opTimeExplode3[1].')';
                                                                }else if($opTimeExplode3[0] == 3){
                                                                    echo '休日：'.Yii::app()->controller->__trans('unknown');
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
                  <span class="caption">備考</span>
                  <tr>
                    <th>見込賃料</th>
                    <td><?php														
                                                            if($expVal[0] != ""){
                                                                echo Yii::app()->controller->renderPrice($expVal[0]);
                                                                if($expVal[1] != ""){
                                                                    echo " ~";
                                                                }else{
                                                                    echo Yii::app()->controller->__trans('Yen');
                                                                }
                                                            }
                                                            if($expVal[1] != ""){
                                                                echo Yii::app()->controller->renderPrice($expVal[1]).Yii::app()->controller->__trans('Yen');
                                                            }
                                                            echo isset($expRent[1]) && $expRent[1] == 1 ? Yii::app()->controller->__trans('(共益費含む)') : Yii::app()->controller->__trans('(共益費含まない)');
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
						$address = $buildCart['address'];
						$lat = $buildCart['map_lat'];
						$lng = $buildCart['map_long'];
						$zoom = isset($arr_zoom[$buildingNumber-1])?$arr_zoom[$buildingNumber-1]:16;
					?>
<div class="sheet_wrapper">
  <section class="sheet"> <?php echo '<span class="build_title">'.$buildingNumber.'.'.$buildCart['name']."<span>"; ?>
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
			$buildNameArray[] = $buildCart['name'];
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
  <section class="sheet"> 
	<iframe id="map_whole" name="map_whole" src="/wholemap.php?key=<?=$gApiKey?>&zoom=<?=$zoom?>&type=<?=$type?>" style="width:277mm;height:179mm;"></iframe>
  </section>
</div>	
<?php } ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
<script>
$(document).ready(function(e) {
    /*************** print to pdf export ******************/
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
			$('.dispLoader').css('display','none');
			if(resp.status == 1){
				var win = window.open(resp.url, '_blank');
				if (win) {
					//Browser has allowed it to be opened
					win.focus();
				} else {
					//Browser has blocked it
					alert('Please allow popups for this website');
				}
				//location.href = reps.url;
			}else{
				alert('何かが間違っていました。');
			}
		});
	});
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
</script>
</body>

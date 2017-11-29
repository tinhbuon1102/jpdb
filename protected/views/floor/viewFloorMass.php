<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
	$update_management = isset($_GET['update_management'])?1:0;
	$aVendorType = Yii::app()->controller->getBuildingVendorType();
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />

<title>一括更新 <?=$buildingDetails['building_id'];?> : <?php echo $buildingDetails['name'];?></title>

<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/css/default.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/css/result_data.css?1477663797" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/css/ui.datepicker.css" />


<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/js/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/js/rollover.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/js/loading.js"></script>
<!-- <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/js/dialog.js"></script> -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/js/err_img_replace.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/js/jquery.accessible-news-slider_3.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/js/data_manage.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/js/jquery.tablefix.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/js/jquery.contextmenu.r2.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/js/ui.datepicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/js/ui.datepicker-ja.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/js/jquery.jgrowl.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/css/jquery.jgrowl.min.css" />

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/a2form.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/new_style.css" media="screen">
<style type="text/css">
  .bootom_pad{
    margin-bottom: 10px !important;
        padding-bottom: 22px !important;
  }
  .own_back{
    background-color: #76ade5 !important;
  }
  .error_val{
    border: 2px red !important;
    border-style: dotted !important;
  }
 </style>

<script>
	var baseUrl = "<?php echo Yii::app()->request->baseUrl; ?>";
	var b_no = <?php echo $buildingDetails['building_id'];?>;
	var upd_floor_done = 0;
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
	
	$(document).on('click','.btnSearchTrader',function(e){
		e.preventDefault();
		$('.ajxLoader').css('display','block');
		
		var query = $('.searchTraderText').val();
		var _bId = $('.hdnBid').val();
		var _fId = $('.hdnFid').val();
			if(query== ''){
				$('.ajxLoader').css('display','none');
				$(".searchTraderText").css("border-color", "red");
				return false;
			}
		var url = baseUrl+'/index.php?r=floor/getSearchedTraderList';
		call({url:url,params:{query:query,bId:_bId,fId:_fId},type:'POST',dataType : 'json'},function(resp){
			$('.traderResp').html(resp);
		});
	});

	$(document).on('click','.btnAddNewHistory',function(e){
		var formdata = $('#frmAddNewHistory').serialize();
		var validat = $('#frmAddNewHistory').valid({lang: 'jp'});
		if(validat == true){
			var url = baseUrl+'/index.php?r=floor/appendNewManagementHistoryMass';
			call({url:url,params:{formdata:formdata},type:'POST',dataType:'json'},function(resp){
 				if(resp.status == 1){
 					alert('管理詳細が追加されました。');
 					window.close();
// 					if(resp.update == 1){
// 						$('.messageManagement').removeClass('hide');
// 						$('.messageManagement').html('管理詳細が追加されました。');
// 					}
// 					$('#frmAddNewHistory')[0].reset();
// 					location.reload();
// 				}else{
// 					alert('何かが間違っていました。');
 				}
// 				setTimeout(function(){
// 					$('.btnModalClose').trigger('click');
// 					$('.manageInfoResponse').html(resp.result);
// 				},3000);
			});
		}
	});
</script>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/js/floor_list_update.js?t=1"></script>
<style>
div#contents table.fl_data_c th {
    word-wrap: break-word;
}
</style>
</head>

<body>
<?php 
 	$arr_floor = Array();
 	foreach($floorList as $floor) {
 		$arr_floor[] = $floor->floor_id;
 	}
	
?>
<input type="hidden" name="hdnBid" class="hdnBid" value="<?php echo $buildingDetails['building_id']; ?>"/>
<input type="hidden" name="hdnFid" class="hdnFid" value="<?php echo implode(',', $arr_floor)?>"/>
<div class="contextMenu" id="myMenu1">
	<ul id="special_context_menu"  style="font-size:12px; width:300px;">		
	</ul>
</div>

<div id="contents" class="fl_list">
<div id="main">
	<div class="ttl_fl">
		<div class="bdnm">
			<span class="bd_id">ビルID：
			<a style="background-color:#333; padding:3px; color:white; border-radius: 3px;" href="#"><?php echo $buildingDetails['building_id'];?></a>
			</span><?php echo $buildingDetails['name'];?>	</div><!--div.bdnm-->	
		
		<div class="bt_fl_add"><a  onclick="$('table#floor_insert_delete').fadeIn();">フロア追加・削除</a></div>	
	</div><!--div.ttl_fl-->

	<table class="floor_edit" id="floor_insert_delete" style="display:none;">
	<tr>
		<th scope="row">チェックを入れたフロアを</th>
		<td class="fl_edit">
			<label class="rd2"><input type="radio" name="floor_copy_or_delete" value="copy" /> コピーする</label>
			<label class="rd2"><input type="radio" name="floor_copy_or_delete" value="delete" /> 削除する</label>
		</td>
		<td class="bt"><input type="button" onclick="copy_delete_floor();" value="削除" class="bt_carry" /></td>
		<td><span>警告：この操作は取り戻せません。細心の注意を払って実施して下さい</span></td>
	</tr>
	<tr>
		<th scope="row">フロアの追加</th>
		<td class="fl_edit"><input type="text" name="add_floor_num" />&nbsp;個のフロアを追加する</td>
		<td class="bt"><input type="button" onclick="add_floor();" value="追加" class="bt_add" /></td>
		<td>&nbsp;</td>
	</tr>	
	</table>
	<form method="post" action="<?php echo Yii::app()->createUrl('floor/updateFloorMass'); ?>" onSubmit=" return submit_check();">
	<table class="fl_data_c" id="tablefix">
	<thead>
	<tr>
		<th scope="col" class="ck">&nbsp;</th>
		<th scope="col" col="f_no" class="w" >フロアID</th>
		<th scope="col" col="f_no" class="w" >Edit</th>
		<th scope="col" col="f_update_flag" class="w">更新日の<br>更新</th>
		<th scope="col" col="f_thisupdate" class="w">更新日</th>
		<th scope="col" col="f_floor" class="w">階数</th>
		<th scope="col" col="f_kubun" class="w">区分所有</th>
		<th scope="col" col="f_roomname" class="w">部屋名</th>
		<th scope="col" col="f_emp" class="w">空満			
			<span style="font-size:10px">
				<br>
				<input type="checkbox" name="switch_emp" value="1" />空
				<input type="checkbox" name="switch_emp" value="0" />満
			</span>
		</th>
		<th scope="col" col="f_acreg" class="w">坪数</th>
		<th scope="col" col="f_m2" class="w">平米数</th>
		<th style="width:1px; background-color:#333;" ></th>
		<th scope="col" col="f_bunkatsu" class="w">分割</th>
		<th scope="col" col="f_bunkatsu_detail" class="w">分割備考</th>
		<th scope="col" col="f_senko_flag" class="w">先行</th>
		<th scope="col" col="f_senko_detail" class="w">先行詳細</th>
		<th scope="col" col="f_senko_check_datetime" class="w">先行確認日</th>
		<th scope="col" col="f_rentstart" class="w">入居時期</th>
		<th scope="col" col="f_akiyotei_date" class="w">空き予定日</th>
		<th scope="col" col="f_purpose" class="w">用途</th>
		<th style="width:1px; background-color:#333;" ></th>
		<th scope="col" col="f_maisonette_flag" class="w">ﾒｿﾞﾈｯﾄﾀｲﾌﾟ</th>
		<th scope="col" col="f_netgross" class="w">ネット/グロス</th>
		<th scope="col" col="f_acreg_net" class="w">ネットの坪数</th>
		<th style="width:1px; background-color:#333;" ></th>
		<th scope="col" col="f_price_t_rent_opt" class="w">賃料<br>未定相談等<!--rent_unit_price_opt--></th>
		<th scope="col" col="f_price_t_rent" class="w">賃料<br>坪単価</th>
		<th scope="col" col="f_price_a_rent" class="w">賃料<br>総額</th>
		<th scope="col" col="f_price_t_mente_opt" class="w">共益費<br>未定相談等<!--unit_condo_fee_opt--></th>
		<th scope="col" col="f_price_t_mente" class="w">共益費<br>坪単価</th>
		<th scope="col" col="f_price_a_mente" class="w">共益費<br>総額</th>
		<th scope="col" col="f_price_m_shiki_opt" class="w" >敷金<br>未定相談等<!--deposit_opt--></th>
		<th scope="col" col="f_price_m_shiki" class="w" >敷金<br>ヶ月</th>
		<th scope="col" col="f_price_t_shiki" class="w" >敷金<br>坪単価</th>
		<th scope="col" col="f_price_a_shiki" class="w" >敷金<br>総額</th>
		<th scope="col" col="f_price_keymoney_opt" class="w" >礼金<br>未定相談等<!--key_money_opt--></th>
		<th scope="col" col="f_price_keymoney" class="w" >礼金<br>ヶ月</th>
		<th scope="col" col="f_price_rerent_opt" class="w" >更新料<br>未定相談等<!--renewal_fee_opt--></th>
		<th scope="col" col="f_price_rerent" class="w" >更新料<br>ヶ月</th>
		<th scope="col" col="f_price_amo_opt" class="w" >償却<br>未定相談等<!--repayment_opt--></th>
		<th scope="col" col="f_price_amo" class="w" >償却</th>
		<th scope="col" col="f_price_amo_flag" class="w" >償却<br>単位</th>
		<th scope="col" col="f_amo_memo" class="w">償却<br>備考</th>
		<th scope="col" col="f_price_amo_timeflag" class="w" >償却<br>現賃料・新賃料フラグ</th>
		<th style="width:1px; background-color:#333;" ></th>
<!-- 		<th scope="col" col="f_rentterm" class="w">契約年数</th> -->
		<th scope="col" col="f_leavenotice" class="w">解約予告</th>
		<th style="width:1px; background-color:#333;" ></th>
<!-- 		<th scope="col" col="f_lightline" class="w">光ケーブル</th> -->
		<th scope="col" col="f_floormate" class="w">床材質</th>
		<th scope="col" col="f_eleccapa" class="w">電気容量</th>
		<th scope="col" col="f_air" class="w">空調設備</th>
		<th scope="col" col="f_air_detail" class="w">空調設備詳細</th>
		<th scope="col" col="f_air_usetime" class="w">空調利用時間制限</th>
		<th scope="col" col="f_oa" class="w">OA</th>
		<th scope="col" col="f_freac_height" class="w">OA床高(mm)</th>
		<th scope="col" col="f_height" class="w">天井高(mm)</th>
		<th scope="col" col="f_wc_flag" class="w">トイレ男女別</th>
		<th style="width:1px; background-color:#333;" ></th>
		<th scope="col" col="f_regloan_flag" class="w">定期借家</th>
		<th scope="col" col="f_regloan_year" class="w">定期借家年数</th>
		<th scope="col" col="f_regloan_year_optcheck" class="w" >契約年数相談<!--contract_period_optchk--></th>
		<th scope="col" col="f_tankigashi_flag" class="w">短期貸し対応</th>
		<th scope="col" col="f_web_publishing_note" class="w">Web非公開</th>	
	</tr>
	</thead>
	
	<tbody>
	<?php foreach($floorList As $floor) {
		$fid = $floor->floor_id;	
		$isCompartOpt = '0';
		$managementCompartDetails = OwnershipManagement::model()->findAll('building_id = '.$buildingDetails['building_id'].' AND floor_id = '.$fid.' and is_compart = 1');
		if(count($managementCompartDetails) > 0){
			$isCompartOpt = (int)$managementCompartDetails[0]->is_compart;
		}
		
		$d1 = date('Y-m-d H:i:s',strtotime($floor['modified_on']));
		$d2 = date('y.m.d H',strtotime($floor['modified_on']));
	?>
	<tr f_no="<?=$fid?>" f_emp="<?php echo (int)$floor->vacancy_info?>" class="floorlist <?php echo $floor['fixed_floor'] ? 'fixed_floor' : ''?>">
		<input type="hidden" name="f_id[]" value="<?=$fid?>">
		<td f_no="<?=$fid?>" col="" od=""  class="ck" scope="col">
			<input type="checkbox" class="mass_update_target" value="<?=$fid?>">
		</td>
		<td>
			<a style="background-color:#333; padding:3px; color:white; border-radius: 3px;">
				<?php echo HelperFunctions::translateBuildingValue('floor_up_down', $buildingDetails, $floor);?>
              	<?php echo HelperFunctions::translateBuildingValue('roomname', $buildingDetails, $floor);?>
			</a>
		</td>
		<td>
			<div class="bt_update">
                          <a href="<?php echo Yii::app()->createUrl('floor/update',array('id'=>$fid)); ?>" onclick="window.open('<?php echo Yii::app()->createUrl('floor/update2',array('id'=>$fid,'window'=>1)); ?>', 'newwindow', 'width=1052, height=600'); return false;" style="padding: 7px; text-decoration: none; background-color: #2E7BBA; color: #fff;"><?php echo Yii::app()->controller->__trans('Edit'); ?></a>
                                
            </div>
		</td>
		<td f_no="<?=$fid?>" col="f_update_flag" od=""  class="w edit" style="" scope="col">
			<img id="f_update_flag<?=$fid?>" name="f_update_flag" src="<?php echo Yii::app()->request->baseUrl; ?>/js/massupdate/css/img/ico_check_mark.gif" class="f_not_updated">
			<input type="hidden" name="f_update_flag[]" value="0">
		</td>
		<td f_no="<?=$fid?>" col="f_thisupdate" od="<?=$d1?>" class="w " style="" scope="col"><?=$d2?>時</td>
		<td f_no="<?=$fid?>" col="f_floor" od=""  f_floor_down='<?=$floor->floor_down?>' f_floor_up='<?=$floor->floor_up?>'  class="w edit" style="" scope="col"><?=$floor->floor_down?>階</td>
		<td f_no="<?=$fid?>" col="f_kubun" od="<?=$isCompartOpt?>"  class="w edit" style="" scope="col"><?=$isCompartOpt?></td>
		<td f_no="<?=$fid?>" col="f_roomname" od="<?=$floor->roomname?>"  class="w edit" style="" scope="col"><?=$floor->roomname?></td>
		<td f_no="<?=$fid?>" col="f_emp" od="<?=$floor->vacancy_info?>"  class="w edit" style="color:<? echo $floor->vacancy_info==0?"red":"blue"?>; font-weight:bold; " scope="col"><?=$floor->vacancy_info?></td>
		<td f_no="<?=$fid?>" col="f_acreg" od="<?=$floor->area_ping?>"  class="w edit" style="" scope="col"><?=$floor->area_ping?></td>
		<td f_no="<?=$fid?>" col="f_m2" od="<?=$floor->area_m?>"  class="w edit" style="" scope="col"><?=$floor->area_m?></td>
		<td style="width:1px; background-color:#333;"></td>
		<td f_no="<?=$fid?>" col="f_bunkatsu" od="<?=$floor->payment_by_installments?>"  class="w edit" style="" scope="col"><?=$floor->payment_by_installments?></td>
		<td f_no="<?=$fid?>" col="f_bunkatsu_detail" od="<?=$floor->payment_by_installments_note?>"  class="w edit" style="" scope="col"><?=$floor->payment_by_installments_note?></td>
		<td f_no="<?=$fid?>" col="f_senko_flag" od="<?=$floor->preceding_user?>"  class="w edit" style="" scope="col"><?=$floor->preceding_user?></td>
		<td f_no="<?=$fid?>" col="f_senko_detail" od="<?=$floor->preceding_details?>"  class="w edit" style="" scope="col"><?=$floor->preceding_details?></td>
		<td f_no="<?=$fid?>" col="f_senko_check_datetime" od="<?=$floor->preceding_check_datetime?>"  class="w edit" style="" scope="col"><?=$floor->preceding_check_datetime?></td>
		<td f_no="<?=$fid?>" col="f_rentstart" od="<?=$floor->move_in_date?>"  class="w edit" style="" scope="col"><?=$floor->move_in_date?></td>
		<td f_no="<?=$fid?>" col="f_akiyotei_date" od="<?=$floor->vacant_schedule?>"  class="w edit" style="" scope="col"><?=$floor->vacant_schedule?></td>
		<td f_no="<?=$fid?>" col="f_purpose" od="<?=$floor->type_of_use?>"  class="w edit" style="" scope="col"><?=$floor->type_of_use?> </td>
		<td style="width:1px; background-color:#333;"></td>
		<td f_no="<?=$fid?>" col="f_maisonette_flag" od="<?=$floor->maisonette_type?>"  class="w edit" style="" scope="col"><?=$floor->maisonette_type?></td>
		<td f_no="<?=$fid?>" col="f_netgross" od="<?=$floor->calculation_method?>"  class="w edit" style="" scope="col"><?=$floor->calculation_method?></td>
		<td f_no="<?=$fid?>" col="f_acreg_net" od="<?=$floor->area_net?>"  class="w edit" style="" scope="col"><?=$floor->area_net?></td>
		<td style="width:1px; background-color:#333;"></td>
		<td f_no="<?=$fid?>" col="f_price_t_rent_opt" od="<?=$floor->rent_unit_price_opt?>"  class="w edit" style="" scope="col"><?=$floor->rent_unit_price_opt ? $floor->rent_unit_price_opt : ''?></td><!--new-->
		<td f_no="<?=$fid?>" col="f_price_t_rent" od="<?=$floor->rent_unit_price?>"  class="w edit" style="" scope="col"><?=$floor->rent_unit_price?></td>
		<td f_no="<?=$fid?>" col="f_price_a_rent" od="<?=$floor->total_rent_price?>"  class="w edit" style="" scope="col"><?=$floor->total_rent_price?></td>
		<td f_no="<?=$fid?>" col="f_price_t_mente_opt" od="<?=$floor->unit_condo_fee_opt?>"  class="w edit" style="" scope="col"><?=$floor->unit_condo_fee_opt?></td><!--new-->
		<td f_no="<?=$fid?>" col="f_price_t_mente" od="<?=$floor->unit_condo_fee?>"  class="w edit" style="" scope="col"><?=$floor->unit_condo_fee?></td>
		<td f_no="<?=$fid?>" col="f_price_a_mente" od="<?=$floor->total_condo_fee?>"  class="w edit" style="" scope="col"><?=$floor->total_condo_fee?></td>
		<td f_no="<?=$fid?>" col="f_price_m_shiki_opt" od="<?=$floor->deposit_opt?>"  class="w edit" style="" scope="col"><?=$floor->deposit_opt?></td><!--new-->
		<td f_no="<?=$fid?>" col="f_price_m_shiki" od="<?=$floor->deposit_month?>"  class="w edit" style="" scope="col"><?=$floor->deposit_month?></td>
		<td f_no="<?=$fid?>" col="f_price_t_shiki" od="<?=$floor->deposit?>"  class="w edit" style="" scope="col"><?=$floor->deposit?></td>
		<td f_no="<?=$fid?>" col="f_price_a_shiki" od="<?=$floor->total_deposit?>"  class="w edit" style="" scope="col"><?=$floor->total_deposit?></td>
		<td f_no="<?=$fid?>" col="f_price_keymoney_opt" od="<?=$floor->key_money_opt?>"  class="w edit" style="" scope="col"><?=$floor->key_money_opt?></td><!--changed col name-->
		<td f_no="<?=$fid?>" col="f_price_keymoney" od="<?= (!$floor->key_money_opt)?$floor->key_money_month:''?>"  class="w edit" style="" scope="col"><?= (!$floor->key_money_opt)?$floor->key_money_month:''?></td><!--new-->
		<td f_no="<?=$fid?>" col="f_price_rerent_opt" od="<?=$floor->renewal_fee_opt?>"  class="w edit" style="" scope="col"><?=$floor->renewal_fee_opt?></td><!--changed col name-->
		<td f_no="<?=$fid?>" col="f_price_rerent" od="<?=(!$floor->renewal_fee_opt)?$floor->renewal_fee_recent:''?>"  class="w edit" style="" scope="col"><?=(!$floor->renewal_fee_opt)?$floor->renewal_fee_recent:''?></td><!--new-->
		<td f_no="<?=$fid?>" col="f_price_amo_opt" od="<?=$floor->repayment_opt?>"  class="w edit" style="" scope="col"><?=$floor->repayment_opt?></td><!--changed col name-->
		<td f_no="<?=$fid?>" col="f_price_amo" od="<?=(!$floor->repayment_opt)?$floor->repayment_amt:''?>"  class="w edit" style="" scope="col"><?=(!$floor->repayment_opt)?$floor->repayment_amt:''?></td><!--new-->
		<td f_no="<?=$fid?>" col="f_price_amo_flag" od="<?=(!$floor->repayment_opt)?$floor->repayment_amt_opt:''?>"  class="w edit" style="" scope="col"><?=(!$floor->repayment_opt)?$floor->repayment_amt_opt:''?></td>
		<td f_no="<?=$fid?>" col="f_amo_memo" od="<?=$floor->repayment_notes?>"  class="w edit" style="" scope="col"><?=$floor->repayment_notes?></td>
 		<td f_no="<?=$fid?>" col="f_price_amo_timeflag" od="<?=$floor->repayment_reason?>"  class="w edit" style="" scope="col"><?=$floor->repayment_reason?></td>
		<td style="width:1px; background-color:#333;"></td>
<!-- 	<td f_no="1018756" col="f_rentterm" od="0"  class="w edit" style="" scope="col">0</td> -->
		<td f_no="<?=$fid?>" col="f_leavenotice" od="<?=$floor->notice_of_cancellation?>"  class="w edit" style="" scope="col"><?=$floor->notice_of_cancellation?></td>
		<td style="width:1px; background-color:#333;"></td>
<!-- 	<td f_no="1018756" col="f_lightline" od="0"  class="w edit" style="" scope="col">0</td> -->
		<td f_no="<?=$fid?>" col="f_floormate" od="<?=$floor->floor_material?>"  class="w edit" style="" scope="col"><?=$floor->floor_material?></td>
		<td f_no="<?=$fid?>" col="f_eleccapa" od="<?=$floor->electric_capacity?>"  class="w edit" style="" scope="col"><?=$floor->electric_capacity?></td>
		<td f_no="<?=$fid?>" col="f_air" od="<?=$floor->air_conditioning_facility_type?>"  class="w edit" style="" scope="col"><?=$floor->air_conditioning_facility_type?></td>
		<td f_no="<?=$fid?>" col="f_air_detail" od="<?=$floor->air_conditioning_details?>"  class="w edit" style="" scope="col"><?=$floor->air_conditioning_details?></td>
		<td f_no="<?=$fid?>" col="f_air_usetime" od="<?=$floor->air_conditioning_time_used?>"  class="w edit" style="" scope="col"><?=$floor->air_conditioning_time_used?></td>
		<td f_no="<?=$fid?>" col="f_oa" od="<?=$floor->oa_type?>"  class="w edit" style="" scope="col"><?=$floor->oa_type?></td>
		<td f_no="<?=$fid?>" col="f_freac_height" od="<?=$floor->oa_height?>"  class="w edit" style="" scope="col"><?=$floor->oa_height?></td>
		<td f_no="<?=$fid?>" col="f_height" od="<?=$floor->ceiling_height?>"  class="w edit" style="" scope="col"><?=$floor->ceiling_height?></td>
		<td f_no="<?=$fid?>" col="f_wc_flag" od="<?=$floor->separate_toilet_by_gender?>"  class="w edit" style="" scope="col"><?=$floor->separate_toilet_by_gender?></td>
		<td style="width:1px; background-color:#333;"></td>
		<td f_no="<?=$fid?>" col="f_regloan_flag" od="<?=$floor->contract_period_opt?>"  class="w edit" style="" scope="col"><?=$floor->contract_period_opt?></td>
		<td f_no="<?=$fid?>" col="f_regloan_year" od="<?=$floor->contract_period_duration?>"  class="w edit" style="" scope="col"><?=$floor->contract_period_duration?></td>
		<td f_no="<?=$fid?>" col="f_regloan_year_check" od="<?=($floor->contract_period_optchk)?$floor->contract_period_optchk:''?>"  class="w edit" style="" scope="col" ><?=($floor->contract_period_optchk)?$floor->contract_period_optchk:''?></td><!--new-->
		<td f_no="<?=$fid?>" col="f_tankigashi_flag" od="<?=$floor->short_term_rent?>"  class="w edit" style="" scope="col"><?=$floor->short_term_rent?></td>
		<td f_no="<?=$fid?>" col="f_web_publishing_note" od="<?=$floor->web_publishing_note?>"  class="w edit" style="" scope="col"><?=$floor->web_publishing_note?></td>
	</tr>
	<?php } ?>
	<tr class="all">
		<td><input type="checkbox" class="mass_update_all_check_switch" ></td>
		<td class="w" colspan="3" id="massUpdateTitle">一括更新欄</td>	
		<td col="f_update_flag" class="w massupdate edit">&nbsp;</td>
		<td col="f_kubun" class="w massupdate edit">&nbsp;</td>
		<td col="f_roomname" class="w massupdate edit">&nbsp;</td>
		<td col="f_emp" class="w massupdate edit">&nbsp;</td>
		<td col="f_acreg" class="w massupdate edit">&nbsp;</td>
		<td col="f_m2" class="w massupdate edit">&nbsp;</td>
		<td style="width:1px; background-color:#333;"></td>
		<td col="f_bunkatsu" class="w massupdate edit">&nbsp;</td>
		<td col="f_bunkatsu_detail" class="w massupdate edit">&nbsp;</td>
		<td col="f_senko_flag" class="w massupdate edit">&nbsp;</td>
		<td col="f_senko_detail" class="w massupdate edit">&nbsp;</td>
		<td col="f_senko_check_datetime" class="w massupdate edit">&nbsp;</td>
		<td col="f_rentstart" class="w massupdate edit">&nbsp;</td>
		<td col="f_akiyotei_date" class="w massupdate edit">&nbsp;</td>
		<td col="f_purpose" class="w massupdate edit">&nbsp;</td>
		<td style="width:1px; background-color:#333;"></td>
		<td col="f_maisonette_flag" class="w massupdate edit">&nbsp;</td>
		<td col="f_netgross" class="w massupdate edit">&nbsp;</td>
		<td col="f_acreg_net" class="w massupdate edit">&nbsp;</td>
		<td style="width:1px; background-color:#333;"></td>
		<td col="f_price_t_rent_opt" class="w massupdate edit">&nbsp;</td>
		<td col="f_price_t_rent" class="w massupdate edit">&nbsp;</td>
		<td col="f_price_a_rent" class="w massupdate edit">&nbsp;</td>
		<td col="f_price_t_mente_opt" class="w massupdate edit">&nbsp;</td>
		<td col="f_price_t_mente" class="w massupdate edit">&nbsp;</td>
		<td col="f_price_a_mente" class="w massupdate edit">&nbsp;</td>
		<td col="f_price_m_shiki_opt" class="w massupdate edit">&nbsp;</td>
		<td col="f_price_m_shiki" class="w massupdate edit">&nbsp;</td>
		<td col="f_price_t_shiki" class="w massupdate edit">&nbsp;</td>
		<td col="f_price_a_shiki" class="w massupdate edit">&nbsp;</td>
		<td col="f_price_keymoney_opt" class="w massupdate edit">&nbsp;</td>
		<td col="f_price_keymoney" class="w massupdate edit">&nbsp;</td>
		<td col="f_price_rerent_opt" class="w massupdate edit">&nbsp;</td>
		<td col="f_price_rerent" class="w massupdate edit">&nbsp;</td>
		<td col="f_price_amo_opt" class="w massupdate edit">&nbsp;</td>
		<td col="f_price_amo" class="w massupdate edit">&nbsp;</td>
		<td col="f_price_amo_flag" class="w massupdate edit">&nbsp;</td>
		<td col="f_amo_memo" class="w massupdate edit">&nbsp;</td>
		<td col="f_price_amo_timeflag" class="w massupdate edit">&nbsp;</td>
		<td style="width:1px; background-color:#333;"></td>
<!-- 	<td col="f_rentterm" class="w massupdate edit">&nbsp;</td> -->
		<td col="f_leavenotice" class="w massupdate edit">&nbsp;</td>
		<td style="width:1px; background-color:#333;"></td>
<!-- 	<td col="f_lightline" class="w massupdate edit">&nbsp;</td> -->
		<td col="f_floormate" class="w massupdate edit">&nbsp;</td>
		<td col="f_eleccapa" class="w massupdate edit">&nbsp;</td>
		<td col="f_air" class="w massupdate edit">&nbsp;</td>
		<td col="f_air_detail" class="w massupdate edit">&nbsp;</td>
		<td col="f_air_usetime" class="w massupdate edit">&nbsp;</td>
		<td col="f_oa" class="w massupdate edit">&nbsp;</td>
		<td col="f_freac_height" class="w massupdate edit">&nbsp;</td>
		<td col="f_height" class="w massupdate edit">&nbsp;</td>
		<td col="f_wc_flag" class="w massupdate edit">&nbsp;</td>
		<td style="width:1px; background-color:#333;"></td>
		<td col="f_regloan_flag" class="w massupdate edit">&nbsp;</td>
		<td col="f_regloan_year" class="w massupdate edit">&nbsp;</td>
		<td col="f_regloan_year_check" class="w massupdate edit">&nbsp;</td>
		<td col="f_tankigashi_flag" class="w massupdate edit">&nbsp;</td>
		<td col="f_web_publishing_note" class="w massupdate edit">&nbsp;</td>
	</tr>
	</tbody>
	</table>
<div class="form_box">
<table class="edit_input">
	<tr>
		<th>今回の情報源</th>
		<td>
			<label class="rd2"><input type="radio" name="fh_source" value="2"  checked> リスト</label>
			<label class="rd2"><input type="radio" name="fh_source" value="3" > 広告</label>
			<label class="rd2"><input type="radio" name="fh_source" value="4" > 電話</label>
			<label class="rd2"><input type="radio" name="fh_source" value="5" > 案内</label>
			<label class="rd2"><input type="radio" name="fh_source" value="6" > 面談</label>
			<label class="rd2"><input type="radio" name="fh_source" value="7" > 契約</label>
			<label class="rd2"><input type="radio" name="fh_source" value="8" > ｱｯﾄﾎｰﾑｳｪﾌﾞ</label>
			<label class="rd2"><input type="radio" name="fh_source" value="9" > ｱｯﾄﾎｰﾑ以外のｳｪﾌﾞ</label>
			<label class="rd2"><input type="radio" name="fh_source" value="10" > 外部修正依頼</label>
			<label class="rd2"><input type="radio" name="fh_source" value="11" > その他</label>
		</td>
	</tr>
	
	<tr>
		<th>更新担当</th>
		<td>
			<select name='fh_update_rep' id='fh_update_rep' data-role='none' >
				<option value=''>-</option>
				<?php
					if(isset($users) && count($users)){
						foreach($users as $user){
							$userFull = AdminDetails::model()->find('user_id = '.$user['user_id']);
				?>
				<option value="<?php echo $user['user_id']; ?>" ><?php echo $userFull['full_name']; ?></option>
				<?php
                		}
					}
				?>
			</select>
		</td>
	</tr>
	
	<tr>
		<th>物件確認担当</th>
		<td>
			<select name='fh_source_rep' id='fh_source_rep' data-role='none' >
				<option value=''>-</option>
				<?php
					if(isset($users) && count($users)){
						foreach($users as $user){
							$userFull = AdminDetails::model()->find('user_id = '.$user['user_id']);
				?>
				<option value="<?php echo $user['user_id']; ?>" ><?php echo $userFull['full_name']; ?></option>
				<?php
                		}
					}
				?>
			</select>
		</td>
	</tr>
	
	<tr>
		<th>更新日</th>
		<td>
		<label><input type="checkbox" name="update_all_floor_update_date" value="0" > 全フロアの更新日を本日にする</label>
		</td>
	</tr>
</table>
</div><!--div.form_box-->

<div class="bt_input_box">
	<input type="hidden" name="b_no" value="<?=$buildingDetails['building_id']?>">
	<input type="submit" value="フロア情報を更新" class="bt_fl_update">
</div>
</form>
</div><!--div.main-->
</div><!--div.contents-->

<?php 
if($update_management==1) {
?>
<script>
$(function() {
	$("#appendManagementModal").dialog({
		modal: true,
		autoOpen: true,
		width: 952,
		resizable:false,
		title: "<?php echo Yii::app()->controller->__trans('Building management edit・add'); ?>",
		buttons: {
		}
	});
});
</script>

<div id="dialog"> 
</div>
<!--Modal Popup for append management history-->
<dl id="appendManagementModal" class="popup_ty5 dialog">
<dd>
        	<?php
// 			$divcls = $divlbl = '';
// 			if($isCompart != ""){
// 				$divcls = 'color-blue';
// 				$divlbl = $isCompart;
// 			}
			
// 			if($isShared != ""){
// 				$divcls = 'color-orange';
// 				$divlbl = $isShared;
// 			}
			?>
        	<div class="differentOwner <?php echo $divcls; ?>"><?php echo $divlbl; ?></div>
        	<div id="main" class="full-width">
            <div class="tab_con" style="max-height: 365px">
            <div class="manage-info table-box new_style_box">
                <form name="frmAddNewHistory" id="frmAddNewHistory" class="frmAddNewHistory" action="<?php echo Yii::app()->createUrl('floor/addHistory'); ?>">
                    <div class="manageInfoResponse">
                        <input type="hidden" name="hdnHistFloorId" id="hdnHistFloorId" value="<?php echo isset($_GET['id']) && $_GET['id'] != "" ? $_GET['id'] : 0; ?>"/>
                        <input type="hidden" name="hdnBillId" id="hdnBillId" value="<?php echo $buildingDetails['building_id']; ?>"/>
                        <input type="hidden" name="base_url" id="base_url" value="<?php echo Yii::app()->request->baseUrl; ?>">
                        <table class="newform_info ad_list">
                            <tbody>
                                <tr>
                                    <th>業者ID<!--Trader ID--></th>
                                    <td><input type="text" name="searchTradersText" class="ty3 searchTradersText2"  id="searchTraderText" ></td>
                                    <th class="btn-cell">
                                        <a href="javaScript:void(0)" class="button style_navy" id="btnSearchTrader">業者を検索</a>
                                    </th>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <select id="trader_id_new" class="auto tradersListNEW" name="traders_id">
                                          <option value="0">既に追加済みの業者</option>
                                          <?php
                                            if(!empty($trans_all)){
                                                foreach($trans_all as $trans_alls){
                                                    $selected = '';
                                            ?>
                                            <option value="<?php echo $trans_alls['trader_id']; ?>"  <?php echo $selected; ?>><?php echo $trans_alls['traderId'].' '.$trans_alls['trader_name']; ?></option>
                                            <?php
                                                }
                                            }else{
                                            ?>
                                            <option value=""><?php echo Yii::app()->controller->__trans('No Trader Available');?></option>
                                            <?php
                                            }
                                            ?>
                                        </select></td>
                                    <th>&nbsp;</th>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>種別</th>
                                    <td>
                                    <select name="traders_type" id="traders_type" data-role="none" class="traders_type" >
                                    <option value="">-</option>
                                    <option value="1">オーナー</option>
                                    <option value="6">サブリース</option>
                                    <option value="7">貸主代理</option>
                                    <option value="8">AM</option>
                                    <option value="10">業者</option>
                                    <option value="4">仲介業者</option>
                                    <option value="2">管理会社</option>
                                    <option value="9">PM</option>
                                    <option value="3">ゼネコン</option>
                                    <option value="-1">不明</option>
                                    </select>
                                    </td>
                                    <th>管理種別</th>
                                    <td>
                                    <select name="management_type_traders" id="traders_contract" class="management_type_traders" data-role="none">
                                      <option value="">-</option>
                                      <option value="-1">不明</option>
                                      <option value="1">専任媒介</option>
                                      <option value="2">一般媒介</option>
                                      <option value="3">代理</option>
                                      <option value="4">貸主</option>
                                    </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>社名</th>
                                    <td><input type="text" name="traders_company_name" id="traders_name" value="" class="ty6 traders_company_name" required></td>
                                    <th>&nbsp;</th>
                                    <td>&nbsp;</td>
                               </tr>
                               <tr>
                                    <th>TEL</th>
                                    <td><input type="text" name="traders_tel" id="td_tel" value="" class="ty6 traders_tel" required></td>
                                    <th>FAX</th>
                                    <td><input type="text" name="traders_fax" id="td_fax" value="" class="ty6 traders_fax" required></td>
                               </tr>
                               <tr>
                                    <th>担当者1</th>
                                    <td><input type="text" name="traders_person_in_charge1" id="bo_rep1" value="" class="ty3 person_in_charge1"></td>
                                    <th>担当者2</th>
                                    <td><input type="text" name="traders_person_in_charge2" id="bo_rep2" value="" class="ty3 person_in_charge2"></td>
                               </tr>
                               <tr>
                                    <th>手数料</th>
                                    <td colspan="3">
                                    <label class="rd2"><input type="radio" name="charge_traders" value="unknown" class="radiUnknown"> 不明</label>
                                    <label class="rd2"><input type="radio" name="charge_traders" value="ask" class="radiAsk"> 相談</label>
                                    <label class="rd2"><input type="radio" name="charge_traders" value="undecided" class="radiUndecided"> 未定</label>
                                    <label class="rd2"><input type="radio" name="charge_traders" value="無し" class="radiNone"> 無し</label>
                                   <label class="rd2">| <input type="text" name="traders_fee" id="traders_fee" size="5" value="" class="ty8 traders_fee"></label>
                                    </td>
                               </tr>
                               <tr>
                                    <th>対象フロア<br/> <input type="checkbox" id="show_vac_floors" class="filter_floors" name="filter_floor"> 空室のみ表示</th>
                                    <td colspan="3" class="floors_target_list">

                                    <?php if(!empty($all_floors)){
                                        foreach ($all_floors as $all_floor) {
                                           if($all_floor['vacancy_info']==1){
                                             $class_floor ='vac_floor';
                                              $span_class  ="vac_span";
                                           }
                                           else{
                                            $class_floor ='no_vac_floor';
                                            $span_class  ="no_vac_span";
                                           }
                                           if(!empty($all_floor['floor_down'])){
                                             $floor= ' '.$all_floor['floor_down'].' F';
                                           }
                                           else{
                                            $floor= 'Blank Floor';
                                           }
                                        ?>
                                            <span class="<?= $span_class?> negFloor floorEmpt"><input type="checkbox" name="targetFloorId[]" id="" class="targetFloorId <?= $class_floor ?>" value="<?= $all_floor['floor_id'] ?>"><?= $floor ?></span>
                                        <?php
                                        }
                                    } ?>
             
                                    </td>
                               </tr>
                                </tbody>
                        </table>
                        <table class="edit_input f_info_b mline tb-floor one-col mix-col">
                          <tbody>
                            <tr>
                              <td align="center"><button href="javaScript:void(0)" name="btnAddNewHistory" class="btnAddNewHistory2" id="btn2AddNeawHistory"><?php echo Yii::app()->controller->__trans('Append History'); ?> </button></td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                 </form>
                </div>
</div><!--/tab_con-->
</div><!--/main-->
			
</dd>          
</dl>
<?php 
}
?>
</body>
</html>
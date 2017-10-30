<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<!--default codes-->
<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" media="screen">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/groovy.css" media="screen">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css">
<link rel="stylesheet" href="//fonts.googleapis.com/earlyaccess/notosansjapanese.css">
<!--/default codes-->
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css//new_style.css" media="screen">
</head>

<body>
<div id="main" class="full-width">
<div class="tab_con">
<div class="manage-info table-box new_style_box">
                   	<div class="ttl_h3 clearfix">
                       <h3>Edit Window・Owner</h3>
                    </div>
                    <div class="manageInfoResponse">
                    	<h4 class="ontable bg_lb"> 
                        <span id="count_window">1.&nbsp;</span>Window<span class="button-right"><a id="add_another_window" class="bg_blue side_button" href="javascript:void(0)">Add another window</a></span></h4>
                        <table class="newform_info ad_list">
                        	<tbody>
                                <tr>
                                    <th>Trader ID</th>
                                    <td><input type="text" name="searchWindowText" class="ty3 searchWindowText" id="searchWindowText"></td>
                                    <th class="btn-cell"><a href="#" class="button style_navy">Search Trader</a></th>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td><select id="windowList" class="auto windowsList" name="window_id"><option value="0">Already added traders</option></select></td>
                                    <th>&nbsp;</th>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>Sorts</th>
                                    <td>
                                    <select name="window_type" id="window_type" data-role="none" class="window_type" required>
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
                                    <th>Transaction type</th>
                                    <td>
                                    <select name="management_type_window" id="window_contract" class="management_type_window" data-role="none">
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
                                    <th>Company Name</th>
									<td><input type="text" name="window_company_name" id="window_name" value="" class="ty6 window_company_name" required=""></td>
									<th>&nbsp;</th>
                                    <td>&nbsp;</td>
                               </tr>
                               <tr>
                                    <th>TEL</th>
									<td><input type="text" name="window_tel" id="td_tel" value="" class="ty6 window_tel"></td>
									<th>FAX</th>
                                    <td><input type="text" name="window_fax" id="td_fax" value="" class="ty6 window_fax"></td>
                               </tr>
                               <tr>
                                    <th>Person in charge1</th>
									<td><input type="text" name="window_person_in_charge1" id="bo_rep1" value="" class="ty3 person_in_charge1"></td>
									<th>Person in charge2</th>
                                    <td><input type="text" name="window_person_in_charge2" id="bo_rep2" value="" class="ty3 person_in_charge2"></td>
                               </tr>
                               <tr>
                                    <th>Fee</th>
									<td colspan="3">
									<label class="rd2"><input type="radio" name="charge_window" value="unknown" class="radiUnknown"> 不明</label>
									<label class="rd2"><input type="radio" name="charge_window" value="ask" class="radiAsk"> 相談</label>
									<label class="rd2"><input type="radio" name="charge_window" value="undecided" class="radiUndecided"> 未定</label>
									<label class="rd2"><input type="radio" name="charge_window" value="無し" class="radiNone"> 無し</label>
                                   <label class="rd2">| <input type="text" name="change_window_txt" id="window_fee" size="5" value="" class="ty8 change_txt"></label>
                                    </td>
                               </tr>
                                </tbody>
                        </table>
                        <h4 class="ontable bg_lb"> 
                        <div id="count_window">1</div>Window<span class="button-right"><a id="add_another_window" class="bg_blue side_button" href="javascript:void(0)">Add another window</a></span></h4>
                         <table class="newform_info ad_list">
                          <tbody>
                                <tr>
                                    <th>Trader ID</th>
                                    <td><input type="text" name="searchWindowText" class="ty3 searchWindowText" id="searchWindowText"></td>
                                    <th class="btn-cell"><a href="#" class="button style_navy">Search Trader</a></th>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td><select id="windowList" class="auto windowsList" name="window_id"><option value="0">Already added traders</option></select></td>
                                    <th>&nbsp;</th>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>Sorts</th>
                                    <td>
                                    <select name="window_type" id="window_type" data-role="none" class="window_type" required>
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
                                    <th>Transaction type</th>
                                    <td>
                                    <select name="management_type_window" id="window_contract" class="management_type_window" data-role="none">
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
                                    <th>Company Name</th>
                  <td><input type="text" name="window_company_name" id="window_name" value="" class="ty6 window_company_name" required=""></td>
                  <th>&nbsp;</th>
                                    <td>&nbsp;</td>
                               </tr>
                               <tr>
                                    <th>TEL</th>
                  <td><input type="text" name="window_tel" id="td_tel" value="" class="ty6 window_tel"></td>
                  <th>FAX</th>
                                    <td><input type="text" name="window_fax" id="td_fax" value="" class="ty6 window_fax"></td>
                               </tr>
                               <tr>
                                    <th>Person in charge1</th>
                  <td><input type="text" name="window_person_in_charge1" id="bo_rep1" value="" class="ty3 person_in_charge1"></td>
                  <th>Person in charge2</th>
                                    <td><input type="text" name="window_person_in_charge2" id="bo_rep2" value="" class="ty3 person_in_charge2"></td>
                               </tr>
                               <tr>
                                    <th>Fee</th>
                  <td colspan="3">
                  <label class="rd2"><input type="radio" name="charge_window" value="unknown" class="radiUnknown"> 不明</label>
                  <label class="rd2"><input type="radio" name="charge_window" value="ask" class="radiAsk"> 相談</label>
                  <label class="rd2"><input type="radio" name="charge_window" value="undecided" class="radiUndecided"> 未定</label>
                  <label class="rd2"><input type="radio" name="charge_window" value="無し" class="radiNone"> 無し</label>
                                   <label class="rd2">| <input type="text" name="change_window_txt" id="window_fee" size="5" value="" class="ty8 change_txt"></label>
                                    </td>
                               </tr>
                                </tbody>
                        </table>
                        <h4 class="ontable bg_blue">Owner Info</h4>
						<table class="newform_info ad_list">
						<tr class="no_border">
							<td colspan="3" class="bold_td col_3"><input type="checkbox" name="sameinfo" value="sameinfo"> Same as window</td>
							<td class="right-align"><a id="add_another_owner" class="bg_blue side_button" href="javascript:void(0)">Add shared owner</a></td>
						</tr>
						<tr>
                                    <th>Trader ID</th>
                                    <td><input type="text" name="searchOwnerText" class="ty3 searchOwnerText" id="searchOwnerText"></td>
                                    <th class="btn-cell"><a href="#" class="button style_navy">Search Trader</a></th>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td><select id="ownerList" class="auto ownersList" name="window_id"><option value="0">Already added owners</option></select></td>
                                    <th>&nbsp;</th>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>Sorts</th>
                                    <td>
                                    <select name="owner_type" id="owner_type" data-role="none" class="owner_type" required>
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
                                    <th>Transaction type</th>
                                    <td>
                                    <select name="management_type_owner" id="owner_contract" class="management_type" data-role="none">
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
                                    <th>Company Name</th>
									<td><input type="text" name="owner_company_name" id="bo_name" value="" class="ty6 owner_company_name" required=""></td>
									<th>&nbsp;</th>
                                    <td>&nbsp;</td>
                               </tr>
                               <tr>
                                    <th>TEL</th>
									<td><input type="text" name="owner_tel" id="owner_tel" value="" class="ty6 com_tel"></td>
									<th>FAX</th>
                                    <td><input type="text" name="owner_fax" id="owner_fax" value="" class="ty6 com_fax"></td>
                               </tr>
                               <tr>
                                    <th>Person in charge1</th>
									<td><input type="text" name="owner_person_in_charge1" id="owner_rep1" value="" class="ty3 person_in_charge1"></td>
									<th>Person in charge2</th>
                                    <td><input type="text" name="owner_person_in_charge2" id="owner_rep2" value="" class="ty3 person_in_charge2"></td>
                               </tr>
                               <tr>
                               	<th>Note</th>
                               	<td colspan="3" class="col_3"><input type="text" name="owner_note" id="owner_note" value="" class="owner_note_ty"></td>
                               </tr>
                               <tr class="no_border">
                               	<td colspan="4" class="bold_td col_4 center pad_top_15"><a id="update_managementinfo" class="bg_blue update_button" href="javascript:void(0)">Update</a></td>
                               </tr>
						</table>
                   
                   <table class="newform_info traders_list">
                   <thead>
						<tr class="no_border">
							<td colspan="5" class="bold_td col_full"><input type="checkbox" name="sameinfo" value="sameinfo"> Check all floors</td>
						</tr>
					   <tr>
					   	<th class="check">&nbsp;</th>
					   	<th class="id_floor">Floor ID</th>
					   	<th class="level_floor">Level of floor</th>
					   	<th class="size_floor">Size</th>
					   	<th class="updated_floor">Updated on</th>
					   </tr>
					   </thead>
					   <tbody>
					   	<tr>
					   		<td colspan="5" class="trader_list">
					   		<span class="trader_item"><label class="trader_label window_label bg_lb">Window</label> H company</span>
					   		<span class="trader_item"><label class="trader_label owner_label bg_blue">Owner</label>AAA company</span></td>
					   	</tr>
					   	<tr>
					   		<td class="check"><input type="checkbox" class="" name=""><label class="no_vacant vacant_status">満</label></td>
					   		<td class="id_floor">314697</td>
					   		<td class="level_floor">2F</td>
					   		<td class="size_floor">20.34坪</td>
					   		<td class="updated_floor">2017-06-21</td>
					   	</tr>
					   	<tr>
					   		<td colspan="5" class="trader_list">
					   		<span class="trader_item"><label class="trader_label window_label bg_lb">Window</label> X company</span>
					   		<span class="trader_item"><label class="trader_label owner_label bg_blue">Owner</label>BBB company</span></td>
					   	</tr>
					   	<tr>
					   		<td class="check"><input type="checkbox" class="" name=""><label class="vacant vacant_status">空</label></td>
					   		<td class="id_floor">314698</td>
					   		<td class="level_floor">3F</td>
					   		<td class="size_floor">20.34坪</td>
					   		<td class="updated_floor">2017-06-21</td>
					   	</tr>
					   	<tr>
					   		<td class="check"><input type="checkbox" class="" name=""><label class="vacant vacant_status">空</label></td>
					   		<td class="id_floor">314699</td>
					   		<td class="level_floor">4F</td>
					   		<td class="size_floor">20.34坪</td>
					   		<td class="updated_floor">2017-06-21</td>
					   	</tr>
					   	<tr>
					   		<td colspan="5" class="trader_list">
					   		<span class="trader_item"><label class="trader_label window_label bg_lb">Window</label> Z company</span>
					   		<span class="trader_item"><label class="trader_label owner_label bg_blue">Owner</label>Owner1/Owner2</span></td>
					   	</tr>
					   	<tr>
					   		<td class="check"><input type="checkbox" class="" name=""><label class="no_vacant vacant_status">満</label></td>
					   		<td class="id_floor">314700</td>
					   		<td class="level_floor">5F</td>
					   		<td class="size_floor">20.34坪</td>
					   		<td class="updated_floor">2017-06-21</td>
					   	</tr>
					   </tbody>
						</table>
                    </div>
                </div>
</div><!--/tab_con-->
</div><!--/main-->
<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>
<script type="text/javascript">
  $(function() {
    alert();
  });
</script>
</body>
</html>

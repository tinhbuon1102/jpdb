<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/datatables.min.css"/>

<style type="text/css">
	#trader_table_wrapper{
		padding: 12px;
	}
	.odd {
    background: rgb(211,221,229,1) !important;
    color: #636363 !important;
   }
   .even{
   	background: rgba(241,245,248,1) !important;
	color: #636363 !important;
   }
   .newform_info.ad_list td {
    padding-right: 5px;
	}
	.box-header{
		padding: 10px;
	}
	table th {
		font-size: 12px;
	}
	.ui-draggable .box-header {
     padding: 10px 10px;
   }
</style>
<div id="content">
	<div id="main" class="list-traders">
		<div class="content-label" style="padding-left: 10px">業者一覧</div>
		<div class="tbl" id="trader-grid">
			<table class="items" id="trader_table">
				<thead>
					<tr>
						<th id="trader-grid_c0"><a class="sort-link" href="javaScript:void(0)">#</a></th>
						<th id="trader-grid_c0"><a class="sort-link" href="javaScript:void(0)">Trader ID</a></th>
						<th id="trader-grid_c1"><a class="sort-link" href="javaScript:void(0)">Trader Name</a></th>
						<th id="trader-grid_c2"><a class="sort-link" href="javaScript:void(0)">TEL</a></th>
						<th id="trader-grid_c3"><a class="sort-link" href="javaScript:void(0)">PIC1</a></th>
						<th id="trader-grid_c4"><a class="sort-link" href="javaScript:void(0)">Fee</a></th>
						<th id="trader-grid_c5"><a class="sort-link" href="javaScript:void(0)">Action</a></th>
					</tr>
				</thead>
				<tbody>

					<?php $count=1;  foreach ($all_teaders_db as $all_teader_db) { ?>
					<tr class="odd">
						<td><?= $count ?></td>
						<td><?= $all_teader_db['trader_id'] ?></td>
						<td><?= $all_teader_db['owner_company_name'] ?></td>
						<td><?= $all_teader_db['company_tel'] ?></td>
						<td><?= $all_teader_db['person_in_charge1'] ?></td>
						<td><?= $all_teader_db['charge'] ?></td>
						<td class="button-column">
							<a class="TraderUpdate ajax-link edit_trader_btn"  trader_id="<?= $all_teader_db['trader_id'] ?>" title="trader_<?= $all_teader_db['trader_id'] ?>" href="javaScript:void(0)"><i class="fa fa-pencil"></i></a>
							<a title="Delete" class="delete" href="javaScript:void(0)" trader_id="<?= $all_teader_db['trader_id'] ?>" title="trader_<?= $all_teader_db['trader_id'] ?>"><i class="fa fa-trash-o"></i></a>
						</td>
					</tr>

					<?php $count++; }  ?>
					
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal-box hide">
  <div class="content">
    <div class="box-header">
     <button type="button" class="btnModalClose" id="btnModalClose">X</button>
      <h2 class="popup-label">Add New Trader</h2>
    </div>

    <div class="box-content">
    	<form name="frmTraderData" id="frmTraderData" class="text-center" action="" method="post" enctype="">
      		<input type="hidden" name="id" id="id" value="0" />
            <div class="divSpace form_style1">
				<div class="row">
					<div class="col-sm-6">
					<label>Type</label>
					<select name="ownership_type" id="ownership_type">
						<option value="">-</option>
						<option value="1">オーナー</option>
						<option value="6">サブリース</option>
						<option value="7">貸主代理</option>
						<option value="8">AM</option>
						<option value="10"> 業者</option>
						<option value="4">仲介業者</option>
						<option value="2">管理会社</option>
						<option value="9">PM</option>
						<option value="3">ゼネコン</option>
						<option value="-1">&gt;不明</option>
					</select>
					</div><!--/col-sm-6-->
					<div class="col-sm-6">
					<label>Management Type</label>
					<select name="management_type" id="management_type" class="management_type" data-role="none">
						<option value="">-</option>
						<option value="-1">不明</option>
						<option value="1">専任媒介</option>
						<option value="2">一般媒介</option>
						<option value="3">代理</option>
						<option value="4">貸主</option>
					</select>
					</div><!--/col-sm-6-->
					<div class="col-sm-12">
						<label>Company Name</label>
						<input type="text" name="company_name">
					</div><!--/col-sm-12-->
					<div class="col-sm-6">
						<label>TEL</label>
						<input type="text" name="tel" id="tel" value="">
					</div><!--/col-sm-6-->
					<div class="col-sm-6">
						<label>FAX</label>
						<input type="text" name="fax" id="fax" value="">
					</div><!--/col-sm-6-->
					<div class="col-sm-12">
						<label>Fee</label>
						<span class="rd2"><input type="radio" name="charge_window1" value="不明" class="radiUnknown">不明</span>
                        <span class="rd2"><input type="radio" name="charge_window1" value="相談" class="radiAsk"> 相談</span>
                        <span class="rd2"><input type="radio" name="charge_window1" value="未定" class="radiUndecided"> 未定</span>
                        <span class="rd2"><input type="radio" name="charge_window1" value="無し" class="radiNone" checked="">無し</span>
                        <span class="rd2"><input type="text" name="change_txt_window1" id="change_txt_window1" size="5" value="無し" class="" style="width: 50px;"></span>  
					</div><!--/col-sm-12-->
				</div><!--/row-->
            </div>

            <div class="divResponse"><span class="form-reponse"></span></div>
            <button type="submit" class="btn-default btnSubmit">Add Trader</button>
      	</form>
    </div>
  </div>
</div>

<!--Modal Popup for append management history-->
<div class="modal-box hide" id="appendManagementModal">
  <div class="content managementHistoryContent">
    <div class="box-header">
      <h2 class="popup-label">
          Edit Trader
      </h2>
      <button type="button" class="btnModalClose" id="btnModalClose">X</button>
    </div>
    <div class="box-content" >
    	<div class="messageManagement hide"></div>
      <div id="main" class="full-width" style="padding-bottom: 0px">
            <div class="tab_con" style="max-height: 365px">
            <div class="manage-info table-box new_style_box">
            	<input type="hidden" name="base_url" id="base_url" value="<?php echo Yii::app()->request->baseUrl; ?>">
                <form name="frmAddNewHistory" id="frmEditTrader" class="frmAddNewHistory" action="<?php echo Yii::app()->createUrl('floor/editTrader'); ?>">
                	<input type="hidden" name="traders_id" id="traders_id" value="">
                    <div class="manageInfoResponse">
                        <table class="newform_info ad_list">
                            <tbody>
                               <!--  <tr>
                                    <th>Trader ID</th>
                                    <td><input type="text" name="searchTradersText" class="ty3 searchTradersText2"  id="searchTraderText" ></td>
                                    <th class="btn-cell">
                                        <a href="javaScript:void(0)" class="button style_navy" id="btnSearchTrader">Search Trader</a>
                                    </th>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td>
                                        <select id="trader_id_new" class="auto tradersListNEW" name="traders_id">
                                          <option value="0">Already added traders</option>
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
                                </tr> -->
                                <tr>
                                    <th>Sorts</th>
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
                                    <th>Transaction type</th>
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
                                    <th>Company Name</th>
                                    <td><input type="text" name="traders_company_name" id="traders_name" value="" class="ty6 traders_company_name" ></td>
                                    <th>&nbsp;</th>
                                    <td>&nbsp;</td>
                               </tr>
                               <tr>
                                    <th>TEL</th>
                                    <td><input type="text" name="traders_tel" id="td_tel" value="" class="ty6 traders_tel" ></td>
                                    <th>FAX</th>
                                    <td><input type="text" name="traders_fax" id="td_fax" value="" class="ty6 traders_fax" ></td>
                               </tr>
                               <tr>
                                    <th>Person in charge1</th>
                                    <td><input type="text" name="traders_person_in_charge1" id="bo_rep1" value="" class="ty3 person_in_charge1"></td>
                                    <th>Person in charge2</th>
                                    <td><input type="text" name="traders_person_in_charge2" id="bo_rep2" value="" class="ty3 person_in_charge2"></td>
                               </tr>
                               <tr>
                                    <th>Fee</th>
                                    <td colspan="3">
                                    <label class="rd2"><input type="radio" name="charge_traders" value="unknown" class="radiUnknown"> 不明</label>
                                    <label class="rd2"><input type="radio" name="charge_traders" value="ask" class="radiAsk"> 相談</label>
                                    <label class="rd2"><input type="radio" name="charge_traders" value="undecided" class="radiUndecided"> 未定</label>
                                    <label class="rd2"><input type="radio" name="charge_traders" value="無し" class="radiNone"> 無し</label>
                                   <label class="rd2">| <input type="text" name="traders_fee" id="traders_fee" size="5" value="" class="ty8 traders_fee"></label>
                                    </td>
                               </tr>
                             <!--   <tr>
                                    <th>Target Floors<br/> <input type="checkbox" id="show_vac_floors" class="filter_floors" name="filter_floor"> Show only vacant floors</th>
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
                                             $floor= ' '.$all_floor['floor_down'].' Floor';
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
                               </tr> -->
                                </tbody>
                        </table>
                        <table class="edit_input f_info_b mline tb-floor one-col mix-col">
                          <tbody>
                            <tr>
                              <td align="center"><button href="javaScript:void(0)" name="btnAddNewHistory" class="btnAddNewHistory2" id="update_trader"><?php echo Yii::app()->controller->__trans('Append History'); ?> </button></td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                 </form>
                </div>
</div><!--/tab_con-->
</div><!--/main-->
     
    </div>
  </div>
</div>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
    $('#trader_table').DataTable(); 
    } );


    	$(document).on('click','.edit_trader_btn',function(e){
	  		e.preventDefault();
	  		var trader_id =$(this).attr('trader_id');
	  		find_trader(trader_id);
	  		return false;
	 		
   	    });
   	    function find_trader(trader_id){
   	      var baseUrl = $('#base_url').val();
          baseUrl = baseUrl+'/index.php?r=floor/getTraderById';
	      $.ajax({
	            url: baseUrl,
	            type: 'POST',
	            data: {trader_id : trader_id},
	            beforeSend: function() {
			       document.getElementById("frmEditTrader").reset(); 
			    }
	          })
	          .done(function(res) {
	            var res = JSON.parse(res); 
	            if(res.status == 'success'){
	            	 $('#traders_id').val(res.traderDetails.trader_id)
		             $('#traders_type').val(res.traderDetails.ownership_type);
		             $('#traders_name').val(res.traderDetails.owner_company_name);
		             $('#traders_contract').val(res.traderDetails.management_type);
		             $('#td_tel').val(res.traderDetails.company_tel);
		             $('#td_fax').val(res.traderDetails.company_fax);
		             $('#bo_rep1').val(res.traderDetails.person_in_charge1);
		             $('#bo_rep2').val(res.traderDetails.person_in_charge2);
		             $('#traders_fee').val(res.traderDetails.charge);
		             if(res.charge !=""){
		                 //$("input[name=charge_traders][value=" + res.traderDetails.charge + "]").prop('checked', true);
		             }
		             $('#appendManagementModal').removeClass('hide');
			   		$('#appendManagementModal').addClass('show');
			   		$('#appendManagementModal').fadeIn(1000);
	            }
	            else{
	              alert('Trader Not found');
	              
	            }
	          })
	          .fail(function() {
	            alert('somthing went wrong');
	          })  

   	    }
   	    $('#update_trader').click(function(event) {
   	    	 var formdata = $('#frmEditTrader').serialize();
             var url = $('#frmEditTrader').attr('action');
              $.ajax({
                    url: url,
                    type: 'POST',
                    data: formdata,
                  })
                  .done(function(res) {
                    if(res == 'success'){
                      document.getElementById("frmEditTrader").reset();
                      alert('Data is update');
                      location.reload();
                    }
                    else{
                      document.getElementById("frmEditTrader").reset();
                      alert('Data is Not update');
                    }
                  })
                  .fail(function() {
                    alert('somthing went wrong');
                  })  
   	    });
</script>
// JavaScript Document
var baseUrl = $('#baseUrl').val();
$( ".input" ).focusin(function() {
	$( this ).find( "span" ).animate({"opacity":"0"}, 200);
});
$( ".input" ).focusout(function() {
  $( this ).find( "span" ).animate({"opacity":"1"}, 300);
});
$(".login").submit(function(){
	$(this).find(".submit i").removeAttr('class').addClass("fa fa-check").css({"color":"#fff"});
	$(".submit").css({"background":"#2ecc71", "border-color":"#2ecc71"});
	$(".feedback").show().animate({"opacity":"1", "bottom":"-80px"}, 400);
	$("input").css({"border-color":"#2ecc71"});
});

/* js by ketan */
$(document).ready(function(e) {
	try{
	$('.content').draggable();	
	}catch(err){}
	$("#customer-form").validate();
	
	//event to close popup-box
	$('.btn-close').click(function(e){
		$('.modal-box').removeClass('show');
		$('.modal-box').addClass('hide');
		$('.modal-box').fadeOut(1000);
	});	
	//event to open popup-box
	$('.btnAddNew').click(function(e){
		$('.modal-box').removeClass('hide');
		$('.modal-box').addClass('show');
		$('.modal-box').fadeIn(1000);
		if($('#id').val() == 0){
			$("#userPassword").css('display','block');
		}
	});
	
	/************************** add introducer ***********************/
	$(document).on('click','#int_btn',function(){
		var url = baseUrl+'/index.php?r=introducer/getIntroducer';
		$('.ajxLoader').css('display','block');
		$('#int_btn').attr('disabled',true);
		var int_value = $('#int_id').val();
		if(int_value== ''){
			$('.ajxLoader').css('display','none');
			$('#int_btn').attr('disabled',false);
			$('.error_msg').html('Please Enter introducer');
			$(".error_msg").css("color", "red");
			return false;
		}
		call({url:url,params:{int_value:int_value},type:'POST',dataType : 'html'},function(resp){
			$('.ajxLoader').css('display','none');
			$('#int_btn').attr('disabled',false);
			$('.introducerResp').html(resp.content);
			if(resp.count == 0){
				$('#int_id').addClass('introducerText');
				$('.btnAddNewIntroducerCust').css('display','block');
			}else{
				$('#int_id').removeClass('introducerText');
				$('.btnAddNewIntroducerCust').css('display','none');
			}
		});
	});
	
	$('#int_id').keyup(function(){
		var int_txt = $('#int_id').val();
		if(int_txt != ''){
			$('.error_msg').html('');
		}else{
			$('.error_msg').html('Please Enter introducer');
		}
	});
	
	
	$('.room_no').keyup(function(){
		var url = baseUrl+'/index.php?r=floor/checkRoomNumber';
		var _this = $(this);
		var room_no = _this.val() 
		var buildingId = $('#buildingId').val();
		call({url:url,params:{room_no:room_no,buildingId:buildingId},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				$('.resperror').css({'display' : 'block','color' : 'red'});
				$('.resperror').html(resp.msg);
				_this.val('');
			}else{
				$('.resperror').css('display','none');
			}
		});
	});
	
	$(document).on('click','.btnAddNewIntroducerCust',function(){
		var url = baseUrl+'/index.php?r=introducer/newIntroducer';
		var int_txt = $('#int_id').val();
		if(int_txt != ""){
			$('.error_msg').html('');
			call({url:url,params:{int_txt:int_txt},type:'POST',dataType : 'html'},function(resp){
				$('.introducerResp').html(resp.content);
				if(resp.count == 0){
					$('#int_id').addClass('introducerText');
					$('.btnAddNewIntroducerCust').css('display','block');
				}else{
					var int_txt = $('#int_id').val('');
					$('#int_id').removeClass('introducerText');
					$('.btnAddNewIntroducerCust').css('display','none');
				}
			});
		}else{
			$('.error_msg').html('Please Enter introducer');
		}
	});
	/*************************** end ***************************/
	
	/******************* building page validation *****************/
	$(".parking_radio_2,.parking_radio_3").click(function() {
		 $('#parking_unit_no_text').attr('disabled',true);
 	});
	
	$(".parking_unit_radio").click(function() {
		 $('#parking_unit_no_text').attr('disabled',false);
 	});
	
	$(".oa_radio_1,.oa_radio_3").click(function() {
		 $('.oa_txt').attr('disabled',true);
 	});
	$(".oa_radio_2").click(function() {
		 $('.oa_txt').attr('disabled',false);
 	});
	       /*****************  for  entrence ************************/
	$('#b_entrance_open_time_week_start,#b_entrance_open_time_week_finish').change(function() {
		if($(this).val() == ''){
			 $('.ent1').attr('checked',true);
		}else{
			 $('.ent2').attr('checked',true);
		}
	});
	$('#b_entrance_open_time_sat_start,#b_entrance_open_time_sat_finish').change(function() {
		if($(this).val() == ''){
			 $('.ent3').attr('checked',true);
		}else{
			 $('.ent4').attr('checked',true);
		}
	});
	$('#b_entrance_open_time_sun_start,#b_entrance_open_time_sun_finish').change(function() {
		if($(this).val() == ''){
			 $('.ent5').attr('checked',true);
		}else{
			 $('.ent6').attr('checked',true);
		}
	});
	        /*****************  end ************************/
	
	       /*****************  for  limit ************************/
	$('#b_limit_open_time_week_start,#b_limit_open_time_week_finish').change(function() {
		if($(this).val() == ''){
			 $('.limit1').attr('checked',true);
		}else{
			 $('.limit2').attr('checked',true);
		}
	});
	$('#b_limit_open_time_sat_start,#b_limit_open_time_sat_finish').change(function() {
		if($(this).val() == ''){
			 $('.limit3').attr('checked',true);
		}else{
			 $('.limit4').attr('checked',true);
		}
	});
	$('#b_limit_open_time_sun_start,#b_limit_open_time_sun_finish').change(function() {
		if($(this).val() == ''){
			 $('.limit5').attr('checked',true);
		}else{
			 $('.limit6').attr('checked',true);
		}
	});
	        /*****************  end ************************/
			
	       /*****************  for  Air Condition ************************/
	$('#b_condition_open_time_week_start,#b_condition_open_time_week_finish').change(function() {
		if($(this).val() == ''){
			 $('.airCondition1').attr('checked',true);
		}else{
			 $('.airCondition2').attr('checked',true);
		}
	});
	$('#b_condition_open_time_sat_start,#b_condition_open_time_sat_finish').change(function() {
		if($(this).val() == ''){
			 $('.airCondition3').attr('checked',true);
		}else{
			 $('.airCondition4').attr('checked',true);
		}
	});
	$('#b_condition_open_time_sun_start,#b_condition_open_time_sun_finish').change(function() {
		if($(this).val() == ''){
			 $('.airCondition5').attr('checked',true);
		}else{
			 $('.airCondition6').attr('checked',true);
		}
	});
	        /*****************  end ************************/
	
	
	$(".building_radio_1,.building_radio_2").click(function() {
 		 $('.b_usertime').val('');
 	});
	
	$(".elevator_group").change(function(){
		if($(this).val() == ''){
			$('.elevator_radio').attr('checked',false);
			$('.ele_unkonwn').attr('checked',true);
		}else{
			$('.elevator_radio').attr('checked',true);
		}
    });
	
	$("#b_usetime_d_from,#b_usetime_d_to").change(function(){
		if($("#b_usetime_d_from").val() == '' || $("#b_usetime_d_to").val() == '' ){
			$('.building_radio').attr('checked',false);
		}else{
			$('.building_radio').attr('checked',true);
		}
    });
	
	$("#parking_unit_no_text").keyup(function(){
		if($('#parking_unit_no_text').val() == ''){
			$('.parking_unit_radio').attr('checked',false);
		}else{
			$('.parking_unit_radio').attr('checked',true);
		}
    });
	/************************** end *************************/
	
	$('.btnPrintCartList').click(function(e){
		 $('.modal-box-print').show();
	});
	
	$('.btnModalClose_print').click(function(e){
		 $('.modal-box-print').hide();
		 
	});
	$('.btnModalClose_help').click(function(e){
		 $('.modal-box-help').hide();
		 
	});
	/********************** convert ping to m2**************/
	$('#area-con-btn').click(function(e){
		var tsubo = $('#area-tsubo').val();
		if(tsubo != '' && tsubo !='undefined'){
			var m2 = 3.305785 * tsubo;
			$('#area-m2').val(m2.toFixed(2));
			$('#area-tsubo').css('border-color','none');
		}
		else{
			$('#area-tsubo').css('border-color','red');
		}
	});
	
	$('#area-con-btn_reverse').click(function(e){
		var m2 = $('#area-m2').val();
		if(m2 != '' && m2 !='undefined'){
			var tsubo = m2 / 3.305785;
			$('#area-tsubo').val(tsubo.toFixed(2));
			$('#area-m2').css('border-color','none');
		}
		else{
			$('#area-m2').css('border-color','red');
		}
	});
	
	/******************** end *********************/
	/*********** Print Cart List ******************/
	 $('.btnPrint').click(function(e){
//		e.preventDefault();
//		var form = $("#frmPrintDetails");
//		form.attr("method", "post");
//		form.attr("action", baseUrl+'/index.php?r=building/printBuildingDetails');
//		// setting form target to a window named 'formresult'
//		form.attr("target", "formresult");
//		form.serialize();
//		window.resizeTo(500,500)
//		// creating the 'formresult' window with custom features prior to submitting the form
//		window.open(baseUrl+'/index.php?r=building/printBuildingDetails', 'formresult', 'scrollbars=no,menubar=no,height=600,width=800,resizable=yes,toolbar=no,status=no');
//		form.submit();
		e.preventDefault();
		var form = $("#frmPrintDetails");
		form.attr("method", "get");
		form.attr("action", baseUrl+'/index.php?r=floor/addProposedToCart');
		// setting form target to a window named 'formresult'
		form.attr("target", "formresult");
		form.serialize();
		window.resizeTo(500,500);
		// creating the 'formresult' window with custom features prior to submitting the form
		window.open(baseUrl+'/index.php?r=floor/addProposedToCart', 'formresult','scrollbars=no,menubar=no,height=600,width=800,resizable=yes,toolbar=no,status=no');
		
		form.submit();
	});
	$(document).on('change','.print_term_op',function(){
		if($('.print_term_op').val() == 'add_text'){
			$('.newAuthorName').css('display','block');
		}else{
			$('.newAuthorName').css('display','none');
		}
	});
	$(document).on('change','.building_with_deadline',function(){
		 if($(this).is(":checked")) {
     		 $(".deadline_date").prop("disabled", false);
  		 }else{
     		 $(".deadline_date").prop("disabled", true);  
  		 }
	});
	 
	$('.printout').click(function(e){
		e.preventDefault();
		var form = $("#frmPrintDetails");
		form.attr("method", "post");
		form.attr("action", baseUrl+'/index.php?r=marketInfo/specificDistrictPrintView');
		// setting form target to a window named 'formresult'
		form.attr("target", "formresult");
		form.serialize();
		window.resizeTo(500,500)
		// creating the 'formresult' window with custom features prior to submitting the form
		window.open(baseUrl+'/index.php?r=building/printBuildingDetails', 'formresult', 'scrollbars=no,menubar=no,height=600,width=800,resizable=yes,toolbar=no,status=no');
		form.submit();
	});
	
	$('.printoutsingle').click(function(e){
		e.preventDefault();
		var form = $("#singleDistrict");
		form.attr("method", "post");
		form.attr("action", baseUrl+'/index.php?r=marketInfo/singleDistrictPrintView');
		// setting form target to a window named 'formresult'
		form.attr("target", "formresult");
		form.serialize();
		window.resizeTo(500,500)
		// creating the 'formresult' window with custom features prior to submitting the form
		window.open(baseUrl+'/index.php?r=building/printBuildingDetails', 'formresult', 'scrollbars=no,menubar=no,height=600,width=800,resizable=yes,toolbar=no,status=no');
		form.submit();
	});
	
	/******************** End ********************/
	/***************** customer Search ************/
	$('#search-customer').click(function(e){
		e.preventDefault();
		var url = baseUrl+'/index.php?r=customer/searchCustomerList';
		$('.ajxLoader').css('display','block');
		$('#search-customer').attr('disabled',true);
		var datastring = $("#preview_form").serialize();
		call({url:url,params:{formdata:datastring},type:'POST',dataType : 'json'},function(resp){
			$('.ajxLoader').css('display','none');
			$('#search-customer').attr('disabled',false);
			$('.customerList').html(resp);
		});
	});
	/*************************** end ****************/
	$(document).on('click','#help',function(e){
		e.preventDefault();	
		$('.modal-box-help').removeClass('hide');
		$('.modal-box-help').addClass('show');
		$('.modal-box-help').fadeIn(1000);
		
	});
	$(document).on('click','.btnPrintModalClose',function(e){
		e.preventDefault();	
		$('.modal-box-print-art').removeClass('hide');
		$('.modal-box-print-art').addClass('show');
		$('.modal-box-print-art').fadeIn(1000);
		
	});
    $(document).on('change','#vac_schedule',function(e){ 
		var todayDate = $.datepicker.formatDate('yy/mm/dd', new Date());
		var vac_schedule =  this.value;
		//console.log(todayDate)
		//console.log(vac_schedule)
		//if(todayDate == vac_schedule){
		//	$('#moving_date').val('即');
		//}else{
		//	$('#moving_date').val(0);
		//}
		
	});
	/******************* pdf upload and validation & delete *****************/
	$(document).on('change','.upfile',function(e){
		fileName = $(this)[0].files[0].name;
		extractName = fileName.split(".");
		fileExtention  = extractName[extractName.length-1];
		if(fileExtention != 'pdf'){
			alert('Please enter only ".pdf" format');
			$(this).val('');
			return false;
		}else{
			var fileSize = parseFloat(($(this)[0].files[0].size)/1000).toFixed(2);
			$('#fileSize').val(fileSize);
		}
	});
	
	$(document).on('click','.btnUploadPdf',function(e){
		e.preventDefault();		
		var validForm = $("#frmUploadBuildingPdf").valid();
		if(validForm != false){
			if($('.upfile').val() != ''){
				$('.uploadAfter').css('display','block');
				$('.btnUploadPdf').css('display','none');
				
				var url = $("#frmUploadBuildingPdf").attr('action');
				var buildingId = $('#buildingId').val();
				var pdftitle = $('#pdftitle').val();
				var pdfSize = $('#fileSize').val();
				var memo = $('.pdfmemo').val();
				
				var formData = new FormData();
				formData.append('file', $('.upfile')[0].files[0]);
				formData.append('buildingId', buildingId);
				formData.append('pdftitle', pdftitle);
				formData.append('pdfSize', pdfSize);
				formData.append('memo', memo);
				
				// Using the core $.ajax() method
				$.ajax({
					url: url,
					data: formData,
					type: "POST",
					cache: false,
					contentType: false,
					processData: false,
					dataType : 'json'
				}).success(function( resp ) {
					$('.uploadAfter').css('display','none');
					$('.btnUploadPdf').css('display','block');
					call({url:resp.url,params:{formdata:resp.id},type:'POST',dataType : 'json'},function(data){
						$('.pdf_list').html(data);
						$("#frmUploadBuildingPdf")[0].reset();
					});
				});
			}else{
				alert('アップロードするファイルを選択します。');
				$('.uploadAfter').css('display','none');
				$('.btnUploadPdf').css('display','block');
			}
		}
	});
	
	$(document).on('click','.deletePdf',function(e){
		e.preventDefault();
		var url = $(this).attr('href');
		var pdfRow = $(this);
		call({url:url,params:{},type:'GET',dataType : 'json'},function(resp){
			if(resp.status == 1){
				call({url:resp.url,params:{formdata:resp.id},type:'POST',dataType : 'json'},function(data){
					pdfRow.closest('tr').remove();
				});
			}else{
				alert('Something went wrong.');
			}
		});
	});
	/********************** end *******************/
	
	/************************change Customer Req Info Customer Page *************/	
	$('.btnGetCustomerReqInfo').click(function(e) {
		e.preventDefault();
		var url = $(this).attr("href");
		//alert(url)
		call({url:url,params:{},type:'POST',dataType:'json'},function(resp){
			$('.divChangeInfo').html(resp);
		});
		$('.updateCusomerReqInfo').removeClass('hide');
		$('.updateCusomerReqInfo').addClass('show');
	});
	
	$('.btnUpdateEditCustomer').click(function(e) {
		e.preventDefault();
		var url = $(this).attr("href");
		call({url:url,params:{},type:'POST',dataType:'json'},function(resp){
			$('.divChange').html(resp);
			//location.reload();
		});
		$('.updateCustomerInfo').removeClass('hide');
		$('.updateCustomerInfo').addClass('show');
	});
	
	$(document).on('click','.btnUpdateCust',function(e){
		e.preventDefault();
		var is_update = $('#is_update').val();
		if(is_update == 1){
			$('.changeLoaderOverly1').css('display','block');
			var datastring = $("#customer-form").serialize();
			var url = $('#updateCustomerInfo').val(); 
			var updateCustomerId = $('#updateCustomerId').val();
			call({url:url,params:{formdata:datastring,updateCustomerId:updateCustomerId},type:'POST',dataType : 'json'},function(resp){
				$('.changeLoaderOverlyMsg1').css('display','none');
				if(resp.status == 1){
					$('.changeLoaderOverlyMsg1').css('display','block');
					$('.responseMsg1').html('<i class="fa fa-smile-o" aria-hidden="true"></i> '+resp.msg);
					setTimeout(function(){
						$('.modal-box').removeClass('show');
						$('.modal-box').addClass('hide');
						$('.modal-box').fadeOut(1000);
						$('.changeLoaderOverlyMsg1').css('display','none');
						$('.changeLoaderOverly1').css('display','none');
					},2000);
					location.reload();
				}
			});
		}
	});
	
	$(document).on('click','#btnUpdateCustomerReqInfo',function(){
		$('.changeLoaderOverly').css('display','block');
		var datastring = $("#frmCustomerReqInfo").serialize();
		var url = $('#changeCustomerReqInfo').val();
		call({url:url,params:{formdata:datastring},type:'POST',dataType : 'json'},function(resp){
			$('.changeLoaderOverlyMsg').css('display','none');
			if(resp.status == 1){
				$('.changeLoaderOverlyMsg').css('display','block');
				$('.responseMsg').html('<i class="fa fa-smile-o" aria-hidden="true"></i> '+resp.msg);
				setTimeout(function(){
					$('.modal-box').removeClass('show');
					$('.modal-box').addClass('hide');
					$('.modal-box').fadeOut(1000);
					$('.changeLoaderOverlyMsg').css('display','none');
					$('.changeLoaderOverly').css('display','none');
					
				},3000);
				location.reload();
			}else{
				$('.changeLoaderOverlyMsg').css('display','block');
				$('.responseMsg').html('<i class="fa fa-meh-o" aria-hidden="true"></i> '+resp.msg);
				setTimeout(function(){
					$('.modal-box').removeClass('show');
					$('.modal-box').addClass('hide');
					$('.modal-box').fadeOut(1000);
					$('.changeLoaderOverlyMsg').css('display','none');
				},3000);
			}
		});
		
	});
	/***********************  end ************************************************/
	/********************* change building info from single building page ****************/
	$('.btnUpdateBuildingInfo').click(function(e) {
		e.preventDefault();
		var url = $(this).attr("href");
		call({url:url,params:{},type:'POST',dataType:'json'},function(resp){
			$('.divChangeInfo').html(resp);
			calculateFieldInit();
		});
		$('.updateBuildingInfo').removeClass('hide');
		$('.updateBuildingInfo').addClass('show');
	});
	
//	$('.btnUpdateBuildingInfo').click(function(e) {
//		e.preventDefault();
//		var url = $(this).attr("href");
//		call({url:url,params:{},type:'POST',dataType:'json'},function(resp){
//			$('.divChangeInfo').html(resp);
//		});
//		$('.updateBuildingInfo').removeClass('hide');
//		$('.updateBuildingInfo').addClass('show');
//	});
	
	$('.btnCSVImport').click(function(e) {
		e.preventDefault();
		$('.modal-importCSV').removeClass('hide');
		$('.modal-importCSV').addClass('show');
	});
	
	$(document).on('click','.btnChangeInfo',function(){
		$('.changeLoaderOverly').css('display','block');
		/*var name = $('#Building_name').val();
		if ($("#buildCheck").is(':checked')){
			$('#Building_name').val(name);
		}else{
			$('#Building_name').val(name+" ビル");
		}*/
		var datastring = $("#frmChangeBuildingInfo").serialize();
		var url = $('#changeBuildingUrl').val();
		call({url:url,params:{formdata:datastring},type:'POST',dataType : 'json'},function(resp){
			$('.changeLoaderOverly').css('display','none');
			if(resp.status == 1){
				$('.changeLoaderOverlyMsg').css('display','block');
				$('.responseMsg').html('<i class="fa fa-smile-o" aria-hidden="true"></i> '+resp.msg);
				setTimeout(function(){
					window.location.reload(true);
					/*$('.modal-box').removeClass('show');
					$('.modal-box').addClass('hide');
					$('.modal-box').fadeOut(1000);
					$('.changeLoaderOverlyMsg').css('display','none');
					$('.changeLoaderOverly').css('display','none');*/
				},3000);
				/*call({url:resp.url,params:{id:resp.id},type:'POST',dataType : 'json'},function(data){
					$('.buildingInformation').html(data);
				});*/
					
			}else{
				$('.changeLoaderOverlyMsg').css('display','block');
				$('.responseMsg').html('<i class="fa fa-meh-o" aria-hidden="true"></i> '+resp.msg);
				setTimeout(function(){
					$('.modal-box').removeClass('show');
					$('.modal-box').addClass('hide');
					$('.modal-box').fadeOut(1000);
					$('.changeLoaderOverlyMsg').css('display','none');
				},3000);
			}
		});
	});
	/**************************** end ********************************/
	
	
	/******************************* Search Traders & Add Trader *****************/
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
	
	$(document).on('click','.btnAddTrader',function(e){
		e.preventDefault();
		$('.ajxLoader').css('display','block');
		var newTrader = $('.newTrader').val();
		if(newTrader== ''){
			$('.ajxLoader').css('display','none');
			$(".newTrader").css("border-color", "red");
			return false;
		}
		var url = baseUrl+'/index.php?r=traders/createOrUpdate';
		call({url:url,params:{name:newTrader},type:'POST',dataType : 'json'},function(resp){
			var newOption = "<select  id='tradersList'  class='auto tradersList' name='Floor[trader_id]' ><option value='"+resp.insert_id+"' selected = 'selected'>"+resp.name+"</option></select>"; 
			$('.traderResp').html(newOption);
		});
	});
	
	$(document).on('keyup','.searchTraderText',function(e){
		var query = $('.searchTraderText').val();
		if(query == ''){
			$(".searchTraderText").css("border-color", "red");
		}else{
			$(".searchTraderText").css('border-color','#ff69b4');
		}	
	});
	
	$(document).on('keyup','.newTrader',function(e){
		var query = $('.newTrader').val();
		if(query == ''){
			$(".newTrader").css("border-color", "red");
		}else{
			$(".newTrader").css('border-color','#ff69b4');
		}	
	});
	
	$(document).on('change','.tradersList',function(e){
		var _nearestTable = $(this).closest('.tb-floor');
		_nearestTable.find('.loadTraders').show();
		$(this).attr('disabled');
		var trader = $(this).val();
		var url = baseUrl+'/index.php?r=floor/getSeletectedTraderDetails';
		call({url:url,params:{trader:trader},type:'POST',dataType : 'json'},function(resp){
			_nearestTable.find('.loadTraders').hide();
			_nearestTable.find('.tradersList').removeAttr('disabled');
			_nearestTable.find('.ownership_type').val(resp.ownership_type);
			_nearestTable.find('.management_type').val(resp.management_type);
			_nearestTable.find('.owner_company_name').val(resp.owner_company_name);
			_nearestTable.find('.company_tel').val(resp.company_tel);
			_nearestTable.find('.person_in_charge1').val(resp.person_in_charge1);
			_nearestTable.find('.person_in_charge2').val(resp.person_in_charge2);
			if(isNaN(resp.charge) && resp.charge != ""){
				if(resp.charge == 'unknown'){
					_nearestTable.find('.radiUnknown').prop('checked',true);
				}else if(resp.charge == 'ask'){
					_nearestTable.find('.radiAsk').prop('checked',true);
				}else if(resp.charge == 'undecided'){
					_nearestTable.find('.radiUndecided').prop('checked',true);
				}else if(resp.charge == '無し'){
					_nearestTable.find('.radiNone').prop('checked',true);
				}
			}else{
				_nearestTable.find('.change_txt').val(resp.charge);
			}
		});
	});
	/**************************** end ***********************/
	 
	/******************** unit & condo fee caculation *******************/
	$(document).on('keyup','#rent_unit_price',function(e){
		if($(this).val() == ''){
			$('#total_rent_price,#f_price_t_shiki,#f_price_a_shiki').val('');
			return false;
		}
		var rent_unit_price = $('#rent_unit_price').val();
		rent_unit_price = rent_unit_price.replace(/,/g, "");
		
		var area_ping = $('#area-tsubo').val();
		//console.log("Unit Price = "+rent_unit_price+" & Area = "+area_ping);
		if(rent_unit_price != '' && rent_unit_price !='undefined'){
			var output = rent_unit_price * area_ping;
			 
			if(output != 0){
				var formatedTotal = addCommas(Math.round(output));
				$('#total_rent_price').val(formatedTotal);
			}
			
			formatedTotal = '';
			if (!isNaN(rent_unit_price))
			{
				var price_calculated = rent_unit_price / OFFICE_DB_FEE_RATE;
				formatedTotal = addCommas(Math.round(price_calculated));
			}
			$('#rent_unit_price_calculated').val(formatedTotal);
		}
		
		if($('#f_price_m_shiki').val() != ''){
			var MVal = $('#f_price_m_shiki').val();
			MVal = MVal.replace(/,/g, "");
			var TVal = $(this).val();
			TVal = TVal.replace(/,/g, "");
			fVal = addCommas(MVal*TVal);
			$('#f_price_t_shiki').val(fVal);
			
			
			var f_price_m_shiki = MVal*TVal;
			var area_tsubo = $('#area-tsubo').val()
			if(rent_unit_price != ''){
				var f_price_t_shiki = f_price_m_shiki * rent_unit_price;
				var fPrice = addCommas(f_price_t_shiki * area_tsubo);
				$('#f_price_a_shiki').val(fPrice);
				
			}  
		}
		
		if($('.deposit_month').val() != ""){
			$('#f_price_m_shiki').trigger('keyup');
		}
		
	});
	
	$(document).on('keyup','#f_price_a_shiki',function(e){
		var _area = $('#area-tsubo').val();
		_area = _area.replace(/,/g, "");
		
		var _totalDeposit = $(this).val();
		_totalDeposit = _totalDeposit.replace(/,/g, "");

		console.log('area'+_area);
		console.log('_totalDeposit'+_totalDeposit);	
			
		if(_area != ""){
			var _finalVal = _totalDeposit / _area;
			 var unit_deposite = _finalVal;
			 var _rent_unit_price = $('#rent_unit_price').val();
			 _rent_unit_price = _rent_unit_price.replace(/,/g, "");
			 //console.log('area'+_area);
			 if(_rent_unit_price != "" && _rent_unit_price > 0){
			 	var varmonths = unit_deposite/(_rent_unit_price);
			 	$('#f_price_m_shiki').val(varmonths);	
			 }

			if(!isNaN(_finalVal)){
				$('#f_price_t_shiki').val(_finalVal);
			}
		}
	});
	
	$(document).on('keyup','#total_rent_price',function(e){
		if($(this).val() != ''){
		}
		var total_rent_price = $('#total_rent_price').val();
		total_rent_price = total_rent_price.replace(/,/g, "");
		var area_ping = $('#area-tsubo').val();
		if(total_rent_price != '' && total_rent_price !='undefined'){
			var output = total_rent_price / area_ping;
			//var output = rent_unit_price * area_ping;
			$('#rent_unit_price').val(output);
			if($('.deposit_month').val() != ""){
				$('#f_price_m_shiki').trigger('keyup');
			}
		}else{
			$('#rent_unit_price').val('');
			if($('.deposit_month').val() != ""){
				$('#f_price_m_shiki').trigger('keyup');
			}
		}
	});
	
	$(document).on('keyup','#f_price_m_shiki',function(e){
		var f_price_m_shiki = $(this).val();
		var area_tsubo = $('#area-tsubo').val()
		if(rent_unit_price != ''){
			var rent_unit_price = $('#rent_unit_price').val();
			rent_unit_price = rent_unit_price.replace(/,/g, "");
			$('#f_price_t_shiki').val(f_price_m_shiki * rent_unit_price)
			
			var f_price_t_shiki = $('#f_price_t_shiki').val();
			f_price_t_shiki = f_price_t_shiki.replace(/,/g, "");
			$('#f_price_a_shiki').val(f_price_t_shiki * area_tsubo)
			
		}  
	});
	
	$(document).on('keyup','.deposit_month, .key_money_month, .renewal_fee_recent, .rent_unit_price ,.unit_condo_fee',function(e){
		var cVal = $(this).val();
		if(cVal != ""){
			cVal = cVal.replace(/,/g, "");
			if(isNaN(cVal)){
				$(this).val('');
			}else{
				if($(this).closest('td').find("input[type='radio']").is(':checked')){
					if($(this).attr('name') != 'Floor[renewal_fee_recent]')
					$(this).closest('td').find("input[type='radio']").prop('checked', false);
				}
			}
		}else{
			if($(this).closest('td').find("input[type='radio']").is(':checked')){
				if($(this).attr('name') != 'Floor[renewal_fee_recent]')
				$(this).closest('td').find("input[type='radio']").prop('checked', false);
			}
		}
	});
	
	
	$(document).on('change','input[name="Floor[rent_unit_price_opt]"],input[name="Floor[unit_condo_fee_opt]"]',function(e){
		$(this).closest('td').find("input[type='text']").val('');
		$(this).closest('tr').find("input[type='text']").val('');
	});
	
	$(document).on('change','.repaymentAmtOpt',function(e){
		if($(this).closest('td').find('.price_amo').is(':checked')){
			$(this).closest('td').find('.price_amo').prop('checked', false);
		}
	});
	
	
	
	$(document).on('change','.clearinput',function(e){
		var _inputtoclear = $(this).attr('data-input');
		if($('.'+_inputtoclear).length > 0){
			$('.'+_inputtoclear).val('');
			$('.'+_inputtoclear).prop('checked',false);
		}
	});
	
	$(document).on('change','#f_price_rerent_timeflag',function(e){
		if($(this).closest('td').find("input[type='radio']").is(':checked')){
			$(this).closest('td').find("input[type='radio']").prop('checked', false);
		}
	});
	
	$(document).on('focus','#frenfr',function(e){
		//console.log('changed');
		//console.log($('.price_rerent.clearinput').length);
		$('.price_rerent.clearinput').prop('checked',false);
	});
	
	$(document).on('change','#f_oa',function(e){
		if($(this).val() == ''){
			$(this).closest('td').find('input').val('');
		}
	});
	
	
	
	$(document).on('change','.repaymentReasonDrop',function(e){
		if($(this).val() != "0"){
			if(isNaN($(this).val())){
				$(this).val('');
			}else{
				if($(this).closest('td').find(".price_amo_opt").is(':checked')){
					$(this).closest('td').find(".price_amo_opt").prop('checked', false);
				}
			}
		}else{
			if($(this).closest('td').find(".price_amo_opt").is(':checked')){
				$(this).closest('td').find(".price_amo_opt").prop('checked', false);
			}
		}
	});
	
	$(document).on('keyup','.repayment_amt',function(e){
		if($(this).val() != ""){
			if(isNaN($(this).val())){
				$(this).val('');
			}else{
				if($(this).closest('td').find(".price_amo_opt").is(':checked')){
					$(this).closest('td').find(".price_amo_opt").prop('checked', false);
				}
			}
		}else{
			if($(this).closest('td').find(".price_amo_opt").is(':checked')){
				$(this).closest('td').find(".price_amo_opt").prop('checked', false);
			}
		}
	});
	
	$(document).on('keyup','#f_price_t_shiki',function(e){
		var f_price_t_shiki = $('#f_price_t_shiki').val();
		f_price_t_shiki = f_price_t_shiki.replace(/,/g, "");
		if(f_price_t_shiki != '' && rent_unit_price !='f_price_t_shiki'){

			var area_tsubo = $('#area-tsubo').val();


			var rent_unit_price = $('#rent_unit_price').val();
			rent_unit_price = rent_unit_price.replace(/,/g, "");
			var month = parseInt(f_price_t_shiki / rent_unit_price);
			$('#f_price_m_shiki').val(month)

			var output = f_price_t_shiki * area_tsubo;
			$('#f_price_a_shiki').val(output.toFixed());


		}
	});
	 
	$(document).on('keyup','#unit_condo_fee',function(e){
		var unit_condo_fee = $('#unit_condo_fee').val();
		unit_condo_fee = unit_condo_fee.replace(/,/g, "");
		unit_condo_fee = unit_condo_fee ? unit_condo_fee : 0;
		var area_ping = $('#area-tsubo').val()
		var output = area_ping * unit_condo_fee;
		if(output != 0){
			var tCondo = addCommas(Math.round(output));
			$('#total_condo_fee').val(tCondo);
		}
	});
	
	$(document).on('keyup','#total_rent_price',function(e){
		if($(this).parent().closest('tr').find("input[type='radio']").is(':checked')){
			$(this).parent().closest('tr').find("input[type='radio']").prop('checked', false);
		}
	});
	
	$(document).on('keyup','#total_condo_fee',function(e){
		if($(this).parent().closest('tr').find("input[type='radio']").is(':checked')){
			$(this).parent().closest('tr').find("input[type='radio']").prop('checked', false);
		}
		
		var total_condo_fee = $('#total_condo_fee').val();
		total_condo_fee = total_condo_fee.replace(/,/g, "");
		total_condo_fee = total_condo_fee ? total_condo_fee : 0;
		var area_ping = $('#area-tsubo').val()
		var output = total_condo_fee / area_ping;
		if(output != 0){
			var tCondo = addCommas(Math.round(output));
			$('#unit_condo_fee').val(tCondo);
		}
		else {
			$('#unit_condo_fee').val('');
		}
	});
	 
	$(document).on('click','#change_price_without_tax',function(e){
		 var rent_unit_price = $('#rent_unit_price').val();
		 rent_unit_price = rent_unit_price.replace(/\,/g, '');
		 var unit_condo_fee = $('#unit_condo_fee').val();
		 unit_condo_fee = unit_condo_fee.replace(/\,/g, '');
		 
		 var area_ping = $('#area-tsubo').val()
		 if(rent_unit_price != ''){
			 if(confirm("And in terms of the price -related values ​​in tax ( 8% ) . Is it OK?")){
				 if(rent_unit_price != ''){
					 var out = parseFloat(rent_unit_price / 1.08);
					 //var val = Math.round(rent_unit_price - out);
					 var formatedRent = addCommas(Math.round(out));
					 $('#rent_unit_price').val(formatedRent);
					 var value = Math.round(out);
					 var newVale = value;
					 var total_out = newVale * area_ping;
					 var formatedTotal = addCommas(total_out);
					 $('#total_rent_price').val(formatedTotal);
				 }else{
					 $('#rent_unit_price').css('border-color','red');
				 }
				 
				 if(unit_condo_fee != ''){
					 var out = parseFloat(unit_condo_fee / 1.08);
					 //var val = Math.round(unit_condo_fee - out);
					 var formatedCondo = addCommas(Math.round(out));
					 $('#unit_condo_fee').val(formatedCondo);
					 var value = Math.round(out);
					 var newVale = value;
					 var total_out = newVale * area_ping;
					 var formatedTotal = addCommas(total_out);
					 $('#total_condo_fee').val(formatedTotal);
				 }else{
					 $('#unit_condo_fee').val(0);
					 $('#total_condo_fee').val(0);
				 }
			 }
		 }else{
			 $('#rent_unit_price').css('border-color','red');
		 }  		 
	});
	 
	/*************** add or remove from cart ***************************/
	$(document).on('click','.btnRemoveFromCart',function(e){
		 var cartId = $(this).parent().find('.cartId').val();
		 var url = baseUrl+'/index.php?r=floor/removeFloorFromCart';
		 if(confirm("Are you sure?") == true){
			 call({url:url,params:{cartId:cartId},type:'POST',dataType : 'json'},function(resp){
				 $('.respTotalItemCount').html(resp.count);
			 });
			 $(this).closest('.min-white-box').remove();
		 }
	});
	 
	 $(document).on('click','.btnRemoveList',function(e){
		  var url = baseUrl+'/index.php?r=floor/removeAllItemCart';
		  var isReload = $(this).data('reload');
		  if(confirm("Are you sure?") == true){
			 call({url:url,params:{},type:'POST',dataType : 'json'},function(resp){
				$('.cartResp').html('');
				$('.respTotalItemCount').html('(0)');
				setTimeout(function(){
					$(".cart-content").slideToggle();
				},2000);
				/*if(isReload == 0){
					window.location.href = baseUrl+'/index.php?r=building/searchBuilding';
				}else{*/
					location.reload();
				//}
			 });
			 
		 }
	 });
	 
	$(document).on('click','.btnAddToCart',function(e){
		 e.stopPropagation();
		 e.preventDefault();
		 var _toRemove = false;
		 if($(this).hasClass('remove')){
		 	_toRemove = true;
		 }
		 var _this = $(this);
		 var searchCriteria = $('.hdnSearchCriteria').val();
		 if(_this.attr('value') == 1){
			var floorId = _this.parent().find('.hdnFloorId').val();
		  	var buildingId = _this.parent().find('.hdnBuildingId').val();
		    var url = baseUrl+'/index.php?r=floor/removeFloorToCart';
			call({url:url,params:{floorId:floorId,buildingId:buildingId},type:'POST',dataType : 'json'},function(resp){
				if(resp.status == 1){
					 _this.text('追加');
					 _this.attr('value',0)
					 _this.addClass('add')
					 _this.removeClass('remove')
					 $('.cartResp').html(resp.respData);
					 $('.respTotalItemCount').html(resp.count);
					 /*setTimeout(function(){
						 if(_toRemove == true){
						 	$(".cart-content").slideToggle('hide');
						 }
					 },3000);*/
					 _this.closest('.trFloor').removeClass('cartColor');
					 console.log(_this.closest('.trFloor'));
				}
			 });
		 }else{
			 var floorId = $(this).parent().find('.hdnFloorId').val();
			 var searchData = $('.hdnSearchCriteria').val();
			 var buildingId = $(this).parent().find('.hdnBuildingId').val();
			 var url = baseUrl+'/index.php?r=floor/addFloorToCart';
			 //$(this).attr('disabled',true);
			 _this.text('削除');
			 call({url:url,params:{floorId:floorId,buildingId:buildingId,searchData:searchData,searchCriteria:searchCriteria},type:'POST',dataType : 'json'},function(resp){
				 _this.addClass('remove')
				 _this.removeClass('add')
				 _this.attr('value',1)
				 $('.cartResp').html(resp.respData);
				 $('.respTotalItemCount').html(resp.count);
				 
				 _this.closest('tr.trFloor').addClass('cartColor');
				 console.log(_this.closest('tr.trFloor'));
				 /* if(_toRemove == true){
				 $('.list-nav').trigger('click');
				  }*/
				 /*setTimeout(function(){
					  if(_toRemove == true){
						 $(".cart-content").slideToggle('hide');
						}
				 },3000);*/
			 });
		 }
	});
	
	function createSearchHidenFields(){
		var oldParams = $.parseJSON(jQuery('#hdnSearchCriteria').val());
		var hiddenFields = ['sortby', 'facilities', 'floorType', 'formTypeList', 'lenderType', 'walkFromStation', 'shortRent', 'hdnAddressBuildingId', 'hdnAddressFloorId', 'hdnRouteBuildingId', 'hdnRouteFloorId' ]
		
		if (oldParams.hdnRRouteId)
		{
			oldParams['stationName'] = oldParams['hdnRRouteId'];
			oldParams['url'] = baseUrl+'/index.php?r=building/getBuildingList';
			hiddenFields.push('pre-list');
			hiddenFields.push('prefectureDistrictlist');
			hiddenFields.push('districtTownList');
			hiddenFields.push('districtTownList[]');
		}
		else {
			oldParams['url'] = baseUrl+'/index.php?r=building/buildingFilterByAddress';
			hiddenFields.push('hdnLineId');
			hiddenFields.push('hdnRPrefId');
			hiddenFields.push('hdnRRouteId');
			hiddenFields.push('hdnRailId');
		}
		
		$.each(hiddenFields, function(index, value){
			delete oldParams[value];
		});
		var sortby = $('#building_sortby').val();
		// empty dynamic hidden block before create submit hidden fields
		$('#dynamic_hidden_fields').html('');
		$.each(oldParams, function(fieldName, fieldValue){
			if ($.inArray(fieldName, ['PHPSESSID']) == -1)
			{
				if (typeof fieldValue == 'string')
				{
					$('#dynamic_hidden_fields').append('<input type="hidden" name="'+fieldName+'" value="'+ fieldValue +'"/>');
				}
				else if (typeof fieldValue == 'object'){
					$.each(fieldValue, function(index, value) {
						$('#dynamic_hidden_fields').append('<input type="hidden" name="'+fieldName+'[]" value="'+ value +'"/>');
					})
				}
			}
		});
		if (sortby)
			$('#dynamic_hidden_fields').append('<input type="hidden" name="sortby" value="'+ sortby +'"/>');
	}
	$(document).on('click', '.reset_hidden_button', function(e){
		location.href = $('#mainSearchCondition').attr('action');
	});
	
	$(document).on('change', '#site_building_sortby', function(e){
		$('#sortby_hidden').val($(this).val());
		$('#mainSearchCondition').submit();
	});
	
	$(document).on('change', '#building_sortby', function(e){
		createSearchHidenFields();
		$('#search_hidden_submit').click();
	});
	
	$(document).on('click', '#mainSearchCondition .result_hidden_button', function(e){
		e.preventDefault();
		$('.condition_results .result_hidden_button').toggle();
		$('#hidden_search_fields').slideToggle();
	});
	
	$(document).on('click', '#mainSearchCondition #search_hidden_submit', function(e){
		e.preventDefault();
		createSearchHidenFields();
		var conditionFormData = $('#mainSearchCondition').serializeArray();
		var url = $('#dynamic_hidden_fields').find('input[name="url"]').val();
				
		call({url:url,params:{conditionFormData:conditionFormData, 'stationName': $('#dynamic_hidden_fields').find('input[name="stationName"]').val()},type:'POST',dataType : 'json'},function(resp){	
			if (resp.totalBuilding > 0 || resp.totalFloor > 0)
			{
				var buildingIds = resp.buildingIds.join(',');
				var floorIds = resp.floorIds.join(',');
				$('#dynamic_hidden_fields').append('<input type="hidden" class="hdnAddressBuildingId" name="hdnAddressBuildingId" value="'+ buildingIds +'"/>');
				$('#dynamic_hidden_fields').append('<input type="hidden" class="hdnAddressFloorId" name="hdnAddressFloorId" value="'+ floorIds +'"/>');
				$('#mainSearchCondition').submit();
			}
			else{
				alert('この条件に合うフロアはヒットしませんでした。');
			}
		});
	});
	
	$(document).on('click','.add_all_list',function(e){
		e.stopPropagation();
		e.preventDefault();
		var floorId = $(this).parent().find('.hdnAllFloorIds').val();
		var buildingId = $(this).parent().find('.hdnBuildingId').val();
		var searchcrietaria = $('.hdnSearchCriteria').val(); 
		var url = baseUrl+'/index.php?r=floor/addAllFromToCart';
		call({url:url,params:{floorId:floorId,buildingId:buildingId,searchcrietaria:searchcrietaria},type:'POST',dataType : 'json'},function(resp){
			window.location.reload(true);
		});
	});
	
	$(document).on('click','.btnAddAll',function(e){
		e.stopPropagation();
		e.preventDefault();
		$(this).closest('table').find('.btnAddToCart.add').trigger('click');
	});
	/****************************** end ******************************/
	 
	$(document).on('click','.trFloor',function(e){
		 if(!$(e.target).is('a')){
			 e.preventDefault();
			 var url = $(this).data('href');
			 if($(e.target).closest('td:first-child').length){
				 e.preventDefault();
				 return false;
			 }else{
				 window.open(url,'_blank');
			 }
		 }		
	});
	 
	/*********************** show and add transmission matters ******************/
	$(document).on('click','.btnAddMatters',function(e){
		 e.preventDefault();
		 var buildingId = $(this).parent().find('.buildingIdForTrans').val();
		 $('.buildId').val(buildingId);
		 var url = baseUrl+'/index.php?r=building/getListOfTransmissionMatters';
		 call({url:url,params:{buildingId:buildingId},type:'POST',dataType : 'json'},function(resp){
			 $('.buildingTransmissionMatters').html(resp);
		 });
		 $('#modalTrans').removeClass('hide');
		 $('#modalTrans').addClass('show');
		 $('#modalTrans').fadeIn(1000);
	});
	 
	$(document).on('click','.btnAddTrans',function(e){
		 var buildingId = $('.buildId').val();
		 var inputText = $('.inputText').val();
		 var url = baseUrl+'/index.php?r=building/saveTransmissionDetails';
		 call({url:url,params:{buildingId:buildingId,inputText:inputText},type:'POST',dataType : 'json'},function(resp){
			 if(resp.status == 1){
			 	alert('伝達事項が追加されました。');
				$('.btnAddMatters').html(resp.count+'件');
				$('.afterTransResp').html(resp.divHtml);
				$('.buildId').val(0);
				$('.inputText').val('');
				$('#modalTrans').removeClass('show');
				$('#modalTrans').addClass('hide');
				$('#modalTrans').fadeOut(1000);
			 }else{
			 	alert('何かが間違っていました。');
				$('.buildId').val(0);
				$('.inputText').val('');
			 }
		 });
	});
	/********************************* end ****************************/
	
	//event to close popup-box
	$(document).on('click','.btnModalClose',function(){
		 $('.modal-box').removeClass('show');
		 $('.modal-box').addClass('hide');
		 $('.modal-box').fadeOut(1000);
		 $('.buildId').val(0);
		 $('.inputText').val('');
	}); 
	 
	/****************** add and remove divided partition ******************/
	$(document).on('click','#addTxtDevided',function(e){
		 var txtVal = $(this).parent().find('#dividedArea').val();
		 if(txtVal != ''){
			 $('#acreg_partition_list').append('<div class="divDivided"><input type="hidden" name="Floor[floor_partition][]" class="ty1 divideTxt" value="'+txtVal+'"/><span>'+txtVal+' 坪&nbsp;</span><input type="button" class="sm-btn btnDelete" id="btnDelete" value="削除"></div>');
			 $(this).parent().find('#dividedArea').val('')
		 }else{
			 $('#dividedArea').css('border-color','red');
		 }
	});
	 
	$(document).on('click','.btnDelete',function(e){
		 e.preventDefault();
		 $(this).parent().remove();	 	
	});
	/************************** end ******************************/
	
	/******************** single building page tab redirection ***************/
	$(document).on('click','.updateHistoryLink',function(e){
		e.preventDefault();
		$('a[href="#tab6"]').trigger('click');	
	});
	$(document).on('click','.seeMoreManagement',function(e){
		e.preventDefault();
		$('a[href="#tab2"]').trigger('click');	
	});
	/**************************** end ******************************/	
	/**********************  Building and floor id search *******/
	$(document).on('click','.searc_btn',function(e){
		$('#frmBuildingFloor').submit();
	});
	
	/************************* end *********************************/
   /**********************  Building Name Search *******/
	$(document).on('click','.btnBuildingName',function(e){
		$('#frmBuildingName').submit();
	});
	
	/************************* end *********************************/
	 /**********************  Owner Name Search *******/
	$(document).on('click','.btnSearchOwner',function(e){
		$('#frmOwnerName').submit();
	});
	
	/************************* end *********************************/
	
	 /**********************  Address Search *******/
	$(document).on('click','.btnSearchAddress',function(e){
		$('#frmSearchAdd').submit();
	});
	
	/************************* end *********************************/
	 /**********************  Owner Search *********************/
	$(document).on('click','#searchOwnerName',function(e){
		var name = $('.inptOwnerName').val();
		if(name == ''){
			$('.inptOwnerName').css('border-color','red')
		}else{
			$('.inptOwnerName').css('border-color','none')
		}
		var url = $(this).attr('data-href');
		call({url:url,params:{name:name},type:'POST',dataType : 'json'},function(resp){
			if(resp != ''){
				$(".wht-box").css("display", "block");
				$('.wht-box').html(resp);
			}
		});
	});
	
	$(document).on('click','#selectDrop',function(e){
		var owners = $('.respOwnerName').val();
		var newVal = $(this).val();
		if(owners != '' && owners != 'undefined'){
			$('.respOwnerName').html(owners+"\n"+newVal);
		}else{
			$('.respOwnerName').html(newVal);
		}
	});
	/************************* end *********************************/
	
	/************************search Building***********************/
	$(document).on('keyup','.specifyCustomerName',function(e){
		var customerName = $(this).val();
		var url = baseUrl+'/index.php?r=building/getCustomerDrop';
		call({url:url,params:{customerName:customerName},type:'POST',dataType : 'json'},function(resp){
			$('.respName').html(resp);
			 $('.respName').css('display','block');
		});
	});
	$(document).on('blur','.specifyCustomerName',function(e){
		var custName = $(this).val();
		if(custName == ''){
			$('.respName').html('');
		}
	});
	$(document).on('click','.customerName',function(e){
		 var customerName = $(this).val();
		 $('.specifyCustomerName').val(customerName);
		 $('.respName').css('display','none');
		 
	});
	/*********************** end **********************************/
	
	$(document).on('click','#pdfArticle',function(e){
		e.preventDefault();
		var propsedArticleId = $(this).parent().find('#hdnProposedArticleId').val();
		$('#hdnProArticlePdfId').val(propsedArticleId);
		$('.modal-box-pdf').removeClass('hide');
		$('.modal-box-pdf').addClass('show');
	});
	/*********************** Print proposed article list **********/
	$(document).on('click','#printArticle',function(e){
		e.preventDefault();
		var propsedArticleId = $(this).parent().find('#hdnProposedArticleId').val();
		$('#hdnProArticleId').val(propsedArticleId);
		$('.modal-box-print-art').removeClass('hide');
		$('.modal-box-print-art').addClass('show');
	});
	$('.btnProposedPrint').click(function(e){
		e.preventDefault();
		var form = $("#frmPrintPropose");
		form.attr("method", "get");
		form.attr("action", baseUrl+'/index.php?r=floor/addProposedToCart');
		// setting form target to a window named 'formresult'
		form.attr("target", "formresult");
		form.serialize();
		 window.resizeTo(500,500)
		// creating the 'formresult' window with custom features prior to submitting the form
		window.open(baseUrl+'/index.php?r=floor/addProposedToCart', 'formresult','scrollbars=no,menubar=no,height=600,width=800,resizable=yes,toolbar=no,status=no');
		
		form.submit();
	});
	 $('input[type="radio"]').click(function(){
		 $('.print_term').attr('disabled',true);
         $(this).parent().find('.print_term').attr('disabled',false);
    });
	$(document).on('click','.add_cover',function(e){
		 if ( $(this).is(":checked")) {
			 $(this).parent().find('.header_name').attr('disabled',false);
			 $(this).parent().find('.proposedUsername').attr('disabled',false);
//			 $(this).parent().find('.header_name').removeAttr('disabled');
//			 $(this).parent().find('.proposedUsername').removeAttr('disabled');
		}else {
			 $(this).parent().find('.header_name').attr('disabled',true);
			 $(this).parent().find('.proposedUsername').attr('disabled',true);
		}
		 $(this).parent().find('.header_name').toggleClass('show');
		 $(this).parent().find('.proposedUsername').toggleClass('show');
    });
	$(document).on('click','.add_cover_foot',function(e){
		 if ($(this).parent().find('.header_name_foot').css('display','none')) {
			 $(this).parent().find('.header_name_foot').css('display','block');
		}else {
			 $(this).parent().find('.header_name_foot').css('display','none');
		}
    });
	/************************* end *********************************/
	$(document).on('click','#btnSinglePrint',function(e){
		e.preventDefault();	
		var url = baseUrl+'/index.php?r=floor/addSingleBuildToCart';
		var buildId = $(this).closest('.add-action').find('#hdbPrintBuildId').val();
		var floorId = $(this).closest('.add-action').find('#hdbPrintFloorId').val();
		call({url:url,params:{buildId:buildId,floorId:floorId},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				$('.respTotalItemCount').html(resp.count);
				$('.list-nav').trigger('click');
				$(".cartResp").html(resp.respData);
				setTimeout(function(){
					$('.modal-box-print').show();
				}, 2000);				
			}
		});
	});
	
	
	/* Floor checked on clone to floors */
	$('.check_all_floors').click(function(e) {
		if(this.checked == false){
			$('.floors_list').find('.copy_floor_target').prop('checked',false);
		}else{
			$('.floors_list').find('.copy_floor_target').prop('checked',true);
		}
	});
	
	$(document).on('click','.clone-floor-settings',function(e){
		e.preventDefault();	
		var url = baseUrl+'/index.php?r=floor/clonesettings';
		var buildId = $(this).parent().find('#hdbPrintBuildId').val();
		var floorId = $(this).parent().find('#hdbPrintFloorId').val();
		
		var _form = $('#floor-form').serializeArray();
		var _pids = Array();
		$('.floors_list').find('.copy_floor_target').each(function(index, element) {
            if(this.checked == true){
				_pids.push($(this).attr('data-floor'));
			}
        });
		call({url:url,params:{fids:_pids,form:_form},type:'POST',dataType : 'json'},function(resp){
			if(resp.success == true){
				alert('Data Successfully updated')
			}
		});
		return false;
	});
	
	
	$(document).on('click','.removeImg',function(e){ e.preventDefault();
		if(confirm('あなたはこのイメージを削除してもよろしいです ?')){
			var _thisimg = $(this).closest('li');
			var b_id = $(this).attr('data-bid');
			var b_img = $(this).attr('data-img');
			var b_type = $(this).attr('data-type');
		
		var url = baseUrl+'/index.php?r=buildingPictures/removePicture';
		call({url:url,params:{b_id:b_id,b_img:b_img,b_type:b_type},type:'POST',dataType : 'json'},function(resp){
			
		});
		_thisimg.fadeOut(500,function(){
			_thisimg.remove();
		});
		}
	});
	
	$(document).on('click','.remove-free-rent',function(e){ e.preventDefault();
		if(confirm('あなたが削除してもよろしいですか？')){
			var r_id = $(this).attr('data-id');
			
			var url = baseUrl+'/index.php?r=building/removeFreeRent';
			call({url:url,params:{id:r_id},type:'POST',dataType : 'json'},function(resp){
				window.location.reload(true);
			});
		}
	});
	
	
	
	
	$(document).on('change','.negotiationType',function(e){ e.preventDefault();		
		if(this.checked == true){			
			var value = $(this).val();
			if(value==1 || value==5)
				$('.inputNote').show();
			else
				$('.inputNote').hide();
			
			var _label = $(this).attr('data-label');
			var _pre = $(this).attr('data-pre');
			var _post = $(this).attr('data-post');
			$('.inputLab').html(_label);
			$('.inputPre').html(_pre);
			$('.inputPost').html(_post);
		}
	});
});//document ready end

function addCommas(nStr){
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}	

function viewFullDetails(url){
	window.location.href =  url;
}
var call = function(data,callback){
	// console.log(data);
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
/* end */
var onShowTab = Array(), change_call;
var address = Array(), selectedArea = '', district=Array();
var addressArray = {}; var addStationhtml , resetTownList , removeStation , getSelectRouteStations , removeSelectStations , aStationName = [] , routeStationClick;
//Initialize the jQuery File Upload plugin
var allUpFiles = [];

$(document).ready(function(e) {
	jQuery.extend(jQuery.validator.messages, {
    required: "この項目は必須です"
	});
	
	function getTabAjaxContent(resp, tabID){
		var responseContent = resp.html;
		var tabContent = $(responseContent).find(tabID).html();
		
		var childTabActivateIndex = $(tabID).find('ul.tabs2 li.active').index();
		
		$(tabID).css('opacity', '0');
		$(tabID).html(tabContent);
		
		if($(tabID + " ul.tabs2").length > 0){
			$(tabID + " ul.tabs2").jTabs({content: ".tabs_content2", animate: true});
			$(tabID + " ul.tabs3").jTabs({content: ".tabs_content3", animate: true});
			
			function accordion(){
				$(this).toggleClass("active").next().slideToggle(300);
			}
			$(".accordion .toggle").click(accordion);
			
			setTimeout(function(){
				$(tabID + " ul.tabs2 li:eq("+ childTabActivateIndex +")").trigger('click');
				$(tabID).css('opacity', '1');
			}, 500);
		}
		
		// Clear file uploaded
		$('.hdnFileNames').val('');
		allUpFiles = [];
	}
	
	$(document).on('keyup','.change_txt',function(e){
		var change_txt = $(this).val();
		if(!$.isNumeric(change_txt)){
			$(this).val('');
		}
		
		if($(this).closest('td').find("input[type='radio']").is(':checked')){
			$(this).closest('td').find("input[type='radio']").prop('checked', false);
		}
	});
	
	$(document).on('change','input[name="charge"]',function(e){
		$(this).closest('td').find(".change_txt").val('');
	});
	
	$(document).on('click','.btnRemoveIntroducer',function(e){
		$(this).parent().find('.dropIntroducer').remove();
		$(this).parent().find('.hdnIntroducer').css('display','block');
		$(this).remove();
	});
	
	$(document).on('keyup','.contractDuration',function(){
		if($('.contractDurationOptNew:checked').length == 1){
			$('.contractDurationOptNew').removeAttr('checked');
		}
		/*var _radioChecked = $(this).closest('td').find("input[type='radio']").is(':checked');
		if(_radioChecked){
			$(this).closest('td').find("input[type='radio']").removeAttr('checked');
		}*/
	});
	
	$(document).on('change','.contractDurationOptNew',function(){
		if($('.contractDuration').val() != ''){
			$('.contractDuration').val('');
		}
		var _radioChecked = $(this).closest('td').find("input[type='radio']").is(':checked');
		if(_radioChecked){
			$(this).closest('td').find("input[type='radio']").removeAttr('checked');
		}
	});
	
	$(document).on('change','input[name="Floor[contract_period_opt]"]',function(){
		/*if($('.contractDuration').val() != ''){
			$('.contractDuration').val('');
		}*/
		if($('.contractDurationOptNew:checked').length == 1){
			$('.contractDurationOptNew').removeAttr('checked');
		}
	});
	/************ toggal dashboard office alert ***********/
	$(document).on('change','.toggleDisplayAlert',function(e){
		e.preventDefault();
		var type = $(this).data('value');
		var url = baseUrl+'/index.php?r=customer/toggleAlertDisplay';
		call({url:url,params:{type:type},type:'POST',dataType:'json'},function(resp){
			if(resp.status == true){
				$('.respDisplayAlert').html(resp.content);
			}
		});
	});
	/************************* end ************************/
    /******************* append history of management ********************/
	$(document).on('click','.appentHistory',function(e){
		e.preventDefault();
		$('#appendManagementModal').removeClass('hide');
		$('#appendManagementModal').addClass('show');
		$('#appendManagementModal').fadeIn(1000);
	});	

	$(document).on('click','.btnAddNewHistory',function(e){
		var formdata = $('#frmAddNewHistory').serialize();
		var validat = $('#frmAddNewHistory').valid();
		if(validat == true){
			var url = baseUrl+'/index.php?r=floor/appendNewManagementHistory';
			call({url:url,params:{formdata:formdata},type:'POST',dataType:'json'},function(resp){
				
				if(resp.status == 1){
					alert('管理詳細が追加されました。');
					if(resp.update == 1){
						$('.messageManagement').removeClass('hide');
						$('.messageManagement').html('管理詳細が追加されました。');
					}
					$('#frmAddNewHistory')[0].reset();
					location.reload();
				}else{
					alert('何かが間違っていました。');
				}
				setTimeout(function(){
					$('.btnModalClose').trigger('click');
					$('.manageInfoResponse').html(resp.result);
				},3000);
			});
		}
	});
	
	$(document).on('click','.btnBulkDelete',function(e){
		var formdata = $('#frmBulkDelete').serialize();
		
		var checkOwnerLength =$('[name="checkOwner[]"]:checked').length;
		var checkVendorLength =$('[name="checkVendor[]"]:checked').length;
		
		if(checkOwnerLength == 0 && checkVendorLength == 0){
			alert('上記のいずれかのチェックボックスを選択します。');
			return false;
		}
		
		if(confirm('Are you sure ?')){
			var url = $('#frmBulkDelete').attr('action');
			call({url:url,params:{formdata:formdata},type:'POST',dataType:'json'},function(resp){
				if(resp.status == 1){
					//$('#frmBulkDelete')[0].reset();
					location.reload();
				}else{
					alert('何かが間違っていました。');
				}
			});
		}
	});
	/******************************** end *******************************/
	
	/******************* add new history of management ********************/
	$(document).on('click','.btnAddManagementDetails',function(e){
		var formdata = $('#frmAddManagementHistory').serialize();
		var url = $('#frmAddManagementHistory').attr('action');
		call({url:url,params:{formdata:formdata},type:'POST',dataType:'json'},function(resp){
			if(resp.status == 1){
				if(resp.update == 1){
					var parentWindowUrl = $('.hdnOwnersResp').val();
					alert('管理詳細が追加されました。床を更新してください。');
					$('.messageManagement').html('管理詳細が追加されました。床を更新してください。');
					window.opener.location.href = parentWindowUrl;
					location.reload();
				}else{
					alert('管理詳細が追加されました。フロアを追加してください。');
					$('.messageManagement').html('管理詳細が追加されました。フロアを追加してください。');
				}
				$('#frmAddManagementHistory')[0].reset();
			}else{
				alert('何かが間違っていました。');
			}
		});
	});
	
	$(document).on('click','.btnAddSharedManagementDetails',function(e){
		var formdata = $('#frmAddSharedManagementHistory').serialize();
		var url = $('#frmAddSharedManagementHistory').attr('action');
		call({url:url,params:{formdata:formdata},type:'POST',dataType:'json'},function(resp){
			if(resp.status == 1){
				if(resp.update == 1){
					var parentWindowUrl = $('.hdnOwnersResp').val();
					alert(parentWindowUrl);
					alert('管理詳細が追加されました。床を更新してください。');
					$('.messageManagement').html('管理詳細が追加されました。床を更新してください。');
					$('#frmAddSharedManagementHistory')[0].reset();					
					window.opener.location.href = parentWindowUrl;
					location.reload();
				}else{
					alert('管理詳細が追加されました。フロアを追加してください。');
					$('.messageManagement').html('管理詳細が追加されました。フロアを追加してください。');
				}
				$('#frmAddSharedManagementHistory')[0].reset();
			}else{
				alert('何かが間違っていました。');
			}
		});
	});
	
	$(document).on('click','.targetedFloor',function(){
		if($(this).is(":checked")){
			var checkValues = $('.targetedFloor:checkbox:checked').map(function(){
				return $(this).data('value');
			}).get();
		}else if($(this).is(":not(:checked)")){
			var checkValues = $('.targetedFloor:checkbox:checked').map(function(){
				return $(this).data('value');
			}).get();
		}
		$('.hdnRelatFloor').val(checkValues);
	});
	/******************************** end *******************************/	

	/********************** remove floor ****************************/
	$(document).on('click','.btnDeleteFloor',function(e){
		if(confirm("本当に実行してよろしいですか？") == true){
			var id = $(".selectedFloorToDelete").val();
			var currentFloorId = $("#currentFloorId").val();
			var url = baseUrl+'/index.php?r=floor/deleteFloor';
			call({url:url,params:{id:id,currentFloorId:currentFloorId},type:'POST',dataType:'json'},function(resp){
				if(resp.available == 0){
					window.location.href = baseUrl+resp.url;
				}else{
					window.location.href = baseUrl+resp.url;
				}
			});
		}else{
			return true;
		}
	});
	/**************************** end *******************************/	

	/********************** add fast floor ****************************/
	$(document).on('click','.btnAddFastFloor',function(e){
		var numberOfFloor = $(".addFastFloorNum").val();
		var currentBuildingId = $("#currentBuildingId").val();
		var currentFloorId = $("#currentFloorId").val();		

		if(isNaN(numberOfFloor) || numberOfFloor == 0){
			alert('Number of floor should be number.');
		}else{
			if(confirm("本当に実行してよろしいですか？") == true){
				var url = baseUrl+'/index.php?r=floor/addFastFloor';
				call({url:url,params:{numberOfFloor:numberOfFloor,currentBuildingId:currentBuildingId,currentFloorId:currentFloorId},type:'POST',dataType:'json'},function(resp){
					if(resp.status == 1){
						window.location.href = baseUrl+resp.url;
					}else{
						alert('Something went wrong.');
					}
				});
			}else{
				return true;
			}
		}
	});
	/******************************* end ****************************/	

	/********************** upload and set plan pictures ***************/
	$(document).on('click','.btnTrigglerFile',function(e){
		$('.uploadPlanClass').trigger('click');
	});
	$(document).on('change','#planPicture',function(e){
		var allowedFileType = ['jpeg', 'jpg', 'png'];
		var filePath = $(this).val();
		$("#fileName_1").val(filePath);
		fileName = $(this)[0].files[0].name;
		extractName = fileName.split(".");
		fileExtention  = extractName[extractName.length-1].toLowerCase();
		if(jQuery.inArray(fileExtention, allowedFileType) == -1){
			alert('Please enter only ".jpeg", ".jpg", ".png" format');
			$(this).val('');
			$("#fileName_1").val('');
			return false;
		}else{
			var fileSize = parseFloat(($(this)[0].files[0].size)/1000).toFixed(2);
		}
	});
	
	$(document).on('change','#csvFloor',function(e){
		var allowedFileType = ['csv'];
		var filePath = $(this).val();
		$("#fileName_1").val(filePath);
		fileName = $(this)[0].files[0].name;
		extractName = fileName.split(".");
		fileExtention  = extractName[extractName.length-1];
		if(jQuery.inArray(fileExtention, allowedFileType) == -1){
			alert('Please enter only ".csv" format');
			$(this).val('');
			$("#fileName_1").val('');
			return false;
		}else{
			var fileSize = parseFloat(($(this)[0].files[0].size)/1000).toFixed(2);
		}
	});
	
	$(document).on('click','.btnUploadCSV',function(e){
		var upFile = $("#csvFloor").val();
		var url = baseUrl+'/index.php?r=building/importCSV';
		if(upFile != ""){
			var formData = new FormData();
			formData.append('file', $('#csvFloor')[0].files[0]);
			
			$("#imgLoad").show();
			$.ajax({
				url: url,
				data: formData,
				type: "POST",
				cache: false,
				contentType: false,
				processData: false,
				dataType : 'json'
			}).success(function(resp){
				$("#imgLoad").hide();
				
				alert(resp.msg);
				if(resp.status = 1){
					location.reload();
				}
			});
		}else{
			alert('Please Select File to Upload');
		}
	});
	
	$(document).on('click','.btnUploadPlanPicture',function(e){
		var upFile = $("#planPicture").val();
		var currentBuildingId = $("#currentBuildingId").val();
		var currentFloorId = $('.hdnSingleFloorPlanUp').val();
		var url = baseUrl+'/index.php?r=floor/addNewPlanPicture';
		if(upFile != ""){
			var formData = new FormData();
			formData.append('file', $('#planPicture')[0].files[0]);
			formData.append('buildingId', currentBuildingId);
			formData.append('floorId', currentFloorId);		
			formData.append('planPictureStandard', $('#planPictureStandard').is(':checked') ? 1 : 0);
			// Using the core $.ajax() method
			$('body').LoadingOverlay("show");
			$.ajax({
				url: url,
				data: formData,
				type: "POST",
				cache: false,
				contentType: false,
				processData: false,
				dataType : 'json'
			}).success(function(resp){
				if(resp.status = 1){
					setAlertMessage(resp.msg, true);
				}else{
					setAlertMessage(resp.msg, false);
				}
				getTabAjaxContent(resp, '#tab4');
				$('body').LoadingOverlay("hide");
			});
		}else{
			alert('Please Select File to Upload');
		}
	});
	$(document).on('click','.btnAllocatePlanPicture',function(e){
		var formData = $("#frmAllocatePlanPicture").serialize();
		var url = $("#frmAllocatePlanPicture").data('action');
		$('body').LoadingOverlay("show");
		call({url:url,params:formData,type:'POST',dataType:'json'},function(resp){
			if(resp.status == 1){
				setAlertMessage(resp.msg, true);
			}else{
				setAlertMessage('Something went wrong.', false);
			}
			getTabAjaxContent(resp, '#tab4');
			$('body').LoadingOverlay("hide");
		});
	});
	$(document).on('click','.btnRemoveSelectedPlanPicture',function(e){
		var checkedNum = $('input[name="deletePlanPicture[]"]:checked').length;
		if(!checkedNum){
			alert('Please Check any Checkbox to Proceed.');
			return false;
		}else{
			if(confirm("本当に実行してよろしいですか？") == true){
				var formData = $("#deleteSelectedPlanPicture").serialize();
				var url = $("#deleteSelectedPlanPicture").data('action');
				$('body').LoadingOverlay("show");
				call({url:url,params:formData,type:'POST',dataType:'json'},function(resp){
					if(resp.status == 1){
						setAlertMessage(resp.msg, true);
					}else{
						setAlertMessage('Something went wrong.', false);
					}
					getTabAjaxContent(resp, '#tab4');
					$('body').LoadingOverlay("hide");
				});
			}else{
				return false;
			}
		}
	});
	/************************** end *******************************/	

	/************************ add & view free rent *********************/
	$(document).on('click','.btnUpdateFreeRent',function(e){
		e.preventDefault();
		buildingId = $(this).parent().find('#hdnRentBillId').val();
		$('.rentBuildId').val(buildingId);
		var url = baseUrl+'/index.php?r=building/getListOfFreeRents';
		call({url:url,params:{buildingId:buildingId},type:'POST',dataType : 'json'},function(resp){
			$('.floorListForFreeRent').html(resp.floors);
			$('.buildingFreeRents').html(resp.list);
		});
		$('#modalFreeRent').removeClass('hide');
		$('#modalFreeRent').addClass('show');
		$('#modalFreeRent').fadeIn(1000);
	});
	$(document).on('click','.btnAddFreeRent',function(e){
		var formdata = $('#frmAddFreeRent').serialize();
		var url = $('#frmAddFreeRent').data('action');
		call({url:url,params:{formdata:formdata},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				alert(resp.msg);
				location.reload();
			}else{
				alert(resp.msg);
			}
		});
	});
	/************************** end ***************************/

	/******************************** add & view rent negotiation ****************/
	$(document).on('click','.btnShowRentNegotiation',function(e){
		e.preventDefault();
		buildingId = $(this).parent().find('#hdnNegBilId').val();
		$('.negBuildId').val(buildingId);
		var url = baseUrl+'/index.php?r=building/getListOfRentsNegotiation';
		call({url:url,params:{buildingId:buildingId},type:'POST',dataType : 'json'},function(resp){
			$('.floorListForRentNegotiation').html(resp.floors);
			$('.buildingRentNegotiations').html(resp.list);
		});
		$('#modalRentNegitiation').removeClass('hide');
		$('#modalRentNegitiation').addClass('show');
		$('#modalRentNegitiation').fadeIn(1000);
	});
	$(document).on('click','.btnAddRentNegotiation',function(e){
		var formdata = $('#frmAddRentNegotiation').serialize();
		var url = $('#frmAddRentNegotiation').data('action');
		call({url:url,params:{formdata:formdata},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				alert(resp.msg);
				location.reload();
			}else{
				alert(resp.msg);
			}
		});
	});
	/*************************************** end ****************************/

	/******************************** change map access & station ****************/
	$(document).on('click','.btnChangeMapDetails',function(e){
		e.preventDefault();
		buildingId = $(this).parent().find('#hdnMapBillId').val();
		$('.mapBuildId').val(buildingId);
		/*var url = baseUrl+'/index.php?r=building/getMapAccessDetails';
		call({url:url,params:{buildingId:buildingId},type:'POST',dataType : 'json'},function(resp){
			 $('.buildingRentNegotiations').html(resp.list);
		});*/		

		$('#modalChangeMapAccess').removeClass('hide');
		$('#modalChangeMapAccess').addClass('show');
		$('#modalChangeMapAccess').fadeIn(1000);
		$('#us3').locationpicker('autosize');
	});
	$(document).on('click','.btnChangeMapAccess',function(e){
		var formdata = $('#frmChangeMapAccess').serialize();
		var url = $('#frmChangeMapAccess').data('action');
		call({url:url,params:{formdata:formdata},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				alert("Data successfully updated.");
				location.reload();
			}else{
				alert("Something went wrong.");
			}
		});
	});
	
	$(document).on('click','.btnTranslateLines',function(e){
		e.preventDefault();
		buildingId = $(this).parent().find('.buildingID').val();
		var url = baseUrl+'/index.php?r=building/getStationsLines';
		call({url:url,params:{buildingId:buildingId},type:'POST',dataType : 'json'},function(resp){
			 $('#frmTranslateStationLines table tbody').html(resp.list);
		});

		$('#modalTranslateStationLines').removeClass('hide');
		$('#modalTranslateStationLines').addClass('show');
		$('#modalTranslateStationLines').fadeIn(1000);
	});
	$(document).on('click','.btnTranslateStationLines',function(e){
		e.preventDefault();
		var url = $('#frmTranslateStationLines').data('action');
		$('body').LoadingOverlay("show");
		$.ajax({
			url: url,
			data: $('#frmTranslateStationLines').serialize(),
			type: "POST",
			dataType : 'json'
		}).success(function(resp){
			$('body').LoadingOverlay("hide");
			alert("Data successfully updated.");
		}).error(function(){
			$('body').LoadingOverlay("hide");
		});
	});
	/*************************************** end ****************************/

	/*********************************** Cart in list ********************/
	$(document).on('click','.btnViewCartList',function(e){
		var url = baseUrl+'/index.php?r=building/checkListForCart';
		call({url:url,params:{},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 0){
				window.location.href = resp.url;
			}else{
				window.location.href = resp.url;
			}
		});
	});
	/********************************** end ******************************/	

	/*********************** add proposed article & all actions *****************/
	$(document).on('click','.btnSaveProposedArticle',function(e){
		e.preventDefault();
		$('#modalProposedArticle').removeClass('hide');
		$('#modalProposedArticle').addClass('show');
		$('#modalProposedArticle').fadeIn(1000);
		var buildIds = $('#hdnCartBuildId').val();
		var flrIds = $('#hdnCartFlrId').val();
		var searchCond = $('#hdnCartCondition').val();
		$('#hdnCartBuildingId').val(buildIds);
		$('#hdnCartFloorId').val(flrIds);
		$('#hdnCartCond').val(searchCond);
	});
	$(document).on('click','.btnAddArticle',function(e){
		e.preventDefault();
		var formdata = $('.frmAddBuildToProposedList').serialize();
		var url = $('.frmAddBuildToProposedList').data('action');
		call({url:url,params:{formdata:formdata},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				window.location.href = resp.url;
			}else{
				location.reload();
			}
		});
	});
	$(document).on('click','.btnDeleteProposedArticle',function(e){
		e.preventDefault();
		var proposedId = $(this).parent().find('.hdnProposedArticleId').val();
		if(confirm("本当に実行してよろしいですか？") == true){
			var url = baseUrl+'/index.php?r=proposedArticle/deleteProposedArticle';
			call({url:url,params:{proposedId:proposedId},type:'POST',dataType : 'json'},function(resp){
				if(resp.status == 1){
					location.reload();
				}else{
					alert('Something went wrong.');
				}
			});
		}
	});
	$(document).on('click','.btnShowProposedArticleList',function(e){
		e.preventDefault();
		var proposedId = $(this).parent().find('.hdnProposedArticleId').val();
		var url = baseUrl+'/index.php?r=building/searchBuildingResult&pid='+proposedId;
		window.location.href = url;
	});
	$(document).on('click','.btnDuplicateProposedArticle',function(e){
		e.preventDefault();
		var searchConditions = $(this).data('value');
		var proposedId = $(this).parent().find('.hdnProposedArticleId').val();
		if(confirm("本当に実行してよろしいですか？") == true){
			$('#modalCloneProposedArticle').removeClass('hide');
			$('#modalCloneProposedArticle').addClass('show');
			$('#modalCloneProposedArticle').fadeIn(1000);
			$('.hdnProArticleId').val(proposedId);
			$('.conditionDuplicate').html(searchConditions);
		}
	});
	$(document).on('click','.btnSaveDuplicateArticle',function(e){
		e.preventDefault();
		formdata = $('#frmCloneProposedArticle').serialize();
		var url = $('#frmCloneProposedArticle').data('action');
		call({url:url,params:{formdata:formdata},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				window.location.href = resp.url;
			}else{
				location.reload();
			}
		});
	});
	$(document).on('click','.btnAddArticleToCart',function(e){
		e.preventDefault();
		var proposedId = $(this).parent().find('.hdnProposedArticleId').val();
		var url = baseUrl+'/index.php?r=proposedArticle/addArticleToCart';
		call({url:url,params:{proposedId:proposedId},type:'POST',dataType : 'json'},function(resp){
			$('.cartResp').html(resp.respData);
			$('.respTotalItemCount').html(resp.count);
			$('.list-nav').trigger('click');
		});
	});
	
	$(document).on('click','.btnDownloadExcel',function(e){
		e.preventDefault();
		var proposedId = $(this).parent().find('.hdnProposedArticleId').val();
		$('.dwnExcelId').val(proposedId);
		$('.frmDownloadAsExcel').submit();
	});
	/********************************** end ******************************/

	/*********************** filter proposed article *****************/
	$(document).on('click','.filterAction',function(e){
		e.preventDefault();
		$('.dispLoader').css('display','block');
		var formdata = $('.frmFilterProposedArticle').serialize();
		var url = $('.frmFilterProposedArticle').data('action');
		call({url:url,params:{formdata:formdata},type:'POST',dataType : 'json'},function(resp){
			$('.dispLoader').css('display','none');
			$('.filterResponse').html(resp.result);
			$('.articleNumber').html(resp.count);
			$('.pagination').html(resp.pgWidget);
		});
	});
	$(document).on('click','.btnFilterByName',function(e){
		e.preventDefault();
		var formdata = $('.frmFilterProposedArticleByCustomer').serialize();
		var url = $('.frmFilterProposedArticleByCustomer').data('action');
		call({url:url,params:{formdata:formdata},type:'POST',dataType : 'json'},function(resp){
			$('.filterResponse').html(resp.result);
			$('.articleNumber').html(resp.count);
		});
	});
	/********************************** end ******************************/
	
	/************************** office alert section ******************/
	$(document).on('click','.btnDeleteOfficeAlert',function(e){
		e.preventDefault();
		var officeAlertId = $(this).parent().find('.hdnOfficeAlertId').val();
		if(confirm("本当に実行してよろしいですか？") == true){
			var url = baseUrl+'/index.php?r=building/deleteOfficeAlert';
			call({url:url,params:{officeAlertId:officeAlertId},type:'POST',dataType : 'json'},function(resp){
				if(resp.status == 1){
					location.reload();
				}else{
					alert('Something went wrong.');
				}
			});
		}
	});
	
	$(document).on('click','.btnDuplicateOfficeAlert',function(e){
		e.preventDefault();
		if(confirm("本当に実行してよろしいですか？") == true){
			var searchConditions = $(this).data('value');
			var officeAlertId = $(this).parent().find('.hdnOfficeAlertId').val();
			$('.hdnOffAlertId').val(officeAlertId);
			$('#modalCloneOfficeAlert').removeClass('hide');
			$('#modalCloneOfficeAlert').addClass('show');
			$('#modalCloneOfficeAlert').fadeIn(1000);
			$('.hdnProArticleId').val(proposedId);
			$('.conditionDuplicate').html(searchConditions);
		}
	});
	
	$(document).on('click','.btnSaveDuplicateOfficeAlert',function(e){
		e.preventDefault();
		formdata = $('#frmCloneOfficeAlert').serialize();
		var url = $('#frmCloneOfficeAlert').data('action');
		call({url:url,params:{formdata:formdata},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				window.location.href = resp.url;
			}else{
				location.reload();
			}
		});
	});
	
	$(document).on('click','.btnShowOfficeAlertList',function(e){
		e.preventDefault();
		var officeAlertId = $(this).parent().find('.hdnOfficeAlertId').val();
		var url = baseUrl+'/index.php?r=building/searchBuildingResult&oid='+officeAlertId;
		window.location.href = url;
	});
	
	$(document).on('click','.btnOffAlert',function(e){
		e.preventDefault();
		if(confirm("本当に実行してよろしいですか？") == true){
			var officeAlertId = $(this).parent().find('.hdnOfficeAlertId').val();
			var url = $(this).attr('href');
			call({url:url,params:{officeAlertId:officeAlertId},type:'POST',dataType : 'json'},function(resp){
				if(resp.status == 1){
					alert(resp.msg);
					location.reload();
				}else{
					alert(resp.msg);
				}
			});
		}
	});
	/***************************** end *******************************/

	/********************************* building picture upload ******************/
	$(document).on('click','.btnUpBuildFrontImages',function(){
		$('#hdnUploadSection').val(1);
		$('#modalUploadPicture').removeClass('hide');
		$('#modalUploadPicture').addClass('show');
		$('#modalUploadPicture').fadeIn(1000);
	});
	$(document).on('click','.btnUpBuildEntranceImages',function(){
		$('#hdnUploadSection').val(2);
		$('#modalUploadPicture').removeClass('hide');
		$('#modalUploadPicture').addClass('show');
		$('#modalUploadPicture').fadeIn(1000);
	});
	$(document).on('click','.btnUpBuildInFrontImages',function(){
		$('#hdnUploadSection').val(3);
		$('#modalUploadPicture').removeClass('hide');
		$('#modalUploadPicture').addClass('show');
		$('#modalUploadPicture').fadeIn(1000);
	});
	
	$(document).on('click','#add_new_owner',function(e){
		$('#appendManagementModal').show();
	});
	
	$(document).on('click','.btnUpBuildingPicture',function(e){
		e.preventDefault();
		var formdata = $('.frmUpBuildingPicture').serialize();
		var url = baseUrl+'/index.php?r=buildingPictures/saveUploadedBuildPicture';
		$('body').LoadingOverlay("show");
		call({url:url,params:{formdata:formdata},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				setAlertMessage('写真が追加されました。', true);
				$('#frmUpBuildingPicture ul li').remove();
			}else{
				setAlertMessage('Something went wrong.', false);
			}
			getTabAjaxContent(resp, '#tab4');
			$('body').LoadingOverlay("hide");
		});
	});
	/********************************* end ************************************/

	/*************************** floor picture upload ************************/
	$(document).on('click','.btnUpFloorIndoorImages',function(){
		$('#hdnUploadFloorSection').val(1);
		var floorId = $(this).closest('li').find('.hdnUpFloorId').val();
		$('#hdnSingleFloorId').val(floorId);
		$('#modalUploadFloorPicture').removeClass('hide');
		$('#modalUploadFloorPicture').addClass('show');
		$('#modalUploadFloorPicture').fadeIn(1000);
	});
	$(document).on('click','.btnUpFloorKitchenImages',function(){
		$('#hdnUploadFloorSection').val(2);
		var floorId = $(this).closest('li').find('.hdnUpFloorId').val();
		$('#hdnSingleFloorId').val(floorId);
		$('#modalUploadFloorPicture').removeClass('hide');
		$('#modalUploadFloorPicture').addClass('show');
		$('#modalUploadFloorPicture').fadeIn(1000);
	});
	$(document).on('click','.btnUpFloorBathroomImages',function(){
		$('#hdnUploadFloorSection').val(3);
		var floorId = $(this).closest('li').find('.hdnUpFloorId').val();
		$('#hdnSingleFloorId').val(floorId);
		$('#modalUploadFloorPicture').removeClass('hide');
		$('#modalUploadFloorPicture').addClass('show');
		$('#modalUploadFloorPicture').fadeIn(1000);
	});
	$(document).on('click','.btnUpFloorProspectImages',function(){
		$('#hdnUploadFloorSection').val(4);
		var floorId = $(this).closest('li').find('.hdnUpFloorId').val();
		$('#hdnSingleFloorId').val(floorId);
		$('#modalUploadFloorPicture').removeClass('hide');
		$('#modalUploadFloorPicture').addClass('show');
		$('#modalUploadFloorPicture').fadeIn(1000);
	});
	$(document).on('click','.btnUpFloorOtherImages',function(){
		$('#hdnUploadFloorSection').val(5);
		var floorId = $(this).closest('li').find('.hdnUpFloorId').val();
		$('#hdnSingleFloorId').val(floorId);
		$('#modalUploadFloorPicture').removeClass('hide');
		$('#modalUploadFloorPicture').addClass('show');
		$('#modalUploadFloorPicture').fadeIn(1000);
	});	
	$(document).on('click','.btnUpFloorTenantListImages',function(){
		$('#hdnUploadFloorSection').val(6);
		var floorId = $(this).closest('li').find('.hdnUpFloorId').val();
		$('#hdnSingleFloorId').val(floorId);
		$('#modalUploadFloorPicture').removeClass('hide');
		$('#modalUploadFloorPicture').addClass('show');
		$('#modalUploadFloorPicture').fadeIn(1000);
	});
	$(document).on('click','.btnUpFloorPicture',function(e){
		e.preventDefault();
		var formdata = $('.frmUpFloorPicture').serialize();
		var url = baseUrl+'/index.php?r=floorPictures/saveUploadedFloorPicture';
		call({url:url,params:{formdata:formdata},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				alert('写真が追加されました。');
				location.reload();
			}else{
				alert('何かが間違っていました。');
			}
		});
	});
	$(document).on('click','.copy_picture',function(){
		if($(this).is(":checked")){
			var checkValues = $('input[name=copy_picture]:checked').map(function(){
				return $(this).val();
			}).get();
			$('.hdnMultiFloorId').val(checkValues);
		}else if($(this).is(":not(:checked)")){
			var checkValues = $('input[name=copy_picture]:checked').map(function(){
				return $(this).val();
			}).get();
			$('.hdnMultiFloorId').val(checkValues);
		}
	});
	$(document).on('click','.btnAllocateUploadSection',function(e){
		e.preventDefault();
		var photoType = $('.photo_type').val();
		var checkedNum = $('input[name="copy_picture"]:checked').length;
		if (photoType == ""){
			alert('あなたは、画像の種類を選択する必要がなければなりません。');
			return false;
		}else{
			if(!checkedNum){
				alert('あなたがチェックボックスのいずれかをチェックする必要がなければなりません。');
				return false;
			}else{
				$('.hdnUploadFloorSection').val(photoType);
				alert('Photo type selected. Click on Add Image to upload picture');
			}
		}
	});
	$(document).on('click','.btnUploadSectionImage',function(){
		var uploadType = $(this).parent().find('.photo_type').val();
		if (uploadType == ""){
			alert('あなたは、画像の種類を選択する必要がなければなりません。');
			return false;
		}
		$('.hdnUploadFloorSection').val(uploadType);
		var checkedNum = $('input[name="copy_picture"]:checked').length;
		if(!checkedNum){
			alert('あなたがチェックボックスのいずれかをチェックする必要がなければなりません。');
			return false;
		}else{
			$('#modalUploadFloorPicture').removeClass('hide');
			$('#modalUploadFloorPicture').addClass('show');
			$('#modalUploadFloorPicture').fadeIn(1000);
		}
	});
	$(document).on('click','.checkAll',function(){
		$('.floorPicAccordion').find("input:checkbox").prop('checked', $(this).prop("checked"));
		var checkValues = $('input[name=copy_picture]:checked').map(function(){
			return $(this).val();
		}).get();
		$('.hdnMultiFloorId').val(checkValues);
	});
	/********************************* end ******************************************/	

	function makeSearchBuildingDefault(level) {
		return;
		if (level == 1)
		{
			$('.routeSearchCriteria .lineList').html('');
		}
		if (level == 1 || level == 2)
		{
			$('.routeSearchCriteria .stationList').html('');
		}
		
		$('.routeBeforeResult').removeClass('hide');
		$('.routeResult').addClass('hide');
	}
	
	/*********************** get list of corporator, line & station / and get building list ********************/
	$(document).on('click','.corporates, .lines, .stations,.listli',function(){
		$(this).find('i').remove();
		$(this).prepend('<i class="fa fa-check-square item-check" aria-hidden="true"></i>');
	});
	$(document).on('change','.singlePrefecture',function(){
		var code = $(this).val();
		var precName = $(this).find('option:selected').text().trim();		
		$(this).addClass('activePrefecture');
		var url = baseUrl+'/index.php?r=building/getCorporationList';
		$('#hdnRPrefId').val(code);
		
		var divClass = 'corporate'+precName;
		divClass.replace(' ', '');
		$('.corporate-sub-list').hide();
		if (!$('.' + divClass).length)
		{
			call({url:url,params:{code:code, name:precName},type:'POST',dataType : 'json'},function(resp){
				//var responseHtml = '<div class="corporate-sub-list '+divClass+'">'+ resp +'</div>';
				//$('.corporateList').append(responseHtml);
				$('.corporateList').html(resp);
				makeSearchBuildingDefault(1);
			});

		}
		$('.' + divClass).show();
		
	});
	
	$(document).on('click','.listli',function(){
		$(this).toggleClass('activelistli');
		if($(this).find('input[type="checkbox"]')[0].checked == true){
			$(this).find('input[type="checkbox"]').prop('checked',false).trigger('change');
		}else{
			$(this).find('input[type="checkbox"]').prop('checked',true).trigger('change');
		}
	});
	
	$(document).on('click','.listli_new .fa',function(){
		$('.districtTownList').hide();
		$(this).parent().toggleClass('activelistli');	
		var code = $(this).parent().data('value');
		
		if($(this).parent().find('input[type="checkbox"]')[0].checked == true){
			$(this).parent().find('input[type="checkbox"]').prop('checked',false).trigger('change');
			$(this).parent().prepend('<i class="fa fa-square" aria-hidden="true"></i>');			
			var index = district.indexOf(code);
			district.splice(index, 1);
			
			var url = baseUrl+'/index.php?r=building/getTownList';
			call({url:url,params:{code:code,added:address},type:'POST',dataType : 'json'},function(resp){				
				for(i=0;i<resp.data.length;i++) {
					var name = resp.data[i][1], code = resp.data[i][0];
					removeStation(name);
				}
				
				
				if(address.length == 0){
					resetTownList();
					return false;
				}
				
				var conditionFormData = $('#mainSearchCondition').serializeArray();
				var url = baseUrl+'/index.php?r=building/buildingFilterByAddress';
				call({url:url,params:{name:address,conditionFormData:conditionFormData},type:'POST',dataType : 'json'},function(resp){
					$('#frmSearchAddressBuildingJson').val(resp.form_json);	
					$('.totalFloorForAddress .number').html(resp.totalFloor);
					$('.totalBuildingForAddress .number').html(resp.totalBuilding);
					$('.hdnAddressBuildingId').val(resp.buildingIds);
					$('.hdnAddressFloorId').val(resp.floorIds);
					$('.addressBeforeResult').addClass('hide');
					$('.addressResult').removeClass('hide');
					$('.divSelArea').html(addStationhtml());			
					if(resp.totalFloor == '0' && resp.totalBuilding == '0'){
						$('.btnSearchPropertiesAddress').attr('disabled','true');
						$('.btnSearchPropertiesAddress').css('cursor','no-drop');
					}else{
						$('.btnSearchPropertiesAddress').removeAttr('disabled');
						$('.btnSearchPropertiesAddress').css('cursor','pointer');
					}
				});
			});
			
		}else{
			$(this).parent().find('input[type="checkbox"]').prop('checked',true).trigger('change');
			$(this).parent().prepend('<i class="fa fa-check-square" aria-hidden="true"></i>');
			district.push(code);			
			
			var url = baseUrl+'/index.php?r=building/getTownList';
			call({url:url,params:{code:code,added:address},type:'POST',dataType : 'json'},function(resp){
				for(i=0;i<resp.data.length;i++) {
					var name = resp.data[i][1], code = resp.data[i][0];
					$('.hiddenTwnvals').append('<input type="hidden" name="districtTownList[]" data-tname="'+name+'" value="'+code+'" />');
					address.push(name);
					addressArray[name] = code;
				}
				if(address.length == 0){
					resetTownList();
					return false;
				}
				
				var conditionFormData = $('#mainSearchCondition').serializeArray();
				var url = baseUrl+'/index.php?r=building/buildingFilterByAddress';
				call({url:url,params:{name:address,conditionFormData:conditionFormData},type:'POST',dataType : 'json'},function(resp){
					$('#frmSearchAddressBuildingJson').val(resp.form_json);	
					$('.totalFloorForAddress .number').html(resp.totalFloor);
					$('.totalBuildingForAddress .number').html(resp.totalBuilding);
					$('.hdnAddressBuildingId').val(resp.buildingIds);
					$('.hdnAddressFloorId').val(resp.floorIds);
					$('.addressBeforeResult').addClass('hide');
					$('.addressResult').removeClass('hide');
					$('.divSelArea').html(addStationhtml());			
					if(resp.totalFloor == '0' && resp.totalBuilding == '0'){
						$('.btnSearchPropertiesAddress').attr('disabled','true');
						$('.btnSearchPropertiesAddress').css('cursor','no-drop');
					}else{
						$('.btnSearchPropertiesAddress').removeAttr('disabled');
						$('.btnSearchPropertiesAddress').css('cursor','pointer');
					}
				});
			});
		}		
		$(this).remove();
	
	});
	
	$(document).on('click','.listli_new span',function(){
		var p_class = $(this).parent().prop('className'); 
		if(p_class.includes("activelistli")) {
			$('.districtTownList').hide();
			return;
		}
		$('.districtTownList').show();
		$('.districtTownList input').attr('disabled',true);
		var code = $(this).data('name');
		if(code == ""){
			$('.districtTownList input').attr('disabled',true);
			return false;
		}
		$('.townGif').css('display','block');
		var url = baseUrl+'/index.php?r=building/getTownList';
		call({url:url,params:{code:code,added:address},type:'POST',dataType : 'json'},function(resp){
			$('.townGif').css('display','none');
			$('.districtTownList').html(resp.html);
			$('.districtTownList input').attr('disabled',false);
		});
	});
	
	/*// Make default Tokyo Prefecture clicked
	if ($('.singlePrefecture.activePrefecture').length && !_dont_load_tokyo)
	{
		$('.singlePrefecture.activePrefecture').click();
	}*/
	
	$(document).on('click','.corporates',function(){
		var corporate = $(this).data('value').trim();
		var prefecName = $('.singlePrefecture option:selected').text().trim();
		$('.corporates').removeClass('activeCorporate');
		$(this).addClass('activeCorporate');
		var url = baseUrl+'/index.php?r=building/getLineList';
		$('#hdnRailId').val(corporate);
		
		var divClass = 'line'+prefecName+corporate;
		divClass.replace(' ', '');
		$('.line-sub-list').hide();
		if (!$('.' + divClass).length)
		{
			call({url:url,params:{corporate:corporate,prefecName:prefecName},type:'POST',dataType : 'json'},function(resp){
				//var responseHtml = '<div class="line-sub-list '+divClass+'">'+ resp +'</div>';
				//$('.lineList').append(responseHtml);
				$('.lineList').html(resp);
				makeSearchBuildingDefault(2);
			});
		}
		$('.' + divClass).show();
	});
	$(document).on('click','.lines',function(){
		var code = $(this).data('value');
		var prefecName = $('.singlePrefecture option:selected').text().trim();
		var lineText = $(this).text();
		$('.lines').removeClass('activeLine');
		$(this).addClass('activeLine');
		var url = baseUrl+'/index.php?r=building/getStationList';
		$('#hdnLineId').val(code);
		
		var divClass = 'station'+prefecName+lineText;
		divClass.replace(' ', '');
		$('.station-sub-list').hide();
		
		if (!$('.' + divClass).length)
		{
			call({url:url,params:{code:code, name:lineText, prefecName:prefecName,actStat:aStationName.join()},type:'POST',dataType : 'json'},function(resp){
				//var responseHtml = '<div class="station-sub-list '+divClass+'">'+ resp +'</div>';
				//$('.stationList').append(responseHtml);
				$('.stationList').html(resp);
				
				$('.routeStation .line-text').show();
				$('.routeStation .pre-title.line-text').text(lineText + 'を選択中です。');
				makeSearchBuildingDefault(3);
			});
		}
		$('.' + divClass).show();
	});
	
	
	$(document).on('click','.removeSearchStation',function(){
		var stationName = $(this).data('value');
		$(this).closest('div').remove();
		$('.stationList .activeStation').each(function(){
			if(stationName == $(this).data('value'))
			{
				$(this).click();
			}
		});
		$('.actStationEle[data-value="'+stationName+'"]').remove();
	});
	$(document).on('click','.stations',function(){
		routeStationClick($(this));
		$('.routeResult .selectedSearchCriteria').html('');
		if ($('.actStationEle').length > 0)
		{
			getbackRouteOpts();
			getSelectRouteStations();
		}else{
			resetRouteList();
			return false;
		}
		var conditionFormData = $('#mainSearchCondition').serializeArray();
		var url = baseUrl+'/index.php?r=building/getBuildingList';
		call({url:url,params:{stationName:aStationName.join(),conditionFormData:conditionFormData},type:'POST',dataType : 'json'},function(resp){
			$('#frmSearchRouteBuildingJson').val(JSON.stringify(resp.form_json));
			$('.totalFloor .number').html(resp.totalFloor);
			$('.totalBuilding .number').html(resp.totalBuilding);
			$('.hdnRouteBuildingId').val(resp.buildingIds);
			$('.hdnRouteFloorId').val(resp.floorIds);
			$('.routeBeforeResult').addClass('hide');
			$('.routeResult').removeClass('hide');
			if(resp.totalFloor == '0' && resp.totalBuilding == '0'){
				$('.btnSearchProperties').attr('disabled','true');
				$('.btnSearchProperties').css('cursor', 'no-drop');
			}else{
				$('.btnSearchProperties').removeAttr('disabled');
				$('.btnSearchProperties').css('cursor', 'pointer');
			}
		});			
	});
	$(document).on('click','.btnSearchProperties',function(){
		getSelectRouteStations();
		$('#hdnRRouteId').val(aStationName.join());
		
		$('#mainSearchCondition').append($('#hdnRPrefId'));
		$('#mainSearchCondition').append($('#hdnRailId'));
		$('#mainSearchCondition').append($('#hdnLineId'));
		$('#mainSearchCondition').append($('#hdnRRouteId'));
		$('#mainSearchCondition').append($('#hdnRouteBuildingId'));
		$('#mainSearchCondition').append($('#hdnRouteFloorId'));
		/*$('#mainSearchCondition').append($('#frmSearchAddressBuildingJson'));*/
		
		$('#mainSearchCondition').submit();
	});
	/**************************** end ***********************************/
	
	/******************* condition change calls **********************/
	
	change_call = function(){
		var tabname = $('.searchTab:visible').data('tabname');
		if(tabname == 'area'){
			if(address.length == 0){
				resetTownList();
				return false;
			}
			
			
			var conditionFormData = $('#mainSearchCondition').serializeArray();
			var url = baseUrl+'/index.php?r=building/buildingFilterByAddress';		
			call({url:url,params:{name:address,conditionFormData:conditionFormData},type:'POST',dataType : 'json'},function(resp){	
				$('#frmSearchAddressBuildingJson').val(resp.form_json);	
				$('.totalFloorForAddress .number').html(resp.totalFloor);		
				$('.totalBuildingForAddress .number').html(resp.totalBuilding);		
				$('.hdnAddressBuildingId').val(resp.buildingIds);
				$('.hdnAddressFloorId').val(resp.floorIds);		
				$('.addressBeforeResult').addClass('hide');		
				$('.addressResult').removeClass('hide');		
				$('.divSelArea').html(addStationhtml());				
				if(resp.totalFloor == '0' && resp.totalBuilding == '0'){
					$('.btnSearchPropertiesAddress').attr('disabled','true');
					$('.btnSearchPropertiesAddress').css('cursor','no-drop');
				}else{
					$('.btnSearchPropertiesAddress').removeAttr('disabled');
					$('.btnSearchPropertiesAddress').css('cursor','pointer');
				}
			});
			
		}
		else if(tabname == 'route'){
			if($('.actStationEle').length > 0){
				$('.routeResult .selectedSearchCriteria').html('');
				if ($('.actStationEle').length > 0)
				{
					getbackRouteOpts();
					getSelectRouteStations();
				}else{
					resetRouteList();
					return false;
				}
				
				var stationName = aStationName.join();
				var conditionFormData = $('#mainSearchCondition').serializeArray();
				var url = baseUrl+'/index.php?r=building/getBuildingList';
				call({url:url,params:{stationName:stationName,conditionFormData:conditionFormData},type:'POST',dataType : 'json'},function(resp){
					$('#frmSearchRouteBuildingJson').val(JSON.stringify(resp.form_json));
					$('.totalFloor .number').html(resp.totalFloor);
					$('.totalBuilding .number').html(resp.totalBuilding);
					$('.hdnRouteBuildingId').val(resp.buildingIds);
					$('.hdnRouteFloorId').val(resp.floorIds);
					$('.routeBeforeResult').addClass('hide');
					$('.routeResult').removeClass('hide');
					if(resp.totalFloor == '0' && resp.totalBuilding == '0'){
						$('.btnSearchProperties').attr('disabled');
						$('.btnSearchProperties').css('cursor', 'no-drop');
					}else{
						$('.btnSearchProperties').attr('disabled');
						$('.btnSearchProperties').css('cursor', 'pointer');
					}
				});
			}
		}else{
			return false;
		}
	
	}
	
	
	$('.divSearchCondition').find('input,select').change(function(){
		change_call();
	});
	/*********************** end *************************/	

	/*********************** get list of district & city / and get building list ********************/
	$(document).on('change','.pre-list',function(){
		$('.prefectureDistrictlist').attr('disabled',true);
		var code = $(this).val();
		if(code == ""){
			$('.prefectureDistrictlist').attr('disabled',true);
			return false;
		}
		$('.districtGif').css('display','block');
		var url = baseUrl+'/index.php?r=building/getDisctrictList';
		call({url:url,params:{code:code, district:district},type:'POST',dataType : 'json'},function(resp){
			$('.districtGif').css('display','none');
			$('.prefectureDistrictlist').html(resp);
			$('.prefectureDistrictlist_new').html(resp);			
//			$('.prefectureDistrictlist').attr('disabled',false);
		});
	});
	$(document).on('change','.prefectureDistrictlist',function(){
		$('.districtTownList input').attr('disabled',true);
		var code = $(this).val();
		if(code == ""){
			$('.districtTownList input').attr('disabled',true);
			return false;
		}
		$('.townGif').css('display','block');
		var url = baseUrl+'/index.php?r=building/getTownList';
		call({url:url,params:{code:code,added:address},type:'POST',dataType : 'json'},function(resp){
			$('.townGif').css('display','none');
			$('.districtTownList').html(resp.html);
			$('.districtTownList input').attr('disabled',false);
		});
	});
	$(document).on('change','.districtTownList input',function(){
		var name = $(this).data('name');
		var code = $(this).val();
		if(this.checked){
			$('.hiddenTwnvals').append('<input type="hidden" name="districtTownList[]" data-tname="'+name+'" value="'+code+'" />');
		  address.push($(this).data('name'));
		  addressArray[$(this).data('name')] = $(this).val();
		}else{
			removeStation($(this).data('name'));
		}
		
		
		if(code == ""){
			return false;
		}
		
		if(address.length == 0){
			resetTownList();
			return false;
		}
		
		var conditionFormData = $('#mainSearchCondition').serializeArray();
		var url = baseUrl+'/index.php?r=building/buildingFilterByAddress';
		call({url:url,params:{name:address,conditionFormData:conditionFormData},type:'POST',dataType : 'json'},function(resp){
			$('#frmSearchAddressBuildingJson').val(resp.form_json);	
			$('.totalFloorForAddress .number').html(resp.totalFloor);
			$('.totalBuildingForAddress .number').html(resp.totalBuilding);
			$('.hdnAddressBuildingId').val(resp.buildingIds);
			$('.hdnAddressFloorId').val(resp.floorIds);
			$('.addressBeforeResult').addClass('hide');
			$('.addressResult').removeClass('hide');
			$('.divSelArea').html(addStationhtml());			
			if(resp.totalFloor == '0' && resp.totalBuilding == '0'){
				$('.btnSearchPropertiesAddress').attr('disabled','true');
				$('.btnSearchPropertiesAddress').css('cursor','no-drop');
			}else{
				$('.btnSearchPropertiesAddress').removeAttr('disabled');
				$('.btnSearchPropertiesAddress').css('cursor','pointer');
			}
		});
	});	
	$(document).on('click','.btnSearchPropertiesAddress',function(){
		$('#mainSearchCondition').append($('#hdnAddressBuildingId'));
		$('#mainSearchCondition').append($('#hdnAddressFloorId'));
		/*$('#mainSearchCondition').append($('#frmSearchAddressBuildingJson'));*/
		$('#mainSearchCondition').submit();
	});
	/**************************** end *******************************/

	/****************************** remove Selected Search ****************/
	$(document).on('click','.removeSelectedStation',function(){
		removeStation($(this).data('name'));	
		$(this).parent().remove();
		
		if(address.length == 0){
			resetTownList();
			return false;
		}
		
		
		var conditionFormData = $('#mainSearchCondition').serializeArray();
		var url = baseUrl+'/index.php?r=building/buildingFilterByAddress';
		call({url:url,params:{name:address,conditionFormData:conditionFormData},type:'POST',dataType : 'json'},function(resp){
			$('#frmSearchAddressBuildingJson').val(resp.form_json);	
			$('.totalFloorForAddress .number').html(resp.totalFloor);
			$('.totalBuildingForAddress .number').html(resp.totalBuilding);
			$('.hdnAddressBuildingId').val(resp.buildingIds);
			$('.hdnAddressFloorId').val(resp.floorIds);
			$('.addressBeforeResult').addClass('hide');
			$('.addressResult').removeClass('hide');
			$('.divSelArea').html(addStationhtml());			
			if(resp.totalFloor == '0' && resp.totalBuilding == '0'){
				$('.btnSearchPropertiesAddress').attr('disabled','true');
				$('.btnSearchPropertiesAddress').css('cursor','no-drop');
			}else{
				$('.btnSearchPropertiesAddress').removeAttr('disabled');
				$('.btnSearchPropertiesAddress').css('cursor','pointer');
			}
		});
	});
	/*************************** end ****************************/

	/*********************** market info section ********************/
	onShowTab['tabs-region-1'] = function(ele){
		$('.loadPrefectureLoader').css('display','block');
		$('.divPrefectureWithContent').css('display','none');
		var region = $(ele).data('value');
		var url = baseUrl+'/index.php?r=marketInfo/getRegionPrefecture';
		call({url:url,params:{region:region},type:'POST',dataType : 'json'},function(resp){
			$('.divPrefectureWithContent').html(resp);
			$('.loadPrefectureLoader').css('display','none');
			$('.divPrefectureWithContent').css('display','block');
		});
	}
	$(document).on('click','.tabPrefecture',function(e){
		e.preventDefault();
		$('.loadDistrictLoader').css('display','block');
		$('.tabDistrict').css('display','none');
		$(this).closest('ul').find('li').removeClass('active');
		$(this).parent().addClass('active');
		var prefecture = $(this).data('value');
		var url = baseUrl+'/index.php?r=marketInfo/getPrefectureDistrict';
		call({url:url,params:{prefecture:prefecture},type:'POST',dataType : 'json'},function(resp){
			$('.tabDistrict').html(resp);
			$('.loadDistrictLoader').css('display','none');
			$('.tabDistrict').css('display','block');
		});
	});
	$(document).on('click','.edit-link-summary',function(e){
		e.preventDefault();
		$('.dispSummary').css('display','none');
		$('.editSummary').css('display','block');
	});
	$(document).on('click','.btnSaveSummary',function(e){
		e.preventDefault();
		var content = $('.summary').val();
		var district = $('.hdnDisctrict').val();
		var url = baseUrl+'/index.php?r=marketInfo/saveSummary';
		call({url:url,params:{content:content,district:district},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				$('.dispSummary').html(resp.content);
				$('.dispSummary').css('display','block');
				$('.editSummary').css('display','none');
			}
		});
	});
	$(document).on('click','.edit-links-areaCommentary',function(e){
		e.preventDefault();
		$('.dispAreaCommentary').css('display','none');
		$('.editAreaCommentary').css('display','block');
	});
	$(document).on('click','.btnSaveAreaCommentary',function(e){
		e.preventDefault();
		var content = $('.areaCommentary').val();
		var district = $('.hdnDisctrict').val();
		var url = baseUrl+'/index.php?r=marketInfo/saveAreaCommentary';
		call({url:url,params:{content:content,district:district},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				$('.dispAreaCommentary').html(resp.content);
				$('.dispAreaCommentary').css('display','block');
				$('.editAreaCommentary').css('display','none');
			}
		});
	});
	$(document).on('click','.edit-links-marketTrends',function(e){
		e.preventDefault();
		$('.dispMarketTrends').css('display','none');
		$('.editMarketTrends').css('display','block');
	});
	$(document).on('click','.btnSaveMarketTrends',function(e){
		e.preventDefault();
		var content = $('.marketTrends').val();
		var district = $('.hdnDisctrict').val();
		var url = baseUrl+'/index.php?r=marketInfo/saveMarketTrends';
		call({url:url,params:{content:content,district:district},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				$('.dispMarketTrends').html(resp.content);
				$('.dispMarketTrends').css('display','block');
				$('.editMarketTrends').css('display','none');
			}
		});
	});
	$(document).on('click','.edit-links-newlyAdded',function(e){
		e.preventDefault();
		$('.new_bild').css('display','none');
		$('.editNewBild').css('display','block');
	});
	$(document).on('click','.btnSaveNewlyAdd',function(e){
		e.preventDefault();
		var content = $('.newlyAdd').val();
		var district = $('.hdnDisctrict').val();
		var url = baseUrl+'/index.php?r=marketInfo/saveNewlyAdd';
		call({url:url,params:{content:content,district:district},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				$('.new_bild').html(resp.content);
				$('.new_bild').css('display','block');
				$('.editNewBild').css('display','none');
			}
		});
	});
	
	$(document).on('click','.edit-links-areaPicture',function(e){
		e.preventDefault();
		$('#modalUploadAreaPicture').removeClass('hide');
		$('#modalUploadAreaPicture').addClass('show');
		$('#modalUploadAreaPicture').fadeIn(1000);
	});
	
	$(document).on('click','.btnUpAreaPicture',function(e){
		e.preventDefault();
		var areaPicture = $('.hdnAreaPictureFile').val();
		var district = $('.hdnDisctrict').val();
		var url = baseUrl+'/index.php?r=marketInfo/saveUploadedAreaPicture';
		call({url:url,params:{areaPicture:areaPicture,district:district},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				alert('写真が追加されました。');
				/*$('#modalUploadAreaPicture').removeClass('show');
				$('#modalUploadAreaPicture').addClass('hide');
				$('#modalUploadAreaPicture').fadeOut(1000);
				$('.sight-image').html(resp.content);
				$('.hdnAreaPictureFile').val(0);
				$('#frmUpAreaPicture ul').html('');
				$('.landscapeText').html('');*/
				location.reload();
			}else{
				alert('何かが間違っていました。');
			}
		});
	});
	
	$(document).on('click','.btnRemvImg',function(e){
		e.preventDefault();
		if(confirm("本当に実行してよろしいですか？") == true){
			$(this).closest('.liImages').remove();
			var finalValue = Array();
			$('.sight-image').find('li').each(function(index, element) {
				finalValue.push($(this).data('value'));
			});
			var district = $('.hdnDisctrict').val();
			var url = baseUrl+'/index.php?r=marketInfo/saveUploadedAreaPicture';
			call({url:url,params:{areaPicture:finalValue,district:district,remove:1},type:'POST',dataType : 'json'},function(resp){
				if(resp.status == 1){
					alert('写真が追加されました。');
					/*$('.sight-image').html(resp.content);
					$('.hdnAreaPictureFile').val(0);
					$('#frmUpAreaPicture ul').html('');
					$('.landscapeText').html('');*/
					location.reload();
				}else{
					alert('何かが間違っていました。');
				}
			});
		}
	});
	
	$(document).on('click','.edit-links-areaDiscription',function(e){
		e.preventDefault();
		$('.dispAreaDiscription').css('display','none');
		$('.editAreaDiscription').css('display','block');
	});
	$(document).on('click','.btnSaveAreaDiscription',function(e){
		e.preventDefault();
		var content = $('.areaDiscription').val();
		var district = $('.hdnDisctrict').val();
		var town = $('.hdnTown').val();
		var url = baseUrl+'/index.php?r=marketInfo/saveAreaDisc';
		call({url:url,params:{content:content,district:district,town:town},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				$('.dispAreaDiscription').html(resp.content);
				$('.dispAreaDiscription').css('display','block');
				$('.editAreaDiscription').css('display','none');
			}
		});
	});
	$(document).on('click','.edit-links-areaSummary',function(e){
		e.preventDefault();
		$('.dispAreaSummary').css('display','none');
		$('.editAreaSummary').css('display','block');
	});
	$(document).on('click','.btnSaveAreaSummary',function(e){
		e.preventDefault();
		var content = $('.areaSummary').val();
		var district = $('.hdnDisctrict').val();
		var town = $('.hdnTown').val();
		var url = baseUrl+'/index.php?r=marketInfo/saveAreaSummary';
		call({url:url,params:{content:content,district:district,town:town},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				$('.dispAreaSummary').html(resp.content);
				$('.dispAreaSummary').css('display','block');
				$('.editAreaSummary').css('display','none');
			}
		});
	});
	$(document).on('click','.edit-links-areaLandscape',function(e){
		e.preventDefault();
		$('#modalUploadAreaLandscape').removeClass('hide');
		$('#modalUploadAreaLandscape').addClass('show');
		$('#modalUploadAreaLandscape').fadeIn(1000);
	});
	$(document).on('click','.btnUpAreaLandscape',function(e){
		e.preventDefault();
		var landscapeFile = $('.hdnLandscapeFile').val();
		var district = $('.hdnDisctrict').val();
		var town = $('.hdnTown').val();
		var url = baseUrl+'/index.php?r=marketInfo/saveUploadedAreaLandscape';
		call({url:url,params:{landscapeFile:landscapeFile,district:district,town:town},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				alert('写真が追加されました。');
				$('#modalUploadAreaLandscape').removeClass('show');
				$('#modalUploadAreaLandscape').addClass('hide');
				$('#modalUploadAreaLandscape').fadeOut(1000);
				$('.sight-image').html(resp.content);
				$('.hdnLandscapeFile').val(0);
				$('#frmUpAreaLandscape ul').html('');
				$('.landscapeText').html('');
			}else{
				alert('何かが間違っていました。');
			}
		});
	});
	/**************************** end *******************************/
	
	/*************************** change password ********************/
	$(document).on('click','.btnChangePassowrd',function(e){
		e.preventDefault();
		var logged_id = $(this).data('value');
		$('.hdnLoggedId').val(logged_id);
		$('.modal-box-change-password').addClass('show');
		$('.modal-box-change-password').removeClass('hide');
		$('.modal-box-change-password').fadeIn(1000);
	});
	$(document).on('click','.btnSavePassword',function(e){
		e.preventDefault();
		var newPassword = $('.newPassword').val();
		var newRePassword = $('.newRePassword').val();
		var id = $('.hdnLoggedId').val();
		if(newPassword != "" && newRePassword != ""){
			if(newPassword != newRePassword){
				alert('Password not same');
				return false;
			}else{
				var url = $('.frmChangePassword').data('action');
				call({url:url,params:{newPassword:newPassword,id:id},type:'POST',dataType : 'json'},function(resp){
					if(resp.status == 1){
						alert('Password successfully change.');
						$('.modal-box-change-password').removeClass('show');
						$('.modal-box-change-password').addClass('hide');
						$('.modal-box-change-password').fadeOut(1000);
					}else{
						alert('Something went wrong.');
					}
				});
			}
		}else{
			alert('Please fill all fields');
			return false;
		}
	});
	$(document).on('click','.btnModalClosePassword',function(){
		$('.modal-box-change-password').removeClass('show');
		$('.modal-box-change-password').addClass('hide');
		$('.modal-box-change-password').fadeOut(1000);
	});
	/*************************** end ********************/
	/*************************** change site settings ********************/
	$(document).on('click','.btnSiteSetting',function(e){
		e.preventDefault();
		$('.modal-box-site-setting').addClass('show');
		$('.modal-box-site-setting').removeClass('hide');
		$('.modal-box-site-setting').fadeIn(1000);
	});
	
	$(document).on('click','.btnSaveSiteSetting',function(e){
		e.preventDefault();
		var companyNameId = $('.companyNameId').val();
		var companyName = $('.companyName').val();
		if(companyName != ""){
			var url = $('.frmSiteSetting').data('action');
			call({url:url,params:{companyNameId:companyNameId,companyName:companyName},type:'POST',dataType : 'json'},function(resp){
				if(resp.status == 1){
					alert('Data successfully change.');
					$('.modal-box-site-setting').removeClass('show');
					$('.modal-box-site-setting').addClass('hide');
					$('.modal-box-site-setting').fadeOut(1000);
					location.reload();
				}else{
					alert('Something went wrong.');
				}
			});
		}else{
			alert('Please fill fields');
			return false;
		}
	});
		
	$(document).on('click','.btnModalCloseSetting',function(){
		$('.modal-box-site-setting').removeClass('show');
		$('.modal-box-site-setting').addClass('hide');
		$('.modal-box-site-setting').fadeOut(1000);
	});
	
	/**************************** end ****************************/
	
	/********************** search global **********************/
	$(document).on('click','.btnSearchGlobal',function(){
		var keyword = $('.searchGlobal').val();
		if(keyword != "" && keyword != "建物名・顧客名から検索"){
			$('.frmSearchKeyWord').submit();
		}else{
			alert('適切なキーワードを検索');
			return false;
		}
	});
	/************************** end ***************************/
	/******************* delete multiple management info ********/
	$(document).on('click','.delete_management_id',function(){
		if($(this).is(":checked")){
			var checkValues = $('input[name=delete_management_id]:checked').map(function(){
				return $(this).val();
			}).get();
			$('.hdnCompnayIds').val(checkValues);
		}else if($(this).is(":not(:checked)")){
			var checkValues = $('input[name=delete_management_id]:checked').map(function(){
				return $(this).val();
			}).get();
			$('.hdnCompnayIds').val(checkValues);
		}
	});
	$(document).on('click','.bulkDeleteCompanies',function(e){
		e.preventDefault();
		var companyIds = $('.hdnCompnayIds').val();
		if(companyIds != ""){
			if(confirm('Are you sure ?')){
				var url = baseUrl+'/index.php?r=floor/deleteManagement';
				call({url:url,params:{companyIds:companyIds},type:'POST',dataType : 'json'},function(resp){
					if(resp.status == 1){
						alert(resp.msg);
						location.reload();
					}else{
						alert(resp.msg);
					}
				});
			}
		}else{
			alert('チェックボックスのいずれかをご確認ください');
			return false;
		}
	});
	/************************** end *****************************/
	
	/************************ bulk delete transmission metters ******/
	$(document).on('click','.transCheck',function(){
		if($(this).is(":checked")){
			var checkValues = $('input[name=transCheck]:checked').map(function(){
				return $(this).val();
			}).get();
			$('.hdnBulkTrans').val(checkValues);
		}else if($(this).is(":not(:checked)")){
			var checkValues = $('input[name=transCheck]:checked').map(function(){
				return $(this).val();
			}).get();
			$('.hdnBulkTrans').val(checkValues);
		}
	});
	$(document).on('click','.btnDeleteTransmission',function(e){
		e.preventDefault();
		var transIds = $('.hdnBulkTrans').val();
		if(transIds != ""){
			var url = baseUrl+'/index.php?r=building/deleteBulkTrans';
			call({url:url,params:{transIds:transIds},type:'POST',dataType : 'json'},function(resp){
				if(resp.status == 1){
					alert(resp.msg);
					location.reload();
				}else{
					alert(resp.msg);
				}
			});
		}else{
			alert('チェックボックスのいずれかをご確認ください');
			return false;
		}
	});
	
	$(document).on('click','#btnDeleteRentHistory',function(e){
		e.preventDefault();
		var removeIds = [];
		$('.tdRentCheck:checked').each(function(){
			removeIds.push($(this).val());
		})
		if(removeIds.length){
			var url = baseUrl+'/index.php?r=building/deleteBulkNego';
			call({url:url,params:{removeIds:removeIds.join(',')},type:'POST',dataType : 'json'},function(resp){
				if(resp.status == 1){
					alert(resp.msg);
					location.reload();
				}else{
					alert(resp.msg);
				}
			});
		}else{
			alert('チェックボックスのいずれかをご確認ください');
			return false;
		}
	});
	/*********************** end **************************/
	
	/****************** disp empty floor in rent negotiation ************/
	$(document).on('click','.dispEmptyOnly',function(){
		
		if($(this).is(":checked")){
			$(this).closest('td').parent().find('.floorNotEmpt').css('display','none');
		}else if($(this).is(":not(:checked)")){
			$(this).closest('td').parent().find('.floorNotEmpt').css('display','block');
		}
	});
	/**************************** end ***************************/
	
	$(document).on('click','.removeNewlyAdd',function(){
		$(this).parent().remove();
		var finalValue = Array();
		$('.divNewlyAdd').find('li').each(function(index, element) {
            finalValue.push($(this).data('value'));
        });
		var district = $('.hdnDisctrict').val();
		var url = baseUrl+'/index.php?r=marketInfo/saveNewlyAdd';
		call({url:url,params:{content:finalValue,district:district,remove:1},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				$('.new_bild').html(resp.content);
				$('.new_bild').css('display','block');
				$('.editNewBild').css('display','none');
			}
		});
	});

	/* Init JTABS */
	if($("ul.tabs-region").length > 0){
		$("ul.tabs-region").jTabs({content: ".tabs_content", animate: true, cookies: false});
	}
	if($("ul.tabs-city").length > 0){
		$("ul.tabs-city").jTabs({content: ".tabs_content2", animate: true, cookies: false});
	}
	
	/* JTABS Search page on tab change disable other */
	$('.tabs li').click(function(e) {
		var _tindex = $(this).index();
		$('.tabs_content.mang-tab').children('div').each(function(index, element) {
            if($(this).index() == 0 || $(this).index() == 1) return;
			if($(this).index() != _tindex){
				$(this).find('input,select,textarea').attr('disabled','disabled');
			}else{
				$(this).find('input,select,textarea').removeAttr('disabled');
			}
        });
    });
	
	if($('.tabs_content.mang-tab').length > 0){
		$('.tabs_content.mang-tab').children('div').each(function(index, element) {
			if($(this).index() == 0 || $(this).index() == 1) return;
			if(!$(this).is(':visible')){
				$(this).find('input,select,textarea').attr('disabled','disabled');
			}else{
				$(this).find('input,select,textarea').removeAttr('disabled');
			}
		});
	}
	
	try{
	$(".js-example-basic-single").select2({
		ajax: {
			dataType: "json",
			url: "/index.php?r=proposedArticle/getcustomers",
			delay: 250,
			minimumInputLength: 1,
			data: function (params) {
			  return {
				q: params.term, // search term
				page: params.page
			  };
			},
			processResults: function (data, params) {			
			  return {
				results: data,
			  };
			},
			cache: true
		  }
	});
	}catch(err){
	};
	
	
	/********************* single area print ********************/
	$(document).on('click','.printSingleArea',function(e){
		e.preventDefault();
		var _dist = $('.hdnDisctrict').val();
		var _town = $('.hdnTown').val();
		var _townName = $('.hdnTownName').val();
		
		e.preventDefault();
		var form = $("#frmPrintSingleArea");
		//form.attr("method", "post");
		//form.attr("action", baseUrl+'/index.php?r=marketInfo/specificDistrictPrintView');
		// setting form target to a window named 'formresult'
		form.attr("target", "formresult");
		form.serialize();
		window.resizeTo(500,500)
		// creating the 'formresult' window with custom features prior to submitting the form
		window.open(baseUrl+'/index.php?r=building/printBuildingDetails', 'formresult', 'scrollbars=no,menubar=no,height=600,width=800,resizable=yes,toolbar=no,status=no');
		form.submit();
	});
	/************************* end ******************************/
	
	/******************** custom ajax pagination ******************/
	$(document).on('click','.afterAjx .page > a',function(e){
		e.preventDefault();
		var _url = $(this).attr('href');
		var _proposedUsername = $('.proposedUsername').val();
		var _filterByDate = $('.filterByDate').val();
		var _newUrl = _url+'&proposedUsername='+_proposedUsername+'&filterByDate='+_filterByDate
		call({url:_newUrl,params:{},type:'POST',dataType : 'json'},function(resp){
			$('.filterResponse').html(resp.result);
			$('.articleNumber').html(resp.count);
			$('.pagination').html(resp.pgWidget);
		});
		
	});
	/**************************** end *****************************/
	
	$(document).on('click','.changeApiKey',function(e){
		e.preventDefault();
		$('#modalUpdateGoogleMapKey').show();	
	});
	
	$(document).on('click','.btnSaveApiKey',function(){
		var _url = $('.frnChangeApiKey').attr('action');
		var _key = $('.apiKey').val();
		
		call({url:_url,params:{key:_key,},type:'POST',dataType : 'json'},function(resp){
			if(resp.status == 1){
				alert(resp.msg);
				location.reload();
			}else{
				alert('何かが間違っていました。');
			}
		});
	});
	
	$(document).on('click','.removeApiKey',function(e){
		e.preventDefault();
		if(confirm("Are You Sure?")){
			var _url = $(this).attr('href');
			call({url:_url,params:{},type:'POST',dataType : 'json'},function(resp){
				if(resp.status == 1){
					alert(resp.msg);
					location.reload();
				}else{
					alert('何かが間違っていました。');
				}
			});
		}
	});
	
	/******************** for check / uncheck comp floors ******************/
	$(document).on('click','.checkAllComp',function(){
		$('.tblComp').find("input:checkbox").prop('checked', $(this).prop("checked"));
		var checkValues = $('input[name=compFloor]:checked').map(function(){
			return $(this).val();
		}).get();
		$('.frmAddManagementHistory').find('.hdnOtherCFloorId').val(checkValues);
	});
	
	$(document).on('click','.compFloor',function(){
		if($(this).is(":checked")){
			var checkValues = $('input[name=compFloor]:checked').map(function(){
				return $(this).val();
			}).get();
			$('.frmAddManagementHistory').find('.hdnOtherCFloorId').val(checkValues);
		}else if($(this).is(":not(:checked)")){
			var checkValues = $('input[name=compFloor]:checked').map(function(){
				return $(this).val();
			}).get();
			$('.frmAddManagementHistory').find('.hdnOtherCFloorId').val(checkValues);
		}
	});	
	/*************************** end *******************************/
	
	/******************** for check / uncheck shared floors ******************/
	$(document).on('click','.checkAllShared',function(){
		$('.tblComp').find("input:checkbox").prop('checked', $(this).prop("checked"));
		var checkValues = $('input[name=sharedFloor]:checked').map(function(){
			return $(this).val();
		}).get();
		$('.frmAddSharedManagementHistory').find('.hdnOtherCFloorId').val(checkValues);
	});
	
	$(document).on('click','.sharedFloorsharedFloor',function(){
		if($(this).is(":checked")){
			var checkValues = $('input[name=sharedFloor]:checked').map(function(){
				return $(this).val();
			}).get();
			$('.frmAddSharedManagementHistory').find('.hdnOtherCFloorId').val(checkValues);
		}else if($(this).is(":not(:checked)")){
			var checkValues = $('input[name=sharedFloor]:checked').map(function(){
				return $(this).val();
			}).get();
			$('.frmAddSharedManagementHistory').find('.hdnOtherCFloorId').val(checkValues);
		}
	});	
	/*************************** end *******************************/
	
	$(document).on('click', '#show_frontend', function(){
		var show_frontend = {};
		$('input.show_frontend').each(function(){
			show_frontend[$(this).val()] = $(this).is(':checked') ? 1 : 0; 
		});
		$('body').LoadingOverlay("show");
		$.ajax({
			url: '/index.php?r=floor/updateShowFrontend',
			data: {show_frontend: show_frontend},
			type: "POST",
			dataType : 'json'
		}).success(function(resp){
			$('body').LoadingOverlay("hide");
			alert('完了');
		}).error(function(){
			$('body').LoadingOverlay("hide");
		});
	});
	
	
	/* end */
});//document ready end

/******************* drag & drop file upload for building ************************/
$(function(){
	var ul = $('#frmUpBuildingPicture ul');
	$('#drop a').click(function(){
		// Simulate a click on the file input button
		// to show the file browser dialog
		$(this).parent().find('input').click();
	});
	$('#frmUpBuildingPicture').fileupload({
		// This element will accept file drag/drop uploading
		dropZone: $('#drop'),
		// This function is called when a file is added to the queue;
		// either via the browse button, or via drag/drop:
		add: function (e, data) {
			var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"'+' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');
			// Append the file name and file size
			tpl.find('p').text(data.files[0].name).append('<i>' + formatFileSize(data.files[0].size) + '</i>');
			// Add the HTML to the UL element
			data.context = tpl.appendTo(ul);
			// Initialize the knob plugin
			tpl.find('input').knob();
			// Listen for clicks on the cancel icon
			tpl.find('span').click(function(){
				if(tpl.hasClass('working')){
					jqXHR.abort();
				}
				tpl.fadeOut(function(){
					tpl.remove();
				});
			});
			// Automatically upload the file once it is added to the queue
			var jqXHR = data.submit();
		},
		change: function (e, data) {
			var idx=0;
			$.each(data.files, function (index, file) {
				idx++;
			});
			if(idx > 16){
				alert('File could not be select more than 16.');
				return false;
			}
		},
		drop: function (e, data) {
			var idx=0;
			$.each(data.files, function (index, file) {
				idx++;
			});
			if(idx > 16){
				alert('File could not be select more than 16.');
				return false;
			}
		},
		progress: function(e, data){
			// Calculate the completion percentage of the upload
			var progress = parseInt(data.loaded / data.total * 100, 10);
			// Update the hidden input field and trigger a change
			// so that the jQuery knob plugin knows to update the dial
			data.context.find('input').val(progress).change();
			if(progress == 100){
				data.context.removeClass('working');
			}
		},
		fail:function(e, data){
			// Something has gone wrong!
			data.context.addClass('error');
		},
		done:function(e, data){
			var newData = $.parseJSON(data.result);
			allUpFiles.push(newData.name);
			$('.hdnFileNames').val(allUpFiles);
		}
	});
	// Prevent the default action when a file is dropped on the window
	$(document).on('drop dragover', function (e) {
		e.preventDefault();
	});
	
	// Helper function that formats the file sizes
	function formatFileSize(bytes) {
		if (typeof bytes !== 'number') {
			return '';
		}
		if (bytes >= 1000000000) {
			return (bytes / 1000000000).toFixed(2) + ' GB';
		}
		if (bytes >= 1000000) {
			return (bytes / 1000000).toFixed(2) + ' MB';
		}
		return (bytes / 1000).toFixed(2) + ' KB';
	}
});
/************************** end ****************************/






/******************* drag & drop file upload for floor************************/
$(function(){
	var ul = $('#frmUpFloorPicture ul');
	$('#dropFloor a').click(function(){
		$(this).parent().find('input').click();
	});
	// Initialize the jQuery File Upload plugin
	var allUpFiles = [];
	$('#frmUpFloorPicture').fileupload({
		dropZone: $('#dropFloor'),
		add: function (e, data) {
			var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"'+' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');
			tpl.find('p').text(data.files[0].name).append('<i>' + formatFileSize(data.files[0].size) + '</i>');
			data.context = tpl.appendTo(ul);
			tpl.find('input').knob();
			tpl.find('span').click(function(){
				if(tpl.hasClass('working')){
					jqXHR.abort();
				}
				tpl.fadeOut(function(){
					tpl.remove();
				});
			});
			var jqXHR = data.submit();
		},
		change: function (e, data) {
			var idx=0;
			$.each(data.files, function (index, file) {
				idx++;
			});
			if(idx > 16){
				alert('File could not be select more than 16.');
				return false;
			}
		},
		drop: function (e, data) {
			var idx=0;
			$.each(data.files, function (index, file) {
				idx++;
			});
			if(idx > 16){
				alert('File could not be select more than 16.');
				return false;
			}
		},
		progress: function(e, data){
			var progress = parseInt(data.loaded / data.total * 100, 10);
			data.context.find('input').val(progress).change();
			if(progress == 100){
				data.context.removeClass('working');
			}
		},
		fail:function(e, data){
			data.context.addClass('error');
		},
		done:function(e, data){
			var newData = $.parseJSON(data.result);
			allUpFiles.push(newData.name);
			$('.hdnFloorFileNames').val(allUpFiles);
		}
	});
	// Prevent the default action when a file is dropped on the window
	$(document).on('drop dragover', function (e) {
		e.preventDefault();
	});
	
	// Helper function that formats the file sizes
	function formatFileSize(bytes){
		if (typeof bytes !== 'number') {
			return '';
		}	

		if (bytes >= 1000000000){
			return (bytes / 1000000000).toFixed(2) + ' GB';
		}	

		if (bytes >= 1000000){
			return (bytes / 1000000).toFixed(2) + ' MB';
		}
		return (bytes / 1000).toFixed(2) + ' KB';
	}
});
/************************** end ****************************/

/******************* drag & drop file upload for area landscape ************************/
$(function(){
	var ul = $('#frmUpAreaLandscape ul');
	$('#dropLandscape a').click(function(){
		$(this).parent().find('input').click();
	});
	// Initialize the jQuery File Upload plugin
	var allUpFiles = [];
	$('#frmUpAreaLandscape').fileupload({
		dropZone: $('#dropLandscape'),
		add: function (e, data) {
			var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"'+' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');
			tpl.find('p').text(data.files[0].name).append('<i>' + formatFileSize(data.files[0].size) + '</i>');
			data.context = tpl.appendTo(ul);
			tpl.find('input').knob();
			tpl.find('span').click(function(){
				if(tpl.hasClass('working')){
					jqXHR.abort();
				}
				tpl.fadeOut(function(){
					tpl.remove();
				});
			});
			var jqXHR = data.submit();
		},
		change: function (e, data) {
			var idx=0;
			$.each(data.files, function (index, file) {
				idx++;
			});
			if(idx > 16){
				alert('File could not be select more than 16.');
				return false;
			}
		},
		drop: function (e, data) {
			var idx=0;
			$.each(data.files, function (index, file) {
				idx++;
			});
			if(idx > 16){
				alert('File could not be select more than 16.');
				return false;
			}
		},
		progress: function(e, data){
			var progress = parseInt(data.loaded / data.total * 100, 10);
			data.context.find('input').val(progress).change();
			if(progress == 100){
				data.context.removeClass('working');
			}
		},
		fail:function(e, data){
			data.context.addClass('error');
		},
		done:function(e, data){
			var newData = $.parseJSON(data.result);
			allUpFiles.push(newData.name);
			$('.hdnLandscapeFile').val(allUpFiles);
		}
	});
	// Prevent the default action when a file is dropped on the window
	$(document).on('drop dragover', function (e) {
		e.preventDefault();
	});	

	// Helper function that formats the file sizes
	function formatFileSize(bytes) {
		if (typeof bytes !== 'number') {
			return '';
		}
		if (bytes >= 1000000000) {
			return (bytes / 1000000000).toFixed(2) + ' GB';
		}
		if (bytes >= 1000000) {
			return (bytes / 1000000).toFixed(2) + ' MB';
		}
		return (bytes / 1000).toFixed(2) + ' KB';
	}
});
/************************** end ****************************/

/******************* drag & drop file upload for area landscape ************************/
$(function(){
	var ul = $('#frmUpAreaPicture ul');
	$('#dropAreaPicture a').click(function(){
		$(this).parent().find('input').click();
	});
	// Initialize the jQuery File Upload plugin
	var allUpFiles = [];
	$('#frmUpAreaPicture').fileupload({
		dropZone: $('#dropAreaPicture'),
		add: function (e, data) {
			var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"'+' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');
			tpl.find('p').text(data.files[0].name).append('<i>' + formatFileSize(data.files[0].size) + '</i>');
			data.context = tpl.appendTo(ul);
			tpl.find('input').knob();
			tpl.find('span').click(function(){
				if(tpl.hasClass('working')){
					jqXHR.abort();
				}
				tpl.fadeOut(function(){
					tpl.remove();
				});
			});
			var jqXHR = data.submit();
		},
		change: function (e, data) {
			var idx=0;
			$.each(data.files, function (index, file) {
				idx++;
			});
			if(idx > 16){
				alert('File could not be select more than 16.');
				return false;
			}
		},
		drop: function (e, data) {
			var idx=0;
			$.each(data.files, function (index, file) {
				idx++;
			});
			if(idx > 16){
				alert('File could not be select more than 16.');
				return false;
			}
		},
		progress: function(e, data){
			var progress = parseInt(data.loaded / data.total * 100, 10);
			data.context.find('input').val(progress).change();
			if(progress == 100){
				data.context.removeClass('working');
			}
		},
		fail:function(e, data){
			data.context.addClass('error');
		},
		done:function(e, data){
			var newData = $.parseJSON(data.result);
			allUpFiles.push(newData.name);
			$('.hdnAreaPictureFile').val(allUpFiles);
		}
	});
	// Prevent the default action when a file is dropped on the window
	$(document).on('drop dragover', function (e) {
		e.preventDefault();
	});	

	// Helper function that formats the file sizes
	function formatFileSize(bytes) {
		if (typeof bytes !== 'number') {
			return '';
		}
		if (bytes >= 1000000000) {
			return (bytes / 1000000000).toFixed(2) + ' GB';
		}
		if (bytes >= 1000000) {
			return (bytes / 1000000).toFixed(2) + ' MB';
		}
		return (bytes / 1000).toFixed(2) + ' KB';
	}
	
	addStationhtml = function(){
		var _html = '';
		for(key in addressArray){
			_html += '<div><span class="selectedArea selectedStation">'+key+' </span><span class="removeSelectedStation" data-name="'+key+'" data-value="'+addressArray[key]+'"><i class="fa fa-times-circle"></i></span></div>';
		}
		return _html;
	}
	
	removeStation = function(sname){
		if (address.indexOf(sname) > -1) {
			address.splice(address.indexOf(sname), 1);
		}
		$('.hiddenTwnvals').find('[data-tname="'+sname+'"]').remove();
		delete addressArray[sname];
		if($('[data-name="'+sname+'"]').length > 0){
			if($('[data-name="'+sname+'"]').closest('.listli').length > 0){
				$('[data-name="'+sname+'"]').closest('.listli').removeClass('activelistli');
			}
		}
	}
	
	resetTownList = function(){
		$('#frmSearchAddressBuildingJson').val('');	
		$('.totalFloorForAddress .number').html(0);
		$('.totalBuildingForAddress .number').html(0);
		$('.hdnAddressBuildingId').val('');
		$('.hdnAddressFloorId').val('');
		$('.divSelArea').html('');
		$('.addressBeforeResult').removeClass('hide');		
		$('.addressResult').addClass('hide');
	}
	
	resetRouteList = function(){
		$('#frmSearchRouteBuildingJson').val('');	
		$('.routeResult .number').html(0);
		$('#hdnRRouteId').val('');
		$('.routeResult .selectedSearchCriteria').html('');	
		$('.btnSearchProperties').attr('disabled','disabled');
		$('.routeBeforeResult').removeClass('hide');
		$('.routeResult').addClass('hide');
	}
	
	getbackRouteOpts = function(){
		$('.btnSearchProperties').removeAttr('disabled');
		$('.routeBeforeResult').addClass('hide');
		$('.routeResult').removeClass('hide');
	}
	
	removeSelectStations = function(){
		
	};
	
	getSelectRouteStations = function(){
		aStationName = [];
		$('.actStationEle').each(function(){
			aStationName.push($(this).data('value'));
			$('.routeResult .selectedSearchCriteria').append('<div><span class="selectedStation">'+$(this).data('value')+'駅</span><span data-value="'+$(this).data('value')+'" class="removeSearchStation"><i class="fa fa-times-circle"></i></span></div>');
		});
	};
	
	routeStationClick = function(ele){
		if(ele.hasClass('activeStation')){
			$('.actStationEle[data-value="'+ele.data("value")+'"]').remove();
		}else{
			$('.hiddenActionStations').append('<input type="hidden" class="actStationEle" data-value="'+ele.data("value")+'">');
		}
		ele.toggleClass('activeStation');
	};
	
	
});
/************************** end ****************************/

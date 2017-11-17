function setPropertyCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}


function setAlertMessage(message, success)
{
	var divMessage = '<div id="dynamic_message" style="display: none;" class="'+ (success ? 'success' : 'error') +'">'+ message +'</div>';
	$('#dynamic_message').remove();
	$('body').append(divMessage);
	$('.btnModalClose').trigger('click');
	$('#dynamic_message').fadeIn('slow');
	setTimeout(function(){
		$('#dynamic_message').fadeOut('slow');
	}, 4000)
}

function calculatedFields(oldField, newField, rate){
	if (!$(oldField).length || !$(newField).length) {
		return ;
	}
	
	  var orginal_vale = $(oldField).val();
		orginal_vale = orginal_vale.replace(/,/g, "");
		var formatedTotal = '';
		if (orginal_vale && !isNaN(orginal_vale))
		{
			if (oldField == 'std_floor_space')
			{
				var price_calculated = orginal_vale * rate;
			}
			else {
				var price_calculated = orginal_vale / rate;
			}
			formatedTotal = addCommas(Math.round(price_calculated));
		}
		$(newField).val(formatedTotal);
}


// Calculated fields when initialize
function calculateFieldInit(){
	  calculatedFields('#std_floor_space', '#std_floor_space_calculated', OFFICE_DB_FEE_RATE);
	  calculatedFields('#avg_neighbor_fee_min', '#avg_neighbor_fee_min_sqm', OFFICE_DB_FEE_RATE);
	  calculatedFields('#avg_neighbor_fee_max', '#avg_neighbor_fee_max_sqm', OFFICE_DB_FEE_RATE);
	  calculatedFields('#rent_unit_price', '#rent_unit_price_calculated', OFFICE_DB_FEE_RATE);
}

$(document).ready(function(e) {
	function scrollCartBox()
	  {
		  if (!$('#cart_content_wraper').length) return;
		
		  var header = $('.cart-content')
		  header_offset = header.offset();
		  header_height = header.height();
		   $(window).scroll(function () {
		 	if($(window).scrollTop() + $(window).height() < $('#cart_content_wraper').offset().top) {
		     header.addClass('scroll');
		    }else {
		     header.removeClass('scroll');
		    }
		   }); 
	  }

	  scrollCartBox();
	  
	  $('body').on('change keyup', '#std_floor_space', function(){
		  calculatedFields('#std_floor_space', '#std_floor_space_calculated', OFFICE_DB_FEE_RATE);
	  });
	  
	  
	  $('body').on('change keyup', '#avg_neighbor_fee_min', function(){
		  calculatedFields('#avg_neighbor_fee_min', '#avg_neighbor_fee_min_sqm', OFFICE_DB_FEE_RATE);
	  });
	  
	  $('body').on('change keyup', '#avg_neighbor_fee_max', function(){
		  calculatedFields('#avg_neighbor_fee_max', '#avg_neighbor_fee_max_sqm', OFFICE_DB_FEE_RATE);
	  });
	  
	  $('body').on('change', '.dispEmptyOnly', function(e){
		 var building_id = $('#negBuildId').val().trim();
		 $('#item_building_'+building_id+' tr.row-novacant').toggle();
	  });
	  
	  calculateFieldInit();
	  
$(document).on('click','.cart-content .header-title',function(e){	  
	$(".cart-content #list_cart").slideToggle(function(){
		var isVisible = $(".cart-content #list_cart").is(':visible') ? 1 : 0;
		setPropertyCookie('cart_visible', isVisible);
	});
});

$(document).on('click','.cart-content button',function(e){	  
	e.stopPropagation();
});

$(document).on('click','.sendupdate-button',function(e){	  
	e.preventDefault();
	if (confirm('本当に更新通知メールを会員に送りますか？'))
	{
		$('body').LoadingOverlay("show");
		var url = baseUrl+'/index.php?r=building/sendEmailFollowed';
		$.ajax({
			url: url,
			method: "POST",
			data: {floor_id: $('#frmUpBuildingPicture .hdnFloorId:eq(0)').val()},
			dataType : 'json'
		}).success(function(resp){
			$('body').LoadingOverlay("hide");
			alert('更新通知メールが送信されました。');
		});
	}
});

try{
$("#list_cart").sortable({
    placeholder: 'min-white-box placeholder',
    helper: 'clone',
    appendTo: 'body',
    forcePlaceholderSize: true,
	items: '.cart-item',
    start: function(event, ui) {
        
    }, 
	
    stop: function(event, ui) {
		serial = $("#list_cart").sortable( 'toArray' );
		$.ajax({
			'url': '/index.php?r=floor/sortCart',
			'type': 'post',
			'data': {data:serial},
			'success': function(data){
			},
			'error': function(request, status, error){
				alert('We are unable to set the sort order at this time.  Please try again in a few minutes.');
			}
		});
    },
    change: function(event, ui) {
        
    },
});
}catch(err){}

function initSlider() {
	if ($('#button_show_option').length)
	{
		$('body').on('click', '#button_show_option, #button_hidden_option', function(){
			$('#advanced_options').slideToggle();
			$('#button_show_option').toggle();
			$('#button_hidden_option').toggle();
		});
	}
	if ($(".slider-range").length) {
		$(".slider-range").each(function(index, element) {
	        var minval = maxval = 0;
			if(typeof $(this).attr('min') != 'undefined' && $(this).attr('min') != '') minval = $(this).attr('min');
			if(typeof $(this).attr('max') != 'undefined' && $(this).attr('max') != '') maxval = $(this).attr('max');
			$(this).slider({
			range: true,
			min: 0,
		    step: $(this).attr('step') ? $(this).attr('step') : 1,
			max: $('#maxVal option:last').val(),
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
	}
}

initSlider();
});



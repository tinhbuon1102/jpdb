function setPropertyCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
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
			data: {floor_id: $('.hdnFloorId:eq(0)').val()},
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
});



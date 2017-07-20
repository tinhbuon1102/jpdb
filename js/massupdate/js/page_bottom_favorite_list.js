
	//==========================================================
	//ページ下部の物件検討リスト
	//==========================================================
	
	//20140513 Huy OR-114
	//Add this declaration 
	//In order to not to do the parallel processing
	//jQuery.ajaxSetup({async:false});
	/*
	 * NOTICE : If define jQuery.ajaxSetup({async:false}); on header of js file => it will apply for all ajax request.
	 * So can't use function display html code (Example loading function)
	 * => Change as follow:
	 * 			Replace $.get{}/$.post by $.ajax{} 
	 * 			On $.ajax{} , add param : async: false
	 * 			=> ONLY This request will change from Asynchronous to Synchronous 
	 * See function "addcart" for more details
	 */

	//var page_bottom_favorite_list_exists = 1;	//ページ下部の関数リストが存在していることを定義
	
	var cart_added_floor_list = new Array();
	
	function show_page_bottom_favorite_list()
	{	
		loading("on");

		$.get("/ajax/bottom_favorite_list.php", {"rand":Math.random()},  function(data){

			$("div.fvlist").html(data);
			
			//検討リストコンテンツ閉開
			
			//Cookieに保存されている開閉状態を元に設定
			if(document.cookie.match(/set_cart_open_status=open/))
			{
				$("dl.fv_box dd.fv_d").css("display","block");

				//ビル写真の表示
				$("img.img_buil_thumb").each(function(){
					
					if($(this).attr("src_tmp") != "")
					{
						$(this).attr("src", $(this).attr("src_tmp")).removeAttr("src_tmp");
					}
				
				});
			}
			
			
			$("dl.fv_box > dt.ttl_fv > div.fv_con > div.click_box").click(function(){
				if($("dd.fv_d").css("display") == "none")
				{
					//開く
					
					$("dd.fv_d").slideDown("slow");
					$("dl.fv_box dt.ttl_fv").css({"background" : "#2e3231"});
					
					$.get("/ajax/bottom_favorite_list.php", {"set_cart_open_status": "open"});
					
					//ビル写真の表示
					$("img.img_buil_thumb").each(function(){
						
						if($(this).attr("src_tmp") != "")
						{
							$(this).attr("src", $(this).attr("src_tmp")).removeAttr("src_tmp");
						}
					
					});
					
					
				}
				else
				{
					//閉じる
					
					$("dd.fv_d").slideUp("slow");
					$("dl.fv_box dt.ttl_fv").css({"background" : "#2e3231"});

					$.get("/ajax/bottom_favorite_list.php", {"set_cart_open_status": "close"});

				}
			});

			//カートに追加済み物件の対応
			//検索結果一覧に、背景色、ボタン表示の反映
			$("tr.floorlist").removeClass("matching");
			$("div.container > div.item").each(function(){

				var this_f_no = $(this).attr("f_no");

				//検索結果一覧の色を変える
				$("tr#floor_" + this_f_no).addClass("matching");
				
				//追加ボタンを削除ボタンにする
				$("tr#floor_" + this_f_no + " > td.bt_fv > a").attr({"onclick":"removecart(" + this_f_no + ");"});
				$("tr#floor_" + this_f_no + " > td.bt_fv > a > img").attr({"src":"/search/img/bt_fv_delete.jpg"});

			});
			
			//----------
			//コンテナ幅の設定
			var i = 0;
			$("div.item").each(function(){
				i++;
			});

			var width = $("div.item").css("width");
			
			if(width != undefined)
			{
				width = width.replace("px", "") - 0;
				width += $("div.item").css("margin-right").replace("px", "") - 0;
				width += 2;
				$("div.container").width((width * (i)) + "px");
			}

			//----------
			//物件詳細表示時、スクロールの位置をその物件に設定
			
			//物件数
			var cart_floor_num = $("span#user_favorite_floor_num").text() - 0;
			
			if( "f_no" in window )
			{
			}
			else
			{
				f_no = -1;
			}
			
			//現在表示中の物件を分かりやすく表示させる
			if(f_no > 0 && cart_floor_num > 0)
			{
				var i = 0;
				var j = 0;
				$("div.item").each(function(){
				
					if($(this).attr("f_no") == f_no)
					{
						j = i;
					}
					i++;	
				});
				
				$("*").scrollLeft((width * (j)))
				
				$("div#footer_fav_floor_" + f_no).addClass("active");
				$("span#floor_num_add_msg").text("中、" + (j + 1) + "件目を表示");
			}
			
			//----------
			
			//カートの物件数がゼロの場合は、カート非表示
			if(cart_floor_num == 0)
			{
				//$("dl.fv_box dd.fv_d").hide();
			}
			
			//存在しない画像の処理
			EXEC_replace_error_image();
			
			loading("off");

		});

	}
	
	//カートの削除
	function removecart(f_no, removemode)
	{
		var current_item_no = parseInt($("span#user_favorite_floor_num").text());
		//ビルなら
		var tmp = "";
		if(removemode == "buil")
		{
			$("tr.floorlist").each(function(){
			
				if($(this).attr("b_no") == f_no)
				{
					tmp += $(this).attr("f_no") + "_";
				}
			});
			
			var target = tmp;
		}
		else
		{
			var target = f_no;
		}
		//Huy 2014/01/24 - OR-88
		
		$.ajax({
		    type: "GET",
		    url: '/ajax/bottom_favorite_list.php',
		    async: false, //Change from Asynchronous to Synchronous when send request
		    data: {remove_floor:1, f_no:target, "rand":Math.random()},
		    success: function (data) {
				var arr_f_no = target.toString().split('_'); // split target to array
				$.each(arr_f_no, function( index, value ) { //each f_no and remove div of this
					if(value != "")
					{
						current_item_no --;
						if(current_item_no < 0)
							current_item_no = 0;
						$("div#footer_fav_floor_"+value).remove();
						$("span#user_favorite_floor_num").text(current_item_no); //set floor number
					}
				});
				
				var tmp = String(target).match(/_/);

				//複数フロアの追加時
				if(tmp != null)
				{
					//全部削除ボタンを全部追加ボタンにする
					$("a#addall_b_no_" + f_no).attr({"onclick":"addcart('" + f_no + "', 'buil');"});
					$("a#addall_b_no_" + f_no + " > img").attr({"src":"/search/img/bt_add_fvall.jpg"});

					var tmp = target.split("_");
					
					for(var i in tmp)
					{
						//削除ボタンを追加ボタンにする
						$("tr#floor_" + tmp[i]).css('background-color', '#ffffff');
						$("tr#floor_" + tmp[i] + " > td.bt_fv > a").attr({"onclick":"addcart(" + tmp[i] + ");"});
						$("tr#floor_" + tmp[i] + " > td.bt_fv > a > img").attr({"src":"/search/img/bt_add_fv.jpg"});
					}
				}
				else
				{
					//削除ボタンを追加ボタンにする
					$("tr#floor_" + f_no).css('background-color', '#ffffff');
					$("tr#floor_" + f_no + " > td.bt_fv > a").attr({"onclick":"addcart(" + f_no + ");"});
					$("tr#floor_" + f_no + " > td.bt_fv > a > img").attr({"src":"/search/img/bt_add_fv.jpg"});
				}
				
				//set with for div 
				var width = $("div.item").css("width");
				if(width != undefined)
				{
					width = width.replace("px", "") - 0;
					width += $("div.item").css("margin-right").replace("px", "") - 0;
					width += 2;
					$("div.container").width((width * (current_item_no)) + "px");
				}
				if(current_item_no == 0)
					$("div.container").removeAttr( "style" );
			}
		});
		
		//$.get("/ajax/bottom_favorite_list.php", {remove_floor:1, f_no:target, "rand":Math.random()}, function(data){});
	}
	
	//カートに追加
	function addcart(f_no, addmode)
	{
		loading("on"); 
		var current_item_no = parseInt($("span#user_favorite_floor_num").text());
		var tmp = "";
		//ビル全部の追加なら
		if(addmode == "buil")
		{
			$("tr.floorlist").each(function(){
				if($(this).attr("b_no") == f_no)
				{
					var att_onclick = $(this).find("td.bt_fv > a").attr("onclick");
					if(att_onclick.search("addcart") > -1)
						tmp += $(this).attr("f_no") + "_";
				}
			});
			
			var target = tmp;
			
			//Huy 2014/01/24 - OR-88
			$.ajax({
			    type: "GET",
			    url: '/ajax/bottom_favorite_list.php',
			    async: false, //Change from Asynchronous to Synchronous when send request
			    data: {add_floor:1, f_no:target,current_item_no:current_item_no, "rand":Math.random()},
			    success: function (data) {
			    	if(target)
					{
						var tmp = data.split("-+-");
						current_item_no = tmp[0];
						data = tmp[1];
						
						var width = $("div.item").css("width"); //set new with for div
						
						if(width != undefined)
						{
							width = width.replace("px", "") - 0;
							width += $("div.item").css("margin-right").replace("px", "") - 0;
							width += 2;
							$("div.container").width((width * (current_item_no)) + "px");
						}
						
						$("span#user_favorite_floor_num").text(current_item_no); //update floor num
						$("div.news_items div.container").append(data); // display data from ajax result
						//show_page_bottom_favorite_list();
					}
					
			    }
			});
			tmp = String(target).match(/_/);
			if(!target)
				tmp=f_no;
		}
		//検索結果にヒットしたフロア全部
		else if(addmode == "result_all")
		{
			$.ajax({
			    type: "GET",
			    url: '/ajax/bottom_favorite_list.php',
			    async: false, //change from Asynchronous to Synchronous 
			    data: {add_result_all:1, "rand":Math.random()},
			    success: function (data) {
			    	show_page_bottom_favorite_list();
					//loading("off");
			    }
			});
			tmp = null;
		}
		else
		{
			//Huy 2014/01/24 - OR-88
			var target = f_no;
			$.ajax({
			    type: "GET",
			    url: '/ajax/bottom_favorite_list.php',
			    async: false,  //change from Asynchronous to Synchronous 
			    data: {add_floor:1, f_no:target, current_item_no:current_item_no, "rand":Math.random()},
			    success: function (data) {
			    	var tmp = data.split("-+-");
					current_item_no = tmp[0];
					data = tmp[1];

					$("div.news_items div.container").append(data);  // display data from ajax result
					var width = $("div.item").css("width"); //calculator and set new width 
					if(width != undefined)
					{
						width = width.replace("px", "") - 0;
						width += $("div.item").css("margin-right").replace("px", "") - 0;
						width += 2;
						$("div.container").width((width * (current_item_no)) + "px");
					}
					
					$("span#user_favorite_floor_num").text(current_item_no);//update floor num
					//show_page_bottom_favorite_list();
					//loading("off");
			    }
			});
			tmp = String(target).match(/_/);
		}
		
		
		//複数フロアの追加時
		if(tmp != null)
		{
			$("a#addall_b_no_" + f_no).attr({"onclick":"removecart('" + f_no + "', 'buil');"});
			$("a#addall_b_no_" + f_no + " > img").attr({"src":"/search/img/bt_add_fvall_delete.jpg"});
			if(tmp.input)
			{
				var arr_f_no = tmp.input.toString().split('_');
				$.each(arr_f_no, function( index, value ) { //each f_no
					if(value)
					{
						$("tr#floor_" + value).css('background-color', '#fefbe0');
						$("tr#floor_" + value + " > td.bt_fv > a").attr({"onclick":"removecart(" + value + ");"});
						$("tr#floor_" + value + " > td.bt_fv > a > img").attr({"src":"/search/img/bt_fv_delete.jpg"});
					}
				});
			}
			
		}
		//単発フロアの追加時
		else if(f_no > 0)
		{
			//追加ボタンを削除ボタンにする
			$("tr#floor_" + f_no).css('background-color', '#fefbe0');
			$("tr#floor_" + f_no + " > td.bt_fv > a").attr({"onclick":"removecart(" + f_no + ");"});
			$("tr#floor_" + f_no + " > td.bt_fv > a > img").attr({"src":"/search/img/bt_fv_delete.jpg"});
		}
		loading("off");
		
	}
	
	//カートのリセット
	function resetcart(mode)
	{
		if(mode == "quiet")
		{
			//アラートを表示させない
			$.get("/ajax/bottom_favorite_list.php", {resetcart:1}, function(data){
				//show_page_bottom_favorite_list();
			});
			
			return true;
		}
		
		
		if(window.confirm("カートに入っているフロアをリセットします。よろしいですか？"))
		{
			
			alert("カートをリセットしました。");
			var list_fno = new Array();
			$.get("/ajax/bottom_favorite_list.php", {resetcart:1}, function(data){
				show_page_bottom_favorite_list();
				$("div.news_items div.container").find("div").each (function() {
					if($(this).attr("f_no") != undefined)
						list_fno.push( $(this).attr("f_no") );
				});
				$.each( list_fno, function( key, value ) {
					$("tr#floor_" + value).css('background-color', '#ffffff');
					$("tr#floor_" + value + " > td.bt_fv > a").attr({"onclick":"addcart(" + value + ");"});
					$("tr#floor_" + value + " > td.bt_fv > a > img").attr({"src":"/search/img/bt_add_fv.jpg"});
				});
			});
		}
	}
	
	
	
	$(function(){
		show_page_bottom_favorite_list();
	});
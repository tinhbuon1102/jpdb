var search_keywork = '';	
	//==========================================================
	//ダイアログ取得・表示・更新関連
	// ポップアップの横幅
	//  大 width: 952px;
	//  中 width: 652px;
	//  小 width: 420px;
	//==========================================================
	

	//★伝達事項の表示
	function show_buil_comment(b_no)
	{
		$.get("/ajax/dialog.php", {b_no:b_no, get_buil_comment:1}, function(data){
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 652,
				resizable:false,
				title:"伝達事項",
				buttons: {
				}
			});
		
		});
	}
	
	//伝達事項の更新
	function update_buil_commend()
	{
		var edit_bc_text = $("textarea[name=edit_bc_text]").val();
		var edit_b_no    = $("input[name=edit_b_no]").val();
		
		if(edit_bc_text == "")
		{
			alert("コメントが記入されていません。");
			return false;
		}
		
		if(edit_b_no > 0)
		{
		}
		else
		{
			alert("ビルIDがありません。");
			return false;
		}
		
		$.get("/ajax/dialog.php", {insert_buil_comment:1, b_no:edit_b_no, bc_text:edit_bc_text}, function(data){
		
			alert("伝達事項を追記しました。");
			show_buil_comment(edit_b_no);
			
			location.reload();
		});
	}
	
	//伝達事項の削除
	function delete_buil_comment(bc_id)
	{
		var edit_b_no    = $("input[name=edit_b_no]").val();
		
		if(window.confirm("削除してよろしいですか？"))
		{
			$.get("/ajax/dialog.php", {delete_buil_comment:1, bc_id:bc_id}, function(data){
			
				alert("伝達事項を削除しました。");
				show_buil_comment(edit_b_no);
			});		
		}
	
	}
	
	//==========================================================
	
	//フリーレント情報の表示
	function show_free_rent_info(b_no)
	{
		$.get("/ajax/dialog.php", {b_no:b_no, get_free_rent_info:1}, function(data){
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 420,
				resizable:false,
				title:"フリーレント",
				buttons: {
				}
			});
			
			$("input[name=freerent_timelimit]").datepicker();
		
		});
	}
	
	//フリーレント情報の追加
	function insert_free_rent_info()
	{
		var freerent_value = $("input[name=freerent_value]").val();
		var freerent_timelimit = $("input[name=freerent_timelimit]").val();
		var edit_b_no    = $("input[name=edit_b_no]").val();
		
		var str = $("form[name=add_free_rent_info]").serialize();

		
		if(freerent_value > 0)
		{
		}
		else
		{
			alert("フリーレントの期間が入力されていません。");
			return false;
		}

		if(edit_b_no > 0)
		{
		}
		else
		{
			alert("ビルIDがありません。");
			return false;
		}
		
		$.post("/ajax/dialog.php", {insert_free_rent_info:1, params:str}, function(data){
		
			alert("フリーレント情報を追加しました。");
			show_free_rent_info(edit_b_no);
			
			location.reload();
			
		});
	
	}

	//フリーレント情報の削除
	function delete_free_rent_info(bc_id)
	{
		var edit_b_no = $("input[name=edit_b_no]").val();
		
		if(window.confirm("削除してよろしいですか？"))
		{
			$.get("/ajax/dialog.php", {delete_free_rent_info:1, bc_id:bc_id}, function(data){
			
				alert("フリーレント情報を削除しました。");
			show_free_rent_info(edit_b_no);
			});		
		}
	
	}


	//==========================================================
	
	//賃料交渉関連情報の表示
	function show_buil_price_info(b_no)
	{
		$.get("/ajax/dialog.php", {b_no:b_no, get_buil_price_info:1}, function(data){
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 652,
				resizable:false,
				title:"賃料底値・目安履歴",
				buttons: {
				}
			});
		
		});
	}
	
	//賃料交渉関連情報の追加
	function insert_buil_price_info()
	{
		var edit_b_no    = $("input[name=edit_b_no]").val();
		var edit_bc_text   = $("input[name=edit_bc_text]").val();
		var edit_bc_type   = $("input[name=bc_type]:checked").val();
		var edit_r_id   = $("select[name=edit_r_id]").val();
		//var edit_f_no   = $("select[name=edit_f_no]").val();

		var price_lower    = $("input[name=price_lower]").val();
		var price_memo     = $("input[name=price_memo]").val();

		var edit_f_no = "";
		$("input[name='edit_f_no[]']:checked").each(function(){
			edit_f_no += $(this).val() + ",";
		});
		
		//賃料交渉値/目安値
		if(edit_bc_type == 7 || edit_bc_type == 13)
		{
			if(price_lower == "" )
			{
				alert("情報が記入されていません。");
				return false;
			}

			if(price_lower.match(/^\d+$/))
			{
			}
			else
			{
				alert("数値以外が入力されています。");
				return false;
			}

			
			if(price_lower < 1000)
			{
				alert("賃料の入力が正しくありません。");
				return false;
			}
			
		}
		//それ以外の情報
		else
		{
			if(edit_bc_text == "")
			{
				alert("情報が記入されていません。");
				return false;
			}
		}
		
		//数値以外の入力はNGのチェック
		if(edit_bc_type != 3 && edit_bc_type != 7 && edit_bc_type != 13)
		{
			if(edit_bc_text.match(/^\d+$/))
			{
			}
			else
			{
				alert("数値以外が入力されています。");
				return false;
			}
		}
		
		
		if(edit_b_no > 0)
		{
		}
		else
		{
			alert("ビルIDがありません。");
			return false;
		}
		
		$.get("/ajax/dialog.php", {insert_buil_price_info:1, b_no:edit_b_no, bc_text:edit_bc_text, bc_type:edit_bc_type, f_no:edit_f_no, r_id:edit_r_id, price_lower:price_lower,  price_memo:price_memo }, function(data){
		
			alert("賃料交渉関連情報を追加しました。");
			show_buil_price_info(edit_b_no);
			
			location.reload();
			
		});
	
	}

	//賃料交渉関連情報の削除
	function delete_buil_price_info(bc_id)
	{
		var edit_b_no = $("input[name=edit_b_no]").val();
		
		if(window.confirm("削除してよろしいですか？"))
		{
			$.get("/ajax/dialog.php", {delete_buil_price_info:1, bc_id:bc_id}, function(data){
			
				alert("賃料交渉関連情報を削除しました。");
				show_buil_price_info(edit_b_no);
				
				location.reload();
			});		
		}
	
	}
	/*
		//Date: 2013/12/24
		//Author : HUY
		//Taks: OR-65 - Remove data from buil_comment . 
	 */
	function remove_list_bc(form_id)
	{
		var data_p = $("#"+form_id).serialize();
		if(window.confirm("選択した項目を削除します。宜しいですか？"))
		{
			$.ajax({
				  type: "POST",
				  url: "/ajax/dialog.php",
				  data: data_p,
				  success: function(data){
					  //console.log(data);
					  
					  alert("削除しました。再読み込みします。");
					  location.reload();
					}
				});
		}
	
	}
	//==========================================================//==========================================================
	
	//案内・面談・成約履歴の取得
	// mode
	//   annnai / mendan / seiyaku
	function get_buil_owner_info(mode, b_no)
	{
		var title_str = "";
		if(mode == "annnai")
			title_str = "案内履歴";
		else if(mode == "mendan")
			title_str = "面談履歴";
		else if(mode == "seiyaku")
			title_str = "成約履歴";
		else
			return false;
	
		$.get("/ajax/dialog.php", {b_no:b_no, get_buil_owner_info:1, show_mode:mode}, function(data){
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 652,
				resizable:false,
				title:title_str,
				buttons: {
				}
			});
		
		});
	
	}
	
	//==========================================================//==========================================================
	//賃料交渉関連情報の表示
	function show_print_dialog(f_no)
	{
		$.get("/ajax/dialog.php", { get_print_dialog:1, f_no:f_no}, function(data){
	
			$(".dialog").remove();	//他のダイアログを消去
			
			var timer = 0;
			
			timer = setInterval(function(){
			
				if(loading_count == 0)
				{
					$("body").append(data);

					$(".dialog").dialog({
						autoOpen: true,
						width: 652,
						resizable:false,
						title:"物件印刷資料の印刷",
						buttons: {
						}
					});
					
					clearInterval(timer);
				}
			
			}, 1000);
			
		
		});
	}
	
	//==========================================================//==========================================================
	//物件リストの保存
	function show_list_save_dialog()
	{
		$.get("/ajax/dialog.php", { show_list_save_dialog:1}, function(data){
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 952,
				resizable:false,
				title:"提案資料の保存",
				buttons: {
				}
			});
		
		});	
	
	}
	
	//物件リストにひもづける顧客名の検索
	function list_customer_search()
	{
		var u_name = $("input[name=customer_name]").val();
		
		loading("on");
		
		if(u_name == "")
		{
			alert("顧客の名前を入力し、検索ボタンを押して下さい。");
			return false;
		}
		
		$.get("/ajax/dialog.php", {search_list_save_customer:1, u_name:u_name}, function(data){
		
			if(data == "false")
			{
				alert("この名前では、顧客が見つかりませんでした。");
				return false;
			}
			else
			{
				$("div#customer_search_result").html("<select id='set_list_customer' name='set_list_customer' onchange='set_list_customer_u_id();'><option value=''>リストをひもづける顧客を選択</option></select>");
				
				var result = data.split("\n");
				
				for(var i in result)
				{
					if(result[i] != "")
					{
						var tmp = result[i].split(',');
						$("select#set_list_customer").append("<option value='" + tmp[0] + "'>" + tmp[1] + "</option>");
					}
				} 
			
			}
			
			loading("off");
		
		});
		
	}
	
	//物件リストにひもづける顧客名のセット
	function set_list_customer_u_id()
	{
		var set_list_customer = $("select#set_list_customer").val();
		$("input[name=u_id]").val(set_list_customer);
		
		if(set_list_customer > 0)
			alert("この顧客にひもづけてリストを保存するよう設定されました。");
		else
			alert("有効な顧客が選択されていません。リストは顧客にひも付けずに保存されます。");
		
		return true;
	}
	
	//リストの保存
	function save_list()
	{
		loading("on");
		
		var u_id = $("input[name=u_id]").val();
		var l_title = $("input[name=list_name]").val();
		var l_text = $("input[name=list_name]").val();
		
		if(l_title == "")
		{
			alert("リストのタイトルを付けて下さい。");
			loading("off");
			return false;
		}
		
		$.get("/save/saveexec.php", {mode:"insert", u_id:u_id, title:l_title, l_text:l_text }, function(data){
		
			if(u_id > 0)
			{
				if(window.confirm("物件リストが、顧客にひもづけて保存されました。顧客の情報ページへ移動しますか？"))
				{
					location.href = "/customer/c_detail.php?u_id=" + u_id;
				}
			}
			else
			{
				alert("物件リストが保存されました。");
			}
		
			$(".dialog").remove();
			loading("off");
		}); 
		
		
	}
	
	//==========================================================//==========================================================

	//メンバーリストの表示
	function show_memberlist(input_mode, u_id)
	{
		$.get("/ajax/dialog.php", { show_member_list:1, input_mode: input_mode, u_id:u_id }, function(data){
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);
			
			if("input_mode" in window)
			{
				if(input_mode.match(/set_customer_r_id/))
				{
					//顧客担当者の設定
					var dialog_title = "顧客担当者の設定";
				}
				else
				{
					//sessionにr_idを設定するモード
					var dialog_title = "表示するメンバーの切り替え";
				}
			}
			else
			{
				//sessionにr_idを設定するモード
				var dialog_title = "表示するメンバーの切り替え";
			}

			$(".dialog").dialog({
				autoOpen: true,
				width: 652,
				resizable:false,
				title:dialog_title
			});
		
		});		
	}
	
	//メンバーリストの切り替え
	function set_target_member()
	{
		var target_member_list = "";
		$("input.replist:checked").each(function(){
			
			target_member_list += $(this).val() + ",";
			
		});
		
		var input_mode = $("input[name=input_mode]").val();
		var u_id = $("input[name=update_u_id]").val();
		
		
		if(target_member_list == "")
		{
			alert("メンバーが選択されていません。");
			return false;
		}
		
		if(input_mode.match(/set_customer_r_id/))
		{
			$.get("/ajax/dialog.php", {set_customer_r_id:1, u_id:u_id, r_id:target_member_list}, function(){
			
				if(window.confirm("顧客に担当者を設定しました。この顧客の画面に移動しますか？"))
				{
					location.href = "/customer/c_detail.php?u_id=" + u_id;
				}
				else
				{
					alert("再読み込みします。");
					location.reload();
				
				}
			
			});
			return target_member_list;
		}
		else
		{
			//sessionに担当者IDを保存
			$.get("/ajax/dialog.php", {set_member_list:1, target_member_list:target_member_list}, function(){
			
				alert("メンバーの設定を行いました。再読み込みします。");
				location.reload();
			
			});
		}
		
	}
	
	//==========================================================//==========================================================
	//顧客の新規登録
	function show_customer_regist_dialog(u_id)
	{
		if("local_mode" in window)
		{
		}
		else
		{
			local_mode = false;
		}
		
		$.get("/ajax/dialog.php", {show_regist_customer_dialog:1, u_id:u_id, local_mode:local_mode}, function(data){
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);
			
			if(u_id > 0)
			{
				var dialog_name = "顧客情報の編集";
			}
			else
			{
				var dialog_name = "顧客の新規追加";
			}
			

			

			$(".dialog").dialog({
				autoOpen: true,
				width: 652,
				resizable:false,
				title:dialog_name,
				buttons: {
				}
			});
		
		});
	
	}
	
	//顧客登録フォームのサブミット
	function submit_customer_regist_dialog()
	{
		//入力チェック
		var err = "";

		if("local_mode" in window)
		{
		}
		else
		{
			local_mode = false;
		}
		
		if($("form[name=form_adduser]").find("input[name=u_corp_name]").val() == "")
			err += "会社名が入力されていません。\n";
		if($("form[name=form_adduser]").find("input[name=u_corp_name_furi]").val() == "")
			err += "会社名(ふりがな)が入力されていません。\n";
		
		if($("form[name=form_adduser]").find("textarea[name=inq_floor_id]").val() != "")
		{
			var val = $("form[name=form_adduser]").find("textarea[name=inq_floor_id]").val();
			
			if(val != undefined)
			{			
				if(val.match(/^[\d\r\n]+$/))
				{
				}
				else
				{
					err += "お問い合わせ物件IDに数字以外が含まれています\n";
				}
			}
		}
			
		if(err != "")
		{
			alert(err);
			return false;
		}
		
		var str = $("form[name=form_adduser]").serialize();
		
		$.post("/ajax/dialog.php", {update_customer_info:1, params:str}, function(data){
		
			//エラーの場合
			if(data == "false")
			{
				alert("顧客情報の登録処理が正しく行われませんでした。");
				return false;
			}
			//成功の場合
			else if(data.match(/done. u_id=\d+/))
			{
				var u_id = data.replace(/done. u_id=(\d+)/, "$1");
				
				if(local_mode == true)
				{
					alert("顧客情報の登録処理が行われました。顧客情報を表示します。");
					location.href = "/contact/customer.php?u_id=" + u_id;
				}
				else
				{
					alert("顧客情報の登録処理が行われました。顧客情報を表示します。");
					location.href = "/customer/c_detail.php?u_id=" + u_id;
				}
			}
			//エラーの場合
			else
			{
				alert(data);
			}
		});
	}
	
	//顧客担当者ダイアログの表示
	function show_customer_rep_dialog(u_id, cr_id)
	{
		$.get("/ajax/dialog.php", {show_customer_rep_edit_dialog:1, u_id:u_id, cr_id:cr_id}, function(data){
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);
			
			if(cr_id > 0)
			{
				var dialog_title = "顧客担当者情報の編集";
			}
			else
			{
				var dialog_title = "顧客担当者の追加";
			}

			$(".dialog").dialog({
				autoOpen: true,
				width: 652,
				resizable:false,
				title:dialog_title,
				buttons: {
				}
			});
		
		});	
	}

	//顧客登録フォームのサブミット
	function submit_customer_rep_dialog()
	{
		//入力チェック
		var err = "";

		if($("form[name=form_edit_rep]").find("input[name=cr_name]").val() == "")
			err += "担当者名が入力されていません。\n";
			
		if(err != "")
		{
			alert(err);
			return false;
		}
		
		var str = $("form[name=from_edit_rep]").serialize();
		$.get("/ajax/dialog.php?update_customer_rep_info=1&" + str , function(data){
		
			//成功の場合
			if(data.match(/done./))
			{
				alert("顧客担当者情報の更新が行われました。顧客情報を再読み込みします");
				location.reload();
			}
			//エラーの場合
			else
			{
				alert(data);
			}
		});
	}
	

	//移転ニーズ編集ダイアログの表示
	function show_edit_customer_needs_dialog(u_id)
	{
		if(u_id > 0)
		{
		}
		else
		{
			alert("u_id がありません");
			return false;
		}
		
		$.get("/ajax/dialog.php", {show_edit_customer_needs_dialog:1, u_id:u_id}, function(data){
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 952,
				resizable:false,
				title:"移転ニーズの編集",
				buttons: {
				}
			});
		
		});	
	}
	
	//移転ニーズダイアログの更新
	function submit_edit_customer_needs_dialog()
	{
		var str = $("form[name=form_customer_needs]").serialize();

		$.post("/ajax/dialog.php", {update_edit_customer_needs_dialog:1, params:str } , function(data){
		
			//成功の場合
			if(data.match(/done./))
			{
				alert("移転ニーズの更新が行われました。顧客情報を再読み込みします");
				location.reload();
			}
			//エラーの場合
			else
			{
				alert(data);
			}

		});
	}
	
	
	//タスク設定ダイアログの表示
	function show_edit_task_dialog(u_id, t_id, update_mode, adddate)
	{
		loading("on");
		
		if(u_id > 0)
		{
		}
		else
		{
			//alert("u_id がありません");
			//return false;
		}
		
		$.get("/ajax/dialog.php", {show_edit_task_dialog:1, u_id:u_id, t_id:t_id, update_mode:update_mode}, function(data){
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);
			
			if(update_mode == "finish")
			{
				var dialog_title = "タスクの完了報告";			
			}
			else
			{
				var dialog_title = "タスクの編集";
			}

			$(".dialog").dialog({
				autoOpen: true,
				width: 652,
				resizable:false,
				title:dialog_title,
				buttons: {
				}
			});

			$("input[name=taskdate]").datepicker();
			
			//タブ切り替え
			var i = 0;
			$("div.detail_taskrp_div").each(function(){
				i++;
				if(i >= 2)
					$(this).hide();
			});

			$("a.detail_taskrp_tab").click(function(){
			
				$("a.detail_taskrp_tab").removeClass("selected");
				$(this).addClass("selected");
				var id = $(this).attr("id");
				
				
				$("div.detail_taskrp_div").hide();
				$("div#"+id).show();
				
			});
			
			//タスク種別切り替え時,種別表示の切り替え
			$("input[name=t_type]").change(function(){
			
				var this_val = $("input[name=t_type]:checked").val();
				
				if(shuhou_teigi[this_val] != undefined)
				{
					$("div#task_way").show();
					$("label.detail").hide();
					
					for(var i in shuhou_teigi[this_val])
					{
						$("label#" + shuhou_teigi[this_val][i]).show();
					}
					
				}
				else
				{
					$("div#task_way").hide();
				}
			
			});
			
			//タスク新規追加時、日付指定
			if("adddate" in window)
			{
				if(adddate != "" && update_mode == "add")
				{
					var tmp = adddate.split(" ");
					$("input[name=taskdate]").val(tmp[0]);
					$("select[name=tasktime]").val(tmp[1]);
					
				}
			}
			
			$("input[name=t_result]").change(function(){
				
				//今回の結果が「継続」以外であれば次回タスク登録は隠す

				if($("input[name=t_result]:checked").val() == "継続")
				{
					$("div#cover_next_task").fadeOut();
				}
				else
				{
					$("div#cover_next_task").fadeIn();
				}
				
				//他決の場合、その会社名を記入させる

				if($("input[name=t_result]:checked").val() == "他決")
				{
					$("textarea[name=t_done_detail]").text("ユーザーが契約を行った競合会社名：");
				}
				
			});
			
			//初期文字の消去
			$("input[name=u_name_search]").click(function(){
			
				if($(this).val() == "顧客名を入力して下さい")
					$(this).val("");
			
			});

			loading("off");
	
		});		
	}

	//手法の定義
	var shuhou_teigi = [];
	shuhou_teigi[801] = ["tel",  "mail"];	
	shuhou_teigi[10]  = ["houmon", "tel"   ];	
	shuhou_teigi[20]  = ["houmon", "tel",  "mail"];	
	shuhou_teigi[501] = ["houmon", "tel",  "mail"];	
	shuhou_teigi[21]  = ["houmon", "tel",  "mail"];	
	shuhou_teigi[604] = ["houmon", "tel",  "mail"];	
	
	//リストに関連するフロア情報を取得し、htmlを入れ込み
	//mode が 1 なら、あらかじめチェックしておく
	function get_relay_list_floor(l_id, mode)
	{
	
		$('div#list_floor_lists').html('loading').css({'display':'block'});

		$.get('/calendar.php?ajax=1&get_list_floor=' + l_id , function(data){
		
			$('div#list_floor_lists').html(data);
			
			$("div#list_floor_lists > label").css({"display":"block"});

			$('input.list_f_no').click(function(){
				$('input[name=change_listfloor_flag]').val('true');
			});
			
			if(mode == 1)
			{
				$("input.list_f_no").attr({"checked":"checked"});
			}

		})
	
	
	}
	
	//タスク設定の更新
	function submit_edit_task_dialog()
	{
		var str = $("form[name=form_task]").serialize();
		
		//未完了のタスクの件数
		var customer_history_yet_num = $("input[name=customer_history_yet_num]").val();
		
		//結果が継続の場合
		if($("input[name=t_result]:checked").val() == "継続" )
		{
			//次回のタスク入力を強制する
			//残りのタスクが2件以上ない（今回完了とするタスク以外にない）場合
			if($("input[name=t_type]:checked").val() == undefined && customer_history_yet_num <= 1)
			{
				alert("結果が「継続」の場合、次回のタスクを選択して下さい。");
				return false;	
			}
		}
		
		$.get("/ajax/dialog.php?update_task=1&" + str , function(data){
		
			//成功の場合
			if(data.match(/done./))
			{
				//スマートフォン版の場合
				if(location.href.match(/\/s\//))
				{
					alert("タスクの更新が行われました。");
					
					var u_id = $("input[name=u_id]").val();
					location.href = "/s/customer/c_detail.php?msg=タスクの更新が完了しました。&u_id=" + u_id;
					return true;
				}
				//PC版の場合
				else
				{
					alert("タスクの更新が行われました。情報を再読み込みします");
					location.reload();
				}
			}
			//エラーの場合
			else
			{
				alert(data);
			}
		});
		
	}
	
	//地図の表示
	//※呼び出し元のページでGoogle Maps APIを宣言しておく必要有り
	function show_map_from_addr(addr)
	{
		$.get("/ajax/dialog.php", {show_map:1}, function(data){
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 652,
				resizable:false,
				title:addr,
				buttons: {
				}
			});
			
			//地図の表示・ジオコーディング
			geocoder = new google.maps.Geocoder();
			
			var latlng = new google.maps.LatLng(35.689927,139.70109);
			var myOptions = {
			  zoom: 15,
			  center: latlng,
			  mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			map = new google.maps.Map(document.getElementById("dialog_map"), myOptions);

			geocoder.geocode( { 'address': addr}, function(results, status) {
			  if (status == google.maps.GeocoderStatus.OK) {
			    map.setCenter(results[0].geometry.location);
			    var marker = new google.maps.Marker({
			        map: map, 
			        position: results[0].geometry.location
			    });
			  } else {
			    alert("この住所が見つかりませんでした。");
			  }
			});
		
		});	
	
	}
	
	//リストの削除
	function list_delete(l_id)
	{
		if(l_id > 0)
		{
			if(window.confirm("指定されたリストを削除します。実施してよろしいですか？"))
			{
				$.get("/save/saveexec.php", {mode:"delete", l_id:l_id}, function(){
					
					alert("削除を行いました。ウィンドウを再読み込みします。");
					location.reload();
					
				});
			}
		}
	}
	
	//リストのコピー
	function list_copy(l_id)
	{
		$.get("/ajax/dialog.php", { show_copy_list_dialog:1, l_id:l_id}, function(data){
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 952,
				resizable:false,
				title:"リストのコピー"
			});
		
		});		
		
	}
	
	//リストコピーの実行
	function submit_list_copy()
	{
		var str = $("form[name=list_copy_form]").serialize();
		
		var u_id = $("select[name=instant_search_u_id_list]").val();
		str += "&u_id=" + u_id + "&mode=copy";
		
		$.get("/save/saveexec.php?" + str, function(){
			alert("リストのコピーが完了しました。画面を再読み込みします。");
			location.reload();
		});
		
	}
	
	//リストの物件をカートに積み込む
	function list_add_cart(l_id)
	{
		if(l_id > 0)
		{
			$.get("/ajax/bottom_favorite_list.php", {list_add_cart:1, l_id:l_id}, function(data){
			
				if(data.match(/done./))
				{
					//alert("リストのフロアを、カートに追加しました。");
					show_page_bottom_favorite_list();
				}
				else
				{
					alert("正しく処理を完了出来ませんでした。");
				}
			
			});
		
		}
	}
	
	//顧客名を検索し、ヒットした顧客U_IDリストをSelectへ代入する
	function customer_instant_search()
	{
	
		var str = $("input[name=u_name_search]").val();
		var only_my_customer = $("input[name=only_my_customer]:checked").val();
		
		if(str == "")
		{
			alert("顧客名を入力して下さい。");
			return false;
		}
		
		$.get("/ajax/dialog.php", {customer_instant_search:1, only_my_customer:only_my_customer, customer_name:str}, function(data){
		
			if(data == "false")
			{
				//alert("顧客が見つかりませんでした。");
				return false;
			}
			$("select[name=instant_search_u_id_list]").html(data).fadeIn();
		
		
		});

	}
	
	//顧客名を↑で検索して、セレクトボックスを変更後の動作
	function customer_instant_search_decision()
	{
		var value = $("select[name=instant_search_u_id_list]").val();
		
		if(value != "")
		{
			var text = $("select[name=instant_search_u_id_list] option:selected").text();
			$("input[name=u_name_search]").val(text);
			$("select[name=instant_search_u_id_list]").fadeOut();
		
		}
	}
	
	//タスク設定時、
	//顧客名に応じて物件リストを表示する
	function get_customer_relay_list(u_id)
	{
		$.get("/ajax/dialog.php", {get_customer_relay_list:1, u_id:u_id}, function(data){
			$("select[name=t_relay_list]").html(data);
		});
	}
	
	
	//顧客・物件一覧の簡易表示ダイアログ
	function show_instant_floor_dialog(target_id, show_mode, l_type, dialog_name)
	{
		if(target_id != "" && show_mode != "")
		{
		}
		else
		{
			return false;
		}
	
		$.get("/ajax/dialog.php", {show_instant_floor_customer_list:1, show_mode: show_mode, target_id: target_id, l_type:l_type}, function(data){
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 652,
				resizable:false,
				title:dialog_name,
				buttons: {
				}
			});
		
		});		
	
	}
	
	//==========================================================//==========================================================
	
	//成約情報のインプットダイアログ
	function show_sales_result_info_dialog(u_id, sl_id)
	{
		$.get("/ajax/dialog.php", {show_sales_result_info_dialog:1, u_id:u_id, sl_id:sl_id}, function(data){
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 952,
				resizable:false,
				title:"成約情報の更新",
				buttons: {
				}
			});0
		
		});			
	}
	
	//フロアIDから住所などの情報を取得
	function get_floor_owner_info_from_f_id()
	{
		var this_f_no = $("input[name=sl_f_no]").val();
		
		if(this_f_no > 0)
		{
			$.get("/ajax/dialog.php", {get_floor_owner_info_from_f_id:1, f_no:this_f_no}, function(data){
			
				if(data.match(/error/) != null)
				{
					alert("フロアIDから情報を呼び出せませんでした。IDが正しいか再度確認して下さい。");
					return false;
				}
				
				$("input[name=sl_b_no]").val($("b_no", data).text());
				$("input[name=sl_b_name]").val($("b_nm", data).text());
				$("input[name=sl_b_address]").val($("b_address", data).text());
				$("input[name=sl_floor]").val($("f_floor_str", data).text());
				$("input[name=sl_acreage]").val($("f_acreg", data).text());
				
				alert("フロアIDから情報を呼び出しました。他の空欄に入力して下さい。");
			
			
			});
			
		
		}
	
	}
	
	//成約情報のサブミット
	function submit_sales_result_info_dialog()
	{
		var str = $("form[name=sales_result_info]").serialize();

		$.post("/ajax/dialog.php", {submit_sales_result_info_dialog:1, params:str } , function(data){
		
			//成功の場合
			if(data.match(/done./))
			{
				alert("成約情報の更新が行われました。情報を再読み込みします");
				location.reload();
			}
			//エラーの場合
			else
			{
				alert(data);
			}

		});

	}
	
	//成約情報のインプット時、東京オフィス検索での成約とする
	function set_sales_as_oftokyo()
	{
		var u_name = $("form[name=sales_result_info]").find("input[name=sl_c_name]").val();
		
		$("input[name=sl_buil_1_c_name]").val(u_name);
		$("input[name=sl_buil_1_type]").val("東京オフィス検索 サービス利用料として");
		$("input[name=sl_buil_1_price]").val("100000");
		$("input[name=sl_buil_1_tax]").val("5000");
		$("input[name=sl_buil_1_allprice]").val("105000");
		
		alert("請求先・請求額に、東京オフィス検索 サービス利用料を設定しました。");
		
		return true;
	}

	//==========================================================
	
	//建物情報 編集ダイアログ
	function show_edit_building_info(b_no)
	{
		if(b_no > 0)
		{
		}
		else
		{
			//return false;
		}
		
		$.get("/ajax/dialog.php", {show_edit_building_info:1, b_no:b_no}, function(data){
		
			if(data.match(/false/))
			{
				alert("エラーが発生したため、建物情報の編集が出来ません。リロードするなど、再度読み込みして下さい");
				return false;
			}
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 952,
				resizable:false,
				title:"建物情報の編集",
				buttons: {
				}
			});0
		
		});				
	
	}
	
	//建物基本情報ダイアログからの更新
	function submit_edit_building_info()
	{
		loading("on");
		var str = $("form[name=edit_building_info]").serialize();

		$.post("/search/detail.php", {postmode:"buil", submit_edit_building_info:1, params:str } , function(data){

			//新規ビル登録が成功の場合
			if(data.match(/new_b_no/))
			{
				var b_no = data.replace(/done.new_b_no=(\d+)/, "$1");
				alert("建物情報の新規登録が成功しました。建物詳細画面へ移動します");
				
				location.href = "/search/detail.php?b_no=" + b_no;
				
				return true;
				
			}
			//更新が成功の場合
			else if(data.match(/done./))
			{
				alert("建物情報の更新が行われました。情報を再読み込みします");
				location.reload();
			}
			//エラーの場合
			else
			{
				if(data.match(/名前の建物は既に登録されています。/))
				{
					var id = data.match(/\d+/);
					if(window.confirm("この建物は既に登録されています。（ID:" + id + ") この建物のページに移動しますか？"))
					{
						location.href = "/search/detail.php?regist_check_redirect=1&b_no=" + id;
					}
				}
				else
				{
					alert(data);
				}
			}
			loading("off");

		});
	}
	
	//建物ウェブ公開情報ダイアログの表示
	function show_web_open_flag_set_dialog(b_no)
	{
		if(b_no > 0)
		{
		}
		else
		{
			return false;
		}
		
		$.get("/ajax/dialog.php", {show_web_open_flag_set_dialog:1, b_no:b_no}, function(data){
		
			if(data.match(/false/))
			{
				alert("エラーが発生したため、建物情報の編集が出来ません。リロードするなど、再度読み込みして下さい");
				return false;
			}
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 952,
				resizable:false,
				title:"ウェブ公開に関する設定",
				buttons: {
				}
			});0
		
		});				
	
	}

	//20150930 Watanabe Update
	//web公開に関する設定
	function submit_web_open_flag_set_dialog()
	{
		//「ウェブ公開不可」の時、理由が選択されているかどうか
		if($("input[name=b_fm_webflag]:checked").val() == 2 && $("input.buil_privately_reason:checked").val() == "")
		{
			alert("ウェブ公開不可の理由が記入されていません。");
			return false;
		}
		//「ウェブ公開不可」以外の時、理由が選択されている場合
		else if($("input[name=b_fm_webflag]:checked").val() != 2 && $("input.buil_privately_reason:checked").val() != "")
		{
			alert("ウェブ公開不可の理由が記入されています。不要な場合、削除して下さい。");
			return false;
		}
		
		var str = $("form[name=web_open_flag_set_dialog]").serialize();
		$.post("/search/detail.php", {postmode:"web_open",  params:str } , function(data){

			//成功の場合
			if(data.match(/done./))
			{
				alert("建物情報の更新が行われました。情報を再読み込みします");
				location.reload();
			}
			//エラーの場合
			else
			{
				alert(data);
			}
		});
	}
	

	//建物 オススメコメント入力ダイアログの表示
	function show_buil_osusume_comment_dialog(b_no)
	{
		if(b_no > 0)
		{
		}
		else
		{
			return false;
		}
		
		$.get("/ajax/dialog.php", {show_buil_osusume_comment_dialog:1, b_no:b_no}, function(data){
		
			if(data.match(/false/))
			{
				alert("エラーが発生したため、建物情報の編集が出来ません。リロードするなど、再度読み込みして下さい");
				return false;
			}
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 652,
				resizable:false,
				title:"建物オススメコメントの編集",
				buttons: {
				}
			});0
		
		});				
	
	}

	//建物 オススメコメント入力ダイアログの入力
	function submit_buil_osusume_comment_dialog()
	{
		var str = $("form[name=buil_osusume_comment_dialog]").serialize();
		
		$.post("/search/detail.php", {postmode:"web_recomend_comment",  params:str } , function(data){

			//成功の場合
			if(data.match(/done./))
			{
				alert("オススメコメントの更新が行われました。情報を再読み込みします");
				location.reload();
			}
			//エラーの場合
			else
			{
				alert(data);
			}
		});
	}
	


	//建物 設備・環境に関するフラグ・コメント入力ダイアログの表示
	function show_buil_facility_flag_dialog(b_no)
	{
		if(b_no > 0)
		{
		}
		else
		{
			return false;
		}
		
		$.get("/ajax/dialog.php", {show_buil_facility_flag_dialog:1, b_no:b_no}, function(data){
		
			if(data.match(/false/))
			{
				alert("エラーが発生したため、建物情報の編集が出来ません。リロードするなど、再度読み込みして下さい");
				return false;
			}
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 952,
				resizable:false,
				title:"設備・環境に関する情報の編集",
				buttons: {
				}
			});0
		
		});				
	
	}

	//建物 設備・環境に関するフラグ・コメント入力ダイアログの入力
	function submit_buil_facility_flag_dialog()
	{
		var str = $("form[name=buil_facility_flag_dialog]").serialize();
		
		$.post("/search/detail.php", {postmode:"buil_facility_flag",  params:str } , function(data){

			//成功の場合
			if(data.match(/done./))
			{
				alert("設備・環境に関する情報の更新が行われました。情報を再読み込みします");
				location.reload();
			}
			//エラーの場合
			else
			{
				alert(data);
			}
		});
	}

	//建物 最寄り駅情報入力ダイアログの表示
	function show_buil_st_walk_edit_dialog(b_no)
	{
		if(b_no > 0)
		{
		}
		else
		{
			return false;
		}
		
		$.get("/ajax/dialog.php", {show_buil_st_walk_edit_dialog:1, b_no:b_no}, function(data){
		
			if(data.match(/false/))
			{
				alert("エラーが発生したため、建物情報の編集が出来ません。リロードするなど、再度読み込みして下さい");
				return false;
			}
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 652,
				resizable:false,
				title:"最寄り駅情報の更新",
				buttons: {
				}
			});0
		
		});				
	
	}

	//建物 最寄り駅情報の入力
	function submit_buil_st_walk_edit_dialog()
	{
		var str = $("form[name=buil_st_walk_edit_dialog]").serialize();
		
		$.post("/search/detail.php", {postmode:"neer_st",  params:str } , function(data){

			//成功の場合
			if(data.match(/done./))
			{
				alert("最寄り駅情報の更新が行われました。情報を再読み込みします");
				location.reload();
			}
			//エラーの場合
			else
			{
				alert(data);
			}
		});
	}
	
	//==========================================================
	
	//ビルオーナー・管理会社情報の追加・編集ダイアログの表示
	function show_buil_management_corp_info_edit_dialog(o_id)
	{
		$.get("/ajax/dialog.php", {show_buil_management_corp_info_edit_dialog:1, o_id:o_id}, function(data){
		
			if(data.match(/false/))
			{
				alert("エラーが発生したため、編集が出来ません。リロードするなど、再度読み込みして下さい");
				return false;
			}
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 952,
				resizable:false,
				title:"管理会社・オーナー情報の編集",
				buttons: {
				}
			});0
		
		});					
	
	}
	
	//ビルオーナー・管理会社情報の追加・編集
	function submit_buil_management_corp_info_edit_dialog()
	{
		var str = $("form[name=buil_management_corp_info_edit_dialog]").serialize();

		$.post("/ajax/dialog.php", {submit_buil_management_corp_info_edit_dialog:1, params:str } , function(data){
		
			//成功の場合
			if(data.match(/done./))
			{
				alert("オーナー・管理会社情報の更新が行われました。");
				$(".dialog").fadeOut().remove();	//ダイアログを消去
			}
			//エラーの場合
			else
			{
				alert(data);
			}

		});	
	}


	//ビル管理履歴の追加・編集ダイアログの表示
	function show_buil_management_history_add_dialog(b_no, bo_id)
	{
		$.get("/ajax/dialog.php", {show_buil_management_history_add_dialog:1, b_no:b_no, bo_id:bo_id}, function(data){
		
			if(data.match(/false/))
			{
				alert("エラーが発生したため、編集が出来ません。リロードするなど、再度読み込みして下さい");
				return false;
			}
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 952,
				resizable:false,
				title:"ビル管理履歴の追加・編集",
				buttons: {
				}
			});0
		
		});					
	
	}
	
	//ビル管理履歴の追加・更新
	function submit_buil_management_history_add_dialog()
	{
		var str = $("form[name=buil_management_history_add_dialog]").serialize();

		$.post("/ajax/dialog.php", {submit_buil_management_history_add_dialog:1, params:str } , function(data){
		
			//成功の場合
			if(data.match(/done./))
			{
				alert("ビル管理履歴の更新が行われました。情報を再読み込みします");
				
				if(location.href.match(/floor_list_update/))
				{
					//フロア一括更新ウィンドウの場合
					var b_no = $("input[name=b_no]").val();
					location.href = "/search/floor_list_update.php?msg=オーナー・業者情報の更新が完了しました。&update_owner_done=1&b_no=" + b_no;
				}
				else
				{
					location.reload();
				}
			}
			//エラーの場合
			else
			{
				alert(data);
			}

		});	
	}
	
	//期間設定
	function show_period_dialog()
	{
		$.get("/ajax/dialog.php", {show_period_dialog:1 }, function(data){
		
			if(data.match(/false/))
			{
				alert("エラーが発生したため、編集が出来ません。リロードするなど、再度読み込みして下さい");
				return false;
			}
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 652,
				resizable:false,
				title:"期間設定",
				buttons: {
				}
			});
			
			$("input[name=period_start], input[name=period_finish] ").datepicker();

		
		});					
	
	}
	
	function set_period()
	{
		var period_start = $("input[name=period_start]").val();
		var period_finish = $("input[name=period_finish]").val();
		
		if(period_start == "" || period_finish == "")
		{
			alert("正しく設定されていません。");
			return false;
		}
		
		$.get("/ajax/dialog.php", {set_period:1, period_start:period_start, period_finish:period_finish}, function(data){
		
			if(data == "err")
			{
				alert("期間の設定に失敗しました。入力を再度確認して下さい。");
			}
			else
			{
				alert("期間が再設定されました。情報を再度読み込みます。");
				location.reload();
			}
			
			return true;
		});
		
	
	}
	
	//請求書発行ダイアログ
	function show_invoice_input_dialog(id)
	{
		$.get("/ajax/dialog.php", {show_invoice_input_dialog:1, id:id }, function(data){
		
			if(data.match(/false/))
			{
				alert("エラーが発生したため、編集が出来ません。リロードするなど、再度読み込みして下さい");
				return false;
			}
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 652,
				resizable:false,
				title:"請求情報の編集・請求書の発行",
				buttons: {
				}
			});0
		
		});	
	}
	
	//請求書情報の更新
	function set_show_invoice_input_dialog()
	{
		var str = $("form[name=form_invoice_input]").serialize();
		var sl_id = $("input[name=sl_id]").val();
		var select = $("input[name=select]").val();
		

		$.post("/ajax/dialog.php", {input_invoice_info:1, params:str } , function(data){
		
			//成功の場合
			if(data.match(/done/))
			{
				alert("請求情報が保存されました。印刷画面を表示します。");
				$(".dialog").fadeOut().remove();	//ダイアログを消去
								
				window.open("/sales/print_invoice.php?sl_id=" + sl_id + "&select=" + select, "print_invoice", 'width=900, height=600, menubar=no, toolbar=no, scrollbars=yes' );
				
			}
			//エラーの場合
			else
			{
				alert(data);
			}

		});
	}
	
	//業者リストの応対履歴 インプットダイアログ
	function show_owner_list_history_input_dialog(o_id, showmode)
	{
		$.get("/ajax/dialog.php", {show_owner_list_history_input_dialog:1, o_id:o_id, showmode:showmode }, function(data){
		
			if(showmode == "eigyo")
			{
				var dialog_title = "オーナー・業者 対応履歴";
			}
			else
			{
				var dialog_title = "オーナー・業者 一覧の応対履歴";
			}


			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 420,
				resizable:false,
				title:dialog_title,
				buttons: {
				}
			});0
		
		});			
	
	}
	
	//2015/06/16 - HUY - OR-260
	//remove ichiran checked
	function remove_owner_ichiran(o_id)
	{
		var list_ichiran = []
		$("input[name='check_owner[]']").each(function(){
			if($(this).prop('checked'))
			{
				list_ichiran.push($(this).val());
			}
		});
		
		if(list_ichiran.length == 0)
		{
			alert('削除したいファイルを選択して下さい。');
			return false;
		}
		$("#dialog-confirm").dialog({
			autoOpen: true,
			width: 420,
			height:80,
			resizable:false,
			title:'一括削除',
			buttons: {
			}
		});
		
	}
	//END
	
	//2015/06/17 - HUY - OR-259
	//Hidden current owner
	function show_owner_hide_dialog(o_id)
	{
		$("#dialog-hide-owner").dialog({
			autoOpen: true,
			width: 420,
			height:80,
			resizable:false,
			title:'管理会社の削除',
			buttons: {
			}
		});
	}
	//END
	
	
	function getDoc(frame) {
	     var doc = null;
	 
	     // IE8 cascading access check
	     try {
	         if (frame.contentWindow) {
	             doc = frame.contentWindow.document;
	         }
	     } catch(err) {
	     }
	 
	     if (doc) { // successful getting content
	         return doc;
	     }
	 
	     try { // simply checking may throw in ie8 under ssl or mismatched protocol
	         doc = frame.contentDocument ? frame.contentDocument : frame.document;
	     } catch(err) {
	         // last attempt
	         doc = frame.document;
	     }
	     return doc;
	 }
	
	
	//業者リストの応対履歴 インプット
	function submit_owner_list_history_input_dialog()
	{
		//Nguyen Trang 2014/02/11 OR-98
		var formObj = $("#owner_list_history_input_dialog");
	    var formURL = "/ajax/dialog.php";
	    var current_os_type = $("input[name=os_type]:checked").val();
	    var current_os_hidden = $("input[type='hidden'][name=os_type]").val();
	    var file_chosen = $('input[type=file]')[0].files[0];
	    var msg_alert = "";
	    var error_chk = false;
	    if(window.FormData !== undefined)  // for HTML5 browsers
	    {
	        var formData = new FormData();
			formData.append('file', file_chosen);
			formData.append('params', formObj.serialize());
			formData.append('submit_owner_list_history_input_dialog', "1");
			formData.append('ajax', "1");
			
			if(!current_os_type && !current_os_hidden)
			{
				msg_alert = "対応種別を選んで下さい。";
				error_chk = true;
			}
			
			if(error_chk)
			{
				alert(msg_alert);
				return false;
			}
			
			
	        $.ajax({
	            url: formURL,
	            type: 'POST',
	            data:  formData,
	            mimeType:"multipart/form-data",
	            contentType: false,
	            cache: false,
	            processData:false,
	            success: function(data, textStatus, jqXHR)
	            {
	            	if(data.match(/finished/))
	            	{
	            		alert("一覧のPDFのアップロードが完了しました。画面を再読み込みします。");
	            	}
	            	else if(data.match(/done/))
					{
						alert("更新が行われました。情報を再読み込みします");
					}
					window.location.reload(true);
	            }     
	       });
	        
	   }
	   else  //for olden browsers
	   {
	        //generate a random id
	        var  iframeId = 'unique' + (new Date().getTime());
	 
	        //create an empty iframe
	        var iframe = $('<iframe src="javascript:false;" name="'+iframeId+'" />');
	 
	        //hide it
	        iframe.hide();
	 
	        //set form target to iframe
	        formObj.attr('target',iframeId);
	 
	        //Add iframe to body
	        iframe.appendTo('body');
	        iframe.load(function(e)
	        {
	            var doc = getDoc(iframe[0]);
	            var docRoot = doc.body ? doc.body : doc.documentElement;
	            var data = docRoot.innerHTML;
	        });
	    }
		//Nguyen Trang END
	}
	
	//業者情報の更新ダイアログ
	function show_owner_info_edit_dialog(o_id)
	{
		$.get("/ajax/dialog.php", {show_owner_info_edit_dialog:1, o_id:o_id }, function(data){
		

			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);
			
			if(o_id > 0)
			{
				var dialog_title = "オーナー・業者情報の更新";			
			}
			else
			{
				var dialog_title = "オーナー・業者の新規追加";
			}

			$(".dialog").dialog({
				autoOpen: true,
				width: 952,
				resizable:false,
				title:dialog_title,
				buttons: {
				}
			});
			
		
		});				
	
	}

	//業者情報の更新
	function submit_owner_info_edit_dialog()
	{
		var str = $("form[name=owner_info_edit_dialog]").serialize();
		
		$.post("/ajax/dialog.php", {ajax:1, submit_owner_info_edit_dialog:1, params:str } , function(data){

			//成功の場合
			if(data.match(/done/))
			{
				var o_id = data.replace(/done. o_id=(\d+)/, "$1");
				
				alert("オーナー・業者情報の更新が行われました。情報を再読み込みします");
				location.href = "/data/builcorp_detail.php?o_id=" + o_id;
				return true;
			}
			//エラーの場合
			else
			{
				alert(data);
			}
		});
		
	}
	
	
	//マニュアルダウンロード台ログ
	function show_manual_download_dialog()
	{
		$.get("/ajax/dialog.php", {show_manual_pdf_list:1,}, function(data){
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 420,
				resizable:false,
				title:"オフィスリサーチ 操作説明",
				buttons: {
				}
			});
			
		
		});					
	}
	
	//物件一括更新ダイアログ
	function show_floor_info_all_update_dialog(b_no)
	{
		loading("on");
		
		$.get("/ajax/dialog.php", {show_floor_info_all_update_dialog:1, b_no:b_no}, function(data){
		
			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 952,
				resizable:false,
				title:"フロア情報 一括更新",
				buttons: {
				}
			});
			
			//値を変更した項目の色を変更
			$("form[name=floor_info_all_update_dialog]").find("input, select").change(function(){
			
					$(this).css("background-color" , "#F0E68C");
					
					//フロア情報変更フラグを立てる
					var this_name = $(this).attr("name");
					var this_f_no = this_name.replace(/.+\[(\d+)\]/, "$1");
					
					$("input[name='change[" + this_f_no + "]']").val("1").attr("checked", true);
					$("span#floor_id_" + this_f_no).css("color", "red");
					
			
			});
			
			//賃料のクリック
			$(".price_rent").blur(function(){
			
				var this_name = $(this).attr("name");
				var this_val = $(this).val();
				var this_f_no = this_name.replace(/.+\[(\d+)\]/, "$1");
				var this_acreg = $("input[name='acreg[" + this_f_no + "]']").val();
			
				//坪単価のクリック
				if(this_name.match(/f_price_t_rent\[\d+\]/))
				{
					if(this_val > 0)
					{
						var tmp = Math.round(this_val * this_acreg);
						
						$("input[name='f_price_a_rent[" + this_f_no + "]']").val(tmp);
						$("input[name='f_price_t_rent_sp[" + this_f_no + "]']").each(function(){
							$(this).attr("checked", false);
						});
					}
					
					if(this_val >= 100000)
						alert("入力された賃料の数値が大きいです。誤っていないか確認して下さい。");
					
				}

				//坪月額のクリック
				if(this_name.match(/f_price_a_rent\[\d+\]/))
				{
					if(this_val > 0)
					{
						var tmp = Math.round(this_val / this_acreg);
						
						$("input[name='f_price_t_rent[" + this_f_no + "]']").val(tmp);
						$("input[name='f_price_t_rent_sp[" + this_f_no + "]']").each(function(){
							$(this).attr("checked", false);
						});
					}

				}

				
				//未定・相談のクリック
				if(this_name.match(/f_price_t_rent_sp\[\d+\]/) && $("input[name='f_price_t_rent_sp[" + this_f_no + "]']:checked").val() < 0 )
				{
					$("input[name='f_price_t_rent[" + this_f_no + "]']").val("");
					$("input[name='f_price_a_rent[" + this_f_no + "]']").val("");
				}
				
			});
			
			//共益費のクリック
			$(".price_mente").blur(function(){
			
				var this_name = $(this).attr("name");
				var this_val = $(this).val();
				var this_f_no = this_name.replace(/.+\[(\d+)\]/, "$1");
				var this_acreg = $("input[name='acreg[" + this_f_no + "]']").val();
			
				//坪単価のクリック
				if(this_name.match(/f_price_t_mente\[\d+\]/))
				{
					if(this_val > 0)
					{
						var tmp = Math.round(this_val * this_acreg);
						
						$("input[name='f_price_a_mente[" + this_f_no + "]']").val(tmp);
						$("input[name='f_price_t_mente_sp[" + this_f_no + "]']").each(function(){
							$(this).attr("checked", false);
						});
					}
					
					if(this_val >= 100000)
						alert("入力された共益費の数値が大きいです。誤っていないか確認して下さい。");
					
				}

			
				//坪月額のクリック
				if(this_name.match(/f_price_a_mente\[\d+\]/))
				{
					if(this_val > 0)
					{
						var tmp = Math.round(this_val / this_acreg);
						
						$("input[name='f_price_t_mente[" + this_f_no + "]']").val(tmp);
						$("input[name='f_price_t_mente_sp[" + this_f_no + "]']").each(function(){
							$(this).attr("checked", false);
						});
					}
					
					if(this_val >= 100000)
						alert("入力された共益費の数値が大きいです。誤っていないか確認して下さい。");
					
				}

				
				//未定・相談のクリック
				if(this_name.match(/f_price_t_mente_sp\[\d+\]/) && $("input[name='f_price_t_mente_sp[" + this_f_no + "]']:checked").val() < 0 )
				{
					$("input[name='f_price_t_mente[" + this_f_no + "]']").val("");
					$("input[name='f_price_a_mente[" + this_f_no + "]']").val("");
				}
				
			});			

			//敷金のクリック
			$(".price_shiki").blur(function(){
			
				var this_name = $(this).attr("name");
				var this_val = $(this).val();
				var this_f_no = this_name.replace(/.+\[(\d+)\]/, "$1");
				var this_acreg = $("input[name='acreg[" + this_f_no + "]']").val();
			
				//坪単価のクリック
				if(this_name.match(/f_price_t_shiki\[\d+\]/))
				{
					if(this_val > 0)
					{
						var tmp = Math.round(this_val * this_acreg);
						
						//$("input[name='f_price_m_shiki[" + this_f_no + "]']").val("");
						$("input[name='f_price_a_shiki[" + this_f_no + "]']").val(tmp);
						$("input[name='f_price_shiki_sp[" + this_f_no + "]']").each(function(){
							$(this).attr("checked", false);
						});
					}
					
					if(this_val >= 100000)
						alert("入力された敷金（坪単価）の数値が大きいです。誤っていないか確認して下さい。");
					
				}

				//ヶ月単価のクリック
				if(this_name.match(/f_price_m_shiki\[\d+\]/))
				{
					//賃料
					var price_month = $("input[name='f_price_a_rent[" + this_f_no + "]']").val();
					
					if(this_val > 0)
					{
						var tmp = Math.round(this_val * price_month);
						
						//$("input[name='f_price_t_shiki[" + this_f_no + "]']").val("");
						$("input[name='f_price_a_shiki[" + this_f_no + "]']").val(tmp);
						$("input[name='f_price_shiki_sp[" + this_f_no + "]']").each(function(){
							$(this).attr("checked", false);
						});
					}
					
					if(this_val >= 100)
						alert("入力された敷金（ヶ月）の数値が大きいです。誤っていないか確認して下さい。");
					
				}
				
				//未定・相談のクリック
				if(this_name.match(/f_price_shiki_sp\[\d+\]/) && $("input[name='f_price_shiki_sp[" + this_f_no + "]']:checked").val() < 0 )
				{
					$("input[name='f_price_t_shiki[" + this_f_no + "]']").val("");
					$("input[name='f_price_m_shiki[" + this_f_no + "]']").val("");
					$("input[name='f_price_a_shiki[" + this_f_no + "]']").val("");
				}
				
			});	

			//礼金のクリック
			$(".price_keymoney").blur(function(){
			
				var this_name = $(this).attr("name");
				var this_val = $(this).val();
				var this_f_no = this_name.replace(/.+\[(\d+)\]/, "$1");
				var this_acreg = $("input[name='f_price_keymoney[" + this_f_no + "]']").val();
			
				//坪単価のクリック
				if(this_name.match(/f_price_keymoney\[\d+\]/))
				{
					if(this_val > 0)
					{
						$("input[name='f_price_keymoney_exist[" + this_f_no + "]']").each(function(){
							$(this).attr("checked", false);
						});
					}
					
					if(this_val >= 100)
						alert("入力された礼金の数値が大きいです。誤っていないか確認して下さい。");
					
				}
				
				//未定・相談のクリック
				if(this_name.match(/f_price_keymoney_exist\[\d+\]/) && $("input[name='f_price_keymoney_exist[" + this_f_no + "]']:checked").val() < 0)
				{
					$("input[name='f_price_keymoney[" + this_f_no + "]']").val("");
				}
				
			});		

			//償却のクリック
			$(".price_amo").blur(function(){
			
				var this_name = $(this).attr("name");
				var this_val = $(this).val();
				var this_f_no = this_name.replace(/.+\[(\d+)\]/, "$1");
			
				//実数入力欄のクリック
				if(this_name.match(/f_price_amo\[\d+\]/))
				{
					if(this_val >= 100)
						alert("入力された償却の数値が大きいです。誤っていないか確認して下さい。");
					
				}
				
				//未定・相談のクリック
				if(this_name.match(/f_price_amo_flag\[\d+\]/) )
				{
					if(this_val < 0)
						$("input[name='f_price_amo[" + this_f_no + "]']").val("");
				}
				
			});		
			
			//更新料のクリック
			$(".price_rerent").blur(function(){
			
				var this_name = $(this).attr("name");
				var this_val = $(this).val();
				var this_f_no = this_name.replace(/.+\[(\d+)\]/, "$1");
			
				//実数入力欄のクリック
				if(this_name.match(/f_price_rerent\[\d+\]/))
				{
					if(this_val >= 100)
						alert("入力された更新料の数値が大きいです。誤っていないか確認して下さい。");
					
					if(this_val > 0)
					{
						$("input[name='f_price_rerent_exist[" + this_f_no + "]']").each(function(){
							$(this).attr("checked", false);
						});
					}
				}
				
				//未定・相談のクリック
				if(this_name.match(/f_price_rerent_exist\[\d+\]/) )
				{
					if(this_val < 0)
						$("input[name='f_price_rerent[" + this_f_no + "]']").val("");
				}
				
			});
			
			//契約期間のクリック
			$(".regloan_flag").blur(function(){
			
				var this_name = $(this).attr("name");
				var this_val = $(this).val();
				var this_f_no = this_name.replace(/.+\[(\d+)\]/, "$1");
			
				//実数入力欄のクリック
				if(this_name.match(/f_regloan_year\[\d+\]/))
				{
					if(this_val >= 100)
						alert("入力された契約期間の数値が大きいです。誤っていないか確認して下さい。");
					
				}

				
			});			
			
			
			loading("off");
		
		});						
	}
	
	
	//一括更新ダイアログの更新
	function submit_floor_info_all_update_dialog()
	{
		var str = $("form[name=floor_info_all_update_dialog]").serialize();
		var b_no = $("input[name=b_no]").val();
		
		$.post("/ajax/dialog.php", {ajax:1, submit_floor_info_all_update_dialog:1, params:str } , function(data){
		
			if(data.match(/done/))
			{
				alert("フロア情報の更新を行いました。\n続けてオーナー・業者情報のインプットダイアログを表示します。");
				show_buil_management_history_add_dialog(b_no, 0);
			}
		
		});
	
	}
	
	function floor_info_all_update_dialog_update_price_zeinuki(f_no)
	{
		if(window.confirm('料金関連の値を税抜に換算します。よろしいですか？'))
		{
			var zei = 1.05;
			
			var t = $("input[name='f_price_t_rent[" + f_no + "]']");
			t.val(Math.round(t.val() / zei));

			var t = $("input[name='f_price_a_rent[" + f_no + "]']");
			t.val(Math.round(t.val() / zei));
			
			var t = $("input[name='f_price_t_mente[" + f_no + "]']");
			t.val(Math.round(t.val() / zei));
			
			var t = $("input[name='f_price_a_mente[" + f_no + "]']");
			t.val(Math.round(t.val() / zei));
			
			alert("賃料・共益費を税抜に換算しました。");

			return true;
		}
		else
		{
			return false;
		}
	}
	
	//問題のある図面・写真の連絡フォーム
	function show_photo_error_alert_form_dialog(buil_info, name)
	{
		$.get("/ajax/dialog.php", {show_photo_error_alert_form_dialog:1, buil_info:buil_info, name:name }, function(data){
		

			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 652,
				resizable:false,
				title:"問題のある写真・図面の連絡",
				buttons: {
				}
			});
			
		
		});					
	
	}
	//DUNG
	//2014/01/13
	//Officenet add text Show dialog and Submit data
	function show_officenet_add_text(thumb_image,f_id)
	{
		$.get("/ajax/dialog.php", {show_officenet_add_text:1, f_id:f_id,thumb_image:thumb_image}, function(data){

			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 420,
				resizable:false,
				title:"写真コメントの編集",
				buttons: {
				}
			});
			
		
		});		
		
	}
	/*
	***DUNGNGUYEN 20141001
	*** page 300
	*/
	//for page 300.php
	function submit_buil_facility_flag_dialog_300(b_no,bip_id)
	{
		var str = $("form[name=buil_facility_flag_dialog]").serialize();
		
		$.ajax({
			  type: "POST",
			  url: "/data_input/300.php",
			  data:  {postmode:"buil_facility_flag", params:str},
			  success: function(data)
			  {
				//成功の場合
					if(data.match(/done./))
					{
						alert("設備・環境に関する情報の更新が行われました。情報を再読み込みします");
						window.location.href = "/data_input/300.php?b_no="+b_no+"&bip_id="+bip_id;
					}
					//エラーの場合
					else
					{
						alert(data);
					}
			  }
			});
	}
	function show_officenet_add_text_300(thumb_image,f_id)
	{
		$.ajax({
			  type: "GET",
			  url: "/ajax/dialog.php",
			  data:  {show_officenet_add_text_300:1, f_id:f_id,thumb_image:thumb_image},
			  success: function(data)
			  {
				  $(".popup_gal").remove();	//他のダイアログを消去
					$("body").append(data);

					$('.popup_gal').dialog({
						height: 285,
						width: 430,
						modal: true,
					    resizable: false,
					    title:"写真コメントの編集",
						dialogClass: 'custom_dialog_gallery'
					});
			  }
			});
	}
	
	//add text for inner building 
	function show_officenet_add_text_writer(thumb_image,f_id)
	{
		$.ajax({
			  type: "GET",
			  url: "/ajax/dialog.php",
			  data:  {show_officenet_add_text_writer:1, f_id:f_id,thumb_image:thumb_image},
			  success: function(data)
			  {
				  $(".dialog").remove();	//他のダイアログを消去
					$("body").append(data);
						
					$(".dialog").dialog({
						autoOpen: true,
						width: 420,
						resizable:false,
						title:"写真コメントの編集",
						buttons: {
						}
					});
			  }
			});
	}
	
	
	
	
	function show_floor_drawing_add_text_300(thumb_image,fd_id,b_no)
	{
		
		$.ajax({
			  type: "GET",
			  url: "/ajax/dialog.php",
			  data:  {show_floor_drawing_add_text_300:1,b_no:b_no,fd_id:fd_id,thumb_image:thumb_image},
			  success: function(data)
			  {
				  $(".popup_gal").remove();	//他のダイアログを消去
					$("body").append(data);

					$('.popup_gal').dialog({
						height: 285,
						width: 430,
						modal: true,
					    resizable: false,
					    title:"写真コメントの編集",
						dialogClass: 'custom_dialog_gallery'
					});
			  }
			});
	}
	
	function submit_floor_drawing_add_text_300(fd_id)
	{
		var b_no = $("input[name=b_no]").val();
		var text_edit = $("textarea[name=text_edit]").val();
		
		$("#drawing_text_"+fd_id).html(text_edit);
		
		$("p#main_show_text").html(text_edit);
		
		$.ajax({
			  type: "POST",
			  url: "/ajax/dialog.php",
			  data:  {submit_floor_drawing_add_text_300:1,b_no:b_no,text_edit:text_edit, fd_id:fd_id},
			  success: function(data)
			  {
				  if(data.match(/done/))
					{
						if(text_edit == "")
						{
							alert("写真コメントを消しました。");
						}
						else
						{
							alert("コメントの登録が完了しました。");
						}
						
						$(".popup_gal").remove();	
						$(".dialog").remove();
					}
					else
					{
						$("textarea[name=text_edit]").focus();
						$("#drawing_text_"+fd_id).html("");
					}
			  }
			});
	}
	
	function submit_officenet_add_text()
	{
		var f_id = $("input[name=f_id]").val();
		var tmp = $("input[name=tmp]").val();
		var text_edit = $("textarea[name=text_edit]").val();
		
		$("#showext_"+tmp).html(text_edit);
		
		$.ajax({
			  type: "POST",
			  url: "/ajax/dialog.php",
			  data:  {submit_officenet_add_text:1,text_edit:text_edit, f_id:f_id},
			  success: function(data)
			  {
				   if(data.match(/done/))
					{
						if(text_edit == "")
						{
							alert("写真コメントを消しました。");
						}
						else
						{
							alert("コメントの登録が完了しました。");
						}
						$(".popup_gal").remove();	
						$(".dialog").remove();	
					}
					else
					{
						$("textarea[name=text_edit]").focus();
					}
			  }
			});
	}
	//END DUNG
	
	//Add text for page writer
	function submit_officenet_add_text_writer()
	{
		var f_id = $("input[name=f_id]").val();
		var tmp = $("input[name=tmp]").val();
		var text_edit = $("textarea[name=text_edit]").val();
		
		//assign text for image comment
		$("#showext_"+tmp).html(text_edit);
		
		//assign text for image large comment
		$("p#main_show_text").text(text_edit);
		
		$.ajax({
			  type: "POST",
			  url: "/ajax/dialog.php",
			  data:  {submit_officenet_add_text:1,text_edit:text_edit, f_id:f_id},
			  success: function(data)
			  {
				   if(data.match(/done/))
					{
						if(text_edit == "")
						{
							alert("写真コメントを消しました。");
						}
						else
						{
							alert("コメントの登録が完了しました。");
						}
						$(".dialog").remove();	
					}
					else
					{
						$("textarea[name=text_edit]").focus();
					}
			  }
			});
	}
	
	function show_floor_drawing_add_text_writer(thumb_image,fd_id,b_no)
	{
		
		$.ajax({
			  type: "GET",
			  url: "/ajax/dialog.php",
			  data:  {show_floor_drawing_add_text_writer:1,b_no:b_no,fd_id:fd_id,thumb_image:thumb_image},
			  success: function(data)
			  {
				  $(".dialog").remove();	//他のダイアログを消去
					$("body").append(data);
						
					$(".dialog").dialog({
						autoOpen: true,
						width: 420,
						resizable:false,
						title:"写真コメントの編集",
						buttons: {
						}
					});
			  }
			});
	}
	
	
	//DUNG
	//2014/01/15
	//Multi language with name, address of building
	function show_building_edit_language(b_no)
	{
		$.ajax({
			beforeSend: function(x) {
				             if(x && x.overrideMimeType) {
				              x.overrideMimeType("text/plain;charset=UTF-8");
				             }
			},
	        type: "POST",
	        url: "/ajax/dialog.php",
	        data: {show_building_edit_language: '1', b_no: b_no},
	        success: function(data){
	        	$(".dialog").remove();	//他のダイアログを消去
				$("body").append(data);

				$(".dialog").dialog({
					autoOpen: true,
					width: 652,
					resizable:false,
					title:"ビル名・住所の編集",
					buttons: {
					}
				});
	        }
		});
	}
	//Transate japan to other language
	function submit_japan_to_all(b_no)
	{
		var b_nm_tran = $("input[name=name_0]").val();
		var b_add_tran = $("input[name=add_0]").val();
		if(b_nm_tran != "" || b_add_tran!="" )
			{
				$("div#show_status").show();
				$.ajax({
					beforeSend: function(x) {
						             if(x && x.overrideMimeType) {
						              x.overrideMimeType("text/plain;charset=UTF-8");
						             }
					},
			        type: "POST",
			        url: "/ajax/dialog.php",
			        data: {submit_japan_to_all: '1', b_no: b_no,b_nm_tran:b_nm_tran, b_add_tran:b_add_tran},
			        success: function(data)
			        {
			        	$("div#show_status").hide();
			        	if(data != "")
			        		{
					        	alert("ビル名と住所を他の言語に翻訳しました。");
								$("div#show_tran_all").html(data);
								$("input[name=name_0]").focus();
			        		}
			        	else
			        		{
			        		    $("input[name=name_0]").focus();
			        		}
			        }
				});
			}
		else
			{
				alert("情報の入力を確認してください。");
				$("input[name=name_0]").focus();
			}
	}
	//Translate english to other language
	function submit_eng_to_all(b_no)
	{
		var b_nm_tran = $("input[name=name_1]").val();
		var b_add_tran = $("input[name=add_1]").val();
		if(b_nm_tran != "" || b_add_tran != "")
			{
				$("div#show_status").show();
				$.ajax({
					beforeSend: function(x) {
						             if(x && x.overrideMimeType) {
						              x.overrideMimeType("text/plain;charset=UTF-8");
						             }
					},
			        type: "POST",
			        url: "/ajax/dialog.php",
			        data: {submit_eng_to_all: '1', b_no: b_no,b_nm_tran:b_nm_tran, b_add_tran:b_add_tran},
			        success: function(data)
			        {
			        	$("div#show_status").hide();
			        	if(data != "")
			        		{
					        	alert("ビル名と住所を他の言語に翻訳しました。");
								$("div#eng_to_all").html(data);
								$("input[name=name_1]").focus();
			        		}
			        	else
			        		{
			        			$("input[name=name_1]").focus();
			        		}
			        }
				});
			}
		else
			{
				alert("情報の入力を確認してください。");
				$("input[name=name_1]").focus();
			}
	}
	//Save data language
	function submit_save_translate(b_no)
	{
		var b_name_m_buil = $("input[name=name_0]").val();
		 var b_add_m_buil = $("input[name=add_0]").val();
		var b_name_tr = "";
		var b_add_tr = "";
		for (var i=1;i<10;i++)
		{ 
			b_name_tr +=  $("input[name=name_"+i+"]").val()+"az,";
			b_add_tr +=  $("input[name=add_"+i+"]").val()+"az,";
		}
//		var str = $("form[name=form_translate_languge]").serialize();
		if(b_name_m_buil != "" || b_add_m_buil != "")
			{
				$.post("/ajax/dialog.php", {submit_save_translate:1,b_no:b_no, b_name_m_buil:b_name_m_buil , b_add_m_buil: b_add_m_buil , b_name_tr:b_name_tr, b_add_tr:b_add_tr } , function(data){
					if(data.match(/done/))
					{
						alert("ビルの翻訳が完了しました。");
						$(".dialog").remove();	
						location.reload();
					}
					else
					{
						$("input[name=name_1]").focus();
					}
				});
			}
		else
			{
				alert("情報の入力を確認してください。");
			}
	}
	//AND DUNG
	
	
	//図面の取り寄せダイアログ
	function show_drawing_order_regist_dialog(b_no)
	{
		$.get("/ajax/dialog.php", {show_drawing_order_regist_dialog:1, b_no:b_no }, function(data){

			$(".dialog").remove();	//他のダイアログを消去
			$("body").append(data);

			$(".dialog").dialog({
				autoOpen: true,
				width: 420,
				resizable:false,
				title:"図面の取り寄せの登録",
				buttons: {
				}
			});
			
		
		});						
	}
	
	//図面の取り寄せダイアログのサブミット
	function submit_drawing_order_regist_dialog()
	{

		var str = $("form[name=drawing_order_regist]").serialize();
		var b_no = $("input[name=b_no]").val();
		
		$.post("/ajax/dialog.php", {ajax:1, submit_drawing_order_regist_dialog:1, params:str } , function(data){
		
			if(data.match(/done/))
			{
				alert("図面の取り寄せを登録しました。\n図面の到着後、取り寄せ一覧画面から「到着済み」の設定を行って下さい。");
				location.reload();
			}
			else
			{
				alert(data);
			}
		
		});
	
	
	}
	
	function load_search_result(build_no)
	{
		var search_key;
		loading("on");
		if(!build_no){
			var s_buil_name = $("#form_search_pop textarea#s_buil_name").val();
			var s_address = $("#form_search_pop textarea#s_address").val();
			var s_build_id = $("#form_search_pop input#s_build_id").val();
			if(s_build_id.length > 0)
				search_key = s_build_id;
			if(s_address.length > 0)
				search_key = s_address;
			if(s_buil_name.length > 0)
				search_key = s_buil_name;
			if(search_keywork != search_key ){
				search_keywork = search_key;
				$.post("/ajax/dialog.php", {ajax:1, get_floorinfo:1, buil_search_fl:1, s_buil_name:s_buil_name , s_address:s_address , s_build_id:s_build_id}, function(data){
					if(!data || data == '')
						$("div.msg_alert").html("この条件では物件が見つかりませんでした。");
					else{
						$("div.msg_alert").html("");
						$("ul.bd_list").append(data);
					}
				});
			}
		}else if(build_no){
			search_keywork = build_no;
			$.post("/ajax/dialog.php", {ajax:1, get_floorinfo:1, buil_search_fl:1, s_buil_name:s_buil_name , s_address:s_address , s_build_id:build_no}, function(data){
				if(!data || data == '')
					$("div.msg_alert").html("この条件では物件が見つかりませんでした。");
				else{
					$("div.msg_alert").html("");
					$("ul.bd_list").append(data);
				}
			});
		}
		loading("off");	
	
	}
	//DUNG NGUYEN 
	//2014/01/21
	//Save data in file builcorp_detail.php
	function save_builcorp_detail()
	{
		var b_no_array = [];
	    $('input:checkbox[name^=ck_]:checked').each(function(index,object){
	        b_no_array[index] = $(this).val();
	    });
	    if(b_no_array.length > 0)
	    	{
		    	$.post("/ajax/dialog.php", {save_builcorp_detail:1,b_no_array:b_no_array } , function(data){
					if(data.match(/done/))
					{
						alert("全て満室にしました。");
						location.reload();
					}
					else
					{
						alert(data);
					}
				
				});
	    	
	    	}
	    else
	    	{
	    		alert("ビルにチェックを入れてください。");
	    	
	    	}
	}
	//AND DUNG
	function owner_popup()
	{
		$('[name="os_type"]' ).live( "click", function() {
			if($(this).val() == 1)
			{
				$( "#oi_status4" ).hide();
				$( "#uploadpdf" ).show();
				$( "#oi_status1" ).hide();
				$( "#oi_status2" ).hide();
			}
			else if($(this).val() == 2)
			{
				$( "#oi_status4" ).hide();
				$( "#uploadpdf" ).hide();
				$( "#oi_status1" ).show();
				 $( "#oi_status2" ).hide();
			}
			else if($(this).val()==3)
			{
				$( "#oi_status4" ).hide();
				$( "#uploadpdf" ).hide();
				$( "#oi_status1" ).hide();
				$( "#oi_status2" ).show();
			}
			else if($(this).val()==4)
			{
				$( "#uploadpdf" ).hide();
				$( "#oi_status1" ).hide();
				$( "#oi_status2" ).hide();
				$( "#oi_status4" ).show();
			}
			else
			{
				$( "#uploadpdf" ).hide();
				$( "#oi_status1" ).hide();
				$( "#oi_status2" ).hide();
				$( "#oi_status4" ).hide();
			}
		});
	
		$( "#date_time" ).live( "focus", function() {
		    $( this ).datepicker();
		});
	}
	
	$(function() {
		$("select#b_ev_num").live('change',function(e) {
            if($(this).val() != "")
            	$('input:radio[name=b_ev_exist][value=1]').attr('checked', true);
            else
            	$('input:radio[name=b_ev_exist][value=2]').attr('checked', true);
		});
		$("td.dw_num select").change(function() {
			$(this).css("background-color", $(this).find("option:selected").css("background-color"));
		});
	});

	var owner_data;
	
	function owserch()
	{
		var target_word = $('#owner_search').val();
		var b_no = $('#owner_search_b_no').val();
		
		if(target_word != "")
		{
			$.get(
				"ajax_owner_search.php", 
				{ owner: target_word, b_no: b_no },
				function(data)
				{
					target_data = String(data);
					target_data = target_data.split("//");
					
					var i;
					
					if(target_data.length <= 1)
					{
						var text = "業者が見つかりませんでした。必要に応じ追加して下さい。";
					}
					else
					{
						var text = "<select id='o_id' name='o_id' onchange='owselect()'><option value=''>選択</option>";
						for(i = 0; i <= target_data.length - 2; i++)
						{
							var co_data = target_data[i].split("@");
							
							text += "<option value='" + co_data[0] + "'>" + co_data[0] + "：" + co_data[1] + "</option>\n";
						}
					
						text += "</select>\n";
					}
					
					$("#owner_id_select").html(text);
										
				}
			);	
		}
	}
	
	//オーナーID
	function owselect()
	{
		var target_word = $('#o_id').val();
		var b_no = $('#owner_search_b_no').val();
		
		if(target_word != "")
		{
			$.get(
				"ajax_owner_search.php", 
				{ owner: target_word, b_no:b_no },
				function(data)
				{
					var co_data = data.split("@");
					$("#bo_name").val(co_data[1]);
					$("#bo_tel1").val(co_data[3]);
					$('#bo_type').val(co_data[4]);
					$('#bo_rep1').val(co_data[5]);
					$('#bo_rep2').val(co_data[6]);
					$('#bo_contract').val(co_data[8]);
					
					//手数料
					if(co_data[7] > 0 || co_data[7] < 0 || co_data[7] == 0)
					{
						$("input[name=bo_fee]").val(co_data[7]);
					}
					else
					{
						$("input[name=bo_fee_ex][value=co_data[7]]").attr({ checked: "checked" });
					}
					
					check_torihiki_keitai();
					
				}
			);	
		}
	}
	
	//取引形態の表示
	//種別が業者の場合だけ表示させる
	function check_torihiki_keitai()
	{
		var value = $("select[name=bo_type]").val();
		
		//業者
		if(value == 4 || value == 2 || value == 9 || value == 3)
		{
			/*
				4 : 仲介業者
				2 : 管理会社
				9 : PM
				3 : ゼネコン
			*/
			//$("select[name=bo_contract]").val("");
			
		}
		//貸し主
		else if(value == 1 || value == 6 || value == 7 || value == 8) 
		{
			//$(".torihiki_keitai").hide();
			$("select[name=bo_contract]").val("4");
		}
		else
		{
			$("select[name=bo_contract]").val("");
		}
		
		return true;
	
	}
	
	function formcheck()
	{
		if(window.confirm('本当に実行してよろしいですか？'))
		{
			return true; // 「OK」時は送信を実行
		}
		else
		{
			return false;
		}
	}


	var clicked = false;
	
	function tab_move_check()
	{
		if(clicked == true)
		{
			alert("データを保存しないままタブを切り替えようとしています。\nデータを編集した場合、保存ボタンを押して下さい。");
			clicked = false;
		}
		
		return true;
	}
	
	function tab_clicked()
	{
		clicked = true;
		return true;
	}
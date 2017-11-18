
	function number_format(num) {
	  return num.toString().replace(/([0-9]+?)(?=(?:[0-9]{3})+$)/g , '$1,')
	}

	//==========================================================
	//フロア一括更新2013年版
	//==========================================================
	var list_f_no_click_7 = new Array();
	var list_f_no_click_2 = new Array();
	var current_edit = "";
	var current_f_no = "";
	var current_edit_col = "";
	
	var last_growl_msg = "";
	
	var price_edit_copy_flag = false;
	
	var field_relation = {'f_price_t_rent_opt': ['f_price_t_rent', 'f_price_a_rent']};
	field_relation['f_price_t_mente_opt'] = ['f_price_t_mente', 'f_price_a_mente'];
	field_relation['f_price_m_shiki_opt'] = ['f_price_m_shiki', 'f_price_t_shiki', 'f_price_a_shiki'];
	field_relation['f_price_keymoney_opt'] = ['f_price_keymoney'];
	field_relation['f_price_rerent_opt'] = ['f_price_rerent'];
	field_relation['f_price_amo_opt'] = ['f_price_amo', 'f_price_amo_flag'];
//	field_relation['f_price_rerent_opt'] = ['f_price_amo_timeflag'];
	
	
	//----------
	//値置き換え一覧
	//----------
	var value_replace_list = new Array();
	
	value_replace_list["f_emp"] = {1:"空", 0:"満"};
	value_replace_list["f_kubun"] = {1:"はい", 0:"いいえ"};
	value_replace_list["f_maisonette_flag"] = {1:"はい", 0:"いいえ"};
	value_replace_list["f_tankigashi_flag"] = {1:"はい", 0:"いいえ"};
	value_replace_list["f_senko_flag"] = {1:"有り", 0:"なし"};
	value_replace_list["f_netgross"] = {1:"ネット", 2:"グロス", 0:"不明"};
	
	value_replace_list["f_price_t_rent_opt"] = {"-1":"未定", "-2":"相談"};
	
	value_replace_list["f_price_t_mente_opt"] = {0:"なし", "-1":"未定", "-2":"相談", "-3":"含む"};
	
	value_replace_list["f_price_m_shiki_opt"] = {"-1":"未定", "-2":"相談", "-3":"なし"};
	
	value_replace_list["f_price_rerent_opt"] = {2:"無し", "-1":"不明", "-2":"未定･相談 "};
	
	value_replace_list["f_price_amo_opt"] = {"-1":"未定", "-2":"相談", "-3":"無し", "-4":"不明", "-5":"スライド式"};
	
	value_replace_list["f_price_keymoney_opt"] = {"2":"無し", "-1":"不明", "-2":"未定･相談"};

	value_replace_list["f_price_rerent_timeflag"] = {1:"現", 2:"新", 0:"未定"};
	value_replace_list["f_price_amo_timeflag"] = {1:"現", 2:"新"};
	
	value_replace_list["f_price_amo_flag"] = {1:"ヶ月", 2:"％", 3:"￥", "-1":"未定", "-2":"相談", "-3":"なし", "-4":"不明", "-5":"ｽﾗｲﾄﾞ式" }
	
	value_replace_list["f_regloan_flag"] = {1:"非定借", 2:"定借", 3:"定借希望"};
	
	value_replace_list["f_purpose"] = {1:"事務所",2:"店舗",3:"ショールーム",5:"倉庫",6:"住居",7:"駐車場",8:"軽飲食",9:"重飲食",10:"医院",
										11:"エステ", 12:"教室", 13:"物販", 14:"レンタルオフィス"};

	value_replace_list["f_air_usetime"] = {0:"不明", 1:"なし", 2:"あり"};
	//value_replace_list["f_regloan_year_check"] = {0:"いいえ", 1:"年数相談"};
    value_replace_list["f_regloan_year_check"] = {1:"年数相談"};

	value_replace_list["f_wc_flag"] = value_replace_list["f_air_usetime"];
	value_replace_list["f_lightline"] = value_replace_list["f_air_usetime"];
	
	value_replace_list["f_floormate"] = {"カーペット":"カーペット", "Pタイル":"Pタイル", "フローリング":"フローリング", "コンクリート":"コンクリート", "たたみ":"たたみ", "不明":"不明" };
	
	value_replace_list["f_air"] = {"個別":"個別", "セントラル":"セントラル", "個別・セントラル":"個・セ", "なし":"なし", "不明":"不明" };

	value_replace_list["f_oa"] = {"非対応":"非対応", "フリーアクセス":"フリーアクセス", "1WAY":"1WAY", "2WAY":"2WAY", "3WAY":"3WAY", "引き込み可":"引き込み可" };
	
	//new 2013/10/28
	value_replace_list["f_bunkatsu"] = {0:"いいえ", 1:"分割例", 2:"分割可"};
	//end

	//----------
	
	//----------
	//テーブル列のクラスリスト
	//----------
	
	var table_row_class_list = {
		"f_no":"fd_e",
		"f_kubun":"fd_a",
		"f_floor":"fd_b",
		"f_roomname":"fd_b",
		"f_emp":"fd_a",
		"f_senko_flag":"fd_a",
		"f_acreg":"fd_c",
		"f_m2":"fd_d",
		"f_bunkatsu" : "fd_d",
		"f_bunkatsu_detail" : "fd_f",
		"f_rentstart":"fd_e",
		"f_akiyotei_date":"fd_e",
		"f_maisonette_flag":"fd_a",
		"f_netgross":"fd_b",
		"f_acreg_net":"fd_b",
		"f_price_t_rent_opt":"fd_d",
		"f_price_t_rent":"fd_d",
		"f_price_a_rent":"fd_d",
		"f_price_t_mente_opt":"fd_d",
		"f_price_t_mente":"fd_d",
		"f_price_a_mente":"fd_d",
		"f_price_m_shiki_opt":"fd_a",
		"f_price_m_shiki":"fd_a",
		"f_price_t_shiki":"fd_d",
		"f_price_a_shiki":"fd_d",
		"f_price_keymoney_opt":"fd_c",
		"f_price_keymoney":"fd_c",
		"f_price_rerent_opt":"fd_c",
		"f_price_rerent":"fd_c",
		"f_price_rerent_timeflag":"fd_c",
		"f_price_amo_opt":"fd_d",
		"f_price_amo":"fd_d",
		"f_price_amo_flag":"fd_a",
		"f_amo_memo":"fd_f",
		"f_price_amo_timeflag":"fd_f",
		"f_rentterm":"fd_a",
		"f_leavenotice":"fd_a",
		"f_lightline":"fd_b",
		"f_floormate":"fd_f",
		"f_eleccapa":"fd_d",
		"f_air":"fd_f",
		"f_air_detail":"fd_f",
		"f_air_usetime":"fd_a",
		"f_oa":"fd_f",
		"f_freac_height":"fd_a",
		"f_height":"fd_d",
		"f_wc_flag":"fd_c",
		"f_regloan_flag":"fd_a",
		"f_regloan_year":"fd_c",
		"f_tankigashi_flag":"fd_a"
	};
	
	function tablefix()
	{
		//縦横のスクロールの設定	
		var pwidth = $(window).width();
		var twidth = (pwidth-30)

		var pheight = $(window).height() - 300;

		$('#tablefix').tablefix({width:twidth,height:pheight,fixRows:1, fixCols: 10});
		
		var cnt = 0;
		
		//----------
		//tablefix によってtableがコピーされることより、動作が重くなる状態を防ぐ処理
		$("table#tablefix").each(function(){
		
			cnt++;
			
			if(cnt <= 2)
			{
				$(this).find("td").attr({"class":"", "col":"", "od":""});
			}
			
			if(cnt == 3)
			{
				$(this).find("td").each(function(){
				
					if($(this).attr("col") == "f_floor")
					{
					}
					else
					{
						//$(this).attr({"class":"", "col":"", "od":""});
					}
				
				});
			}
		
		});
	}

	
	$(function(){

		//テーブルの列のClass設定
		$("th, td").each(function(){
		
			var col = $(this).attr("col");
			if(col != "")
			{
				if(table_row_class_list[col] != undefined)
				{
					$(this).addClass(table_row_class_list[col]);
				}
			}
		
		});
		
		
		//----------
		//★tablefix
		tablefix();

		
		//----------
		

		//空満表示の切り替え
		$("input[name=switch_emp]").click(function(){
			switch_emp_floor($(this).val(), $(this).attr('checked'));
		});
		
		//一括更新ターゲットの全チェックの切り替え
		$("input.mass_update_all_check_switch").click(function(){
		
			if($(this).attr("checked") == "checked")
			{
				$("input.mass_update_target").attr("checked", "checked");
			}
			else
			{
				$("input.mass_update_target").attr("checked", false);			
			}
			
			show_mass_update_button();
		
		});
		
		//----------
		//表示の置き換え （0→いいえ、1→はい のようなかたち）
		$("td.edit").each(function(){
		
			var col = $(this).attr("col");
			var value = $(this).text();
			if(value_replace_list[col] != undefined)
			{
				if(value_replace_list[col][value] != undefined) {
					$(this).text(value_replace_list[col][value]);
				}
			}
			
			//20131118 賃料系の値のコンマ表示
			if(col.match(/price/))
			{
				if(value > 999)
					$(this).text(number_format(value));
			}

		
		});
		
		//----------
		//20131118 区分所有フロアの表示
		$("td[col=f_kubun]").each(function(){
			
			if($(this).text() == "はい")
			{
				$(this).css("background-color", "pink");
			}
			
		});		
		
		//----------
		
		//一括更新対象のTRにClassを付与する
		$("input.mass_update_target").click(function(){
		
			f_no = $(this).val();
			
			if($(this).attr("checked") == "checked")
			{
				$("tr.floorlist[f_no=" + f_no + "]").addClass("massUpdateTarget");	
			}
			else
			{
				$("tr.floorlist[f_no=" + f_no + "]").removeClass("massUpdateTarget");
			}
			
			
			//一括更新反映ボタンの表示
			show_mass_update_button();
		
		});

		//----------
		//入力フォームの準備
		
		$("td.edit").click(function(){
			
			var f_no = $(this).attr("f_no");
			current_f_no = f_no;

			var od = $(this).attr("od");		//元の値
			if(od == undefined)
				od = "";
			
			var col = $(this).attr("col");
			if(col == "f_no")
				return false;
			
			current_edit_col = col;
			
			var this_id = col + f_no;
			current_edit = this_id;
			
			var name = col + "[" + f_no + "]";
			
			//一括更新欄か
			var mass_update_flag = false;
			var mass_update_input_class = "";
			if($(this).hasClass("massupdate"))
			{
				mass_update_flag = true;
				mass_update_input_class = "massupdate";
			}
			
			if($(this).hasClass("edit_on"))
			{
			}
			else
			{	
				//階数の編集だけ特殊
				if(col == "f_floor")
				{
					var tmp = "";
					
					var f_floor_down = $(this).attr("f_floor_down");		//元の値
					var f_floor_up   = $(this).attr("f_floor_up");		//元の値
					
					$(this).html("<input style=\"width:25px\" col='" + col + "' class='instant_edit " + mass_update_input_class + "' type=text name='f_floor_down[" + f_no + "]' value='"+ f_floor_down + "'>" 
							+ " - <input style=\"width:25px\" col='" + col + "' class='instant_edit' type=text name='f_floor_up[" + f_no + "]' value='"+ f_floor_up + "'>");
					$(this).find("input:first-child").select(); //select text in input
				}
				else if(col == 'f_rentstart')// When Col name is 'f_rentstart' do this: Display check box have all days in 5 years and 4 const string "月内","上旬","中旬","下旬" in monthly
				{
					
					var str_html = "<select name='" + name + "' class=\"f_rentstart\" style='width:100px;'> ";
					if($(this).html() == "//" || $(this).html().length == 8)//get value "//" to set for list box
					{
						str_html = str_html + "<option selected value='' >-</option> ";
					}
					else
					{
						str_html = str_html + "<option value='' >-</option> ";
					}
					
					
					if($(this).html() == "即")//get value "即" to set for list box
					{
						str_html = str_html + "<option value=\"即\" selected>即</option> ";
					}
					else
					{
						str_html = str_html + "<option value=\"即\">即</option> ";
					}
					
					if($(this).html() == "相談")//get value "相談" to set for list box
					{
						str_html = str_html + "<option value=\"相談\" selected>相談</option>";
					}
					else
					{
						str_html = str_html + "<option value=\"相談\">相談</option>";
					}
					
					if($(this).html() == "未定")//get value "未定" to set for list box
					{
						str_html = str_html + "<option value=\"未定\" selected>未定</option>";
					}
					else
					{
						str_html = str_html + "<option value=\"未定\">未定</option>";//string html have list of date Select Box
					}
					
					var y = new Date();
					var current_year = y.getFullYear();
					var ar_date = new Array("月内","上旬","中旬","下旬");
					var str_date;
					if($(this).html().length == 8)
					{
						var old_year = $(this).html();
						old_year = old_year.substr(0,4);
						
						
						if(old_year < current_year || old_year > (current_year + 5))
						{
							for(var j = 1; j < 13; j++)// var j is month
							{
								str_html = str_html + "<optgroup label=\"" + old_year + "年" + j + "月\">";
								for (str_date in ar_date)
								{
									if($(this).html() == (old_year + "/" + j + "/" + ar_date[str_date]) )//get value year/month/const_string to set for list box
									{
										str_html = str_html + "<option value=\"" + old_year + "/" + j + "/" + ar_date[str_date] + "\" selected>" + old_year + "/" + j + "/" + ar_date[str_date] + "</option>";
									}
									else
									{
										str_html = str_html + "<option value=\"" + old_year + "/" + j + "/" + ar_date[str_date] + "\">" + old_year + "/" + j + "/" + ar_date[str_date] + "</option>";
									}
									
								}
								
								var d = new Date(old_year, j, 0);// to get total days of the month
								for(var k = 1; k < (d.getDate() + 1) ; k++)
								{
									if($(this).html() == (old_year + "/" + j + "/" + k) )//get value year/month/day to set for list box
									{
										str_html = str_html + "<option value=\"" + old_year + "/" + j + "/" + k + "\" selected>" + old_year + "/" + j + "/" + k + "</option>";
									}
									else
									{
										str_html = str_html + "<option value=\"" + old_year + "/" + j + "/" + k + "\">" + old_year + "/" + j + "/" + k + "</option>";
									}
									
									
									
								}
							}
						}
					}
					
					for(var i = current_year; i < (current_year + 6); i++)// var i is year
					{
						for(var j = 1; j < 13; j++)// var j is month
						{
							str_html = str_html + "<optgroup label=\"" + i + "年" + j + "月\">";
							for (str_date in ar_date)
							{
								if($(this).html() == (i + "/" + j + "/" + ar_date[str_date]) )//get value year/month/const_string to set for list box
								{
									str_html = str_html + "<option value=\"" + i + "/" + j + "/" + ar_date[str_date] + "\" selected>" + i + "/" + j + "/" + ar_date[str_date] + "</option>";
								}
								else
								{
									str_html = str_html + "<option value=\"" + i + "/" + j + "/" + ar_date[str_date] + "\">" + i + "/" + j + "/" + ar_date[str_date] + "</option>";
								}
									
							}
							
							var d = new Date(i, j, 0);// to get total days of the month
							for(var k = 1; k < (d.getDate() + 1) ; k++)
							{
								if($(this).html() == (i + "/" + j + "/" + k) )//get value year/month/day to set for list box
								{
									str_html = str_html + "<option value=\"" + i + "/" + j + "/" + k + "\" selected>" + i + "/" + j + "/" + k + "</option>";
								}
								else
								{
									str_html = str_html + "<option value=\"" + i + "/" + j + "/" + k + "\">" + i + "/" + j + "/" + k + "</option>";
								}
								
								
								
							}
						}
					}
					str_html = str_html + "</select>";
					$(this).html(str_html);//display list box
					
					
				}
				else if(col == "f_update_flag") // Click Checkmark at "Update" column 
				{
					var this_update = $(this).find("img[name=f_update_flag]");
					if (this_update.attr("class") == "f_not_updated") // Checkmark is not shown currently
					{
						// Show checkmark and change status to "updated"
						this_update.removeClass("f_not_updated");
						this_update.addClass("f_updated");
						
						// Set value to hidden tag
						$(this).find("input[name='f_update_flag[]']").val(f_no);
					}
					else // Checkmark is shown currently
					{
						// Hide checkmark and change status to "not updated"
						this_update.removeClass("f_updated");
						this_update.addClass("f_not_updated");
						
						// Reset all values of hidden tags have this f_no 
						$("input[name='f_update_flag[]'][value=" + f_no + "]").each(function() {
							$(this).val(0);
						});
						
						// Uncheck 「全フロアの更新日を本日にする」
						$("input[name=update_all_floor_update_date]").prop("checked", false);
						$("input[name=update_all_floor_update_date]").val(0);
					}
					return;
				}
				else
				{
					$(this).html("<input id='" + this_id + "' style='width:85px' col='" + col + "' f_no='" + f_no + "' class='instant_edit " + mass_update_input_class + "' type=text name='" + name + "' value='"+ od + "'>");
					var ex_sp_list_7 = ["f_price_t_rent_opt", "f_price_t_rent", "f_price_t_mente_opt", "f_price_t_mente", "f_price_t_sum_rm", "f_price_a_mente", "f_price_a_rent", "f_price_a_sum_rm", "f_price_t_shiki", "f_price_a_deposit", "f_price_m_shiki_opt","f_price_m_shiki", "f_price_a_shiki"];
					var ex_sp_list_2 = ["f_acreg", "f_m2"];
					if( ex_sp_list_7.indexOf(col) != -1 )// When columns: "f_price_t_rent", "f_price_t_mente", "f_price_t_sum_rm", "f_price_a_mente", "f_price_a_rent", "f_price_a_sum_rm", "f_price_t_shiki", "f_price_a_deposit", "f_price_m_shiki", "f_price_a_shiki"
					{
						if(list_f_no_click_7.indexOf(f_no)  == -1)// check row have f_no not selected
						{
							list_f_no_click_7.push(f_no);
							$(this).children().select();
							
						}
					}
					else if(ex_sp_list_2.indexOf(col) != -1)// When columns: "f_acreg", "f_m2" 
					{
						if(list_f_no_click_2.indexOf(f_no)  == -1)// check row have f_no not selected
						{
							list_f_no_click_2.push(f_no);
							$(this).find("input").select();
						}
					}
					else
					{
						$(this).children().select();
					}
					
					
				}
			}
			
			$(this).addClass("edit_on");	//tdの中にフォーム表示中を示すクラス
			
			// Show checkmark and change status to "updated"
			var td_update = $("td[f_no=" + f_no + "][col=f_update_flag]");
			td_update.find("img[name=f_update_flag]").removeClass("f_not_updated");
			td_update.find("img[name=f_update_flag]").addClass("f_updated");
			td_update.find("input[name='f_update_flag[]']").val(f_no);
			
			//この列が編集中であることを示すClassを追加
			$("td[col=" + col + "], th[col=" + col + "] ").addClass("col_edit_on");
			
			//inputにフォーカスが当たっていることを示す
			$("input.instant_edit").css("background-color", "white").removeClass("edit_on");
			$(this).find("input.instant_edit").css("background-color", "lemonchiffon").addClass("edit_on");
			
			
			//一括更新反映ボタンの表示
			//DUNG 
			//2014/01/17
			
			$("select.f_rentstart").change(function(){
				if($("select.f_rentstart").parent().hasClass("massupdate") && $("select.f_rentstart").parent().parent().hasClass("all") )
					{
						show_mass_update_button();
					}	
				});
			//End DUNG
			
			$("input.massupdate").blur(function(){
				show_mass_update_button();
			});
			
			
			
			
			//==========================================================
			//種別に応じてコンテキストメニューの内容を書き換え
			var context_sp_menu = $("ul#special_context_menu");

			context_sp_menu.html("");
			var str = "";
			
			if(value_replace_list[col] != undefined)
			{
				for(var i in value_replace_list[col])
					str += "<li class='s' d='" + i + "'>" + value_replace_list[col][i] + "(" + i + ")</li>";
			}
			

			
			if(col == "f_acreg")
				str = "<li  onclick=\"acreg_to_m2();\">坪数を平米に換算して入力";
				
			if(col == "f_m2")
				str = "<li  onclick=\"m2_to_acreg();\">平米を坪に換算して入力";

			if(col == "f_rentstart")
				str = "<li class=s d='即'>即入居";
			
			if(col == "f_price_t_rent" || col == "f_price_a_rent"|| col == "f_price_t_mente"|| col == "f_price_a_mente")
				str += "<hr><li onclick='tax_to_off(8);'>税抜に換算(8%）<li onclick='tax_to_off(5);'>税抜に換算(5%）";

			if(col == "f_floor")
				str = "<li class=hint>ヒント：階数が複数にまたがる場合（1階～2階）の場合、左右両方に入力してください<li class=hint>ヒント：地下の場合はマイナスを入力して下さい（例：地下2階なら「-2」";

			//end 
			if(str != "")
			{
				$("input#" + this_id).addClass("hint_exists");
			}

			str += "<hr><li onclick=\"copy_to_all_floor();\">この値を全フロアにコピー";
			
			if(str != "")
				context_sp_menu.html(str);
		
			$('input.instant_edit').contextMenu('myMenu1', {});
			
			$("li.s").click(function(){
				if(col == "f_purpose") {
					old = $("input#" + current_edit).val();
					oldarr = old.split(",");
					if(oldarr.indexOf($(this).attr("d")) == -1) {
						oldarr.push($(this).attr("d"));						
						$("input#" + current_edit).val(oldarr.toString()).focus();
					}
				} else
					$("input#" + current_edit).val( $(this).attr("d") ).focus();
				$("body").click();
				
				setTimeout(function(){
					$("div#myMenu1").fadeOut();
				}, 1000);
			});
			
			//==========================================================
			
			//特定の項目は、クリックしたら他の項目も一緒に編集可能とする
			if(price_edit_copy_flag == false)
			{
				var sp_list = ["f_price_t_rent_opt", "f_price_t_rent","f_price_t_mente_opt", "f_price_t_mente","f_price_t_sum_rm","f_price_a_mente","f_price_a_rent","f_price_a_sum_rm","f_price_t_shiki","f_price_a_deposit","f_price_m_shiki_opt", "f_price_m_shiki","f_price_a_shiki"];
				
				for(var i in sp_list)
				{
					if(col == sp_list[i])
					{
						for(var j in sp_list)
						{
							var target = $("td[f_no=" + f_no + "][col=" + sp_list[j] + "]:last");
							if(target.hasClass("edit_on"))
							{
							}
							else
							{
								price_edit_copy_flag = true;
								target.click();
							}
						}
					}
				}
				
				//坪数・平米
				if(col == "f_acreg")
				{
					var target = $("td[f_no=" + f_no + "][col=f_m2]:last");
					if(target.hasClass("edit_on") == false)
					{
						target.click().find("input").css({"width":"60px", "margin-left":"20px"});
						
					}	
					
				}

				if(col == "f_m2")
				{
					var target = $("td[f_no=" + f_no + "][col=f_acreg]");
					if(target.hasClass("edit_on") == false)
					{
						target.click();
						$(this).find("input").css({"width":"60px", "margin-left":"20px"});
						$("td[f_no=" + f_no + "][col=f_m2]").find("input").select();
					}	
					
				}
				
				price_edit_copy_flag = false;
			}
			
			//償却は単位も同時に表示
			if(col == "f_price_amo")
			{
				 var target = $("td[f_no=" + f_no + "][col=f_price_amo_flag]:last");
				if(target.hasClass("edit_on"))
				{
				}
				else
				{
					target.click();
				}
				$(this).find("input").select(); //select text in input for column f_price_amo
			}
			
			// check input and set color on click event
			check_floor_input(f_no);
			//==========================================================
			
			//賃料系の自動計算
			
			$(this).find("input.instant_edit").blur(function(){
			
				var row_wraper = $(this).closest('tr');
				var value = $(this).val();
				var od = $(this).parent().attr("od");
				
				/*
				if(value == od)
					return true;
				else
					$(this).parent().attr("od", value);
				*/
				
				var this_f_no = $(this).attr("f_no");
				var this_col = $(this).attr("col");
				
				var growl_msg = "";
				
				$.each(field_relation, function(f_parent, f_childs){
					if (f_parent == this_col)
					{
						$.each(f_childs, function(f_childs, f_child){
							// Clear child fields
							row_wraper.find('input.instant_edit[col="'+f_child+'"]').val('');
						})
					}
					else {
						$.each(f_childs, function(f_childs, f_child){
							if (f_child == this_col)
							{
								// Clear parent field
								row_wraper.find('input.instant_edit[col="'+f_parent+'"]').val('');
								// Break the each loop
								return false;
							}
						})
					}
				})
				
				var this_acreg = $("input[f_no=" + this_f_no + "][col=f_acreg]:last").val();
				if(this_acreg != undefined)
				{
				}
				else
				{
					var this_acreg = $("td[f_no=" + this_f_no + "][col=f_acreg]:last").attr("od");
				}
				
				//賃料単価→総額
				if(this_col == "f_price_t_rent")
				{
					if(value > 0)
					{
						$("input[f_no=" + this_f_no + "][col=f_price_a_rent]:last").val(Math.round(value * this_acreg));
					
					}
					else
						$("input[f_no=" + this_f_no + "][col=f_price_a_rent]:last").val(value);
					
					growl_msg = "賃料坪単価 から 賃料総額 を算出しました。";
					
					//check input data
					//Wrong input: 1潤ｵ4999、もしくは 100000以上
					$(this).removeClass("input_wrong");
					if (isNaN(value) || (value >= 1 && value <= 4999) || value >= 100000)
					{
						$(this).addClass("input_wrong");
					}
				}
				
				//共益費単価→総額
				if(this_col == "f_price_t_mente")
				{
					if(value > 0)
						$("input[f_no=" + this_f_no + "][col=f_price_a_mente]:last").val(Math.round(value * this_acreg));
					else
						$("input[f_no=" + this_f_no + "][col=f_price_a_mente]:last").val(value);

					growl_msg = '共益費坪単価 から 共益費総額 を算出しました。';
					
					//check input data
					//Wrong input: 9999以上
					$(this).removeClass("input_wrong");
					if (isNaN(value) || value >= 9999)
					{
						$(this).addClass("input_wrong");
					}
				}
				
				//賃料総額→単価
				if(this_col == "f_price_a_rent")
				{
					if(value > 0)
						$("input[f_no=" + this_f_no + "][col=f_price_t_rent]:last").val(Math.round(value / this_acreg));
					else
						$("input[f_no=" + this_f_no + "][col=f_price_t_rent]:last").val(value);

					growl_msg = '賃料総額 から 賃料坪単価 を算出しました。';
				}

				//共益費総額→単価
				if(this_col == "f_price_a_mente")
				{
					if(value > 0)
						$("input[f_no=" + this_f_no + "][col=f_price_t_mente]:last").val(Math.round(value / this_acreg));
					else
						$("input[f_no=" + this_f_no + "][col=f_price_t_mente]:last").val(value);

					growl_msg = '共益費総額 から 共益費坪単価 を算出しました。';
				}
				
				//敷金 ヶ月→ 敷金単価・総額
				if(this_col == "f_price_m_shiki")
				{
					var t_rent = $("input[f_no=" + this_f_no + "][col=f_price_t_rent]:last").val();
					var a_rent = $("input[f_no=" + this_f_no + "][col=f_price_a_rent]:last").val();
					
					if(t_rent > 0 && value > 0)
					{
						$("input[f_no=" + this_f_no + "][col=f_price_a_shiki]:last").val(Math.round(a_rent * value));
						$("input[f_no=" + this_f_no + "][col=f_price_t_shiki]:last").val(Math.round(a_rent * value / this_acreg));
					}
					else if(value > 0)
					{
						$("input[f_no=" + this_f_no + "][col=f_price_a_shiki]:last").val(a_rent);
						$("input[f_no=" + this_f_no + "][col=f_price_t_shiki]:last").val(a_rent);
					}
					else
					{
						$("input[f_no=" + this_f_no + "][col=f_price_a_shiki]:last").val(value);
						$("input[f_no=" + this_f_no + "][col=f_price_t_shiki]:last").val(value);
					}

					growl_msg = '敷金ヶ月 から 敷金坪単価・総額 を算出しました。';
					
					//check input data
					//Wrong input: 99以上
					$(this).removeClass("input_wrong");
					if (isNaN(value) || value >= 99)
					{
						$(this).addClass("input_wrong");
					}
				}
				
				//敷金総額 → 敷金ヶ月・単価
				if(this_col == "f_price_a_shiki")
				{
					var t_rent = $("input[f_no=" + this_f_no + "][col=f_price_t_rent]:last").val();
					var a_rent = $("input[f_no=" + this_f_no + "][col=f_price_a_rent]:last").val();
				
					if(t_rent > 0 && value > 0)
					{
						$("input[f_no=" + this_f_no + "][col=f_price_m_shiki]:last").val(value / a_rent);
						$("input[f_no=" + this_f_no + "][col=f_price_t_shiki]:last").val(Math.round(value / this_acreg));
					}
					else if(value > 0)
					{
						$("input[f_no=" + this_f_no + "][col=f_price_m_shiki]:last").val(a_rent);
						$("input[f_no=" + this_f_no + "][col=f_price_t_shiki]:last").val(a_rent);
					}
					else
					{
						$("input[f_no=" + this_f_no + "][col=f_price_m_shiki]:last").val(value);
						$("input[f_no=" + this_f_no + "][col=f_price_t_shiki]:last").val(value);
					}

					growl_msg = '敷金総額 から 敷金ヶ月・総額 を算出しました。';
				}
				
				//坪数・平米数を OD （オリジナルデータ）へ反映
				if(this_col == "f_acreg")
				{
					$(this).parent().attr("od", value);
					$("input[col=f_m2][f_no=" + this_f_no + "]").val((value * 3.3057).toFixed(3));
					growl_msg = '坪数 から 平米数 を算出しました';
					
					//check input data
					//Wrong input: 1以下、1000以上
					$(this).removeClass("input_wrong");
					if (isNaN(value) || value <= 1 || value >= 1000)
					{
						$(this).addClass("input_wrong");
					}
				}

				if(this_col == "f_m2")
				{
					$(this).parent().attr("od", value);
					$("input[col=f_acreg][f_no=" + this_f_no + "]").val((value / 3.3057).toFixed(2));
					growl_msg = '平米数 から 坪数 を算出しました';
				}
				
				if (this_col == "f_floor")
				{
					// get f_no from <td> tag
					this_f_no = $(this).parent().attr("f_no");
				}
				// check input and set color on blur event
				if (! check_floor_input(this_f_no) && this_col == "f_floor")
				{
					growl_msg = '正しい階数を入力して下さい。';
				}
				
				if(growl_msg != last_growl_msg && growl_msg != "" )
					$.jGrowl(growl_msg);
					
				if(growl_msg != "")
					last_growl_msg = growl_msg;		//同じメッセージの連続表示を防ぐ処理
				
			})
			.hover(function(){
				
				//右クリックがスムーズに動作するよう、input の上にカーソルが当たったらクリックさせる
				if($(this).hasClass("edit_on") == false)
					$(this).click();
			});
			
			$("input[col=f_senko_check_datetime]").datepicker();
		});
		
		//更新したら、業者情報更新ダイアログを表示
		if(upd_floor_done > 0)
		{
			show_buil_management_history_add_dialog(b_no, 0);
		}
		
		// 全フロアの更新日を本日にする
		$("input[name=update_all_floor_update_date]").click(function() {
			if ($(this).prop("checked") == true)
			{
				// Show all checkmark and change status to "updated"
				$("img[name=f_update_flag]").removeClass("f_not_updated");
				$("img[name=f_update_flag]").addClass("f_updated");
				$(this).val(1);
				
				// add f_no to value of hidden tags
				$("td[col='f_update_flag']").each(function() {
					$(this).find("input[name='f_update_flag[]']").val($(this).attr("f_no"));
				});
			}
			else // uncheck
			{
				// Hide all checkmark and change status to "not updated"
				$("img[name=f_update_flag]").removeClass("f_updated");
				$("img[name=f_update_flag]").addClass("f_not_updated");
				$(this).val(0);
				
				// clear value of hidden tags
				$("input[name='f_update_flag[]']").val(0);
			}
		});
		
	});

	//purpose, add new value to original item.
	function purpose(newvalue)
	{
		var this_val = $("input#" + current_edit).val();
		
		$("input#" + current_edit).val(this_val + "," + newvalue);
		console.log(current_edit, this_val, newvalue);
	}
	
	//坪数→平米換算
	function acreg_to_m2()
	{
		var this_val = $("input#" + current_edit).val() - 0;
		
		$("td[f_no=" + current_f_no + "][col=f_m2]").click();
		$("input[col=f_m2][f_no=" + current_f_no + "]").val((this_val * 3.3057).toFixed(3));

		$.jGrowl('坪数から平米数を算出しました');
		
	}

	//坪数→平米換算
	function m2_to_acreg()
	{
		var this_val = $("input#" + current_edit).val() - 0;
		
		$("td[f_no=" + current_f_no + "][col=f_acreg]").click();
		$("input[col=f_acreg][f_no=" + current_f_no + "]").val((this_val / 3.3057).toFixed(2));
		
		$.jGrowl('平米数から坪数を算出しました');

	}
	
	//税抜き
	function tax_to_off(parsentage)
	{
		//20140401 消費税8%への対応
		var tax_parsentage = 1 + 0.01 * parsentage;
	
		var this_val = $("input#" + current_edit).val() - 0;
		$("input#" + current_edit).val(Math.round(this_val / tax_parsentage)).click().blur().click();

		$.jGrowl('税抜きに変換しました。');

	}
	
	//全フロアへのコピー
	function copy_to_all_floor()
	{
		var this_val = $("input#" + current_edit).val();
		
		if (confirm('本気ですか ？')) {
			$("td[col=" + current_edit_col + "]").each(function(){
			
				if($(this).hasClass("massupdate"))
				{
				}
				else
				{
					$(this).click();	
					$(this).find("input").val(this_val).blur();
				
					/*
					var this_f_no = $(this).attr("f_no");
					var name = current_edit_col + "[" + this_f_no + "]";
					var this_id = current_edit_col + this_f_no;
					
					$(this).html("<input id='" + this_id + "' style='width:85px' class='instant_edit' type=text name=" + name + " value='"+ this_val + "'>");
					*/
				}		
			});
			$("body").click();
		}
	}
	
	//空満表示の切り替え
	function switch_emp_floor(value, check_status)
	{
		$("tr.floorlist").show();
		
		if (check_status == 'checked')
		{
			if(value >= 1)
			{
				//空室を表示
				$("tr.floorlist[f_emp=0]").hide();
				$("input[name=switch_emp][value='0']").prop('checked', false);
			}
			else if(value == 0)
			{
				//満室を表示
				$("tr.floorlist[f_emp=1]").hide();
				$("input[name=switch_emp][value='1']").prop('checked', false);
			}
		}
		else {
			$("tr.floorlist[f_emp=0]").show();
			$("tr.floorlist[f_emp=1]").show();
		}
	}
	
	//一括更新ボタンの表示
	function show_mass_update_button()
	{
		var target_checked = false;
		var field_exists   = false;
		//対象フロアがチェック済みか
		$("input.mass_update_target:checked").each(function(){
			target_checked = true;
		});
		
		//項目が設定されているか
		$("input.massupdate").each(function(){
			field_exists   = true;
		});
		//DUNG
		//2014/01/17 
		//When change select box
		$("select.f_rentstart").each(function(){
			if($("select.f_rentstart").parent().hasClass("massupdate") && $("select.f_rentstart").parent().parent().hasClass("all")  )
				{
					field_exists   = true;
				}
		});
		//END DUNG
		
		if(target_checked == true && field_exists == true)
		{
			$("td#massUpdateTitle").html("<input type=\"button\" onclick=\"run_mass_update();\" style=\"padding:3px; background-color:red; color:white;\" value=\"一括更新の反映\">");
			$.jGrowl("[一括更新の反映]ボタンを押すと、各フロアに反映されます。");
		}
		else
		{
			$("td#massUpdateTitle").text("一括更新欄");
		}
	
	}
	
	//一括更新の実施
	function run_mass_update()
	{
		//対象のフロアの取得
		target_floor_list = new Array();
		$("input.mass_update_target:checked").each(function(){
			target_floor_list.push($(this).val());
		});
		
		//反映
		$("input.massupdate").each(function(){
			var value = $(this).val();
			var current_edit_col = $(this).attr("col");
			for(var i in target_floor_list)
			{
				target_f_no = target_floor_list[i];
				
				var target_obj = $("td[col=" + current_edit_col + "][f_no=" + target_f_no + "]");
				
				target_obj.click();
				target_obj.find("input").val(value).blur();
			}
		});
		//DUNG NGUYEN 
		//2014/01/17
		$("select.f_rentstart").each(function(){
			var value = $(this).val();
			var current_edit_col = $(this).attr("class");
			for(var i in target_floor_list)
			{
				target_f_no = target_floor_list[i];
				
				var target_obj = $("td[col=" + current_edit_col + "][f_no=" + target_f_no + "]");
				
				target_obj.click();
				target_obj.find("select").val(value).blur();
			}
		});
		//END DUNG
		
		$("body").click();
		remove_mass_update_show();
		
		//メッセージの表示
		$.jGrowl("一括更新を反映しました。");
		
		return true;
	}
	
	//一括更新関連の表示の解除
	function remove_mass_update_show()
	{
		//チェックなどの解除
		$("input.mass_update_target:checked").attr("checked", false);
		$("tr.floorlist").removeClass("massUpdateTarget");
		
		$("td.massupdate").text("").removeClass("edit_on").removeClass("col_edit_on");
		$("td#massUpdateTitle").text("一括更新欄");
		
		$("input.mass_update_all_check_switch").attr("checked", false);
	}
	
	
	//==========================================================
	
	//フロアの追加
	function add_floor()
	{
		var add_floor_num = $("input[name=add_floor_num]").val();
		
		if(add_floor_num > 0)
		{
			if(window.confirm("フロアの追加を行います。よろしいですか？"))
			{
				$.get("/index.php?r=floor/insertFloorMass", 
					{ ajax:1, add_floor:1, b_no:b_no, add_floor_num:add_floor_num},
					function(data)
					{
						if(data == "success")
						{
							alert("フロアの追加が完了しました。再更新します。");
							location.href = "/index.php?r=floor/viewFloorMass&id=" + b_no;
							return true;
						}
					}
				);
			}
		}
	}
	
	//フロアのコピー・削除
	function copy_delete_floor()
	{
		var mode = $("input[name=floor_copy_or_delete]:checked").val();
		
		var target_floor_list = "";
		var target_floor_num  = 0;
		
		$("input.mass_update_target:checked").each(function(){
		
			target_floor_num++;
			
			target_floor_list += $(this).val() + ",";
			
		});
		
		if(mode == undefined)
		{
			alert("コピーするか、削除するにチェックを入れて下さい。");
			return false;
		}
		
		if(target_floor_num == 0)
		{
			alert("対象のフロアにチェックを入れて下さい。");
			return false;
		}
		
		//削除
		if(mode == "delete")
		{
			if(window.confirm("チェックされたフロアを削除します。これはやり直しは出来ません。本当によろしいですか？"))
			{
				$.get("/index.php?r=floor/deleteFloorMass", 
					{ ajax:1, delete_floor:1, b_no:b_no, delete_floor_list:target_floor_list},
					function(data)
					{
						console.log(data);
						if(data.trim() == "success")
						{
							alert("フロアの削除が完了しました。再更新します。");
							location.href = "/index.php?r=floor/viewFloorMass&id=" + b_no;
							return true;
						}
					}
				);			
			}
		}

		//コピー
		if(mode == "copy")
		{
			if(target_floor_num >= 2)
			{
				alert("対象のフロアを一つだけチェックして下さい。複数の選択は出来ません。");
				return false;
			}
			
			if(window.confirm("チェックされたフロアをコピーし、新しく登録します。よろしいですか？"))
			{
				$.get("/index.php?r=floor/copyFloorMass", 
					{ ajax:1, copy_floor:1, b_no:b_no, copy_floor:target_floor_list},
					function(data)
					{
						console.log(data);
						if(data.trim() == "success")
						{
							alert("フロアのコピーが完了しました。再更新します。");
							location.href = "/index.php?r=floor/viewFloorMass&id=" + b_no;
							return true;
						}
					}
				);			
			}
		}
	
	}

	/**
	 * @ Check input data of f_floor_down and f_floor_up
	 * @ In case of WRONG DATA: change background color on input into 'pink'
	 * @ WRONG DATA:
	 * @ 1. f_floor_down = 0 or f_floor_up = 0
	 * @ 2. f_floor_down is empty or f_floor_up is empty
	 * 
	 * @returns Boolean
	 * @ true: correct data
	 * @ false: wrong data
	 */
	function check_floor_input(f_no) {
		var result = true;
		
		$("td[col='f_floor']").each(function() // browse all rows (floors)
		{
			var td_f_no = $(this).attr("f_no");
			var numFieldEmpty = 0;
			$(this).find("input.instant_edit").each(function() // f_floor_down <input> tag and f_floor_up <input> tag
			{
				// set default color to all
				if ($(this).hasClass("edit_on")) // editting <input>
				{
					$(this).css("background-color", "lemonchiffon");
				}
				else // others
				{
					$(this).css("background-color", "white");
				}
				
				// check input data and set 'pink' color to error <input>
				if ($(this).val() == null || isNaN($(this).val()) || $(this).val().trim().length == 0 || parseInt($(this).val()) == 0) // wrong data
				{
					numFieldEmpty++;
				}
			});
			
			if (numFieldEmpty == 2)
			{
				$(this).find("input.instant_edit").css("background-color", "pink");
				if (td_f_no == f_no)
				{
					result = false;
				}
			}
		});
		
		return result;
	}
	
	//フォームSubmit時、入力の確認
	function submit_check()
	{
		var error = false;
		
		//初期化
		$("input.instant_edit").removeClass("error_value").removeClass("edit_on");
		
		//各フォームをチェック
		$("input11.instant_edit").each(function(){
		
			var col = $(this).attr("col");
			var f_no = $(this).attr("f_no");
			var value = $(this).val();
			
			//おかしな値が入っていないか
			if(value_replace_list[col] != undefined)
			{
				if(value_replace_list[col][value] == undefined)
				{
					//逸脱した値が入っている場合
					if(col == "f_purpose")
					{
						//用途はbitなので算出不能 ここでは対象外
					}
					else if(col.match(/price/) && value > 0)
					{
						//賃料系は値が入る場合があるので、1以上の場合は対象外
					}
					else if(value == "")
					{
						if(col.match(/price/) || col == "f_emp")
						{
							$(this).addClass("error_value");
							error = true;
						}
						else
						{
							//未入力は対象外
						}
					}
					else
					{
						$(this).addClass("error_value");
						error = true;
					}
				}
			}
			
			//償却の場合、単位が入っているか
			if(col == "f_price_amo")
			{
				var amo_flag_obj = $("input[col=f_price_amo_flag][f_no=" + f_no + "]");
				var amo_flag = amo_flag_obj.val();
				
				if(value > 0 && (amo_flag <= 0 || amo_flag == ""))
				{
					amo_flag_obj.addClass("error_value");
					$.jGrowl('償却に単位が設定されていないものがあります。');
					error = true;
				}
			}
			
			//階数
			// check input data
			if(col == "f_floor")
			{
				if (value == null || isNaN(value) || value.trim().length == 0 || parseInt(value) == 0) // wrong data
				{
					$.jGrowl('正しい階数を入力して下さい。');
					error = true;
				}
			}
		});
		
		if(error == true)
		{
			$.jGrowl('入力に不備のある項目があります。ピンク色の項目を確認して下さい。');
			return false;
		}
		else
		{
			// Remove hidden tags of f_update_flag that are not updated
			$("input[name='f_update_flag[]']").each(function() {
				if ($(this).val() == 0)
				{
					$(this).remove();
				}
			});
		}
	
	}
	

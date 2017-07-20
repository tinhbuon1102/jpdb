
	//==========================================================
	//エラーとなっている画像の処理
	//==========================================================
	

	function EXEC_replace_error_image()
	{
		
		$("img").each(function(){ 
		
			$(this).error(function(){
		
				var this_class = $(this).attr("class");
				var this_src   = $(this).attr("src");
				
				//ビル外観写真なら
				//別の写真の読み込みをトライする

				if(this_class == undefined)
				{
				}
				else if(this_class.match(/img_buil_thumb/))
				{
				
					var new_src = this_src.replace("a-0", "a-2");
					
					$(this).attr("src", new_src).error(function(){
					
						var new_new_src = this_src.replace("a-2", "a-1");
						
						$(this).attr("src", new_new_src).error(function(){
						
							//印刷用ページでは真っ白にする
							if(location.href.match(/print/))
							{
								$(this).attr("src", "/img/spacer.jpg");
							}
							//通常のページでは「No Image」の表示
							else
							{	
								$(this).attr("src", "/img/building_noimage.jpg");
							}
						
						});
					
					});
					
				}
				//一般の画像なら
				//真っ白なjpgに置換する
				else
				{
					//$(this).attr("src", "/img/spacer.jpg");
				
				}
		
			});
			
		});
		
	}
		
	$(function(){
		EXEC_replace_error_image();
	});
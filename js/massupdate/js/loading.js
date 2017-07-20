
	//==========================================================
	//ロ〖ディングの山绩
	//==========================================================
	
	var loading_count = 0;
	
	function loading(mode)
	{
		if(mode == "on")
		{
			var html = "<div id='loading' style=\"position:fixed; display:none; color:#999; opacity:0.8; font-size:11px; top:10px; left:10px; z-index:999; padding:20px; width:150px: height:80px; text-align:center;\"><img src='../css/img/loading_b.gif'><!--<img src=\"/img/loading_ball\.gif\">　粕み哈み面..--></div>";
			
			$("body").prepend(html);
			$("div#loading").fadeIn();
			
			loading_count++;
			
		}
		
		if(mode == "off")
		{
			loading_count--;
			
			if(loading_count <= 0)
				$("div#loading").remove();
		}
	
	}
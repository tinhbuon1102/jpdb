$(function(){
        var total_window=$('#total_window').val();
        var total_owner=$('#total_owner').val();
        //$(".mask_tel").mask('99-9999-9999',{placeholder:"00-0000-0000"});
        total_window=parseInt(total_window);
        total_owner=parseInt(total_owner);
        if(total_window == 0){
           window_tab();
        }
        if(total_owner == 0){
           owner_tab();
        }
       function add_tab(tabtype, count){
       	var tab_classs="";
       	var btn_class="";
       	var own_back="";
        var none=$('#none_radio').val();
        var undecided=$('#undecided_radio').val();
        var ask=$('#ask_radio').val();
        var unknown=$('#unknown_radio').val();
       	var traders_option =$('#traders_option').html();
       	var ownership_type =$('#ownership_type').html();
       	var management_type=$('#management_type').html();
       	if(tabtype=="owner"){
       		tab_classs="bg_blue";
       		own_back="own_back";
       	}
       	else{
            tab_classs="bg_lb";
       	}
       	var tab_id=tabtype+count;
       	var tab ='<div id="'+tab_id+'" count="'+count+'">';
        tab+=    '<input type="hidden" id="update_'+tabtype+count+'" name="update_'+tabtype+count+'" value="0">';
       	tab+=    '<h4 class="ontable '+tab_classs+'">';
        tab+=       '<span id="count_'+tabtype+'_'+count+'">'+count+'.&nbsp;</span>'+tabtype;
	      tab+=	    '<span class="button-right">';
	      tab+=          		'<a id="add_another_window" class="bg_blue '+own_back+' side_button  add_another_'+tabtype+'" href="javascript:void(0)">Add another '+tabtype+'</a>';
	      tab+=        '</span>';
        tab+=   '</h4>';
		    tab+=	'<table class="newform_info ad_list">';
        tab+=       '<tbody>';
        if(tabtype=="owner"){
       	  	
       	  	if(count==1){
                tab += '<tr class="no_border">';
				tab +=		'<th colspan="4" class="bold_td col_3">';
				tab +=			'<input type="checkbox" name="sameinfo"  id="sameinfo" value="sameinfo"> Same as window';
				tab +=        '</th>';
				tab += '</tr>';
             }
			
       	}
        tab+=         '<tr>';
        tab+=           '<th>Trader ID</th>';
        tab+=            '<td><input type="text" name="search_'+tab_id+'" count="'+count+'"  class="search_by_tel mask_tel ty3 searchWindowText" id="search_'+tab_id+'"></td>';
        tab+=           '<th class="btn-cell"><a href="javascript:void(0)"  id="search_tel'+tab_id+'" class="button style_navy search_tel" count="'+count+'" tabtype="'+tabtype+'">Search Trader</a></th>';
        tab+=           '<td>&nbsp;</td>';
        tab+=         '</tr>';
        tab+=         '<tr>';
        tab+=           '<th>&nbsp;</th>';
        tab+=           '<td><select id="trader_search_'+tab_id+'" class="auto trader_search trader_search_'+tabtype+'" name="trder_'+tab_id+'"  count="'+count+'" tabtype="'+tabtype+'" >';
        tab+=         traders_option;
        tab+=          '</select></td>';
        tab+=           '<th>&nbsp;</th>';
        tab+=           '<td>&nbsp;</td>';
        tab+=         '</tr>';
        tab+=         '<tr>';
        tab+=           '<th>Sorts</th>';
        tab+=           '<td>';
        tab+=               '<select name="ownership_type_'+tab_id+'" id="ownership_type_'+tab_id+'" data-role="none" class="window_type" required>';
        tab+=        ownership_type;                         
        tab+=               '</select>';
        tab+=           '</td>';
        tab+=           '<th>Transaction type</th>';
        tab+=           '<td>';
        tab+=             '<select name="management_type_'+tab_id+'" id="management_type_'+tab_id+'" class="management_type_window" data-role="none">';
        tab+=        management_type;				  
	    tab+=			  '</select>';
        tab+=           '</td>';
        tab+=         '</tr>'
        tab+=         '<tr>'
        tab+=           '<th>Company Name</th>';
		tab+=			'<td>';
		tab+=			  '<input type="text" name="company_name_'+tab_id+'" id="company_name_'+tab_id+'" value="" class="ty6 window_company_name" required="">';
		tab+=			'</td>';
		tab+=				'<th>&nbsp;</th>';
        tab+=                '<td>&nbsp;</td>';
        tab+=            '</tr>';
        tab+=              '<tr>';
        tab+=                '<th>TEL</th>';
		tab+=				'<td>';
		tab+=				  '<input type="text" name="tel_'+tab_id+'" id="tel_'+tab_id+'" value="" class="mask_tel ty6 window_tel">';
		tab+=				'</td>';
		tab+=				'<th>FAX</th>';
        tab+=               '<td>'
        tab+=                 '<input type="text" name="fax_'+tab_id+'" id="fax_'+tab_id+'" value="" class="mask_tel ty6 window_fax">';
        tab+=               '</td>';
        tab+=            '</tr>';
        tab+=             '<tr>';
        tab+=               '<th>Person in charge1</th>';
		tab+=				 '<td>';
		tab+=				   '<input type="text" name="person_in_charge1_'+tab_id+'" id="person_in_charge1_'+tab_id+'" value="" class="ty3 person_in_charge1">';
		tab+=				  '</td>';
		tab+=				  '<th>Person in charge2</th>';
	    tab+=                  '<td>';
	    tab+=                   '<input type="text" name="person_in_charge2_'+tab_id+'" id="person_in_charge2_'+tab_id+'" value="" class="ty3 person_in_charge2">';
	    tab+=                  '</td>';
        tab+=             '</tr>';
        if(tabtype=="window"){
	        tab+=             '<tr>';
	        tab+=                 '<th>Fee</th>';
			tab+=				  '<td colspan="3">';
			tab+=					 '<label class="rd2"><input type="radio" name="charge_'+tab_id+'" value="'+unknown+'" class="radiUnknown">'+unknown+'</label>';
			tab+=					 '<label class="rd2"><input type="radio" name="charge_'+tab_id+'" value="'+ask+'" class="radiAsk"> '+ask+'</label>';
			tab+=					 '<label class="rd2"><input type="radio" ;name="charge_'+tab_id+'" value="'+undecided+'" class="radiUndecided"> '+undecided+'</label>'
			tab+=					 '<label class="rd2"><input type="radio" name="charge_'+tab_id+'" value="'+none+'" class="radiNone">'+none+'</label>';
	        tab+=                     '<label class="rd2">| <input type="text" name="change_txt_'+tab_id+'" id="change_txt_'+tab_id+'" size="5" value="" class="ty8 change_txt"></label>';
	        tab+=                  '</td>';
	        tab+=               '</tr>';
        }
         if(tabtype=="owner"){
         	tab+= 	'<tr>';
            tab+=       '<th>Note</th>';
            tab+=        '<td colspan="3" class="col_3">';
            tab+=			'<input type="text" name="note_'+tab_id+'" id="note_'+tab_id+'" value="" class="owner_note_ty">';
            tab+=			'</td>';
            tab+=   '</tr>';

         }
        tab+=            '</tbody>';
        tab+=        '</table>';
        tab+=        '<h4 class="ontable '+tab_classs+' bootom_pad">' 
	    tab+=                    '<span class="button-right">';
	    tab+=                     	'<a id="remove_'+tab_id+'" own_id="0" class="bg_blue side_button ' +own_back+'  remove_'+tabtype+'" href="javascript:void(0)"  div_id="'+tab_id+'" >Remove '+ tabtype+'</a>';
	    tab+=                     '</span>';
	    tab+=                '</h4>';
        tab+=     '</div>';
        return tab;

       }

        function window_tab(){
        	var count=$('#total_window').val();
            count=parseInt(count);
            $('#total_window').val(++count);
        	var tab=add_tab('window' , count);
            $('#window_add').append(tab)
            if(count==1){
            	$('.remove_window').hide();
            }
            else{
               $('.remove_window').show();  
            }
            //$(".mask_tel").mask('99-9999-9999',{placeholder:"00-0000-0000"});
        }
        function owner_tab(){
        	var count=$('#total_owner').val();
            count=parseInt(count);
            $('#total_owner').val(++count);
        	var tab=add_tab('owner' , count);
            $('#add_owner').append(tab);
            if(count==1){
            	$('.remove_owner').hide();
            }
            else{
               $('.remove_owner').show();  
            }
            //$(".mask_tel").mask('999-99999-99999',{placeholder:"00-0000-0000"});
            
        }
        $('#window_add').on( "click", ".add_another_window", function() {
          $("#sameinfo").prop('checked', false);
        	window_tab();
        });

         $('#add_owner').on( "click", ".add_another_owner", function() {
          $("#sameinfo").prop('checked', false);
        	 owner_tab();
        });


        $('#window_add').on( "click", ".remove_window", function() {
          var con= confirm("Are you Sure Delete This record");
          if(!(con)){
            return false;
          }
         
        	var div_id=$(this).attr('div_id');
          var own_id =$(this).attr('own_id');
          own_id >parseInt(own_id);
        	var curr_elem=$('#'+div_id).attr('count');
        	var count_total=$('#total_window').val();
        	count_total=parseInt(count_total);
        	if(count_total < 2){
        		return false;
        	}
          if(own_id > 0){
            remove_db_element(own_id);
          }
        	suff_tab_element(count_total, curr_elem, 'window');
        	$('#'+div_id).remove();
        	$('#total_window').val(count_total-1);
            if(count_total-1==1){
            	$('.remove_window').hide();
            }
            else{
               $('.remove_window').show();  
            }
        	
        });

         $('#add_owner').on( "click", ".remove_owner", function() {
          var con= confirm("Are you Sure Delete This record");
          if(!(con)){
            return false;
          }
          var own_id =$(this).attr('own_id');
          $("#sameinfo").prop('checked', false);
        	var div_id=$(this).attr('div_id');
        	var curr_elem=$('#'+div_id).attr('count');
        	var count_total=$('#total_owner').val();
        	count_total=parseInt(count_total);
        	if(count_total < 2){
        		return false;
        	}
           if(own_id > 0){
            remove_db_element(own_id);
          }
        	suff_tab_element(count_total, curr_elem, 'owner');
        	$('#'+div_id).remove();
        	$('#total_owner').val(count_total-1);
        	if(count_total-1==1){
            	$('.remove_owner').hide();
            }
            else{
               $('.remove_owner').show();  
            }
        	
        });

        function suff_tab_element(total_elememt, curr_elem, ele){
        	total_elememt=parseInt(total_elememt);
        	curr_elem=parseInt(curr_elem);
        	var new_ele="";
        	if(total_elememt > curr_elem){
        		for(var i =curr_elem+1; i<=total_elememt ; i++ ){
        			new_ele= i;
        			new_ele='count_'+ele+'_'+new_ele;
        			$('#'+new_ele).html(i-1+' .');
        			$('#'+new_ele).attr('id', 'count_'+ele+'_'+String(i-1));
        			$('#'+ele+String(i)).attr('count', String(i-1));
        			$('#'+ele+String(i)).attr('id', ele+String(i-1));
              $('#remove_'+ele+String(i)).attr('div_id', ele+String(i-1));
              $('#remove_'+ele+String(i)).attr('id', 'remove_'+ele+String(i-1));
              $('#search_'+ele+String(i)).attr('name', 'search_'+ele+String(i-1));
              $('#search_'+ele+String(i)).attr('count', String(i-1));
              $('#search_'+ele+String(i)).attr('id', 'search_'+ele+String(i-1));
              $('#search_tel'+ele+String(i)).attr('count', String(i-1));
              $('#search_tel'+ele+String(i)).attr('id', 'search_tel'+ele+String(i-1));
              $('#trader_search_'+ele+String(i)).attr('count', String(i-1));
              $('#trader_search_'+ele+String(i)).attr('name', 'trder_'+ele+String(i-1));
              $('#trader_search_'+ele+String(i)).attr('id', 'trader_search_'+ele+String(i-1));
              $('#ownership_type_'+ele+String(i)).attr('name', 'ownership_type_'+ele+String(i-1));
              $('#ownership_type_'+ele+String(i)).attr('id', 'ownership_type_'+ele+String(i-1)); 
              $('#management_type_'+ele+String(i)).attr('name', 'management_type_'+ele+String(i-1));
              $('#management_type_'+ele+String(i)).attr('id', 'management_type_'+ele+String(i-1));
              $('#company_name_'+ele+String(i)).attr('name', 'company_name_'+ele+String(i-1));
              $('#company_name_'+ele+String(i)).attr('id', 'company_name_'+ele+String(i-1));
              $('#tel_'+ele+String(i)).attr('name', 'tel_'+ele+String(i-1));
              $('#tel_'+ele+String(i)).attr('id', 'tel_'+ele+String(i-1));
              $('#fax_'+ele+String(i)).attr('name', 'fax_'+ele+String(i-1));
              $('#fax_'+ele+String(i)).attr('id', 'fax_'+ele+String(i-1));
              $('#person_in_charge1_'+ele+String(i)).attr('name', 'person_in_charge1_'+ele+String(i-1));
              $('#person_in_charge1_'+ele+String(i)).attr('id', 'person_in_charge1_'+ele+String(i-1));
              $('#person_in_charge2_'+ele+String(i)).attr('name', 'person_in_charge2_'+ele+String(i-1));
              $('#person_in_charge2_'+ele+String(i)).attr('id', 'person_in_charge2_'+ele+String(i-1));
              if(ele=="window"){
                 $("input[name=charge_"+ele+String(i)+"]").attr('name', 'charge_'+ele+String(i-1));
                 $('#change_txt_'+ele+String(i)).attr('name', 'change_txt_'+ele+String(i-1));
                 $('#change_txt_'+ele+String(i)).attr('id', 'change_txt_'+ele+String(i-1));
              }
              if(ele=="owner"){
                $('#note_'+ele+String(i)).attr('name', 'note_'+ele+String(i-1));
                $('#note_'+ele+String(i)).attr('id', 'note_'+ele+String(i-1));
              }
              
              
        		}
        	}

        } 

        

        $('#main').on( "change", ".trader_search", function() {
        	var tab = $(this).attr('count');
        	var tabtype = $(this).attr('tabtype');
        	var val = $(this).val();
        	search_trader(val, tabtype, tab);
        });

      

        $('#main').on( "click", ".search_tel", function() {
        	var tab = $(this).attr('count');
        	var tabtype = $(this).attr('tabtype');
        	var val = $('#search_'+tabtype+tab).val();
        	var res= search_trader_tel(val, tabtype, tab);
        });
          
        function search_trader(traders_id, tabtype, tab){
          var baseUrl=$('#base_url').val();
          var build_id=$('#hdnBillId').val();
          var floor_id=$('#hdnFloorId').val();
        	$.ajax({
        		url: baseUrl+'/index.php?r=floor/getSeletectedTraderDetails',
        		type: 'POST',
        		data: {trader: traders_id, build_id:build_id, floor_id:floor_id},
        	})
        	.done(function(res) {
        		if(res != 'blank Request'){
        		update_ajax_fileld(res, tabtype, tab);
        		}
        	})
        	.fail(function() {
        		alert('somthing went wrong');
        	})
        	
        }

        function remove_db_element(own_id){
          var baseUrl = $('#base_url').val();
          $.ajax({
            url: baseUrl+'/index.php?r=floor/delOwnerSingle',
            type: 'POST',
            data: {own_id: own_id},
          })
          .done(function(res) {
            location.reload();
           
          })
          .fail(function() {
            alert('somthing went wrong');

        })
      }
        function search_trader_tel(trader_tel,  tabtype, tab){
          var baseUrl=$('#base_url').val();
          var build_id=$('#hdnBillId').val();
          var floor_id=$('#hdnFloorId').val();

        	$.ajax({
        		url: baseUrl+'/index.php?r=floor/getSeletectedTraderDetails',
        		type: 'POST',
        		data: {trader_tel: trader_tel, build_id:build_id, floor_id:floor_id},
        	})
        	.done(function(res) {
        		if(res != 'blank Request'){
              var res = JSON.parse(res); 
              var option=""
              if(res.status=='success'){
                 $.each( res.traders, function( key, trd ) {
                    option += '<option value="'+trd.trader_id+'">'+trd.traderId+'&nbsp;'+trd.trader_name+'</option>';
                  });
                 alert('Trader Found Please Select Trader');
                  
              }
              else{
                   alert('No Trader Found');
                  option += '<option value="0"> No Trader Found</option>';
              }
              $('#trader_search_'+tabtype+tab).html('');
              $('#trader_search_'+tabtype+tab).html(option);
        		}
            else{
              alert('Field Is blank');
            }
        	})
        	.fail(function() {
        		alert('somthing went wrong');
        	})	
        }

         function update_ajax_fileld(res,  tabtype, tab){
         	 res=JSON.parse(res);
         	 $('#trader_search_'+tabtype+tab).val(res.trader_id);
         	 $('#ownership_type_'+tabtype+tab).val(res.ownership_type);
         	 $('#company_name_'+tabtype+tab).val(res.owner_company_name);
         	 $('#management_type_'+tabtype+tab).val(res.management_type);
         	 $('#tel_'+tabtype+tab).val(res.company_tel);
         	 $('#fax_'+tabtype+tab).val(res.company_fax);
         	 $('#person_in_charge1_'+tabtype+tab).val(res.person_in_charge1);
         	 $('#person_in_charge2_'+tabtype+tab).val(res.person_in_charge2);
         	 if(tabtype='window'){
         	 	 $('#change_txt_'+tabtype+tab).val(res.charge);
             if(res.charge !=""){
                 $("input[name=charge_"+tabtype+tab+"][value=" + res.charge + "]").prop('checked', true);
             }
         	 
         	 }
        	//;
        	
        }

         $('#main').on( "click", "#sameinfo", function() {
            if ($('#sameinfo').is(':checked')) {
              var count=$('#total_owner').val();
               for(var i=2; i<=count; i++){
                $('#owner'+String(i)).remove();
               } 
               var count=$('#total_window').val();
               for(var i=1; i<count; i++){
                owner_tab();
               }
               copy_ele_info();
            }
            else{
               var count=$('#total_owner').val();
                for(var i=2; i<=count; i++){
                $('#owner'+String(i)).remove();
               } 
               clear_owner_data()
            }
         });    


        function copy_ele_info(){
          var count=$('#total_window').val();
               var ele1='window';
               var ele2='owner';
               for(var i=1; i<=count; i++){
                $('#search_'+ele2+String(i)).val($('#search_'+ele1+String(i)).val());
                $('#trader_search_'+ele2+String(i)).val($('#trader_search_'+ele1+String(i)).val());
                $('#ownership_type_'+ele2+String(i)).val($('#ownership_type_'+ele1+String(i)).val());
                $('#management_type_'+ele2+String(i)).val($('#management_type_'+ele1+String(i)).val());
                $('#company_name_'+ele2+String(i)).val($('#company_name_'+ele1+String(i)).val());
                $('#company_name_'+ele2+String(i)).val($('#company_name_'+ele1+String(i)).val());
                $('#tel_'+ele2+String(i)).val($('#tel_'+ele1+String(i)).val());
                $('#fax_'+ele2+String(i)).val($('#fax_'+ele1+String(i)).val());
                $('#person_in_charge1_'+ele2+String(i)).val($('#person_in_charge1_'+ele1+String(i)).val());
                $('#person_in_charge2_'+ele2+String(i)).val($('#person_in_charge2_'+ele1+String(i)).val());
              }
        }

        function clear_owner_data(){
               $('#total_owner').val(1);
               var ele2='owner';
               var i =1;
                $('#search_'+ele2+String(i)).val("");
                $('#trader_search_'+ele2+String(i)).val("");
                $('#ownership_type_'+ele2+String(i)).val("");
                $('#management_type_'+ele2+String(i)).val("");
                $('#company_name_'+ele2+String(i)).val("");
                $('#company_name_'+ele2+String(i)).val("");
                $('#tel_'+ele2+String(i)).val("");
                $('#fax_'+ele2+String(i)).val("");
                $('#person_in_charge1_'+ele2+String(i)).val("");
                $('#person_in_charge2_'+ele2+String(i)).val("");
              
        }

            
          
        
  });

function check_validity(action="normal"){
  var error_count=0;
  var window_count =$('#total_window').val();
  var owner_count =$('#total_owner').val();
  var cname="";
  var tel="";
  var fax="";
  for(var i=1; window_count >= i; i++){
    cname = $('#company_name_window'+i).val();
    tel = $('#tel_window'+i).val();
    fax = $('#fax_window'+i).val();
    if((typeof cname == "undefined")||(cname == "")){
       $('#company_name_window'+i).addClass('error_val');
       error_count++;
     }
     else{
      $('#company_name_window'+i).removeClass('error_val');
     }
    
    // if((typeof tel == "undefined")||(tel == "")||(tel=='000-00000-00000')){
    //    $('#tel_window'+i).addClass('error_val');
    //    error_count++;

    // }
    // else{
    //   $('#tel_window'+i).removeClass('error_val');
    // }
    // if((typeof fax == "undefined")||(fax == "")||(fax=='000-00000-00000')){
    //    $('#fax_window'+i).addClass('error_val');
    //    error_count++;
    // }
    // else{
    //   $('#fax_window'+i).removeClass('error_val');
    // }
    //alert(error_count);
  }
   for(var i=1; owner_count >= i; i++){
    cname = $('#company_name_owner'+i).val();
    tel = $('#tel_owner'+i).val();
    fax = $('#fax_owner'+i).val();
    if((typeof cname == "undefined")||(cname == "")){
       $('#company_name_owner'+i).addClass('error_val');
       error_count++;
    }
    else{
        $('#company_name_owner'+i).removeClass('error_val');
    }
    // if((typeof tel == "undefined")||(tel == "")||(tel=='000-00000-00000')){
    //    $('#tel_owner'+i).addClass('error_val');
    //    error_count++;
    // }
    // else{
    //    $('#tel_owner'+i).removeClass('error_val');
    // }
    // if((typeof fax == "undefined")||(cname == "")||(fax=='000-00000-00000')){
    //    $('#fax_owner'+i).addClass('error_val');
    //    error_count++;
    // }
    // else{
    //   $('#fax_owner'+i).removeClass('error_val');
    // }
  }
  if(error_count>0){
    error_count 
    alert(" please fill all required fields");
    return false;
  }
  else{
    if(action=='bluk_Update'){
      bluk_Update()
    }
    else{
       submit_form();
    }
    
   
  }
  


}
 $(document).on('click','#upadte_floor', function(e){
  check_validity('normal');
 });


  /******************* add new history of management ********************/
  function submit_form(){
    var formdata = $('#frmAddManagementHistoryNew').serialize();
    var url = $('#frmAddManagementHistoryNew').attr('action');
      $.ajax({
            url: url,
            type: 'POST',
            data: formdata,
          })
          .done(function(res) {
            if(res == 'success'){
              document.getElementById("frmAddManagementHistoryNew").reset();
              alert('Data is inserted');
              location.reload();
            }
            else{
              document.getElementById("frmAddManagementHistoryNew").reset();
              alert('Data is Not inserted');
            }
          })
          .fail(function() {
            alert('somthing went wrong');
          })  
   
  }


  /******************* Delete magment History ********************/
  function delete_mang(upadte_floor){
    var baseUrl = $('#base_url').val();
        baseUrl = baseUrl+'/index.php?r=floor/deleteManagement2';
      $.ajax({
            url: baseUrl,
            type: 'POST',
            data: {floors:  upadte_floor },
          })
          .done(function(res) {
            if(res == 'success'){
              document.getElementById("frmAddManagementHistoryNew").reset();
              alert('Data is Deleted.');
              location.reload();
            }
            else{
              document.getElementById("frmAddManagementHistoryNew").reset();
              alert('Data is Already Deleted.');
              location.reload();
            }
          })
          .fail(function() {
            alert('somthing went wrong');
          })  
   
  }

  /******************* Bluk update magment History ********************/
  function bluk_Update(){
        var baseUrl = $('#base_url').val();
        var formdata = $('#frmAddManagementHistoryNew').serialize();
        baseUrl = baseUrl+'/index.php?r=floor/blukUpdateManagement2';
      $.ajax({
            url: baseUrl,
            type: 'POST',
            data: formdata,
          })
          .done(function(res) {
            if(res == 'success'){
              document.getElementById("frmAddManagementHistoryNew").reset();
              alert('Data is Updated.');
              location.reload();
            }
            else{
              document.getElementById("frmAddManagementHistoryNew").reset();
              alert('NO Data Is updated.');
              location.reload();
            }
          })
          .fail(function() {
            alert('somthing went wrong');
          })  
   
  }



   $('#main').on( "click", "#check_all_floor", function() {
            if ($('#check_all_floor').is(':checked')) {
              $(".bulk_upadte_floor").prop('checked', true);
              
            }
            else{
               $(".bulk_upadte_floor").prop('checked', false);
            }
    });

    $('#main').on( "click", "#bulk_del_floor", function() {
        var formdata = $('#frmAddManagementHistoryNew').serialize();
         var upadte_floor = [];
          $.each($(".bulk_upadte_floor:checked"), function(){            
              upadte_floor.push($(this).val());
          });

          if(upadte_floor.length > 0){
            if(confirm("Are You Sure to Delete Selected Floor")){
              delete_mang(upadte_floor);
            }
            else{
              return false;
            }

          }
          else{
            alert('No floor Is selected');
            return false;
          }        
           
    });

   $('#main').on( "click", "#bulk_upadte_floor", function() {
     var formdata = $('#frmAddManagementHistoryNew').serialize();
     var upadte_floor = [];
      $.each($(".bulk_upadte_floor:checked"), function(){            
          upadte_floor.push($(this).val());
      });

      if(upadte_floor.length > 0){
        check_validity('bluk_Update');
      }
      else{
        alert('No floor Is selected');
        return false;
      }        
    });
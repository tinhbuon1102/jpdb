 $(document).ready(function() {
         //$("#searchTraderText").mask('999-99999-99999',{placeholder:"000-00000-00000"});
        // $("#td_tel").mask('999-99999-99999',{placeholder:"000-00000-00000"});
        // $("#td_fax").mask('999-99999-99999',{placeholder:"000-00000-00000"});
         $('#show_vac_floors').click(function(event) {
            if ($('#show_vac_floors').is(':checked')) {
                 $(".no_vac_floor").prop('checked', false);
                 $('.vac_span').show();
                 $('.no_vac_span').hide();
            }
            else{
                //$(".vac_floor").prop('checked', false );
                //$(".no_vac_floor").prop('checked', false);
                $('.vac_span').show();
                $('.no_vac_span').show();

          }
    }); 
    $("#frmAddNewHistory").submit(function(e){ e. preventDefault(); });

  function check_validity(){
    var error_count=0;
    var cname="";
    var tel="";
    var fax="";
    cname = $('#traders_name').val();
    tel = $('#td_tel').val();
    fax = $('#td_fax').val();
    if((typeof cname == "undefined")||(cname == "")){
       $('#traders_name').addClass('error_val');
       error_count++;
     }
     else{
      $('#traders_name').removeClass('error_val');
     }
    
    if((typeof tel == "undefined")||(tel == "")||(tel=='000-00000-00000')){
       $('#td_tel').addClass('error_val');
       error_count++;

    }
    else{
      $('#td_tel').removeClass('error_val');
    }
    // if((typeof fax == "undefined")||(fax == "")||(fax=='000-00000-00000')){
    //    $('#td_fax').addClass('error_val');
    //    error_count++;
    // }
    // else{
    //   $('#td_fax').removeClass('error_val');
    // }
     if(error_count>0){
    alert("please fill all required fields");
    return false;
    }
   else{
    var targetFloorId = $('.targetFloorId').is(':checked');
    if(!targetFloorId){
        alert("please select atleast one floor");
        return false;
    }
    submit_form();
   
   }
  }

$('#btn2AddNeawHistory').click(function(event) {
          check_validity();
    
 });

        $('#trader_id_new').change( function() {
            var val = $(this).val();
            search_trader(val);
        });

      
        $('#btnSearchTrader').click(function(event) {
            var val = $('#searchTraderText').val();
            var res= search_trader_tel(val);
        });


        function search_trader(traders_id, tabtype, tab){
          var baseUrl=$('#base_url').val();
          var build_id=$('#hdnBillId').val();
          var floor_id=$('#hdnHistFloorId').val();
            $.ajax({
                url: baseUrl+'/index.php?r=floor/getSeletectedTraderDetails',
                type: 'POST',
                data: {trader: traders_id, build_id:build_id, floor_id:floor_id},
            })
            .done(function(res) {
                if(res != 'blank Request'){
                update_ajax_fileld(res);
                }
            })
            .fail(function() {
                alert('somthing went wrong');
            })
            
        }
        function search_trader_tel(trader_tel){
          var baseUrl=$('#base_url').val();
          var build_id=$('#hdnBillId').val();
          var floor_id=$('#hdnHistFloorId').val();

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
                    $('#trader_id_new').html('');
                    $('#trader_id_new').html(option);
                }
              else{
                alert('Field Is blank');
              }
            })
            .fail(function() {
                alert('somthing went wrong');
            })  
        }

         function update_ajax_fileld(res){
             res=JSON.parse(res);
             $('#trader_id_new').val(res.trader_id);
             $('#traders_type').val(res.ownership_type);
             $('#traders_name').val(res.owner_company_name);
             $('#traders_contract').val(res.management_type);
             $('#td_tel').val(res.company_tel);
             $('#td_fax').val(res.company_fax);
             $('#bo_rep1').val(res.person_in_charge1);
             $('#bo_rep2').val(res.person_in_charge2);
             $('#traders_fee').val(res.charge);
             if(res.charge !=""){
                 $("input[name=charge_traders][value=" + res.charge + "]").prop('checked', true);
             }
             
             }

        function submit_form(){
            var formdata = $('#frmAddNewHistory').serialize();
            var url = $('#frmAddNewHistory').attr('action');
              $.ajax({
                    url: url,
                    type: 'POST',
                    data: formdata,
                  })
                  .done(function(res) {
                    if(res == 'success'){
                      document.getElementById("frmAddNewHistory").reset();
                      alert('Data is inserted');
                      location.reload();
                    }
                    else{
                      document.getElementById("frmAddNewHistory").reset();
                      alert('Data is Not inserted');
                    }
                  })
                  .fail(function() {
                    alert('somthing went wrong');
                  })  
           
          }


        
});
    
  

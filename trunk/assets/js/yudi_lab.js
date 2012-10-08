(function($){
    $(function(){
        //test chart
        if($('#vehicles_population').length > 0){
            
            $('#vehicles_population').gvChart({
                chartType: 'PieChart',
                gvSettings: {
                    vAxis: {
                        title: 'Vehicles Population'
                    },
                    hAxis: {
                        title: 'Type'
                    },
                    width: 720,
                    height: 300
                }
            });
        }
        
        
        //test service log di trabsaction service
        /*if($('#modal-service_log').length > 0){
            $('#modal-service_log').live('click',function(){ console.log('test');
                var vehicle_ID_val = $('#kendaraan_id').val();
                if(vehicle_ID_val == ''){
                    alert('Harap pilih kendaraan terlebih dahulu');
                }else{
                    var string ={
                        vehicle_ID : vehicle_ID_val
                    };
                    $.post(site_url+'vehicle/get_service_log_html',string,function(res){
                            console.log(res);
                        });
                }
                
                return false; 
            });
        }*/
        
        //exist check
        if($('#exist_check input[name="no_polisi"]').length > 0 ){
            $('#exist_check input[name="no_polisi"]').exist_check({
                url : site_url+"vehicle/complete_info/json",
                where : {
                    vehicle_type : 'MOBIL'
                },
                trigger_event : 'keyup',
                bubble : 'true|sudah terdaftar',
                success_fn : function(res){
                    console.log('masuk ke success fn');
                },
                error_fn : function(){
                    console.log('masuk ke error fn');
                }
                
            });
        }
        
        if($('#exist_check input[name="perbaikan"]').length > 0 ){
            $('#exist_check input[name="perbaikan"]').typeahead({
                url : site_url+"master/perbaikan/suggestion",
                objCatch : 'perbaikan_options', 
                hidesome : 'true|#add-perbaikan_lain_lain-detail^true|#merk',
                qWhere : {
                    service_category_id : 7 //perbaikan lain-lain
                },
                callback_fn : function(){
                    
                }
            }).bind('keyup',function(e){
                elem = $(this);
                var e = window.event || e;
                var keycode = e.charCode || e.keyCode;
                
                if (e !== undefined) {
                    switch(keycode){  
                        case 13 :
                            //save perbaikan
                            //get date
                            var fullDate = new Date();
                            var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);//convert month to 2 digits
                            var currentDate = fullDate.getFullYear()+'-'+twoDigitMonth+ "-" +fullDate.getDate()+ " " +fullDate.getHours()+':'+fullDate.getMinutes()+':'+fullDate.getSeconds();
                    
                            $.ajax({
                                type: "POST",
                                url: site_url+"master/perbaikan/create_ajaxMode",
                                dataType : 'json',
                                data: {
                                    service_category_id : 7,//category perbaikan lain-lain
                                    perbaikan : elem.val(),
                                    description :elem.val(),
                                    created_on :currentDate,
                                    created_by : user_nip
                                },
                                success: function(res){
                                    //console.log(res);
                                    var perbaikan_id = '';
                                    if(res){
                                        $.each(res,function(i,n){
                                            perbaikan_id = i;
                                            var perbaikan = n;
                                        //console.log('id:'+i+', perb:'+n);
                                        });
                                    }//console.log(perbaikan_id);
                                    var html_temp = '<div class="control-group"><label class="control-label">&nbsp;</label><div class="controls"><label style="width: 400px;" class="control-label al">'+elem.val().toUpperCase()+'<input type="hidden" name="perbaikan_lain_id[]" value="'+perbaikan_id+'"></label></div></div>';
                                    elem.parent().parent().after(html_temp);
                                }
                            });
                            break;
                    }
                    
                }
            });
        }
        
        //END
        
        
        //autocomplete using enter
        if($('#autocomplete input[name="no_polisi"]').length > 0 ){
            $('#autocomplete input[name="no_polisi"]').completeby13({
                url : site_url+"vehicle/complete_info/json",
                apply :{
                    id : 'input[name="vehicle_id"]',
                    jenis : 'input[name="vehicle_type"]',
                    last_user : '#peminjam',
                    last_used_date : '#tgl_sewa'
                },
                where : {
                    vehicle_type : 'MOTOR'
                }/*,
                xalert : {
                    last_pickup_id : '|Kendaraan tidak disewa'
                }*/,
                hidesome : {
                    foc : 'false|#hide_show_me'
                }
            });
        }
        
        //typeahead custom
        if($('#typeahead_custom input[name="bengkel"]').length > 0 ){
            $('#typeahead_custom input[name="bengkel"]').typeahead({
                url : site_url+"transaction/service_luar/suggestion",
                objCatch : 'bengkel_options', 
                dataToView : {
                    kota_options : '#kota',
                    pic_options : '#pic'
                }
            });
        }

    });
})(jQuery);
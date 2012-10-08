(function($){
    /**
     *@author : Yudi IT / 24088
     *@description : checking existensi data, kemudian melakukan callback ke function lain
     *              + trigger_val : dipakai jika elemen yang diassign bukan merupakan elemen yang ingin 
     *              diambil valuenya, misal harusnya ambil value dari inputan, ternyata ingin assign ke button dahulu baru check
     *              + success_fn, dipakai jika setelah mendapatkan value akhir kemudian ingin menjalankan function lain
     *              + error_fn, menjalanankan sesuatu function jika error
     *@return : TRUE ( return detail dari yang dicari ) dan FALSE
     *          
     **/
    $.fn.exist_check=function(options){
        var defaults={
            trigger_event : 'focusout',//bisa pakai keypress,keyup,click,dblclick, dll...
            trigger_val : '',
            bubble : '',
            success_fn : function(){},
            error_fn : function(){}
        }
        var options=$.extend(defaults,options);
        return this.each(function(){
            $(this).bind(options.trigger_event,function(){
                elem = $(this);
                var elem_ID = elem.attr('id');
                var elem_NAME = elem.attr('name');
                var elem_VAL = elem.val();
                if(elem_VAL){
                    options.where[elem_NAME] = elem_VAL; // default, add object data, dengan nama dan value sesuai nama element
                    $.ajax({
                        type: "POST",
                        url: options.url,
                        dataType : 'json',
                        data: options.where,
                        success: function(res){
                            if(res){
                                //assign bubble if any
                                if(options.bubble){
                                    var bubble_raw = options.bubble.split('|');
                                    var bubble_condition = bubble_raw[0] == 'true'?true:false;
                                    var bubble_text = bubble_raw[1];
                                    var bubble_html = '<div id="'+elem_NAME+'_bubble" class="tooltip fade right in" style="top: 132px; left: 280px; display: block;"><div class="tooltip-arrow"></div><div class="tooltip-inner"><icon class="icon-remove icon-white"></icon> '+bubble_text+'</div></div>';
                                    if(bubble_condition == true ) elem.after(bubble_html);
                                }
                                
                                options.success_fn(res); 
                            }else{
                                if(options.bubble){//clear bubble
                                    if($('#'+elem_NAME+'_bubble').length > 0 )$('#'+elem_NAME+'_bubble').remove();
                                }
                                options.error_fn();
                            }
                                        
                        }
                    });
                }else{
                    if(options.bubble){
                        if($('#'+elem_NAME+'_bubble').length > 0 )$('#'+elem_NAME+'_bubble').remove();
                    }
                }
            });
        });
    };
    
    /**
     *@author : Yudi IT / 24088
     *@description : disabling enter key exact element
     *          
     **/
    $.fn.stop13=function(options){
        var defaults={
            button : '13'
        }
        var options=$.extend(defaults,options);
        return this.each(function(){
            $(this).bind('keypress',function(e){
                var e = window.event || e;
                var keycode = e.charCode || e.keyCode;
                
                if (e !== undefined) {
                    switch(keycode){  
                        case 13 :
                            e.preventDefault();
                            break;
                    }
                    
                }
            });
        });
    };
    /**
     *@author : Yudi IT / 24088
     *@description : autocomplete dengan enter untuk menampilkan resultnya 
     *@param : defaults 
     *          + button : defaultnya enter / 13
     *          + url : url ke alamat controller CI
     *          + where : pencarian berdasarkan apa ?
     *          + apply : hasil dari balikan json akan di aplikasikan kemana
     *          
     **/
    $.fn.completeby13=function(options){
        var defaults={
            button : '13',
            url : '',
            where : {},
            apply :{},
            xalert :{},
            hidesome :{},
            check_on_autoload : {}
        }
        var options=$.extend(defaults,options);
        return this.each(function(){
            $(this).bind('keypress',function(e){
                elem = $(this); 
                var e = window.event || e;
                var keycode = e.charCode || e.keyCode;
                
                if (e !== undefined) {
                    switch(keycode){
                        case 9 :     
                        case 13 :
                            var elem_ID = elem.attr('id');
                            var elem_NAME = elem.attr('name');
                            var elem_VAL = elem.val();
                            if(options.where){
                                $.map( options.where, function( n,i ) {
                                    return options.where[i] = n;
                                });
                            }
                            options.where[elem_NAME] = elem_VAL; // default, add object data, dengan nama dan value sesuai nama element
                            $.ajax({
                                type: "POST",
                                url: options.url,
                                dataType : 'json',
                                data: options.where,
                                success: function(res){
                                    if(res){
                                        var error_detected = false;
                                        
                                        if(options.bubble){
                                            var bubble_raw = options.bubble.split('|');
                                            var bubble_condition = bubble_raw[0] == 'true'?true:false;
                                            var bubble_text = bubble_raw[1];
                                            var bubble_html = '<div id="'+elem_NAME+'_bubble" class="tooltip fade right in" style="top: 132px; left: 280px; display: block;"><div class="tooltip-arrow"></div><div class="tooltip-inner"><icon class="icon-remove icon-white"></icon> '+bubble_text+'</div></div>';
                                            if(bubble_condition == true ) elem.after(bubble_html);
                                        }
                                        
                                    
                                        if(options.xalert){ //show dialog box
                                            
                                            if($.isEmptyObject(options.check_on_autoload) == false){ //co_o_a
                                                var c_o_a_var = options.check_on_autoload;
                                                //check global variable or not
                                                if(c_o_a_var.indexOf('globvar_') != -1){ //if it is global variable
                                                    c_o_a_var = c_o_a_var.replace('globvar_','');
                                                    if(eval("$."+c_o_a_var) == false || eval("$."+c_o_a_var) == undefined){
                                                        $.each(options.xalert,function(check,response_check){
                                                            var lookup = res[check];
                                                            var response_check_raw = response_check.split('|');
                                                            var xalert_condition = response_check_raw[0] == 'true'?true:false;
                                                            var xalert_text = response_check_raw[1];
                                                            if(lookup == true ){ 
                                                                alert(xalert_text);
                                                                error_detected = true;
                                                            }
                                                    
                                                        });
                                                        reset_apply(options);
                                                    }
                                                }else{//common variable
                                                    //console.log('it\'s common variable');
                                                    //bisa copy dari atas jika suatu saat pakai variable biasa
                                                }
                                            }
                                            
                                        }
                                        if(options.hidesome){ //hide some element
                                            $.each(options.hidesome,function(check,response_check){
                                                var response_check = response_check.split('|');
                                                if(res[check] == Boolean(response_check[0]) ){ 
                                                    $(response_check[1]).hide();
                                                }else{
                                                    $(response_check[1]).show();
                                                }
                                            });
                                            reset_apply(options);
                                        }
                                        if(!error_detected){
                                            $.each(options.apply,function(json_obj,apply_to){
                                                if($(apply_to).is('INPUT'))
                                                    $(apply_to).val('').val(res[json_obj]);
                                                else
                                                    $(apply_to).text('').html(res[json_obj]);
                                            });
                                        }
                                        
                                        
                                    }else{
                                        reset_apply(options);
                                        alert('Data tidak ditemukan');
                                    }
                                        
                                }
                            });
                        
                            e.preventDefault();
                            break;
                    }
                    
                }
            });
        });
    };
    
    function reset_apply(options){ 
        $.each(options.apply,function(json_obj,apply_to){
            if($(apply_to).is('INPUT'))
                $(apply_to).val('');
            else
                $(apply_to).text('-');
        });
    }
})(jQuery);
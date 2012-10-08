(function($){
    
    if($('#add-desa_kelurahan').length > 0 ){
        $('#add-desa_kelurahan').live('click',function(){
                           
            var kelurahan_id = $('#desa_kelurahan_id').val();
            var kelurahan_name = $('#desa_kelurahan_id option:selected').text();
                
            if(kelurahan_id==0){
                alert("Harap Pilih Desa/Kelurahan");                  
            }else{
                var cloned = $("#temp_teknisi_dropdown").html();
                                 
                var elem = $(this);
                var elem_parent = elem.parents('.control-group');
                var html_to_add = '<div class="control-group">\n\
                                            <label class="control-label">&nbsp</label>\n\
                                            <div class="controls">KELURAHAN - '+ kelurahan_name +' <input class="span1" type="hidden" value="' + kelurahan_id + '" name="desa_kelurahan_id[]">\n\
                                                <a class="btn btn-mini remove-desa_kelurahan"><i class="icon-minus"></i></a>\n\
                                            </div>\n\
                                      </div>';
                elem_parent.after(html_to_add);
                
                $('.remove-desa_kelurahan').live('click',function(){
             
                    elem = $(this);
                    var idx = $('.remove-desa_kelurahan').index(this);  
                    var elem = $(this);
                    var elem_parent = elem.parents('.controls').parent().remove() 
             
                    return false;    
                });   
            }
            return false;

        });       
    }
    
})(jQuery);
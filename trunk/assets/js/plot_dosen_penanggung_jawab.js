$().ready(function(){
    if($('#button_add_dosen').length > 0 ){
        $('#button_add_dosen').live('click',function(){

            var cloned = $("#dosen_id").html(); //<select class="input-medium" name="dosen_id" prevData-selected="">'+dosen_id+'</select>

            var elem = $(this);
            var elem_parent = elem.parents('.control-group');
            var html_to_add = '<div class="control-group">\n\
                                        <label class="control-label" for="dosen_id">Dosen Anggota</label>\n\
                                        <div class="controls">\n\
                                            <select id="dosen_id_1" class="input-medium" prevdata-selected="" name="dosen_id[]">'+cloned+'</select>\n\
                                                <span class="btn-mini-class"><a class="btn btn-mini remove-add_dosen"><i class="icon-minus"></i></a></span>\n\
                                            </div>\n\
                                        <div class="clear:both"></div>\n\
                                    </div>';
                elem_parent.after(html_to_add);
                $('#dosen_id_1').combobox()
                 
                //assign eventnya
                if($('.remove-add_dosen').length > 0 ){
                    $('.remove-add_dosen').live('click',function(){

                     elem = $(this);
                     var idx = $('.remove-add_dosen').index(this);//console.log(idx);

                     var elem = $(this);
                     var elem_parent = elem.parents('.controls').parent().remove();

                });
            }
            return false;
        });
    }
	if($('#button_add_pegawai').length > 0 ){
        $('#button_add_pegawai').live('click',function(){

            var cloned = $("#pegawai_id").html(); //<select class="input-medium" name="pegawai_id" prevData-selected="">'+pegawai_id+'</select>

            var elem = $(this);
            var elem_parent = elem.parents('.control-group');
            var html_to_add = '<div class="control-group">\n\
                                        <label class="control-label" for="pegawai_id">Pegawai</label>\n\
                                        <div class="controls">\n\
                                            <select id="pegawai_id_1" class="input-medium" prevdata-selected="" name="pegawai_id[]">'+cloned+'</select>\n\
                                                <span class="btn-mini-class"><a class="btn btn-mini remove-add_pegawai"><i class="icon-minus"></i></a></span>\n\
                                            </div>\n\
                                        <div class="clear:both"></div>\n\
                                    </div>';
                elem_parent.after(html_to_add);
                $('#pegawai_id_1').combobox()
                 
                //assign eventnya
                if($('.remove-add_pegawai').length > 0 ){
                    $('.remove-add_pegawai').live('click',function(){

                     elem = $(this);
                     var idx = $('.remove-add_pegawai').index(this);//console.log(idx);

                     var elem = $(this);
                     var elem_parent = elem.parents('.controls').parent().remove();

                });
            }
            return false;
        });
    }
});
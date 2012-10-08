(function($){
    
    if($('#jadwal_kuliah input[name^="nama_ruang"]').length > 0){
        $('#jadwal_kuliah input[name^="nama_ruang"]').typeahead({
            url : site_url+"master/ruang_pelajaran/suggestion",
            objCatch : 'nama_ruang_options', 
            parseData : 'nama_ruang',  
            dataToView_res_inline : true
        });
    }  
    
})(jQuery);
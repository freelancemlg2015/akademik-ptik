(function($){
    
    if($('#jadwal_kuliah input[name^="nama_angkatan"]').length > 0){

        //console.log('test');
        $('#jadwal_kuliah input[name^="nama_angkatan"]').typeahead({
            url : site_url+"master/angkatan/suggestion",
            objCatch : 'nama_angkatan_options', 
            parseData : 'nama_angkatan',  
            dataToView_res_inline : true
        });
               
    }  
    
})(jQuery);
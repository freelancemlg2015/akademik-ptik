(function($){
    
    if($('#jadwal_kuliah input[name^="tahun_ajar"]').length > 0){

        //console.log('test');
        $('#jadwal_kuliah input[name^="tahun_ajar"]').typeahead({
            url : site_url+"master/tahun_akademik/suggestion",
            objCatch : 'tahun_ajar_options', 
            parseData : 'tahun_ajar',  
            dataToView_res_inline : true
        });
               
    }  
    
})(jQuery);
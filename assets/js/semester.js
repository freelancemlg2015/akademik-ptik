(function($){
    
    if($('#jadwal_kuliah input[name^="nama_semester"]').length > 0){

        //console.log('test');
        $('#jadwal_kuliah input[name^="nama_semester"]').typeahead({
            url : site_url+"master/semester/suggestion",
            objCatch : 'nama_semester_options', 
            parseData : 'nama_semester',  
            dataToView_res_inline : true
        });
               
    }  
    
})(jQuery);
(function($){
    
    if($('#jadwal_kuliah input[name^="nama_dosen"]').length > 0){

        //console.log('test');
        $('#jadwal_kuliah input[name^="nama_dosen"]').typeahead({
            url : site_url+"master/dosen/suggestion",
            objCatch : 'nama_dosen_options', 
            parseData : 'nama_dosen',  
            dataToView : {  
                id_dosen_options :  'input[name="dosen_ajar_id"]'
            }
        });
               
    }  
    
})(jQuery);
(function($){
    
    if($('#mahasiswa input[name^="kode_pangkat"]').length > 0){

        //console.log('test');
        $('#mahasiswa input[name^="kode_pangkat"]').typeahead({
            url : site_url+"master/mahasiswa/suggestion",
            objCatch : 'kode_pangkats_options', 
            parseData : 'kode_pangkat',  
            dataToView : {  
                id_pangkat_options :  'input[name="id_pangkat"]'
            }
        });
               
    }  
    
})(jQuery);
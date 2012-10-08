(function($){
    
    //AJAX SIMPLE AUTOCOMPLETE
    
    if($('#mahasiswa input[name^="nama_program_studi"]').length > 0){

        $('#mahasiswa input[name^="nama_program_studi"]').typeahead({
            url : site_url+"master/program_studi/suggestion",
            objCatch : 'nama_program_studi_options', 
            parseData : 'nama_program_studi',  
            dataToView_res_inline : true
        });
               
    }  
    
    
})(jQuery);
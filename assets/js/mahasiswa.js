(function($){
    
    if($('#nilai_fisik input[name^="nim"]').length > 0){

        //console.log('test');
        $('#nilai_fisik input[name^="nim"]').typeahead({
            url : site_url+"master/mahasiswa/suggestion",
            objCatch : 'nim_options', 
            parseData : 'nim',  
            dataToView_res_inline : true
        });
               
    }  
    
})(jQuery);
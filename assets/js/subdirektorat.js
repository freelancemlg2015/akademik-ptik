(function($){
    
    if($('#subdirektorat input[name^="nama_direktorat"]').length > 0){

        //console.log('test');
        $('#subdirektorat input[name^="nama_direktorat"]').typeahead({
            url : site_url+"master/direktorat/suggestion",
            objCatch : 'nama_direktorat_options', 
            parseData : 'nama_direktorat',  
            dataToView : {  
                id_direktorat_options :  '#direktorat_id'
            }
        });
               
    }  
    
})(jQuery);
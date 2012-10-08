(function($){
    $(function(){
        if($('#tab-serviceSheet #nip').length > 0){
            $('#tab-serviceSheet #nip').typeahead({
                url : site_url+"master/peminjam/suggestion",
                objCatch : 'nip_options', 
                parseData : 'nip',
                dataToView : {
                    peminjam_options : '#customer'
                }
            });
        }
    });
        
        
})(jQuery);




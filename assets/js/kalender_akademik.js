(function($){
    
    if($('#kalender_akademik input[name^="nama_angkatan"], #kalender_akademik input[name="tahun"]').length > 0){

        //console.log('test');
        $('#kalender_akademik input[name^="nama_angkatan"]').typeahead({
            url : site_url+"master/angkatan/suggestion",
            objCatch : 'nama_angkatan_options', 
            parseData : 'nama_angkatan',  
            dataToView : {  
                id_angkatan_options :  'input[name="angkatan_id"]'
            }
        });
        
        $('#kalender_akademik input[name^="tahun"]').typeahead({
            url : site_url+"master/tahun_akademik/suggestion",
            objCatch : 'tahun_options', 
            parseData : 'tahun',  
            dataToView : {  
                id_tahun_ajar_options :  'input[name="tahun_akademik_id"]'
            }
        });
    }
})(jQuery);

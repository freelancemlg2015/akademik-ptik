(function($){
    
    if($('#paket_matakuliah input[name^="nama_angkatan"],\n\
          #paket_matakuliah input[name^="tahun_ajar"],\n\
          #paket_matakuliah input[name^="nama_mata_kuliah"]').length > 0){

        //console.log('test');
        $('#paket_matakuliah input[name^="nama_angkatan"]').typeahead({
            url : site_url+"master/angkatan/suggestion",
            objCatch : 'nama_angkatan_options', 
            parseData : 'nama_angkatan',  
            dataToView : {  
                id_angkatan_options :  'input[name="angkatan_id"]'
            }
        });
        
        $('#paket_matakuliah input[name^="tahun_ajar"]').typeahead({
            url : site_url+"master/tahun_akademik/suggestion",
            objCatch : 'tahun_ajar_options', 
            parseData : 'tahun_ajar',  
            dataToView : {  
                id_tahun_ajar_options :  'input[name="tahun_akademik_id"]'
            }
        });
        
        $('#paket_matakuliah input[name^="nama_mata_kuliah"]').typeahead({
            url : site_url+"master/mata_kuliah/suggestion",
            objCatch : 'nama_mata_kuliah_options', 
            parseData : 'nama_mata_kuliah',  
            dataToView : {  
                id_mata_kuliah_options :  'input[name="mata_kuliah_id"]'
            }
        });
    }
})(jQuery);

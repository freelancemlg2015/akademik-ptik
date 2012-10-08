(function($){
    $(function(){
        
        if($('#musrenbang_kelurahan').length > 0){      
            $('#musrenbang_kelurahan').gvChart({
                chartType: 'BarChart',
                gvSettings: {
                    vAxis: {
                        title: 'Musrenbang Kelurahan'
                    },
                    hAxis: {
                        title: 'Rekapitulasi'
                    },
                    width: 600,
                    height: 400
                }
            });
        }
        
        if($('#musrenbang_kecamatan').length > 0){ 
            $('#musrenbang_kecamatan').gvChart({
                chartType: 'BarChart',
                gvSettings: {
                    vAxis: {
                        title: 'Musrenbang Kecamatan'
                    },
                    hAxis: {
                        title: 'Rekapitulasi'
                    },
                    width: 600,
                    height: 400
                }
            });
        }

    });
})(jQuery);
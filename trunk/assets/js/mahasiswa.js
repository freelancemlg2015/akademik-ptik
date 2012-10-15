(function($){
    
//    if($('#mahasiswa input[name^="kode_pangkat"]').length > 0){
//
//        //console.log('test');
//        $('#mahasiswa input[name^="kode_pangkat"]').typeahead({
//            url : site_url+"master/pangkat/suggestion",
//            objCatch : 'kode_pangkat_options', 
//            parseData : 'kode_pangkat',  
//            dataToView : {  
//                nama_pangkat_options :  'input[name="nama_pangkat"]'
//            }
//        });
//               
//    }
    $("#pangkat_id").change(function(){
        var value = ($(this).val()).split("-");
        //alert(value[1]);
        $('input[name="span_pangkat"]').val(value[1]);
    })
    
})(jQuery);
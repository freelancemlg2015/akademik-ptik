(function($){
    $("#plot_mata_kuliah_id").change(function(){
        var value = ($(this).val()).split("-");
        //alert(value[1]);
        $('input[name="span_pangkat"]').val(value[1]);
    })
    
})(jQuery);
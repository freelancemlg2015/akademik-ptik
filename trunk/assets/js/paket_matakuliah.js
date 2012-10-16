$(document).ready(function(){
    $("input[name='kelompok_mata_kuliah_id']").click(function(){
        var nama = $(this).val();
        if($(this).is(":checked")){
            $("input[name='kelompok_mata_kuliah_id']").val(nama);
        }
        else {
            $("input[name='kelompok_mata_kuliah_id']").val(nama);
        }
    });
});
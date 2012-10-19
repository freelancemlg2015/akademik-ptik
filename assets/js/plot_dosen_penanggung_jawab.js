$().ready(function(){
    $("#button_dosen").click(function(){
        page = site + "create/dosen/";
        $.ajax({
            url: page,
            success: function(response){
                $("#combo_dosen").append(response);
            },
            dataType:"html"
        });
        return false;
    });
});
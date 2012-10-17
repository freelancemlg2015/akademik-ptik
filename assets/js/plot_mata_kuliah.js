function cek_all(v){
    if($(v).attr("id")=='1'){
        $("input#cek[type='checkbox']").attr('checked',1);
        $(v).attr("id",'0')
    }else{
        $("input#cek[type='checkbox']").attr('checked',0).removeAttr('checked');
        $(v).attr("id",'1')
    }
    
}
    

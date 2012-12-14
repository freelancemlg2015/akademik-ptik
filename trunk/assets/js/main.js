(function($){
    
    function kendaraan_kpm_checker(check,target){
        //console.log($(check).val());
        if($(check).val() == 'KPM'){
            return $(target).show();//just show it
        }else{
            return $(target)
            .val('')
            .hide();//reset & hide
        } 
    }
    
    function asuransi_perusahaan_checker(check,target){
        //console.log($(check).val());
        if($(check).val() == 'PERUSAHAAN'){
            return $(target).show();//just show it
        }else if ($(check).val() == 'PRIBADI'){
            return $(target).hide();//just hide it
        }else{
            return $(target)
            .val('')
            .show();//reset & hide
        }
    }
    
    function asuransi_pribadi_checker(check,target){
        //console.log($(check).val());
        if($(check).val() == 'PERUSAHAAN'){
            return $(target).hide();//just show it
        }else if ($(check).val() == 'PRIBADI'){
            return $(target).show();//just hide it
        }else{
            return $(target)
            .val('')
            .show();//reset & hide
        }
    }
    
    function asuransi_bank_checker(check,target){
        //console.log($(check).val());
        if($(check).val() == 'Bank'){
            return $(target).show();//just show it
        }else if ($(check).val() == 'non-Bank'){
            return $(target).hide();//just hide it
        }
        else{
            return $(target)
            .val('')
            .show();//reset & hide
        }
    }
    
    function asuransi_leasing_checker(check,target){
        //console.log($(check).val());
        if($(check).val() == 'leasing'){
            return $(target).show();//just show it
        }else{
            return $(target)
            .val('')
            .hide();//reset & hide
        }
    }
    
    function asuransi_non_leasing_checker(check,target){
        //console.log($(check).val());
        if($(check).val() == 'non_leasing'){
            return $(target).hide();//just show it
        }else{
            return $(target)
            .val('')
            .hide();//reset & hide
        }
    }
    
    $(function(){
        if($('.data_list a').length > 0 || $('.tab-content').length > 0){
            //data list
            $('.data_list a, .tab-content .icon-info-sign, .icon-random').tooltip({
                placement : 'right',
                delay: {
                    show: 10, 
                    hide: 200
                }
            });
        }
        
        if($('.resign-info').length > 0 ){
            //data list
            $('.resign-info').tooltip({
                placement : 'right',
                delay: {
                    show: 10, 
                    hide: 200
                }
            });
        }
        
        $('.icon-info-sign').tooltip({
            delay: {
                show: 10, 
                hide: 200
            }
        });  
        
        if($('.tabs').length > 0)
            $('.tabs').tab('show');
        
        if($('#role_capabilities').length > 0 ){
            $('#role_capabilities .check_all').change(function(){
                elem = $(this);
                $('#role_capabilities input[name^="capability"]').attr('checked',(( elem.is(':checked') )? true : false ));
            });
        }
        
        if($('#perbaikan_form_extend').length > 0 ){
            $('#perbaikan_form_extend .check_all').live('change',function(){
                elem = $(this);
                $('#perbaikan_form_extend input[name^="perbaikan"]').attr('checked',(( elem.is(':checked') )? true : false ));
            });
        }
        
        if($('#type_swap select[name="merk_ID"]').length > 0){
            $('#type_swap select[name="merk_ID"]').live('change',function(){
                elem = $(this);
                var elem_val = elem.val();
                var field_jenis = $('#type_swap select[name="type_ID"]');
                if(elem_val == '0'){
                    $('#by_jenis').parent().parent().remove();
                }else{
                    var string ={
                        merk_id : elem_val,
                        data_type : 'json'
                    };
                    
                    $.post(site_url+'master/jenis',string,function(res){
                        var options_html = '<option value="0">-Pilih-</option>';
                        $.each(res, function(key, val) {
                            options_html += '<option value="'+key+'">'+val+'</option>';
                        });
                        field_jenis.html(options_html);
                    }, 'json');
                
                }
            
            });
        }
        
        if($('#users select[name="merk"]').length > 0){
            $('#users select[name="merk"]').live('change',function(){
                elem = $(this);
                var elem_val = elem.val();
                var field_jenis = $('#users select[name="jenis"]');
                if(elem_val == '0'){
                    $('#by_jenis').parent().parent().remove();
                }else{
                    var string ={
                        merk_id : elem_val,
                        data_type : 'json'
                    };
                    
                    $.post(site_url+'master/jenis',string,function(res){
                        var options_html = '<option value="0">-Pilih-</option>';
                        $.each(res, function(key, val) {
                            options_html += '<option value="'+key+'">'+val+'</option>';
                        });
                        field_jenis.html(options_html);
                    }, 'json');
                
                }
            
            });
        }
        
        if($('#kendaraan select[name="merk_id"]').length > 0){
            // merk & jenis
            $('#kendaraan select[name="merk_id"]').trigger('change');
            $('#kendaraan select[name="merk_id"]').live('change',function(){
                elem = $(this); 
                var elem_val = elem.val();
                var field_jenis = $('#kendaraan select[name="jenis_id"]');
                if(elem_val == '0'){
                    field_jenis.removeAttr('prevdata-selected');
                    $('#by_jenis').parent().parent().remove();
                }else{
                    var string ={
                        merk_id : elem_val,
                        data_type : 'json'
                    };
                    
                    $.post(site_url+'master/jenis',string,function(res){
                        var options_html = '<option value="0">-JENIS-</option>';
                        $.each(res, function(key, val) {
                            options_html += '<option value="'+key+'">'+val+'</option>';
                        });
                        field_jenis.html(options_html);
                        
                        //auto select latest data
                        var prevData_selected = $('#kendaraan select[name="jenis_id"]').attr('prevdata-selected');
                        if(prevData_selected != '')
                            $('#kendaraan select[name="jenis_id"] option[value="'+prevData_selected+'"]').attr('selected','selected');
                    
                    }, 'json');
                
                }
            
            });
            
            //auto load jenis, lalu lihat keatas, supaya terselect id nya
            if($('#kendaraan select[name="merk_id"]').val() >= 0 ) $('#kendaraan select[name="merk_id"]').trigger('change');      
            
            //END merk & jenis          
            
            //init KPM, check
            kendaraan_kpm_checker('#kendaraan select[name="status_kepemilikan"]','#kendaraan input[name="kpm_atas_nama"]');
            
            //assign change event
            $('#kendaraan select[name="status_kepemilikan"]').live('change',function(){
                kendaraan_kpm_checker($(this),'#kendaraan input[name="kpm_atas_nama"]');
            });
            
            //auto load pemilik, lalu lihat keatas, supaya terselect id nya
            if($('#kendaraan select[name="kota_id"]').val() >= 0 ) $('#kendaraan select[name="kota_id"]').trigger('change');
        //END kota dan pemilik(company)
        
        }
        
        if($('#kendaraan-search select[name="merk"]').length > 0){
            $('#kendaraan-search select[name="merk"]').trigger('change');
            $('#kendaraan-search select[name="merk"]').live('change',function(){
                var elem = $(this);
                var elem_val = elem.val();
                var field_jenis = $('#kendaraan-search select[name="jenis"]');
                if(elem_val == '0'){
                    $('#by_jenis').parent().parent().remove();
                }else{
                    var string ={
                        merk_id : elem_val,
                        data_type : 'json'
                    };
                    
                    $.post(site_url+'master/jenis',string,function(res){
                        var options_html = '<option value="0">-Pilih-</option>';
                        $.each(res, function(key, val) {
                            options_html += '<option value="'+key+'">'+val+'</option>';
                        });
                        field_jenis.html(options_html);
                    }, 'json');
                
                }
            
            });
        }   
        
        if($('#peminjam select[name="company"]').length > 0){
            $('#peminjam select[name="company"]').live('change',function(){
                elem = $(this);
                var elem_val = elem.val();
                var field_department = $('#peminjam select[name="department"]');
                var options_html = '<option value="0">-Pilih-</option>';
                if(elem_val == '0'){
                    field_department.html(options_html);
                }else{
                    var string ={
                        company_id : elem_val,
                        data_type : 'json'
                    };
                    
                    $.post(site_url+'master/departments',string,function(res){
                        $.each(res, function(key, val) {
                            options_html += '<option value="'+key+'">'+val+'</option>';
                        });
                        field_department.html(options_html);
                    }, 'json');
                
                }
            
            });
        }
                
        //edit
        $('.data_list tbody tr').live('click',function(){
            var data_list_id = $('.data_list').attr('id');
            var id = $(this).attr('id');
            var controller = $('.data_list').attr('controller');
            window.location = site_url+controller+'/'+data_list_id+'/info/'+id;
            return false;
        });
        
        //edit--> semua bakal kaya gini
        $('#letter_of_authority.data_list tbody tr,#letter_of_authority.data_list tbody tr,#dropoff.data_list tbody tr,#member.data_list tbody tr,\n\
           #desa_kelurahan.data_list tbody tr,#kecamatan.data_list tbody tr,#kategori_skpd.data_list tbody tr,#skpd.data_list tbody tr,#status_prioritas.data_list tbody tr,#status_kegiatan.data_list tbody tr,#status_pelaksanaan.data_list tbody tr,#status_musrenbang.data_list tbody tr,#musrenbang_usulan.data_list tbody tr,#sample.data_list tbody tr,\n\
           #direktorat.data_list tbody tr,#subdirektorat.data_list tbody tr,,#angkatan.data_list tbody tr,#program_studi.data_list tbody tr,#tahun_akademik.data_list tbody tr,#kelompok_mata_kuliah.data_list tbody tr,#mata_kuliah.data_list tbody tr,#jenjang_studi.data_list tbody tr,#akta_mengajar.data_list tbody tr,#bobot_nilai.data_list tbody tr,#mahasiswa.data_list tbody tr,#dosen.data_list tbody tr,#pegawai.data_list tbody tr,#frekuensi_pemutakhiran.data_list tbody tr,,#pelaksana_pemutakhiran.data_list tbody tr,\n\
           #jam_pelajaran.data_list tbody tr,#ruang_pelajaran.data_list tbody tr,#jenis_ruang.data_list tbody tr,#status_akreditasi.data_list tbody tr,#status_aktivitas_dosen.data_list tbody tr,#status_kerja_dosen.data_list tbody tr,#status_dosen_penasehat.data_list tbody tr,#status_mata_kuliah.data_list tbody tr,#golongan.data_list tbody tr,#jabatan_akademik.data_list tbody tr,#jabatan_tertinggi.data_list tbody tr,#jenis_kelamin.data_list tbody tr,\n\
           #jenis_ujian.data_list tbody tr,#nilai.data_list tbody tr,#pangkat.data_list tbody tr,#kesatuan_asal.data_list tbody tr,#konsentrasi_studi.data_list tbody tr,#semester.data_list tbody tr,#semester_mulai_aktivitas.data_list tbody tr,#surat_ijin_mengajar.data_list tbody tr,#nilai_fisik.data_list tbody tr,#nilai_mental.data_list tbody tr,#jadwal_kuliah.data_list tbody tr,#ujian_skripsi.data_list tbody tr,#kalender_akademik.data_list tbody tr,\n\
           #plot_mata_kuliah.data_list tbody tr,#plot_semester.data_list tbody tr,#paket_matakuliah.data_list tbody tr,#plot_dosen_penanggung_jawab.data_list tbody tr,#rencana_mata_pelajaran.data_list tbody tr,#plot_kelas.data_list tbody tr,#nilai_akademik.data_list tbody tr, #penasehat_akademik.data_list tbody tr,#provinsi.data_list tbody tr,#kategori_pejabat.data_list tbody tr,#pejabat_tanda_tangan.data_list tbody tr,#kategori_berita.data_list tbody tr,\n\
           #berita.data_list tbody tr,#kategori_unduhan.data_list tbody tr,#unduhan.data_list tbody tr,#jadwal_ujian.data_list tbody tr,#pengajuan_skripsi.data_list tbody tr,#nilai_skripsi.data_list tbody tr').live('click',function(){
            var data_list_id = $('.data_list').attr('id');
            var id = $(this).attr('id');
            var controller = $('.data_list').attr('controller');
            window.location = site_url+controller+'/'+data_list_id+'/'+id+'/info';
            return false;
        });
        
        //end edit
        //
        // Datepicker
        $('input[name="tgl_terima"],input[name="tgl_pelaksanaan"],input[name="tgl_estimasi"],input[name="tgl_selesai"],\n\
           input[name="tgl_akhir_cicilan"],input[name="tgl_akhir_stnk"],input[name="tgl_akhir_kir"],input[name="tgl_akhir_asuransi"],\n\
           input[name="tgl_jual"],input[name="tgl_transaksi"],input[name="tgl_peminjaman"],input[name="tgl_payment"],input[name="tgl_pemakaian"],\n\
           input[name="tgl_pengembalian"],input[name="tgl_pengambilan"],input[name="tgl_perbaikan"],input[name="periode_awal"],input[name="periode_akhir"],\n\
           input[name="tgl_penjualan"],input[name="tgl_mutasi"],input[name="tgl_audit"],input[name="tgl_start"],input[name="tgl_end"],input[name="tgl_claim"],input[name="tgl_sk_terakhir"],input[name="tgl_sk_akreditasi"],input[name="tgl_pendirian_program_studi"],input[name="tgl_akhir_sk"],input[name="tgl_mulai"],input[name="tgl_akhir"],\n\
           input[name="tgl_lahir"],input[name="tgl_lahir_ayah"],input[name="tgl_lahir_wali"],input[name="tgl_mulai_masuk"],input[name="tgl_keluar"],input[name="tanggal"],input[name="tgl_ujian"],input[name="tanggal_tanda_tangan"],input[name="tgl_kalender_mulai"],input[name="tgl_kalender_akhir"],input[name="tgl_mulai_kegiatan"],\n\
           input[name="tgl_akhir_kegiatan"],input[name="tgl_pengajuan"]')
        .datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
        //end datepicker
        
        //Timepicker
        $('input[name="jam"],input[name="jam_normal_mulai"],input[name="jam_normal_akhir"],input[name="jam_puasa_mulai"],input[name=jam_puasa_akhir],input[name="jam_mulai"],input[name="jam_akhir"],input[name="waktu_mulai"],input[name="waktu_selesai"]')
        .timepicker();
        //end timepicker
        
        //add new
        if($('#modal-createPerbaikan').length > 0){
            $('#modal-createPerbaikan').modal('hide');
            $('#save_perbaikan_ajaxMode').live('click',function(){
                
                $.ajax({
                    url: site_url+"master/perbaikan/create_ajaxMode",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        service_category_id : $('#modal-createPerbaikan select[name="service_category_id"]').val().toUpperCase(),
                        perbaikan : $('#modal-createPerbaikan input[name="new_perbaikan"]').val().toUpperCase(),
                        description :  $('#modal-createPerbaikan textarea[name="new_description"]').val().toUpperCase()
                    },
                    success: function( data ) {
                        $('#modal-createPerbaikan .close').trigger('click');//close modal
                        $('#perbaikan_form_extend').html('').load(site_url+"master/perbaikan/view_ajaxMode");//reload perbaikan
                        //reset field
                        $('#modal-createPerbaikan select[name="service_category_id"]').val(0);
                        $('#modal-createPerbaikan input[name="new_perbaikan"]').val('');
                        $('#modal-createPerbaikan textarea[name="new_description"]').val('');
                    }
                });
                return false;
            });
        }
        
        //QUICK update
        if($('#modal-kilometer').length > 0){
            var elem = $('#modal-kilometer');
            elem.modal('hide');
            $('button[name="save"]',elem).live('click',function(){
                $.ajax({
                    url: site_url+"master/kendaraan/quickUpdate_ajaxMode",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        id :  $('input[name="kendaraan_id"]',elem).val(),
                        kilometer :  $('input[name="kilometer"]',elem).val(),
                        section :  $('input[name="section"]',elem).val()
                    },
                    success: function( data ) {
                        $('.close',elem).trigger('click');//close modal
                        $('#kilometer_upToDate').text(data.kilometer_terakhir);
                        //$('#perbaikan_form_extend').html('').load(site_url+"master/perbaikan/view_ajaxMode");//reload perbaikan
                        //reset field
                        $('input[name="kilometer"]',elem).val('');
                    }
                });
                return false;
            });
        }
        
        //ajax autoload
        if($('#perbaikan_form_extend').length > 0){
            var href = $(location).attr('href');
            var uri_segments = href.split('/');
            var action_type = uri_segments[uri_segments.length - 2];
            var service_id = uri_segments[uri_segments.length - 1];
            var service_type = uri_segments[uri_segments.length - 3];
            //[debug]console.log('action type : '+action_type+'service id : '+service_id+', service type : '+ service_type);
            //sementara tambah info, nanti dihapus
            if(action_type === 'update' || action_type === 'info')
                $('#perbaikan_form_extend').empty().load(site_url+"master/perbaikan/view_ajaxMode/"+service_type+"/"+service_id);
            else
                $('#perbaikan_form_extend').empty().load(site_url+"master/perbaikan/view_ajaxMode");
        }
        
        //END QUICK UPDATE
        
        //ajax autoload
        if($('#perbaikan_form_extend').length > 0){
            var href = $(location).attr('href');
            var uri_segments = href.split('/');
            var action_type = uri_segments[uri_segments.length - 2];
            var service_id = uri_segments[uri_segments.length - 1];
            var service_type = uri_segments[uri_segments.length - 3];
            //[debug]console.log('action type : '+action_type+'service id : '+service_id+', service type : '+ service_type);
            //sementara tambah info, nanti dihapus
            if(action_type === 'update' || action_type === 'info')
                $('#perbaikan_form_extend').empty().load(site_url+"master/perbaikan/view_ajaxMode/"+service_type+"/"+service_id);
            else
                $('#perbaikan_form_extend').empty().load(site_url+"master/perbaikan/view_ajaxMode");
        }
        
        if($('#login').length > 0){
            console.log('test');
            $('#login').modal({
                backdrop: false
            });
        }
        
        $(".alert-message").alert('close');
        
        if($('#tab-peminjamanSheet #nip').length > 0){
            $('#tab-peminjamanSheet #nip').typeahead({
                url : site_url+"master/peminjam/suggestion",
                objCatch : 'nip_options', 
                parseData : 'nip',
                dataToView : {
                    peminjam_options : '#peminjam',
                    lokasi_options : '#lokasi',
                    company_options : '#company',
                    department_options : '#department',
                    jabatan_options : '#jabatan'
                }
            });
        }
        
        if($('#tab-peminjamanSheet #no_polisi').length > 0){
            $('#tab-peminjamanSheet #no_polisi').completeby13({
                url : site_url+"vehicle/complete_info/json",
                apply :{
                    id : 'input[name="kendaraan_id"]',
                    merk : '#merk',
                    jenis : '#jenis',
                    no_mesin : '#no_mesin',
                    no_rangka : '#no_rangka',
                    tahun_merk_jenis : '#tahun_merk_jenis',
                    rangka_mesin : '#rangka_mesin'
                },
                where : {
                    status_kendaraan_id : 1
                }

            });        
        }
        
        if($('#tab-pengembalianSheet #no_transaksi').length > 0){
            //get jenis transaksi pengembalian
            $('select[name="tipe_transaksi"]').live('change',function(event){
                var trans_type = $(this).val();
                //reassign - remove element first, karena sudah ter assign typeahead, susah dihilangkan jadi sebaiknya diremove dan append lagi
                $('#tab-pengembalianSheet #no_transaksi').remove();
                $(this).after('&nbsp;<input type="text" autocomplete="off" class="span2" id="no_transaksi" value="" name="no_transaksi">');
                
                $('input[name="no_transaksi"]').typeahead({
                    url : site_url+"transaction/"+trans_type+"/suggestion",
                    objCatch : 'no_'+trans_type+'_options', 
                    parseData : 'no_'+trans_type,
                    dataToView : {
                        
                        nip_options : '#nip',
                        peminjam_options : '#peminjam',
                        no_polisi_hide_options : '#no_polisi'
                    }
                });
            });
        }      
        
        if($('#tab-pengembalianSheet #no_polisi').length > 0){
            $('select[name="tipe_transaksi"]').live('change',function(event){
                var trans_type = $(this).val();  
                
                $('input[name="no_polisi"]').typeahead({
                    url : site_url+"transaction/"+trans_type+"/suggestion_no_polisi",
                    objCatch : 'no_polisi_options', 
                    parseData : 'no_polisi',
                    dataToView : {   
                        
                        nip_options : '#nip',
                        peminjam_options : '#peminjam',
                        no_transaksi_hide_options : '#no_transaksi'
                    }
                });
            });
        }      

        if($('#tab-pengambilanSheet #nip').length > 0){
            $('#tab-pengambilanSheet #nip').typeahead({
                url : site_url+"master/peminjam/suggestion",
                objCatch : 'nip_options', 
                parseData : 'nip',
                dataToView : {
                    peminjam_options : '#peminjam',
                    company_options : '#company',
                    department_options : '#department',
                    jabatan_options : '#jabatan'
                }
            });
        }
         
        if($('#tab-pengambilanSheet #no_polisi').length > 0){
            $('#tab-pengambilanSheet #no_polisi').completeby13({
                url : site_url+"vehicle/complete_info/json",
                apply :{
                    id : 'input[name="kendaraan_id"]',
                    merk : '#merk',
                    jenis : '#jenis',
                    no_mesin : '#no_mesin',
                    no_rangka : '#no_rangka',
                    tahun_merk_jenis : '#tahun_merk_jenis',
                    rangka_mesin : '#rangka_mesin'
                },
                where : {
                    status_kendaraan_id : 1
                }

            });        
        }
  
        //END
        
        //AJAX PAYMENT : Start     
        
        if($('#payment-detail input[name^=no_polisi]').length > 0){
            $('#payment-detail select[name^="jenis_transaksi"]').live('change',function(){
                var idx = $('#payment-detail select[name^="jenis_transaksi"]').index(this);
                $('#payment-detail tbody tr:eq('+idx+') input').val('');
            });
            
            $('#payment-detail input[name^=no_polisi]').typeahead({
                url : site_url+"master/kendaraan/suggestion",
                objCatch : 'no_polisi_options', 
                parseData : 'no_polisi',
                qWhere :{
                    'status_kendaraan_id' : 3
                },
                integration : {
                    'source' : 'jenis_transaksi',
                    'indicator_checked' : 'jenis_transaksi'
                },
                dataToView : {
                    tgl_akhir_options : 'input[name="tgl_lama[]"]',
                    tgl_baru_options : 'input[name="tgl_baru[]"]'
                },
                dataToView_res_inline : true
            });


        }
        
        //enter to tab
        if($('#payment-detail input[name^=total]').length > 0){
            $('#payment-detail input[name^=total]').keydown(function(event){
                $('#msg-keydown').html('keydown() is triggered!, keyCode = ' 
                    + event.keyCode + ' which = ' + event.which)
            });
        }
        
        if($('#add-payment-detail').length > 0 ){
            $('#add-payment-detail').live('click',function(){
                                          
                var master_payment_detail = $('#payment-detail tbody');
             
                var master_payment_detail_TR_TD1 = '<select name="jenis_transaksi[]"><option value="stnk">STNK</option><option value="kir">KIR</option></select>';    
                var master_payment_detail_TR_TD2 = '<input class="span2" type="text" style="text-transform : uppercase;" autocomplete="off" value="" name="no_polisi[]">';
                var master_payment_detail_TR_TD3 = '<input class="span2 hasDatepicker" type="text" value="" name="tgl_lama[]">';
                var master_payment_detail_TR_TD4 = '<input class="span2" type="text" value="" name="tgl_baru[]">';
                var master_payment_detail_TR_TD5 = '<input class="span2 formatWhileTypingAndWarnOnDecimalsEntered2" type="text" value="" name="total[]">&nbsp;&nbsp;&nbsp;<a class="btn btn-mini remove-payment-detail"><i class="icon-minus"></i></a>';
              
                var master_payment_detail_TR = '<tr><td>'+master_payment_detail_TR_TD1+'</td><td>'+master_payment_detail_TR_TD2+'</td><td>'+master_payment_detail_TR_TD3+'</td><td>'+master_payment_detail_TR_TD4+'</td><td>'+master_payment_detail_TR_TD5+'</td></tr>';
                master_payment_detail = master_payment_detail.prepend(master_payment_detail_TR);
               
                $('.formatWhileTypingAndWarnOnDecimalsEntered2').formatCurrency({
                    colorize: true, 
                    negativeFormat: '-%s%n', 
                    roundToDecimalPlace: 0,
                    symbol: ''
                })
                .keyup(function(e) {
                    var e = window.event || e;
                    var keyUnicode = e.charCode || e.keyCode;
                    if (e !== undefined) {
                        switch (keyUnicode) {
                            case 16:
                                break; // Shift
                            case 17:
                                break; // Ctrl
                            case 18:
                                break; // Alt
                            case 27:
                                this.value = '';
                                break; // Esc: clear entry
                            case 35:
                                break; // End
                            case 36:
                                break; // Home
                            case 37:
                                break; // cursor left
                            case 38:
                                break; // cursor up
                            case 39:
                                break; // cursor right
                            case 40:
                                break; // cursor down
                            case 78:
                                break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
                            case 110:
                                break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
                            case 190:
                                break; // .
                            default:
                                $(this).formatCurrency({
                                    colorize: true, 
                                    negativeFormat: '-%s%n', 
                                    roundToDecimalPlace: -1, 
                                    eventOnDecimalsEntered: true,
                                    symbol: ''
                                });
                        }
                    }
                })
                .bind('decimalsEntered', function(e, cents) {
                    if (String(cents).length > 2) {
                        var errorMsg = 'Please do not enter any cents (0.' + cents + ')';
                        $('#formatWhileTypingAndWarnOnDecimalsEnteredNotification2').html(errorMsg);
                        log('Event on decimals entered: ' + errorMsg);
                    }
                });
       
   
                $('#payment-detail input[name^=no_polisi]').typeahead({
                    url : site_url+"master/kendaraan/suggestion",
                    objCatch : 'no_polisi_options', 
                    parseData : 'no_polisi',
                    qWhere :{
                        'status_kendaraan_id' : 3
                    },
                    integration : {
                        'source' : 'jenis_transaksi',
                        'indicator_checked' : 'jenis_transaksi'
                    },
                    dataToView : {
                        tgl_akhir_options : 'input[name="tgl_lama[]"]',
                        tgl_baru_options : 'input[name="tgl_baru[]"]'
                    },
                    dataToView_res_inline : true
                });
                return false;
            });
            
            $('.remove-payment-detail').live('click',function(){
             
                elem = $(this);
                var elem_val = elem.val();
                var idx = $('.remove-payment-detail').index(this);// console.log(idx); 
                var pk_payment_detail_elem = elem.parents('tr').find('input[name="pk[]"]');
                var pk_payment_detail_elem_val = elem.parents('tr').find('input[name="pk[]"]').val();
                
                var total_TR = $('#payment-detail tbody tr').length;//console.log('total TR : ' + total_TR);
                
                if(total_TR == 1){
                    $('.remove-payment-detail').hide();     
                } else if(pk_payment_detail_elem.length > 0){//console.log('punya pk service detail : ' + pk_service_detail_elem_val);                       
                    $.ajax({
                        url:  site_url+"transaction/payment/delete_payment_detail",
                        type: 'POST',
                        dataType: "json",
                        data: {
                            pk: pk_payment_detail_elem_val
                        },
                        success: function( data ) {
               
                        }
                    });                    
                    var elem = $(this);
                    var elem_parent =  elem.parents('tr').remove();                             
                }else{//console.log('tidak punya pk service detail');                    
                    var elem = $(this);
                    var elem_parent =  elem.parents('tr').remove();     
                }
               
                return false;    
            });
       
        } 
        
        //estimate payment KIR || STNK
        if($('#payment-detail').length > 0 ){
            $('input[name^="tgl_lama"]')
            .datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                onSelect:function(dateText, inst) {
                    //var date_selected = inst.lastVal;
                    var next_date = $(this).datepicker('getDate');
                    if (next_date) {
                        var curr_TR = $(this).parent().parent();
                        var transaction_type = curr_TR.find('select[name="jenis_transaksi[]"]').val();
                        var months_next;
                        if(transaction_type != ''){
                            switch(transaction_type){
                                case 'kir':
                                    months_next = 6;
                                    break;
                                case 'stnk':
                                    months_next = 12;//lebih satu emang
                                    break
                            }
                            next_date.setMonth(next_date.getMonth() + months_next);
                            var next_date_formated = $.datepicker.formatDate('yy-mm-dd', next_date);
                            curr_TR.find('input[name="tgl_baru[]"]').val(next_date_formated);
                        }else{
                            alert('Harap pilih Jenis Transaksi');
                            $(this).val('');
                        }                   
                    }                
                }
            });
        }
        
        if($('.remove-payment-detail').length > 0 ){
            $('.remove-payment-detail').live('click',function(){
             
                elem = $(this);
                var elem_val = elem.val();
                var idx = $('.remove-payment-detail').index(this);// console.log(idx); 
                var pk_payment_detail_elem = elem.parents('tr').find('input[name="pk[]"]');
                var pk_payment_detail_elem_val = elem.parents('tr').find('input[name="pk[]"]').val();
                
                var total_TR = $('#payment-detail tbody tr').length;//console.log('total TR : ' + total_TR);
                
                if(total_TR == 1){
                    $('.remove-payment-detail').hide();     
                } else if(pk_payment_detail_elem.length > 0){//console.log('punya pk service detail : ' + pk_service_detail_elem_val);                       
                    $.ajax({
                        url:  site_url+"transaction/payment/delete_payment_detail",
                        type: 'POST',
                        dataType: "json",
                        data: {
                            pk: pk_payment_detail_elem_val
                        },
                        success: function( data ) {
               
                        }
                    });                    
                    var elem = $(this);
                    var elem_parent =  elem.parents('tr').remove();                             
                }else{//console.log('tidak punya pk service detail');                    
                    var elem = $(this);
                    var elem_parent =  elem.parents('tr').remove();     
                }
               
                return false;    
            });
            
        }
        
        if($('#tab-paymentSheet #bureau').length > 0){
            $('#tab-paymentSheet #bureau').typeahead({
                url : site_url+"master/service_bureau/suggestion",
                objCatch : 'bureau_options', 
                parseData : 'bureau'
            });
        }
        
        //AJAX PAYMENT : End
        
        //AJAX Surat Kuasa : Start
        
        if($('#tab-suratkuasaSheet #no_polisi').length > 0){
            $('#tab-suratkuasaSheet #no_polisi').typeahead({
                url : site_url+"master/kendaraan/suggestion",
                objCatch : 'no_polisi_options', 
                parseData : 'no_polisi',
                qWhere :{
                    'status_kendaraan_id' : 3
                },
                dataToView : {
                    merk_options : '#merk',
                    jenis_options : '#jenis',
                    tahun_options : '#tahun',
                    warna_options : '#warna',
                    no_rangka_options : '#no_rangka',
                    no_mesin_options : '#no_mesin'
                }
            });
        }
        
        if($('#tab-suratkuasaSheet #company').length > 0){
            $('#tab-suratkuasaSheet #company').typeahead({
                url : site_url+"master/company/suggestion",
                objCatch : 'company_options', 
                parseData : 'company',
                qWhere :{
                    'company_active' : 1,
                    'branch_active' : 1
                },
                dataToView : {
                    address_options : '#address',
                    branch_id_options : '#branch'
                }
            });
        }
        
        //AJAX Surat Kuasa : Start
        
        //AJAX Surat Pengalihan Hak : Start
        
        if($('#tab-suratpengalihanhakSheet #no_polisi').length > 0){
            $('#tab-suratpengalihanhakSheet #no_polisi').typeahead({
                url : site_url+"master/kendaraan/suggestion",
                objCatch : 'no_polisi_options', 
                parseData : 'no_polisi',
                dataToView : {
                    merk_options : '#merk',
                    jenis_options : '#jenis',
                    tahun_options : '#tahun',
                    warna_options : '#warna',
                    no_rangka_options : '#no_rangka',
                    no_mesin_options : '#no_mesin'
                }
            });
        }
        
        if($('#tab-suratpengalihanhakSheet #company').length > 0){
            $('#tab-suratpengalihanhakSheet #company').typeahead({
                url : site_url+"master/company/suggestion",
                objCatch : 'company_options', 
                parseData : 'company',
                dataToView : {
                    alamat_options : '#alamat'
                }
            });
        }
        
        //AJAX Surat Pengalihan Hak : End
        
        //AJAX Surat Perintah Kerja : Start
        
        if($('#tab-suratperintahkerjaSheet #no_polisi').length > 0){
            $('#tab-suratperintahkerjaSheet #no_polisi').typeahead({
                url : site_url+"master/kendaraan/suggestion",
                objCatch : 'no_polisi_options', 
                parseData : 'no_polisi',
                dataToView : {
                    merk_options : '#merk',
                    jenis_options : '#jenis',
                    tahun_options : '#tahun',
                    warna_options : '#warna',
                    no_rangka_options : '#no_rangka',
                    no_mesin_options : '#no_mesin',
                    kilometer_terakhir_options : '#kilometer_terakhir'
                }
            });
        }
        
        if($('#tab-suratperintahkerjaSheet #company').length > 0){
            $('#tab-suratperintahkerjaSheet #company').typeahead({
                url : site_url+"master/company/suggestion",
                objCatch : 'company_options', 
                parseData : 'company',
                dataToView : {
                    alamat_options : '#alamat'
                }
            });
        }
        
        if($('#suratperintahkerja-detail input[name^="no_part"]').length > 0){
            $('#suratperintahkerja-detail input[name^="no_part"]').typeahead({
                url : site_url+"master/part/suggestion",
                objCatch : 'id_options', 
                parseData : 'no_part',
                integration : {
                    'source' : 'as400',
                    'indicator_checked' : 'use_as400'
                },
                dataToView : {
                    part_options : 'input[name="part[]"]',
                    price_options : 'input[name="price[]"]',
                    stock_options : 'input[name="max_qty[]"]'
                },
                dataToView_res_inline : true
            });
        }
        
        if($('#add-suratperintahkerja-detail').length > 0 ){
            $('#add-suratperintahkerja-detail').live('click',function(){
                var master_suratperintahkerja_detail = $('#suratperintahkerja-detail tbody');
                var master_suratperintahkerja_detail_TR = $('tr:eq(0)',master_suratperintahkerja_detail).html();
                master_suratperintahkerja_detail.prepend('<tr>'+master_suratperintahkerja_detail_TR+'</tr>');
                
                $('#suratperintahkerja-detail input[name^="no_part"]').typeahead({
                    url : site_url+"master/part/suggestion",
                    objCatch : 'id_options', 
                    parseData : 'no_part',
                    dataToView : {
                        part_options : 'input[name="part[]"]',
                        price_options : 'input[name="price[]"]',
                        stock_options : 'input[name="max_qty[]"]'
                    },
                    integration : {
                        'source' : 'as400',
                        'indicator_checked' : 'use_as400'
                    },
                    dataToView_res_inline : true
                });
                return false;
            });
        
        }
        
        if($('#suratperintahkerja-detail input[name^="no_part"]').length > 0){
            $('#suratperintahkerja-detail input[name^="no_part"]').typeahead({
                url : site_url+"master/part/suggestion",
                objCatch : 'id_options', 
                parseData : 'no_part',
                integration : {
                    'source' : 'as400',
                    'indicator_checked' : 'use_as400'
                },
                dataToView : {
                    part_options : 'input[name="part[]"]',
                    price_options : 'input[name="price[]"]',
                    stock_options : 'input[name="max_qty[]"]'
                },
                dataToView_res_inline : true
            });
        }  
        
        if($('#add-suratperintahkerja-detail').length > 0 ){
            $('#add-suratperintahkerja-detail').live('click',function(){
                var master_suratperintahkerja_detail = $('#suratperintahkerja-detail tbody');
                var master_suratperintahkerja_detail_TR = $('tr:eq(0)',master_suratperintahkerja_detail).html();
                master_suratperintahkerja_detail.prepend('<tr>'+master_suratperintahkerja_detail_TR+'</tr>');
                
                $('#suratperintahkerja-detail input[name^="no_part"]').typeahead({
                    url : site_url+"master/part/suggestion",
                    objCatch : 'id_options', 
                    parseData : 'no_part',
                    dataToView : {
                        part_options : 'input[name="part[]"]',
                        price_options : 'input[name="price[]"]',
                        stock_options : 'input[name="max_qty[]"]'
                    },
                    integration : {
                        'source' : 'as400',
                        'indicator_checked' : 'use_as400'
                    },
                    dataToView_res_inline : true
                });
                return false;
            });
        
        }
        
        if($('#suratperintahkerja-detail input[name^="no_part"]').length > 0){
            $('#suratperintahkerja-detail input[name^="no_part"]').typeahead({
                url : site_url+"master/part/suggestion",
                objCatch : 'id_options', 
                parseData : 'no_part',
                integration : {
                    'source' : 'as400',
                    'indicator_checked' : 'use_as400'
                },
                dataToView : {
                    part_options : 'input[name="part[]"]',
                    price_options : 'input[name="price[]"]',
                    stock_options : 'input[name="max_qty[]"]'
                },
                dataToView_res_inline : true
            });
        }
        
        //AJAX Surat Perintah Kerja : End
        
        //AJAX Claim : Start
        
        if($('#tab-claimSheet #nip').length > 0){
            $('#tab-claimSheet #nip').typeahead({
                url : site_url+"master/peminjam/suggestion",
                objCatch : 'nip_options', 
                parseData : 'nip',
                dataToView : {
                    peminjam_options : '#customer'
                }
            });
        }

        $('#tab-claimSheet input[name="no_polisi"]').completeby13({
            url : site_url+"vehicle/complete_info/json",
            apply :{
                no_polisi : 'input[name="no_polisi"]',
                id : 'input[name="kendaraan_id"]',
                merk : '#merk',
                jenis : '#jenis',
                kilometer_terakhir : '#kilometer_terakhir',          
                no_mesin : '#no_mesin',
                no_rangka : '#no_rangka',
                tahun_merk_jenis : '#tahun_merk_jenis',
                rangka_mesin : '#rangka_mesin'
            }
         
        }); 
        
        if($('#tab-claimSheet #bengkel').length > 0){
            $('#tab-claimSheet #bengkel').typeahead({
                url : site_url+"transaction/service_luar/suggestion",
                objCatch : 'bengkel_options', 
                dataToView : {
                    bengkel_id_options : '#bengkel_id',
                    kota_options : '#kota',
                    pic_bengkel_options : '#pic_bengkel',
                    email_options : '#email',
                    telephone_options : '#telephone'
                       
                }            
            });
            
        }       
        
        if($('#tab-claimSheet #nip').length > 0){
            $('#tab-claimSheet #nip').typeahead({
                url : site_url+"master/peminjam/suggestion",
                objCatch : 'nip_options', 
                parseData : 'nip',
                dataToView : {
                    peminjam_options : '#customer'
                }
            });
        }
       
        //AJAX Claim : End
        
        //AJAX Asuransi : Start
             
        if($('#tab-asuransiSheet select[name="jenis_bank"]').length > 0){
            $('#tab-asuransiSheet select[name="jenis_bank"]').live('change',function(){
                asuransi_bank_checker($(this),'#tab-asuransiSheet input[name^="nama_bank"]');
            });
        }  
        
        if($('#tab-asuransiSheet select[name="jenis_tertanggung"]').length > 0){
            $('#tab-asuransiSheet select[name="jenis_tertanggung"]').live('change',function(){
                asuransi_perusahaan_checker($(this),'#tab-asuransiSheet input[name="perusahaan_tertanggung"]');
            });
        }    
        
        if($('#tab-asuransiSheet select[name="jenis_tertanggung"]').length > 0){
            $('#tab-asuransiSheet select[name="jenis_tertanggung"]').live('change',function(){
                asuransi_pribadi_checker($(this),'#tab-asuransiSheet input[name="pribadi_tertanggung"]');
            });
        }    
        
        if($('#tab-asuransiSheet input[name="nama_bank"]').length > 0){
            $('#tab-asuransiSheet input[name="nama_bank"]').typeahead({
                url : site_url+"master/bank/suggestion",
                objCatch : 'bank_options', 
                parseData : 'bank',
                dataToView_res_inline : true
            });
        }
        
        if($('#tab-asuransiSheet input[name="perusahaan_tertanggung"]').length > 0){
            $('#tab-asuransiSheet input[name="perusahaan_tertanggung"]').typeahead({
                url : site_url+"master/company/suggestion",
                objCatch : 'company_options', 
                parseData : 'company',
                dataToView_res_inline : true
            });
        }
                   
        $(".non-bca").hide();
        $(".bca-detail").hide();
        $(".non-bca-detail").hide();
       
        if($('#tab-asuransiSheet input[name="nama_bank"]').length > 0){
            $('#tab-asuransiSheet input[name="nama_bank"]').live('change',function(){
                var idx = $('#tab-asuransiSheet input[name="nama_bank"]').index(this);
                var elem = $(this);  
                var val_nama_bank = elem.val();
                var val_bank = $('#tab-asuransiSheet input[name="nama_bank"]').val();
                var val_action_type = $('#tab-asuransiSheet input[name="action_type"]').val();
                
                if(val_bank == 'BCA'){   
                    $(".non-bca").hide();
                    $(".bca-detail").show();
                    $(".non-bca-detail").hide();
                }else{
                    $(".non-bca").show();
                    $(".bca-detail").hide();
                    $(".non-bca-detail").show();
                }      
              
            });
        }
        
        if($('#tab-asuransiSheet select[name="jenis_bank"]').length > 0){

            var val_jenis_bank = $('#tab-asuransiSheet select[name="jenis_bank"]').val();
            //console.log(val_jenis_bank);
            if(val_jenis_bank=='non-Bank'){
                $(".non-bca").show();
                $(".non-bca-detail").show();
                $(".bca-detail").hide();
            }else{
                $(".non-bca").hide();
                $(".non-bca-detail").hide();
                $(".bca-detail").show();
            }
               
        }  

        if($('#tab-asuransiSheet select[name="jenis_bank"]').length > 0){
            $('#tab-asuransiSheet select[name="jenis_bank"]').live('change',function(){

                var val_jenis_bank = $('#tab-asuransiSheet select[name="jenis_bank"]').val();
                if(val_jenis_bank=='non-Bank'){
                    $(".non-bca").show();
                    $(".non-bca-detail").show();
                }else{
                    $(".non-bca").hide();
                    $(".non-bca-detail").hide();
                }
               
            });
        }  
              
        if($('#asuransi-detail input[name^="no_polisi"]').length > 0){
            $('#asuransi-detail input[name^="no_polisi"]').typeahead({
                url : site_url+"master/kendaraan/suggestion",
                objCatch : 'no_polisi_options', 
                parseData : 'no_polisi',
                dataToView : {
                    vehicle_type_options : 'input[name="vehicle_type[]"]'
                },
                dataToView_res_inline : true
            });
        }

        if($('#asuransi-non-bca-detail input[name^="no_polisi"]').length > 0){
            $('#asuransi-non-bca-detail input[name^="no_polisi"]').typeahead({
                url : site_url+"master/kendaraan/suggestion",
                objCatch : 'no_polisi_options', 
                parseData : 'no_polisi',
                dataToView : {
                    vehicle_type_options : 'input[name="vehicle_type[]"]'
                },
                dataToView_res_inline : true
            });
        }
        
        if($('#asuransi-detail').length > 0 ){
            $('#asuransi-detail input[name="harga_pertanggungan[]"]').keyup(function(){
                var idx = $('#asuransi-detail input[name="harga_pertanggungan[]"]').index(this);
                //check index --> console.log('ini index # '+idx);
                var elem = $(this);  
                var val_harga_pertanggungan = elem.val(); //harga pertanggungan
                
                var val_rate = $('#asuransi-detail input[name="rate[]"]:eq('+idx+')').val(); //rate
                val_rate = (val_rate == '')?1:val_rate;
                
                var val_persentase = $('#asuransi-detail input[name="persentase[]"]:eq('+idx+')').val(); //persentase
                val_persentase = (val_persentase == '')?1:val_persentase;
                
                var premi = val_harga_pertanggungan * val_rate * val_persentase; //premi           
                //console.log(idx);
                $('#asuransi-detail input[name="premi[]"]:eq('+idx+')').val(premi);
            
            });
        }   
               
        if($('#asuransi-non-bca-detail').length > 0 ){
            $('#asuransi-non-bca-detail input[name="harga_pertanggungan[]"]').keyup(function(){
                var idx = $('#asuransi-non-bca-detail input[name="harga_pertanggungan[]"]').index(this);
                //check index --> console.log('ini index # '+idx);
                var elem = $(this);  
                var val_harga_pertanggungan = elem.val(); //harga pertanggungan
                
                var val_rate = $('#asuransi-non-bca-detail input[name="rate[]"]:eq('+idx+')').val(); //rate
                val_rate = (val_rate == '')?1:val_rate;
                
                var val_periode_awal =  $('#tab-asuransiSheet input[name="periode_awal"]').val();  
                var val_periode_akhir =  $('#tab-asuransiSheet input[name="periode_akhir"]').val();  

                var x=val_periode_awal.split("-");     
                var y=val_periode_akhir.split("-");
                var one_day=1000*60*60*24; 

                var date1=new Date(x[0],(x[1]-1),x[2]);
                var date2=new Date(y[0],(y[1]-1),y[2]);

                var month1=x[1]-1;
                var month2=y[1]-1;

                var _Diff = Math.ceil((date2.getTime()-date1.getTime())/(one_day));
                
                var tot_har = _Diff/365;    
                $('#tab-asuransiSheet input[name="tot_har"],#tab-asuransiSheet input[name="jam"]').val(tot_har);
               
                //console.log('Periode Awal : ' +val_periode_awal +' Periode Akhir : ' +val_periode_akhir + ' Selisih Periode : ' + tot_har);
               
                var ReplacedNumber = val_harga_pertanggungan.replace(/[^0-9]/gi,'');

                var premi = ReplacedNumber * val_rate * tot_har; //premi           
               
                //console.log(idx);
                $('#asuransi-non-bca-detail input[name="premi[]"]:eq('+idx+')').val(parseFloat(premi));
            
            });
        }   
        
        if($('#add-asuransi-detail').length > 0 ){
            $('#add-asuransi-detail').live('click',function(){
                
                var master_asuransi_detail = $('#asuransi-detail tbody');
             
                var master_asuransi_detail_TR_TD1 = '<input class="span2" type="text" style="text-transform : uppercase" autocomplete="off" value="" name="no_polisi[]">';    
                var master_asuransi_detail_TR_TD2 = '<input class="span1" type="text" disabled="disable" value="" name="vehicle_type[]">';
                var master_asuransi_detail_TR_TD3 = '<input class="span1" type="text" autocomplete="off" value="" name="tahun[]">';
                var master_asuransi_detail_TR_TD4 = '<select name="cover[]"><option value="All Risk">All Risk</option><option value="TLO">TLO</option><option value="All Risk Exclude TLO">All Risk Exclude TLO</option></select>';
                var master_asuransi_detail_TR_TD5 = '<input class="span1" type="text" value="" name="rate[]">';
                var master_asuransi_detail_TR_TD6 = '<input class="span1" type="text" value="" name="persentase[]">';
                var master_asuransi_detail_TR_TD7 = '<input id="num" class="span2 formatWhileTypingAndWarnOnDecimalsEntered2" type="text" value="" name="harga_pertanggungan[]">';
                var master_asuransi_detail_TR_TD8 = '<input id="format" class="span1" type="text" value="" name="premi[]">&nbsp;&nbsp;&nbsp;<a class = "btn btn-mini remove-asuransi-detail"><i class = "icon-minus"></i></a>';
                var master_asuransi_detail_TR = '<tr><td>'+master_asuransi_detail_TR_TD1+'</td><td>'+master_asuransi_detail_TR_TD2+'</td><td>'+master_asuransi_detail_TR_TD3+'</td><td>'+master_asuransi_detail_TR_TD4+'</td><td>'+master_asuransi_detail_TR_TD5+'</td><td>'+master_asuransi_detail_TR_TD6+'</td><td>'+master_asuransi_detail_TR_TD7+'</td><td>'+master_asuransi_detail_TR_TD8+'</td></tr>';
                master_asuransi_detail = master_asuransi_detail.prepend(master_asuransi_detail_TR);

                $('#asuransi-detail input[name^="no_polisi"]').typeahead({
                    url : site_url+"master/kendaraan/suggestion",
                    objCatch : 'no_polisi_options', 
                    parseData : 'no_polisi',
                    dataToView : {
                        vehicle_type_options : 'input[name="vehicle_type[]"]'
                    },
                    dataToView_res_inline : true
                });      
                
                $('.remove-asuransi-detail').live('click',function(){
             
                    elem = $(this);
                    var elem_val = elem.val();
                    var idx = $('.remove-asuransi-detail').index(this);// console.log(idx); 
                    var pk_asuransi_detail_elem = elem.parents('tr').find('input[name="pk[]"]');
                    var pk_asuransi_detail_elem_val = elem.parents('tr').find('input[name="pk[]"]').val();
                
                    var total_TR = $('#asuransi-detail tbody tr').length;//console.log('total TR : ' + total_TR);
                
                    if(total_TR == 1){
                        $('.remove-asuransi-detail').hide();     
                    } else if(pk_asuransi_detail_elem.length > 0){//console.log('punya pk service detail : ' + pk_service_detail_elem_val);                       
                        $.ajax({
                            url:  site_url+"transaction/asuransi/delete_asuransi_detail",
                            type: 'POST',
                            dataType: "json",
                            data: {
                                pk: pk_asuransi_detail_elem_val
                            },
                            success: function( data ) {
               
                            }
                        });                    
                        var elem = $(this);
                        var elem_parent =  elem.parents('tr').remove();                             
                    }else{//console.log('tidak punya pk service detail');                    
                        var elem = $(this);
                        var elem_parent =  elem.parents('tr').remove();     
                    }
               
                    return false;    
                });
                
                return false;
            });
        
        }       
        
        if($('#add-asuransi-non-bca-detail').length > 0 ){
            $('#add-asuransi-non-bca-detail').live('click',function(){
                
                var master_asuransi_detail = $('#asuransi-non-bca-detail tbody');
             
                var master_asuransi_detail_TR_TD1 = '<input class="span2" type="text" style="text-transform : uppercase" autocomplete="off" value="" name="no_polisi[]">';    
                var master_asuransi_detail_TR_TD2 = '<input class="span1" type="text" disabled="disable" value="" name="vehicle_type[]">';
                var master_asuransi_detail_TR_TD4 = '<select name="cover[]"><option value="All Risk">All Risk</option><option value="TLO">TLO</option><option value="All Risk Exclude TLO">All Risk Exclude TLO</option></select>';
                var master_asuransi_detail_TR_TD5 = '<input class="span1" type="text" value="" name="rate[]">';
                var master_asuransi_detail_TR_TD7 = '<input id="num" class="span2 formatWhileTypingAndWarnOnDecimalsEntered2" type="text" value="" name="harga_pertanggungan[]">';
                var master_asuransi_detail_TR_TD8 = '<input id="format" class="span1" type="text" value="" name="premi[]">&nbsp;&nbsp;&nbsp;<a class = "btn btn-mini remove-asuransi-non-bca-detail"><i class = "icon-minus"></i></a>';
                var master_asuransi_detail_TR = '<tr><td>'+master_asuransi_detail_TR_TD1+'</td><td>'+master_asuransi_detail_TR_TD2+'</td><td>'+master_asuransi_detail_TR_TD4+'</td><td>'+master_asuransi_detail_TR_TD5+'</td><td>'+master_asuransi_detail_TR_TD7+'</td><td>'+master_asuransi_detail_TR_TD8+'</td></tr>';
                master_asuransi_detail = master_asuransi_detail.prepend(master_asuransi_detail_TR);

                $('#asuransi-non-bca-detail input[name^="no_polisi"]').typeahead({
                    url : site_url+"master/kendaraan/suggestion",
                    objCatch : 'no_polisi_options', 
                    parseData : 'no_polisi',
                    dataToView : {
                        vehicle_type_options : 'input[name="vehicle_type[]"]'
                    },
                    dataToView_res_inline : true
                });      
                
                $('.remove-asuransi-non-bca-detail').live('click',function(){
             
                    elem = $(this);
                    var elem_val = elem.val();
                    var idx = $('.remove-asuransi-non-bca-detail').index(this);// console.log(idx); 
                    var pk_asuransi_detail_elem = elem.parents('tr').find('input[name="pk[]"]');
                    var pk_asuransi_detail_elem_val = elem.parents('tr').find('input[name="pk[]"]').val();
                
                    var total_TR = $('#asuransi-non-bca-detail tbody tr').length;//console.log('total TR : ' + total_TR);
                
                    if(total_TR == 1){
                        $('.remove-asuransi-non-bca-detail').hide();     
                    } else if(pk_asuransi_detail_elem.length > 0){//console.log('punya pk service detail : ' + pk_service_detail_elem_val);                       
                        $.ajax({
                            url:  site_url+"transaction/asuransi/delete_asuransi_detail",
                            type: 'POST',
                            dataType: "json",
                            data: {
                                pk: pk_asuransi_detail_elem_val
                            },
                            success: function( data ) {
               
                            }
                        });                    
                        var elem = $(this);
                        var elem_parent =  elem.parents('tr').remove();                             
                    }else{//console.log('tidak punya pk service detail');                    
                        var elem = $(this);
                        var elem_parent =  elem.parents('tr').remove();     
                    }
               
                    return false;    
                });
                
                return false;
            });
        
        }       
                
        if($('.remove-asuransi-detail').length > 0 ){
            $('.remove-asuransi-detail').live('click',function(){
             
                elem = $(this);
                var elem_val = elem.val();
                var idx = $('.remove-asuransi-detail').index(this);// console.log(idx); 
                var pk_asuransi_detail_elem = elem.parents('tr').find('input[name="pk[]"]');
                var pk_asuransi_detail_elem_val = elem.parents('tr').find('input[name="pk[]"]').val();
                
                var total_TR = $('#asuransi-detail tbody tr').length;//console.log('total TR : ' + total_TR);
                
                if(total_TR == 1){
                    $('.remove-asuransi-detail').hide();     
                } else if(pk_asuransi_detail_elem.length > 0){//console.log('punya pk service detail : ' + pk_service_detail_elem_val);                       
                    $.ajax({
                        url:  site_url+"transaction/asuransi/delete_asuransi_detail",
                        type: 'POST',
                        dataType: "json",
                        data: {
                            pk: pk_asuransi_detail_elem_val
                        },
                        success: function( data ) {
               
                        }
                    });                    
                    var elem = $(this);
                    var elem_parent =  elem.parents('tr').remove();                             
                }else{//console.log('tidak punya pk service detail');                    
                    var elem = $(this);
                    var elem_parent =  elem.parents('tr').remove();     
                }
               
                return false;    
            });
            
        }
        
        if($('.remove-asuransi-non-bca-detail').length > 0 ){
            $('.remove-asuransi-non-bca-detail').live('click',function(){
             
                elem = $(this);
                var elem_val = elem.val();
                var idx = $('.remove-asuransi-non-bca-detail').index(this);// console.log(idx); 
                var pk_asuransi_detail_elem = elem.parents('tr').find('input[name="pk[]"]');
                var pk_asuransi_detail_elem_val = elem.parents('tr').find('input[name="pk[]"]').val();
                
                var total_TR = $('#asuransi-non-bca-detail tbody tr').length;//console.log('total TR : ' + total_TR);
                
                if(total_TR == 1){
                    $('.remove-asuransi-non-bca-detail').hide();     
                } else if(pk_asuransi_detail_elem.length > 0){//console.log('punya pk service detail : ' + pk_service_detail_elem_val);                       
                    $.ajax({
                        url:  site_url+"transaction/asuransi/delete_asuransi_detail",
                        type: 'POST',
                        dataType: "json",
                        data: {
                            pk: pk_asuransi_detail_elem_val
                        },
                        success: function( data ) {
               
                        }
                    });                    
                    var elem = $(this);
                    var elem_parent =  elem.parents('tr').remove();                             
                }else{//console.log('tidak punya pk service detail');                    
                    var elem = $(this);
                    var elem_parent =  elem.parents('tr').remove();     
                }
               
                return false;    
            });
            
        }
        
        if($('#add-asuransi-detail').length > 0 ){
            $('#add-asuransi-detail').live('click',function(){
                
                $('#asuransi-detail input[name="harga_pertanggungan[]"]').keyup(function(){
                    var idx = $('#asuransi-detail input[name="harga_pertanggungan[]"]').index(this);
                    //check index --> 
                    console.log('ini index # '+idx);
                    var elem = $(this);  
                    var val_harga_pertanggungan = elem.val(); //harga pertanggungan
                    
                    var val_rate = $('#asuransi-detail input[name="rate[]"]:eq('+idx+')').val(); //rate
                    val_rate = (val_rate == '')?1:val_rate;
                    
                    var val_persentase = $('#asuransi-detail input[name="persentase[]"]:eq('+idx+')').val(); //persentase
                    val_persentase = (val_persentase == '')?1:val_persentase;
                    
                    var premi = val_harga_pertanggungan * val_rate * val_persentase; //premi    
                    
                    console.log(val_harga_pertanggungan * val_rate * val_persentase);
                    $('#asuransi-detail input[name="premi[]"]:eq('+idx+')').val(premi);
                
                });
                
                return false;
            });
        
        }
        
        if($('#add-asuransi-non-bca-detail').length > 0 ){
            $('#add-asuransi-non-bca-detail').live('click',function(){
                
                $('#asuransi-non-bca-detail input[name="harga_pertanggungan[]"]').keyup(function(){
                    var idx = $('#asuransi-non-bca-detail input[name="harga_pertanggungan[]"]').index(this);
                    //check index --> 
                    console.log('ini index # '+idx);
                    var elem = $(this);  
                    var val_harga_pertanggungan = elem.val(); //harga pertanggungan
                    
                    var val_rate = $('#asuransi-non-bca-detail input[name="rate[]"]:eq('+idx+')').val(); //rate
                    val_rate = (val_rate == '')?1:val_rate;
                    
                    var val_tot_hari = $('#tab-asuransiSheet input[name="total_hari"]').val();
                    var val_sel_hari = val_tot_hari/365;
                
                    var premi = val_harga_pertanggungan * val_rate * val_sel_hari; //premi       
                    
                    console.log(val_harga_pertanggungan * val_rate * val_sel_hari);
                    $('#asuransi-non-bca-detail input[name="premi[]"]:eq('+idx+')').val(premi);
                
                });
                
                return false;
            });
        
        }
        
        //AJAX Asuransi : End
       
        //AJAX Penjualan : Start
        
        $('#tab-penjualanSheet input[name="no_polisi"]').completeby13({
            url : site_url+"vehicle/complete_info/json",
            apply :{
                no_polisi : 'input[name="no_polisi"]',
                id : 'input[name="kendaraan_id"]',
                merk : '#merk',
                jenis : '#jenis',
                kilometer_terakhir : '#kilometer_terakhir',          
                last_user_name_only : '#customer',
                last_user_nip : '#nip',
                no_mesin : '#no_mesin',
                no_rangka : '#no_rangka',
                tahun_merk_jenis : '#tahun_merk_jenis',
                rangka_mesin : '#rangka_mesin',
                foc : 'input[name="foc"]',
                service_log_html : '#temp_service_log_html'
            }
         
        }); 

        //AJAX Penjualan : End
        
        //AJAX Mutasi : Start
        
        if($('#tab-mutasiSheet #no_polisi_lama').length > 0){
            $('#tab-mutasiSheet #no_polisi_lama').typeahead({
                url : site_url+"master/kendaraan/suggestion",
                objCatch : 'no_polisi_options', 
                parseData : 'no_polisi',
                dataToView : {
                    merk_options : '#merk_lama',
                    jenis_options : '#jenis_lama',
                    tahun_options : '#tahun_lama',
                    no_rangka_options : '#no_rangka_lama',
                    no_mesin_options : '#no_mesin_lama'
                }
            });
        }
        
        if($('#tab-mutasiSheet #no_polisi_baru').length > 0){
            $('#tab-mutasiSheet #no_polisi_baru').typeahead({
                url : site_url+"master/kendaraan/suggestion",
                objCatch : 'no_polisi_options', 
                parseData : 'no_polisi',
                dataToView : {
                    merk_options : '#merk_baru',
                    jenis_options : '#jenis_baru',
                    tahun_options : '#tahun_baru',
                    no_rangka_options : '#no_rangka_baru',
                    no_mesin_options : '#no_mesin_baru'
                }
            });
        }  
    
        //AJAX Mutasi : End
        
        //AJAX Audit : Start
            
        $('#tab-auditSheet input[name="no_polisi"]').completeby13({
            url : site_url+"vehicle/complete_info/json",
            apply :{
                no_polisi : 'input[name="no_polisi"]',
                id : 'input[name="kendaraan_id"]',
                merk : '#merk',
                jenis : '#jenis',
                kilometer_terakhir : '#kilometer_terakhir',          
                no_mesin : '#no_mesin',
                no_rangka : '#no_rangka',
                tahun_merk_jenis : '#tahun_merk_jenis',
                rangka_mesin : '#rangka_mesin'
            }
         
        }); 
        
        if($('#audit-detail input[name^="no_polisi"]').length > 0){
            $('#audit-detail input[name^="no_polisi"]').typeahead({
                url : site_url+"master/kendaraan/suggestion",
                objCatch : 'no_polisi_options', 
                parseData : 'no_polisi',
                dataToView : {
                    vehicle_type_options : 'input[name="vehicle_type[]"]'
                },
                dataToView_res_inline : true
            });
        }
        
        if($('#add-audit-detail').length > 0 ){
            $('#add-audit-detail').live('click',function(){
                var master_audit_detail = $('#audit-detail tbody');
                var master_audit_detail_TR = $('tr:eq(0)',master_audit_detail).html();
                master_audit_detail.prepend('<tr>'+master_audit_detail_TR+'</tr>');
                
                $('#audit-detail input[name^="no_polisi"]').typeahead({
                    url : site_url+"master/kendaraan/suggestion",
                    objCatch : 'no_polisi_options', 
                    parseData : 'no_polisi',
                    dataToView : {
                        vehicle_type_options : 'input[name="vehicle_type[]"]'
                    
                    },
                    dataToView_res_inline : true
                });
                return false;
            });
        
        }
        
        if($('#audit-detail input[name^="no_polisi"]').length > 0){
            $('#audit-detail input[name^="no_polisi"]').typeahead({
                url : site_url+"master/kendaraan/suggestion",
                objCatch : 'no_polisi_options', 
                parseData : 'no_polisi',
                dataToView : {
                    vehicle_type_options : 'input[name="vehicle_type[]"]'
                },
                dataToView_res_inline : true
            });
        }
        
        //AJAX Audit : End
               
        //letter_of_authority / surat kuasa
        if($('#letter_of_authority #no_polisi').length > 0){
         
            $('#letter_of_authority #no_polisi').completeby13({
                url : site_url+"vehicle/complete_info/json",
                apply :{
                    id : 'input[name="temp_kendaraan_id"]',
                    merk_jenis : '#merk_jenis',
                    rangka_mesin : '#rangka_mesin'
                }
            });
            
            $('#letter_of_authority #company').typeahead({
                url : site_url+"master/company/unique_suggestion",
                objCatch : 'company_options', 
                parseData : 'company',
                qWhere :{
                    'active' : 1
                },
                dataToView : {
                    address_options : 'input[name="temp_company_address"]',
                    branch_id_options : 'input[name="temp_branch_id"]',
                    branch_options : 'input[name="temp_branch_name"]'
                }
            });           
            
            $('#letter_of_authority select[name="branch_id"]').live('click',function(){
                var get_branch_id = $('#letter_of_authority input[name="temp_branch_id"]').val();
                var get_branch_name = $('#letter_of_authority input[name="temp_branch_name"]').val();
                
                var branch_id_arr = get_branch_id.split(',');
                var branch_name_arr = get_branch_name.split(',');
                //create options
                var options_html = '<option value="0">-CABANG-</option>';
                $.each(branch_id_arr,function(index,value){
                    options_html += '<option value="'+value+'">'+branch_name_arr[index]+'</option>';
                });
                $('#letter_of_authority select[name="branch_id"]').html(options_html);
                
                //tandain yang pernah terpilih sebelumnya
                var already_choosed = $('#letter_of_authority select[name="branch_id"]').attr('choosed');
                if( already_choosed !== 'undefined' && already_choosed !== '')
                    $('#letter_of_authority select[name="branch_id"]').val(already_choosed);
                return false;
            }).live('change',function(){ //trigger change setelah klik dropdown
                
                var branch_id_arr = $('#letter_of_authority input[name="temp_branch_id"]').val().split(',');
                var index_selected = branch_id_arr.indexOf($(this).val());
                var get_company_address = $('#letter_of_authority input[name="temp_company_address"]').val();
                var company_address_arr = get_company_address.split('|,');
                company_address_arr = $.map(company_address_arr,function(n,i){
                    var last_word = n.substring(n.length - 1, n.length);
                    //console.log(last_word);
                    return (last_word === '|')?n.replace('|',''):n;
                });
                $('#letter_of_authority textarea[name="alamat"]').val(company_address_arr[index_selected]);
                $('#letter_of_authority select[name="branch_id"]').attr('choosed',$(this).val());//tandain kalo udah ter pilih , karena setelah ini click akan tertrigger lagi
            });
            
            //check jika company sudah diisi / ada default
            //6 adalah id branch jakarta
            if($('#letter_of_authority #company').val() != ''){
                $('#letter_of_authority select[name="branch_id"]')
                .trigger('click')
                .val(6)
                .trigger('change');
            }   
        }
        
        //dropoff / pengembalian
        $('#dropoff input[name="no_polisi"]').completeby13({
            url : site_url+"vehicle/complete_info/json",
            apply :{
                id : 'input[name="kendaraan_id"]',
                merk_jenis : '#merk_jenis',
                last_pickup : '#transaksi',
                last_used_date : '#tgl_sewa',
                last_user : '#peminjam',
                last_user_name_only : 'input[name="diserahkan_oleh"]',
                last_pickup_type : 'input[name="tipe_transaksi"]',
                last_pickup_id : 'input[name="no_transaksi"]'
            },
            xalert : {
                last_pickup_id : '|Kendaraan tidak disewa'
            }
        }); 
        
       
        $('.no-enter input').stop13();// jika menggunaka class no-enter pada tipe inputan, maka tdk bs menggunakan enter
        
        $('#service_history_list .toggle-detail').live('click',function(){
            //$('#kendaraan #collapse_all').removeClass('active');
            $('#service_log_expand_all').removeClass('active');
            var to_expand = $(this).attr('to_expand');
            $('.target_to_expand').each(function(){
                var elem = $(this);
                var target_ID = elem.attr('id');
                if(target_ID == to_expand){
                    if(elem.hasClass('collapsed')){
                        $('#'+target_ID)
                        .removeClass('collapsed')
                        .addClass('expanded');
                    }else{
                        $('#'+target_ID)
                        .removeClass('expanded')
                        .addClass('collapsed');
                    }
                    
                }
            });
        });
        $('#service_log_expand_all').live('click',function(){
            $('#service_log_collapse_all').removeClass('active');
            $(this).addClass('active');
            $('.target_to_expand')
            .removeClass('collapsed')
            .addClass('expanded');
        });
        
        $('#service_log_collapse_all').live('click',function(){
            $('#service_log_expand_all').removeClass('active');
            //$(this).addClass('active');
            $('.target_to_expand')
            .removeClass('expanded')
            .addClass('collapsed');
        });
        
        $('#tab-serviceSheet input[name="no_polisi"]').completeby13({
            url : site_url+"vehicle/complete_info/json",
            apply :{
                no_polisi : 'input[name="no_polisi"]',
                id : 'input[name="kendaraan_id"]',
                merk : '#merk',
                jenis : '#jenis',
                kilometer_terakhir : '#kilometer_terakhir',          
                last_user_name_only : '#customer',
                last_user_nip : '#nip',
                no_mesin : '#no_mesin',
                no_rangka : '#no_rangka',
                tahun_merk_jenis : '#tahun_merk_jenis',
                rangka_mesin : '#rangka_mesin',
                foc : 'input[name="foc"]',
                service_log_html : '#temp_service_log_html'
            },
            hidesome :{
                foc : 'false|#biaya_group'
            }
        /*,
            xalert : {
                has_service_pending : 'false|Kendaraan masih di Service'
            },
            check_on_autoload : 'globvar_vehicle_autoloaded'
             */
        }); 
        
        if($('#service-detail input[name^="no_part"]').length > 0){
            $('#service-detail input[name^="no_part"]').typeahead({
                url : site_url+"master/part/suggestion_by_no_part",
                objCatch : 'id_options', 
                parseData : 'no_part',
                integration : {
                    'source' : 'as400',
                    'indicator_checked' : 'use_as400'
                },
                dataToView : {
                    barcode_options : 'input[name="barcode[]"]',
                    part_options : 'input[name="part[]"]',
                    stock_options : '.stock',
                    price_options : 'input[name="price[]"]'
                },
                dataToView_res_inline : true
            });
        }
           
        if($('#service-detail input[name^="barcode"]').length > 0){
            $('#service-detail input[name^="barcode"]').typeahead({
                url : site_url+"master/part/suggestion_by_barcode",
                objCatch : 'barcode_options', 
                parseData : 'barcode',
                dataToView : {
                    id_options : 'input[name="no_part[]"]',
                    part_options : 'input[name="part[]"]',
                    stock_options : '.stock',
                    price_options : 'input[name="price[]"]'
                },
                dataToView_res_inline : true
            });
        }
        
        if($('#service-detail input[name^="part"]').length > 0){
            $('#service-detail input[name^="part"]').typeahead({
                url : site_url+"master/part/suggestion_by_part",
                objCatch : 'part_options', 
                parseData : 'part',
                dataToView : {
                    id_options : 'input[name="no_part[]"]',
                    barcode_options : 'input[name="barcode[]"]',
                    stock_options : '.stock',
                    price_options : 'input[name="price[]"]'
                },
                dataToView_res_inline : true
            });
        }
        
        if($('#service-luar-detail input[name^="part"]').length > 0){
            $('#service-luar-detail input[name^="part"]').typeahead({
                url : site_url+"master/part/suggestion_by_part_luar",
                objCatch : 'part_options', 
                parseData : 'part',
                dataToView : {
                    id_options : 'input[name="no_part[]"]',
                    price_options : 'input[name="price[]"]'
                },
                dataToView_res_inline : true
            });
        }
        
        if($('#service-luar-detail').length > 0 ){
            $('#service-luar-detail input[name="qty[]"]').keyup(function(){
                var idx = $('#service-luar-detail input[name="qty[]"]').index(this);
                //check index --> console.log('ini index # '+idx);
                var elem = $(this);    
                var val_qty = elem.val();
                var val_price = $('#service-luar-detail input[name="price[]"]:eq('+idx+')').val();
                val_price = (val_price == '')?1:val_price;
                var total = val_qty * val_price;
                console.log(idx);
                $('#service-luar-detail input[name="total[]"]:eq('+idx+')').val(total);

            });
        }
        
        if($('#service-luar-detail').length > 0 ){
            $('#service-luar-detail input[name="price[]"]').keyup(function(){
                var idx = $('#service-luar-detail input[name="price[]"]').index(this);
                //check index --> console.log('ini index # '+idx);
                var elem = $(this);    
                var val_price = elem.val();
                var val_qty = $('#service-luar-detail input[name="qty[]"]:eq('+idx+')').val();
                val_qty = (val_qty == '')?1:val_qty;
                var total = val_price * val_qty;
                console.log(idx);
                $('#service-luar-detail input[name="total[]"]:eq('+idx+')').val(total);
                 
            });
        }
        
        if($('#add-service-luar-detail').length > 0 ){
            $('#add-service-luar-detail').live('click',function(){
                var master_service_detail = $('#service-luar-detail tbody');
                
                var master_service_detail_TR_TD1 = '<input class="span5" type="text" style="text-transform : uppercase" autocomplete="off" value="" name="part[]">';    
                var master_service_detail_TR_TD2 = '<input class="span1 formatWhileTypingAndWarnOnDecimalsEntered" type="text" value="" name="price[]">';
                var master_service_detail_TR_TD3 = '<input class="span1" type="text" value="" name="qty[]"><input type="hidden" value="" name="pk[]"><input type="hidden" value="" name="no_part[]">&nbsp;&nbsp;&nbsp;<a class="btn btn-mini remove-service-luar-detail"><i class="icon-minus"></i></a>';
                var master_service_detail_TR = '<tr><td>'+master_service_detail_TR_TD1+'</td><td>'+master_service_detail_TR_TD2+'</td><td>'+master_service_detail_TR_TD3+'</td></tr>';
                master_service_detail = master_service_detail.prepend(master_service_detail_TR);

                if($('#service-luar-detail input[name^="part"]').length > 0){
                    $('#service-luar-detail input[name^="part"]').typeahead({
                        url : site_url+"master/part/suggestion_by_part_luar",
                        objCatch : 'part_options', 
                        parseData : 'part',
                        dataToView : {
                            id_options : 'input[name="no_part[]"]',
                            price_options : 'input[name="price[]"]'
                        },
                        dataToView_res_inline : true
                    
                    });
                }
        
                if($('#service-luar-detail').length > 0 ){
                    $('#service-luar-detail input[name="qty[]"]').keyup(function(){
                        var idx = $('#service-luar-detail input[name="qty[]"]').index(this);
                        //check index --> console.log('ini index # '+idx);
                        var elem = $(this);    
                        var val_qty = elem.val();
                        var val_price = $('#service-luar-detail input[name="price[]"]:eq('+idx+')').val();
                        val_price = (val_price == '')?1:val_price;
                        var total = val_qty * val_price;
                        console.log(idx);
                        $('#service-luar-detail input[name="total[]"]:eq('+idx+')').val(total);
                
            
                    });
                }
        
                if($('#service-luar-detail').length > 0 ){
                    $('#service-luar-detail input[name="price[]"]').keyup(function(){
                        var idx = $('#service-luar-detail input[name="price[]"]').index(this);
                        //check index --> console.log('ini index # '+idx);
                        var elem = $(this);    
                        var val_price = elem.val();
                        var val_qty = $('#service-luar-detail input[name="qty[]"]:eq('+idx+')').val();
                        val_qty = (val_qty == '')?1:val_qty;
                        var total = val_price * val_qty;
                        console.log(idx);
                        $('#service-luar-detail input[name="total[]"]:eq('+idx+')').val(total);
                 
                    });
                }
        
                return false;
            });
            
            $('.remove-service-luar-detail').live('click',function(){
                
                elem = $(this);
                var elem_val = elem.val();
                var idx = $('.remove-service-luar-detail').index(this);// console.log(idx); 
                var part_service_detail_elem = elem.parents('tr').find('input[name="no_part[]"]');
                var pk_service_detail_elem = elem.parents('tr').find('input[name="pk[]"]');
                var pk_service_detail_elem_val = elem.parents('tr').find('input[name="pk[]"]').val();
                
                var total_TR = $('#service-luar-detail tbody tr').length;//console.log('total TR : ' + total_TR);
                
                if(total_TR == 1){
                    $('.remove-service-luar-detail').hide();                   
                } else if(pk_service_detail_elem.length > 0){//console.log('punya pk service detail : ' + pk_service_detail_elem_val);                       
                    $.ajax({
                        url:  site_url+"transaction/service/delete_service_detail",
                        type: 'POST',
                        dataType: "json",
                        data: {
                            pk: pk_service_detail_elem_val
                        },
                        success: function( data ) {
               
                        }
                    });                    
                    var elem = $(this);
                    var elem_parent =  elem.parents('tr').remove();                             
                }else{//console.log('tidak punya pk service detail');                    
                    var elem = $(this);
                    var elem_parent =  elem.parents('tr').remove();     
                }
               
                return false;    
            });
                      
        }

        //START autocomplete using typeahead modified
        
        if($('#tab-serviceSheet select[name="service_category_id"]').length > 0){
            // kategori & perbaikan
            $('#tab-serviceSheet select[name="service_category_id"]').trigger('change');
            $('#tab-serviceSheet select[name="service_category_id"]').live('change',function(){
                elem = $(this); 
                var elem_val = elem.val();
                var field_perbaikan = $('#tab-serviceSheet select[name="perbaikan_id"]');
                if(elem_val == '0'){
                    field_perbaikan.removeAttr('prevdata-selected');
                    $('#by_perbaikan').parent().parent().remove();
                }else{
                    var string ={
                        service_category_id : elem_val,
                        data_type : 'json'
                    };
                    
                    $.post(site_url+'master/perbaikan',string,function(res){
                        var options_html = '<option value="0">-PERBAIKAN-</option>';
                        $.each(res, function(key, val) {
                            options_html += '<option value="'+key+'">'+val+'</option>';
                        });
                        field_perbaikan.html(options_html);
                        
                        //auto select latest data
                        var prevData_selected = $('#tab-serviceSheet select[name="perbaikan_id"]').attr('prevdata-selected');
                        if(prevData_selected != '')
                            $('#tab-serviceSheet select[name="perbaikan_id"] option[value="'+prevData_selected+'"]').attr('selected','selected');
                    
                    }, 'json');
                
                }
            });
        }
        
        if($('#tab-serviceSheet select[name="service_category_id"]').val() >= 0 ) $('#tab-serviceSheet select[name="service_category_id"]').trigger('change');
        
        $("#temp_teknisi_dropdown").hide();
        
        if($('#add-perbaikan-detail').length > 0 ){
            $('#add-perbaikan-detail').live('click',function(){
                
                var cat_perbaikan = $('.perbaikan-detail select[name="service_category_id"]').val(); 
                var cat_perbaikan_name = $('#service_category_id option:selected').text();
                
                var perbaikan = $('.perbaikan-detail select[name="perbaikan_id"]').val();
                var perbaikan_name = $('#perbaikan_id option:selected').text();
                
                var teknisi = $('.perbaikan-detail select[name="temp_teknisi_dropdown"]').val();
                var teknisi_name = $('#temp_teknisi_dropdown option:selected').text();
                
                if(cat_perbaikan==0){
                    alert("Harap Pilih Kategori Perbaikan");                  
                }else if(perbaikan==0){
                    alert("Harap Pilih Perbaikan");
                }else{
                    var cloned = $("#temp_teknisi_dropdown").html();//<select class="input-medium" name="tek_id[]">'+cloned+'</select>
                                 
                    var elem = $(this);
                    var elem_parent = elem.parents('.control-group');
                    var html_to_add = '<div class="control-group">\n\
                                            <label class="control-label">&nbsp</label>\n\
                                            <div class="controls">'+ cat_perbaikan_name +' <input class="span1" type="hidden" value="' + cat_perbaikan + '" name="cat_per_id[]"> - '+ perbaikan_name +' <input class="span1" type="hidden" value="' + perbaikan + '" name="per_id[]">\n\
                                                <a class="btn btn-mini remove-perbaikan-detail"><i class="icon-minus"></i></a>\n\
                                            </div>\n\
                                      </div>';
                    elem_parent.after(html_to_add);
                    
                    //assign eventnya
                    $('.remove-perbaikan-detail').live('click',function(){
             
                        elem = $(this);
                        var idx = $('.remove-perbaikan-detail').index(this);//console.log(idx);
                        var pk_perbaikan_detail_elem = elem.parents('.control-group').find('input[name="pk_perbaikan_detail[]"]');
                        var pk_perbaikan_detail_elem_val = elem.parents('.control-group').find('input[name="pk_perbaikan_detail[]"]').val();
                  
                        if(pk_perbaikan_detail_elem.length > 0){//console.log('punya pk perbaikan : ' + pk_perbaikan_detail_elem_val);
                            $.ajax({
                                url:  site_url+"transaction/service/delete_perbaikan",
                                type: 'POST',
                                dataType: "json",
                                data: {
                                    pk_perbaikan_detail: pk_perbaikan_detail_elem_val
                                },
                                success: function( data ) {
               
                                }
                            });                                   
                            var elem = $(this);
                            var elem_parent = elem.parents('.controls').parent().remove()
                        }else{//console.log('tidak punya pk perbaikan');
                            var elem = $(this);
                            var elem_parent = elem.parents('.controls').parent().remove() 
                        }
             
                        return false;    
                    });
                
                }
          
                return false;
            });
           
        }
               
        if($('.remove-perbaikan-detail').length > 0 ){
            $('.remove-perbaikan-detail').live('click',function(){
             
                elem = $(this);
                var idx = $('.remove-perbaikan-detail').index(this);//console.log(idx);
                var pk_perbaikan_detail_elem = elem.parents('.control-group').find('input[name="pk_perbaikan_detail[]"]');
                var pk_perbaikan_detail_elem_val = elem.parents('.control-group').find('input[name="pk_perbaikan_detail[]"]').val();
                  
                if(pk_perbaikan_detail_elem.length > 0){//console.log('punya pk perbaikan : ' + pk_perbaikan_detail_elem_val);
                    $.ajax({
                        url:  site_url+"transaction/service/delete_perbaikan",
                        type: 'POST',
                        dataType: "json",
                        data: {
                            pk_perbaikan_detail: pk_perbaikan_detail_elem_val
                        },
                        success: function( data ) {
               
                        }
                    });                                   
                    var elem = $(this);
                    var elem_parent = elem.parents('.controls').parent().remove()
                }else{//console.log('tidak punya pk perbaikan');
                    var elem = $(this);
                    var elem_parent = elem.parents('.controls').parent().remove() 
                }
             
                return false;    
            });
            
        }
          
        if($('#add-service-detail').length > 0 ){
            $('#add-service-detail').live('click',function(){
                var master_service_detail = $('#service-detail tbody');
                var master_service_detail_TR_TD1 = '<input class="input-medium" type="text" style="text-transform: uppercase;" autocomplete="off" value="" name="no_part[]">';         
                var master_service_detail_TR_TD2 = '<input class="input-medium" type="text" style="text-transform: uppercase;" autocomplete="off" value="" name="barcode[]">';
                var master_service_detail_TR_TD3 = '<input class="span5" type="text" style="text-transform : uppercase" autocomplete="off" value="" name="part[]">';
                var master_service_detail_TR_TD4 = '<label style="width:50px" class="stock control-label al">-</label>';
                var master_service_detail_TR_TD5 = '<input class="span1" type="text" value="" name="qty[]">&nbsp;<input type="hidden" value="" name="price[]">&nbsp;&nbsp;<a class="btn btn-mini remove-service-detail"><i class="icon-minus"></i></a>';
                var master_service_detail_TR = '<tr><td>'+master_service_detail_TR_TD1+'</td><td>'+master_service_detail_TR_TD2+'</td><td>'+master_service_detail_TR_TD3+'</td><td>'+master_service_detail_TR_TD4+'</td><td>'+master_service_detail_TR_TD5+'</td></tr>';
                master_service_detail = master_service_detail.prepend(master_service_detail_TR);
  
                $('#service-detail input[name^="no_part"]').typeahead({
                    url : site_url+"master/part/suggestion_by_no_part",
                    objCatch : 'id_options', 
                    parseData : 'no_part',
                    integration : {
                        'source' : 'as400',
                        'indicator_checked' : 'use_as400'
                    },
                    dataToView : {
                        barcode_options : 'input[name="barcode[]"]',
                        part_options : 'input[name="part[]"]',
                        stock_options : '.stock',
                        price_options : 'input[name="price[]"]'
                      
                    },
                    dataToView_res_inline : true
                });
                
                $('#service-detail input[name^="barcode"]').typeahead({
                    url : site_url+"master/part/suggestion_by_barcode",
                    objCatch : 'barcode_options', 
                    parseData : 'barcode',
                    dataToView : {
                        id_options : 'input[name="no_part[]"]',
                        part_options : 'input[name="part[]"]',
                        stock_options : '.stock',
                        price_options : 'input[name="price[]"]'
                    },
                    dataToView_res_inline : true
                });
                
                $('#service-detail input[name^="part"]').typeahead({
                    url : site_url+"master/part/suggestion_by_part",
                    objCatch : 'part_options', 
                    parseData : 'part',
                    dataToView : {
                        id_options : 'input[name="no_part[]"]',
                        barcode_options : 'input[name="barcode[]"]',
                        stock_options : '.stock',
                        price_options : 'input[name="price[]"]'
                    },
                    dataToView_res_inline : true
                });
                     
                return false;
            });
                      
        }
        
        if($('.remove-service-detail').length > 0 ){
            $('.remove-service-detail').live('click',function(){
                
                elem = $(this);
                var elem_val = elem.val();
                var idx = $('.remove-service-detail').index(this);// console.log(idx); 
                var part_service_detail_elem = elem.parents('tr').find('input[name="no_part[]"]');
                var pk_service_detail_elem = elem.parents('tr').find('input[name="pk[]"]');
                var pk_service_detail_elem_val = elem.parents('tr').find('input[name="pk[]"]').val();
                
                var total_TR = $('#service-detail tbody tr').length;//console.log('total TR : ' + total_TR);
                
                if(total_TR == 1){
                    $('.remove-service-detail').hide();     
                } else if(pk_service_detail_elem.length > 0){//console.log('punya pk service detail : ' + pk_service_detail_elem_val);                       
                    $.ajax({
                        url:  site_url+"transaction/service/delete_service_detail",
                        type: 'POST',
                        dataType: "json",
                        data: {
                            pk: pk_service_detail_elem_val
                        },
                        success: function( data ) {
               
                        }
                    });                    
                    var elem = $(this);
                    var elem_parent =  elem.parents('tr').remove();                             
                }else{//console.log('tidak punya pk service detail');                    
                    var elem = $(this);
                    var elem_parent =  elem.parents('tr').remove();     
                }
               
                return false;    
            });
            
        }
        
        if($('.remove-service-luar-detail').length > 0 ){
            $('.remove-service-luar-detail').live('click',function(){
                
                elem = $(this);
                var elem_val = elem.val();
                var idx = $('.remove-service-luar-detail').index(this);// console.log(idx); 
                var part_service_detail_elem = elem.parents('tr').find('input[name="no_part[]"]');
                var pk_service_detail_elem = elem.parents('tr').find('input[name="pk[]"]');
                var pk_service_detail_elem_val = elem.parents('tr').find('input[name="pk[]"]').val();
                
                var total_TR = $('#service-luar-detail tbody tr').length;//console.log('total TR : ' + total_TR);
                
                if(total_TR == 1){
                    $('.remove-service-luar-detail').hide();                   
                } else if(pk_service_detail_elem.length > 0){//console.log('punya pk service detail : ' + pk_service_detail_elem_val);                       
                    $.ajax({
                        url:  site_url+"transaction/service/delete_service_detail",
                        type: 'POST',
                        dataType: "json",
                        data: {
                            pk: pk_service_detail_elem_val
                        },
                        success: function( data ) {
               
                        }
                    });                    
                    var elem = $(this);
                    var elem_parent =  elem.parents('tr').remove();                             
                }else{//console.log('tidak punya pk service detail');                    
                    var elem = $(this);
                    var elem_parent =  elem.parents('tr').remove();     
                }
               
                return false;    
            });
            
        }

        $('#reason_cancel').hide();          
        
        function status_service_checker(check,target){
            //console.log($(check).val());
            if($(check).val() == 'BATAL'){
                return $(target).show();//just show it
            }else{
                return $(target)
                .val('')
                .hide();//reset & hide
            }
        }
        
        if($('#tab-serviceSheet select[name="status"]').length > 0){
            $('#tab-serviceSheet select[name="status"]').live('change',function(){
                status_service_checker($(this),'#reason_cancel');
            });
        }    
        
        if( $('#tab-serviceSheet input[name="bengkel_id"]').length > 0){
            
            elem = $(this);
            var elem_val = elem.val();
            var idx = $('.teknisi_outsource').index(this);//console.log(idx); 
            
            var val_bengkel_luar = $('#tab-serviceSheet input[name="bengkel_id"]').val(); 
            if(val_bengkel_luar != 46){
                $('.teknisi_outsource').hide();
            }
        }    
               
        if($('.teknisi_outsource').length > 0 ){
            $('.teknisi_outsource').live('change',function(){
                
                elem = $(this);
                var elem_val = elem.val();
                var idx = $('.teknisi_outsource').index(this);//console.log(idx); 
                var teknisi_id = elem.parents('div').find('select[name^="tek_id[]"]:eq('+idx+')').val();
                var val_bengkel_luar = $('#tab-serviceSheet input[name="bengkel_id"]').val(); 

                if(teknisi_id == 26 && val_bengkel_luar != 46){//nanti bisa yang lain
                    alert("Maaf OUTSOURCE Khusus Bengkel Dalam !");
                    elem.parents('div').find('select[name^="tek_id[]"]:eq('+idx+')').val("0")
                }else{
                    if(teknisi_id == 26){
                        $('#tab-serviceSheet select[name="bek_id[]"]:eq('+idx+')').show();
                        $('.part_luar').show();           
                    }
                    else{
                        $('#tab-serviceSheet select[name="bek_id[]"]:eq('+idx+')').hide();
                        $('.part_luar').hide();  
                    }   
                }
           
            });
        
        }    

        //dynamic keluhan
        if($('.bengkel_outsource').length > 0 ){
            $('.bengkel_outsource').live('change',function(){
                
                elem = $(this);
                var elem_val = elem.val();
                var idx = $('.bengkel_outsource').index(this);//console.log(idx); 
                var bek_id = elem.parents('div').find('select[name^="bek_id[]"]:eq('+idx+')').val(); 
                var val_bengkel_luar = $('#tab-serviceSheet select[name^="bek_id[]"]:eq('+idx+')').val();               
                var label_bengkel = $('.bengkel_outsource :selected:eq('+idx+')').text();
                if(val_bengkel_luar > 0){                  
                    var cloned = $('.keluhan').html();                              
                    var elem = $(this);
                    var elem_parent = elem.parents('div').find('.keluhan_template');
                    var html_to_add = '&nbsp;&nbsp;<textarea placeholder="Keluhan '+label_bengkel+'" rows="3" cols="40" name="keluhan['+bek_id+']"></textarea>&nbsp;&nbsp;';
                    elem_parent.after(html_to_add); 
                }        
        
            });
            
        }    
        
        if($('.bengkel_outsource').length > 0 ){
            $('.bengkel_outsource').each(function(index) {
                
                elem = $(this); // alert(index + ': ' + $(this).text());
                var elem_val = elem.val(); //alert(elem_val);   
               
                var idx = $('.bengkel_outsource').index(this);//console.log(idx); 
                var bek_id = elem.parents('div').find('select[name^="bek_id[]"]:eq('+idx+')').val();
                               
                if(bek_id != 0){
                    $('#tab-serviceSheet select[name="bek_id[]"]:eq('+idx+')').show();  
                }
                else{
                    $('#tab-serviceSheet select[name="bek_id[]"]:eq('+idx+')').hide();              
                }   
               
                if(bek_id == 0){
                    $('.part_luar').hide();
                }else{
                    $('.part_luar').show();
                }
 
            });
        }
        
        //Punya Service Dalam
        if($('#tab-serviceSheet input[name="no_polisi"]').length > 0){
            //auto trigger
            var no_polisi = $('#tab-serviceSheet input[name="no_polisi"]').val();
            if(no_polisi != ''){
                $.vehicle_autoloaded = true;
                var e = $.Event('keypress');
                e.which = 13;
                e.keyCode = 13;
                $('#tab-serviceSheet input[name="no_polisi"]').trigger(e);
            }
        }
        
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
         
        if($('#tab-serviceSheet #bengkel').length > 0){
            $('#tab-serviceSheet #bengkel').typeahead({
                url : site_url+"transaction/service_luar/suggestion",
                objCatch : 'bengkel_options', 
                dataToView : {
                    bengkel_id_options : '#bengkel_id',
                    kota_options : '#kota',
                    pic_bengkel_options : '#pic_bengkel',
                    email_options : '#email',
                    telephone_options : '#telephone'
                       
                }            
            });
            
        }       

        $("#temp_teknisi_dropdown").hide();
        
        if($('#tab-serviceSheet input[name="lain_lain"]').length > 0 ){
            $('#tab-serviceSheet input[name="lain_lain"]').typeahead({
                url : site_url+"master/perbaikan/suggestion",
                objCatch : 'perbaikan_options', 
                parseData : 'lain_lain',
                qWhere : {
                    service_category_id : 6 //ID perbaikan lain-lain
                }
            }).bind('keyup',function(e){
                elem = $(this);
                var e = window.event || e;
                var keycode = e.charCode || e.keyCode;
                
                if (e !== undefined) {
                    switch(keycode){  
                        case 13 :
                            //save perbaikan
                            //get date
                            var fullDate = new Date();
                            var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);//convert month to 2 digits
                            var currentDate = fullDate.getFullYear()+'-'+twoDigitMonth+ "-" +fullDate.getDate()+ " " +fullDate.getHours()+':'+fullDate.getMinutes()+':'+fullDate.getSeconds();
                    
                            $.ajax({
                                type: "POST",
                                url: site_url+"master/perbaikan/create_ajaxMode",
                                dataType : 'json',
                                data: {
                                    service_category_id : 6,//category perbaikan lain-lain
                                    perbaikan : elem.val(),
                                    description :elem.val(),
                                    created_on :currentDate,
                                    created_by : user_nip
                                },
                                success: function(res){
                                    var perbaikan_id = '';
                                    if(res){
                                        $.each(res,function(i,n){
                                            perbaikan_id = i;
                                            var perbaikan = n;
                                        });
                                    }
                                    var html_temp = '<div class="control-group"><label class="control-label">&nbsp;</label><div class="controls"><label style="width: 400px;" class="control-label al">'+elem.val().toUpperCase()+'&nbsp;<a class="btn btn-mini remove-perbaikan-lain-detail"><i class="icon-minus"></i></a><input type="hidden" name="cat_per_id[]" value="6"><input type="hidden" name="per_id[]" value="'+perbaikan_id+'"></label></div></div>';
                                    elem.parent().parent().after(html_temp);
                                    
                                    //assign eventnya
                                    if($('.remove-perbaikan-lain-detail').length > 0 ){
                                        $('.remove-perbaikan-lain-detail').live('click',function(){             
                                            var elem = $(this);
                                            var elem_parent = elem.parents('.controls').parent().remove();
                                            return false;    
                                        });
            
                                    }
                                }
                            });
                            break;
                    }
                    
                }           
            });
        } 
      
        //JQUERY PLUGIN
        // Start Format Currency : jquery.formatCurrency-1.4.0 => for Payment Module
        // Format while typing & warn on decimals entered, 2 decimal places
        $('.formatWhileTypingAndWarnOnDecimalsEntered2').blur(function() {
            $('.formatWhileTypingAndWarnOnDecimalsEnteredNotification2').html(null);
            $(this).formatCurrency({
                colorize: true, 
                negativeFormat: '-%s%n', 
                roundToDecimalPlace: 0,
                symbol: ''
            });
        })
        .keyup(function(e) {
            var e = window.event || e;
            var keyUnicode = e.charCode || e.keyCode;
            if (e !== undefined) {
                switch (keyUnicode) {
                    case 16:
                        break; // Shift
                    case 17:
                        break; // Ctrl
                    case 18:
                        break; // Alt
                    case 27:
                        this.value = '';
                        break; // Esc: clear entry
                    case 35:
                        break; // End
                    case 36:
                        break; // Home
                    case 37:
                        break; // cursor left
                    case 38:
                        break; // cursor up
                    case 39:
                        break; // cursor right
                    case 40:
                        break; // cursor down
                    case 78:
                        break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
                    case 110:
                        break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
                    case 190:
                        break; // .
                    default:
                        $(this).formatCurrency({
                            colorize: true, 
                            negativeFormat: '-%s%n', 
                            roundToDecimalPlace: -1, 
                            eventOnDecimalsEntered: true,
                            symbol: ''
                        });
                }
            }
        })
        .bind('decimalsEntered', function(e, cents) {
            if (String(cents).length > 2) {
                var errorMsg = 'Please do not enter any cents (0.' + cents + ')';
                $('#formatWhileTypingAndWarnOnDecimalsEnteredNotification2').html(errorMsg);
                log('Event on decimals entered: ' + errorMsg);
            }
        });
    
        // End Format Currency : jquery.formatCurrency-1.4.0 
    
        if($('.formatWhileTypingAndWarnOnDecimalsEntered2').length > 0 ){
            $('.formatWhileTypingAndWarnOnDecimalsEntered2').live('click',function(){
   
                }).bind('keydown',function(e){
                elem = $(this);
                var e = window.event || e;
                var keycode = e.charCode || e.keyCode;
                
                if (e !== undefined) {
                    switch(keycode){  
                        case 9 :
                           
                            var master_payment_detail = $('#payment-detail tbody');
                            var master_payment_detail_TR = $('tr:eq(0)',master_payment_detail).html();
                            master_payment_detail.prepend('<tr>'+master_payment_detail_TR+'</tr>');
                            $('.formatWhileTypingAndWarnOnDecimalsEntered2').formatCurrency({
                                colorize: true, 
                                negativeFormat: '-%s%n', 
                                roundToDecimalPlace: 0,
                                symbol: ''
                            })
                            .keyup(function(e) {
                                var e = window.event || e;
                                var keyUnicode = e.charCode || e.keyCode;
                                if (e !== undefined) {
                                    switch (keyUnicode) {
                                        case 16:
                                            break; // Shift
                                        case 17:
                                            break; // Ctrl
                                        case 18:
                                            break; // Alt
                                        case 27:
                                            this.value = '';
                                            break; // Esc: clear entry
                                        case 35:
                                            break; // End
                                        case 36:
                                            break; // Home
                                        case 37:
                                            break; // cursor left
                                        case 38:
                                            break; // cursor up
                                        case 39:
                                            break; // cursor right
                                        case 40:
                                            break; // cursor down
                                        case 78:
                                            break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
                                        case 110:
                                            break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
                                        case 190:
                                            break; // .
                                        default:
                                            $(this).formatCurrency({
                                                colorize: true, 
                                                negativeFormat: '-%s%n', 
                                                roundToDecimalPlace: -1, 
                                                eventOnDecimalsEntered: true,
                                                symbol: ''
                                            });
                                    }
                                }
                            })
                            .bind('decimalsEntered', function(e, cents) {
                                if (String(cents).length > 2) {
                                    var errorMsg = 'Please do not enter any cents (0.' + cents + ')';
                                    $('#formatWhileTypingAndWarnOnDecimalsEnteredNotification2').html(errorMsg);
                                    log('Event on decimals entered: ' + errorMsg);
                                }
                            });
        
                            $('#payment-detail input[name^=no_polisi]').typeahead({
                                url : site_url+"master/kendaraan/suggestion",
                                objCatch : 'no_polisi_options', 
                                parseData : 'no_polisi',
                                qWhere :{
                                    'status_kendaraan_id' : 3
                                },
                                integration : {
                                    'source' : 'jenis_transaksi',
                                    'indicator_checked' : 'jenis_transaksi'
                                },
                                dataToView : {
                                    tgl_akhir_options : 'input[name="tgl_lama[]"]',
                                    tgl_baru_options : 'input[name="tgl_baru[]"]'
                                },
                                dataToView_res_inline : true
                            });
                            return false;
            
                            break;
                    }
                    
                }           
            });
        } 
    
    });
})(jQuery);
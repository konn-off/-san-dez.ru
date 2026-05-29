var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};

   
    var selects = document.querySelectorAll("[name='status_lead']");

    selects.forEach(select => {
        select.onchange = () => {  //alert(select.getAttribute('data-id')); //alert(select.value);
            $.get("https://san-dez.ru/my_script/all_leads_save/insert.php",{ id: select.getAttribute('data-id'), status_lead: select.value }, onAjaxSuccess );
            function onAjaxSuccess(data){ location.reload(); }
        };
    });
    
    var earnings = document.querySelectorAll("[name='price']");

    earnings.forEach(earning => {
        earning.onchange = () => {  
            $.get("https://san-dez.ru/my_script/all_leads_save/insert.php",{ id: earning.getAttribute('data-id'), price: earning.value }, onAjaxSuccess );
            function onAjaxSuccess(data){ location.reload(); }
        };
    });
    
    var coments = document.querySelectorAll("#coment");

    coments.forEach(coment => {
        coment.onkeyup = () => {  
            $.get("https://san-dez.ru/my_script/all_leads_save/insert.php",{ id: coment.getAttribute('data-id'), coment: coment.innerHTML }, onAjaxSuccess );
            function onAjaxSuccess(data){  }
        };
    });
    
    
    
    $('.date_but').on('click', function(){
        var date_on = $('.date_on').val();
        var date_off = $('.date_off').val();
        if(date_on<date_off || date_on==date_off){
            window.location.replace('https://san-dez.ru'+window.location.pathname+'?date_on='+date_on+'&date_off='+date_off);
        }else{alert('Не верная дата');}
    });
    
    $('.source').on('click', function(){
        $('.filter_source,.close').fadeIn();
    });
    $('.site').on('click', function(){
        $('.filter_site,.close').fadeIn();
    });
    $('.utm_source').on('click', function(){
        $('.filter_utm_source,.close').fadeIn();
    });
    $('.utm_medium').on('click', function(){
        $('.filter_utm_medium,.close').fadeIn();
    });
    $('.utm_campaign').on('click', function(){
        $('.filter_utm_campaign,.close').fadeIn();
    });
    $('.utm_content').on('click', function(){
        $('.filter_utm_content,.close').fadeIn();
    });
    $('.utm_term').on('click', function(){
        $('.filter_utm_term,.close').fadeIn();
    });
    $('.close').on('click', function(){
        $('.filter_source,.filter_site,.filter_utm_source,.filter_utm_medium,.filter_utm_campaign,.filter_utm_content,.filter_utm_term,.close').fadeOut();
    });
    


    function filters_on(filter_name,filter_val){console.log(filter_val);
        var date_on = getUrlParameter('date_on');
        var date_off = getUrlParameter('date_off');
        var povtor_lead = getUrlParameter('povtor_lead');
        if(povtor_lead !=''){var povtor_lead = '&povtor_lead='+povtor_lead;} else {var povtor_lead = '';}
        if(date_on !='' && date_off !=''){var date_filter = 'date_on='+date_on+'&date_off='+date_off;} else {var date_filter = '';}
        if(filter_val != ''){
            window.location.replace('https://san-dez.ru'+window.location.pathname+'?'+date_filter+povtor_lead+'&'+filter_name+'='+filter_val);
        }else{
            window.location.replace('https://san-dez.ru'+window.location.pathname+'?'+date_filter+povtor_lead);
        }
        
    }
    
    $('.filter_source_but').on('click', function(){
        var mvar = "";
        $("[name='source']:checked").each(function() {
            if(mvar == ''){ mvar += '"'+$(this).val()+'"'; }else{ mvar += ',"'+$(this).val()+'"'; }
        });
        filters_on('fiter_source',mvar);
    });
    
    $('.filter_utm_source_but').on('click', function(){
        var mvar = "";
        $("[name='utm_source']:checked").each(function() {
            if(mvar == ''){ mvar += '"'+$(this).val()+'"'; }else{ mvar += ',"'+$(this).val()+'"'; }
        });
        filters_on('fiter_utm_source',mvar);
    });
    
    //
    
    
    
    
    
    $('.table_open, .table_open2, .table_open3').on('click', function(d){const id = this.id;
        //Находим все элементы с id "line"
        let lines = document.querySelectorAll('.'+id);
        
        //Обходим каждый найденный элемент 
        for  (let line of lines) {
            line.classList.toggle('hidd');
        }
        
    });
    
    
    
    $('.insert_cost').on('click', function(){ 
        $('.insert_cost_form').fadeIn();
    });
    
    
    
    $('.insert_cost_form button').on('click', function(){
        $.post('https://san-dez.ru/my_script/all_leads_save/insert.php', {cost: $('.insert_cost_form textarea').val()}, function(data){
            $('.insert_cost_form textarea').val(data);
            setTimeout(() => location.reload(), 5000);
        });
    });
    
    
    $('[name="table_vid"]').on('change', function(event){
        //console.log(event.target.value);
        window.location.href = window.location.href+'&table_vid='+event.target.value;
    });
    
    
    
    $('.insert_lead_roistat').on('click', function(){
        alert($(this).attr('data-id'));
        $.post('https://san-dez.ru/my_script/all_leads_save/insert.php', {insert_lead_roistat: $(this).attr('data-id')}, function(data){
            setTimeout(() => location.reload(), 2000);
        });
    });
    
    
    
    /******* WZ *******/
    $('.close_block_mes_wz').on('click', function(){$('.wz_chat_open').val('0'); $('.block_mes_wz').fadeOut(); $('.but_green').attr('class','but_wz_sent');});
    
    function showmessage(dialogId){
        $.get('https://san-dez.ru/my_script/wappi/api.php', {type_mes: 'get_mes', phone: dialogId}, function(data){ 
            var dat = data.split(":::");
            //$('.wz_phone').text(dat[2]);
            $('.wz_name').text(dat[0]);
            $('.mes_wz').html(dat[3]);
        });
    }
    
    function showmessageMax(phone, chat_id_max){
        $.get('https://san-dez.ru/my_script/wappi_Max/Api_Max.php', {type_mes: 'get_mes', phone: phone, chat_id: chat_id_max}, function(data){ 
            var dat = data.split(":::");
            //$('.wz_phone').text(dat[2]);
            $('.wz_name').text(dat[0]);
            $('.mes_wz').html(dat[3]);
        });
    }
    
        
    function showmessageTg(phone, chat_id_max){
        $.get('https://san-dez.ru/my_script/wappi_Tg/Api_Tg.php', {type_mes: 'get_mes', phone: phone, chat_id: chat_id_max}, function(data){ 
            var dat = data.split(":::");
            //$('.wz_phone').text(dat[2]);
            $('.wz_name').text(dat[0]);
            $('.mes_wz').html(dat[3]);
        });
    }
    
    function showmessageTeletype(dialogId){
        $.get('https://san-dez.ru/my_script/Teletype/api.php', {type: 'all_mes', dialogId: dialogId}, function(data){
            var dat = data.split(":::");
            $('.wz_phone').text(dat[2]);
            $('.wz_name').text(dat[0]);
            $('.mes_wz').html(dat[3]);
        });
    }
    
    
    
    $('.but_mes_shablon').on('click', function(){$('.shablon_mes_wz').fadeIn();});
    
    $('.shablon_mes_wz p').on('click', function(){
        $('.mes_wz_sent textarea').val($(this).html());
        $('.shablon_mes_wz').fadeOut();
    });
    
    
    
    $('.but_messenger_wz').on('click', function(){
        $('.but_messenger_max').removeClass('but_messenger_activ');
        $('.but_messenger_tg').removeClass('but_messenger_activ');
        $('.but_messenger_wz').addClass('but_messenger_activ');
        $('.wz_messenger_activ').val('wz');
        showmessage($('.wz_phone').text());
    });
    $('.but_messenger_max').on('click', function(){
        $('.but_messenger_wz').removeClass('but_messenger_activ');
        $('.but_messenger_tg').removeClass('but_messenger_activ');
        $('.but_messenger_max').addClass('but_messenger_activ');
        $('.wz_messenger_activ').val('max');
        showmessageMax($('.wz_phone').text(), $('.wz_chat_id_max').val());
    });
    $('.but_messenger_tg').on('click', function(){
        $('.but_messenger_wz').removeClass('but_messenger_activ');
        $('.but_messenger_max').removeClass('but_messenger_activ');
        $('.but_messenger_tg').addClass('but_messenger_activ');
        $('.wz_messenger_activ').val('tg');
        showmessageTg($('.wz_phone').text(), $('.wz_chat_id_max').val());
    });
    

// остановить вывод через 5 секунд
//setTimeout(() => { clearInterval(timerId); alert('stop'); }, 5000);
    
    
    
    
    
    

    $('.but_wz_sent').on('click', function(){
        //clearInterval(timerId);
        $('.wz_chat_open').val('1');
        $('.but_green').attr('class','but_wz_sent');
        $(this).attr('class',$(this).attr('class')+' but_green');
        //alert($(this).attr('data-phone'));
        $('.block_mes_wz').fadeIn();
        $('.mes_wz').html('<img src="https://san-dez.ru/my_script/Teletype/load_icon.gif">');
        $('.wz_dialogId').val($(this).attr('id'));
        $('.wz_chat_id_max').val($(this).attr('data-chat_id_max'));
        $('.wz_chat_id_tg').val($(this).attr('data-chat_id_tg'));
        
        $('.block_mes_wz .id_crm').text($(this).attr('data-id_crm'));
        $('.block_mes_wz .wz_phone').text($(this).attr('data-phone'));
        
        if($(this).attr('data-messenger_activ')=='wz'){
            $('.but_messenger_wz').attr('class','but_messenger_wz but_messenger_activ');
            $('.but_messenger_max').attr('class','but_messenger_max');
            $('.but_messenger_tg').attr('class','but_messenger_tg');
            $('.wz_messenger_activ').val('wz');
            if($(this).attr('id')!=''){showmessageTeletype($(this).attr('id'));}else{showmessage($(this).attr('data-phone'));}
        }
        if($(this).attr('data-messenger_activ')=='max'){
            $('.but_messenger_max').attr('class','but_messenger_max but_messenger_activ');
            $('.but_messenger_wz').attr('class','but_messenger_wz');
            $('.but_messenger_tg').attr('class','but_messenger_tg');
            $('.wz_messenger_activ').val('max');
            showmessageMax($(this).attr('data-phone'), $(this).attr('data-chat_id_max'));
        }
        if($(this).attr('data-messenger_activ')=='tg'){
            $('.but_messenger_tg').attr('class','but_messenger_tg but_messenger_activ');
            $('.but_messenger_wz').attr('class','but_messenger_wz');
            $('.but_messenger_max').attr('class','but_messenger_max');
            $('.wz_messenger_activ').val('tg');
            showmessageTg($(this).attr('data-phone'), $(this).attr('data-chat_id_tg'));
        }
        
        
        // повторить с интервалом 4 секунды
        //let timerId = setInterval(() => showmessage($(this).attr('data-phone')), 4000);
    });
    
    
    $('.but_wz_new_dialog').on('click', function(){
        $('.but_green').attr('class','but_wz_sent');
        $(this).attr('class','but_wz_sent but_green'); 
        $.get('https://san-dez.ru/my_script/Teletype/api.php', {type: 'new_dialog', clientPhone: $(this).attr('data-phone')}, function(data){
            //alert(data);
            if(data != '' && data.indexOf('Ошибка') == -1){
                $('.block_mes_wz').fadeIn();
                $('.mes_wz').html('<img src="https://san-dez.ru/my_script/Teletype/load_icon.gif">');
                $('.wz_dialogId').val(data);
                $('.block_mes_wz .id_crm').text($(this).attr('data-id_crm'));
                $(this).attr('id',data)
                
                showmessage(data);
            }
            if(data.indexOf('Ошибка') != -1){alert(data);}
        });
    });
    
    
    
    
    $('body').on('click', '.new_mes_noti', function(){
        $(this).fadeOut();
        $('.wz_chat_open').val('1');
        //$('.but_green').attr('class','but_wz_sent');
        //$(this).attr('class',$(this).attr('class')+' but_green');
        //alert($(this).attr('data-phone'));
        $('.block_mes_wz').fadeIn();
        $('.mes_wz').html('<img src="https://san-dez.ru/my_script/Teletype/load_icon.gif">');
        $('.wz_dialogId').val($(this).attr('id'));
        $('.wz_chat_id_max').val($(this).attr('data-chat_id_max'));
        $('.wz_chat_id_tg').val($(this).attr('data-chat_id_tg'));
        
        $('.block_mes_wz .id_crm').text($(this).attr('data-id_crm'));
        $('.block_mes_wz .wz_phone').text($(this).attr('data-phone'));
        
        if($(this).attr('data-messenger_activ')=='wz'){
            $('.but_messenger_wz').attr('class','but_messenger_wz but_messenger_activ');
            $('.but_messenger_max').attr('class','but_messenger_max');
            $('.but_messenger_tg').attr('class','but_messenger_tg');
            $('.wz_messenger_activ').val('wz');
            if($(this).attr('id')!=''){showmessageTeletype($(this).attr('id'));}else{showmessage($(this).attr('data-phone'));}
        }
        if($(this).attr('data-messenger_activ')=='max'){
            $('.but_messenger_max').attr('class','but_messenger_max but_messenger_activ');
            $('.but_messenger_wz').attr('class','but_messenger_wz');
            $('.but_messenger_tg').attr('class','but_messenger_tg');
            $('.wz_messenger_activ').val('max');
            showmessageMax($(this).attr('data-phone'), $(this).attr('data-chat_id_max'));
        }
        if($(this).attr('data-messenger_activ')=='tg'){
            $('.but_messenger_tg').attr('class','but_messenger_tg but_messenger_activ');
            $('.but_messenger_wz').attr('class','but_messenger_wz');
            $('.but_messenger_max').attr('class','but_messenger_max');
            $('.wz_messenger_activ').val('tg');
            showmessageTg($(this).attr('data-phone'), $(this).attr('data-chat_id_tg'));
        }
        
    });
    
    
    $('.but_mes_sent').on('click', function(){
        
        if($('.wz_dialogId').val()!=''){
            $.get('https://san-dez.ru/my_script/Teletype/api.php', {type: 'sent_mes', dialogId: $('.wz_dialogId').val(), mes: $('.mes_wz_sent textarea').val(), id_men: $('.wz_id_men').val(), name_men: $('.wz_name_men').val()}, function(data){
                //alert(data);
                $('.mes_wz_sent textarea').val('');
                setTimeout(showmessageTeletype($('.wz_dialogId').val()), 2000);
                setTimeout(showmessageTeletype($('.wz_dialogId').val()), 4000);
            });
        }else{
            var type_mes = $(this).attr('data-type_mes');
            if($(this).attr('data-id_mes_reply')){var message_id = $(this).attr('data-id_mes_reply');}else{var message_id = '';}
            if(type_mes=='file'){
                var url_file = $('.file_load_url').attr('data-url_file');
                var caption = $('.mes_wz_sent textarea').val();
                var file_name = $('.file_load_url').attr('data-name_file');
            }else {var url_file = ''; var caption = ''; var file_name = '';}
            
            
            $('.mes_wz').html('<img src="https://san-dez.ru/my_script/Teletype/load_icon.gif">');
            
            if($('.wz_messenger_activ').val() == 'max'){
                var url_script = 'https://san-dez.ru/my_script/wappi_Max/Api_Max.php';
                var chat_id = $('.wz_chat_id_max').val();
            }
            if($('.wz_messenger_activ').val() == 'tg'){
                var url_script = 'https://san-dez.ru/my_script/wappi_Tg/Api_Tg.php';
                var chat_id = $('.wz_chat_id_tg').val();
            }
            if($('.wz_messenger_activ').val() == 'wz'){
                var url_script = 'https://san-dez.ru/my_script/wappi/api.php';
                var chat_id = '';
            }
    
            $.get(url_script, {
                phone: $('.wz_phone').html(), 
                type_mes: type_mes, 
                mes: $('.mes_wz_sent textarea').val(), 
                /*id_men: $('.wz_id_men').val(), 
                name_men: $('.wz_name_men').val(), */
                id_mes: message_id,
                url_file:url_file,
                caption:caption,
                file_name:file_name,
                chat_id:chat_id
                
            }, function(data){
                //alert(data);
                
                $('.mes_wz_sent textarea').val('');
                if($('.wz_messenger_activ').val() == 'wz'){
                    setTimeout(showmessage($('.wz_phone').html()), 2000);
                    setTimeout(showmessage($('.wz_phone').html()), 4000);
                }
                if($('.wz_messenger_activ').val() == 'max'){
                    if(data != 'ok'){
                        $('.mes_wz').append('<p class="eror_mes">'+data+'</p>');
                        
                    }else{
                        showmessageMax($('.wz_phone').html(), $('.wz_chat_id_max').val());
                    }
                }
                if($('.wz_messenger_activ').val() == 'tg'){
                    showmessageTg($('.wz_phone').html(), $('.wz_chat_id_tg').val());
                    /*if(data != 'ok'){
                        $('.mes_wz').append('<p class="eror_mes">'+data+'</p>');
                        
                    }else{
                        showmessageTg($('.wz_phone').html(), $('.wz_chat_id_tg').val());
                    }*/
                }
            });
            
            $.get(url_script, {type_mes: 'read', id_mes: $('.mes_wz .mes-client').attr('id'), phone:$('.wz_phone').html(), chat_id:chat_id}, function(data){});
            
            $(this).removeAttr('data-id_mes_reply');
            $(this).attr('data-type_mes','text');
            $('.reply_mes_text').fadeOut();
            $('.file_load').remove();
            
            /*$.get('https://san-dez.ru/my_script/wappi/api.php', {type_mes: 'read', id_mes: $('.mes_wz .mes-client').attr('id'), phone:$('.wz_phone').html()}, function(data){});*/
        }
    });
    
    
    $('.view_mes').on('click', function(){ 
        /*alert($('.mes_wz .mes-client').attr('id'));*/
        if($('.wz_messenger_activ').val() == 'max'){
            var url_script = 'https://san-dez.ru/my_script/wappi_Max/Api_Max.php'; 
            var chat_id = $('.wz_chat_id_max').val();
        }
        if($('.wz_messenger_activ').val() == 'tg'){
            var url_script = 'https://san-dez.ru/my_script/wappi_Tg/Api_Tg.php';
            var chat_id = $('.wz_chat_id_tg').val();
        }
        if($('.wz_messenger_activ').val() == 'wz'){
            var url_script = 'https://san-dez.ru/my_script/wappi/api.php'; 
            var chat_id = '';
        }
        $.get(url_script, {type_mes: 'read', id_mes: $('.mes_wz .mes-client').attr('id'), phone:$('.wz_phone').html(), chat_id:chat_id}, function(data){
            //alert(data);
            setTimeout(() => location.reload(), 2000);
        });
    });
    
    
    $('.search_phone').on('click', function(){
        if(window.location.search ==''){var ghj = '?';}else{var ghj = '&';}
        window.location.replace(window.location.href+ghj+'phone='+$(this).attr('data-phone'));
    });
    
    
    $('.close_search').on('click', function(){
        var url = window.location.href;
        var url = url.replace("&phone="+$('[name="search"]').val(), "");
        window.location.replace(url);
    });
    
    
    $('.search_but').on('click', function(){
        var url = window.location.href;
        if(window.location.search ==''){var ghj = '?';}else{var ghj = '&';}
        var url = url.replace("&phone="+$('[name="search"]').val(), "");
        window.location.replace(window.location.href+ghj+'phone='+$('[name="search"]').val());
    });
    
    
    
    
    const audioElement = document.getElementById('notification-sound');

    // Функция для воспроизведения звука
    function playNotificationSound() {
        audioElement.play().catch(error => {
            // Автовоспроизведение может быть заблокировано браузером
            console.log("Не удалось воспроизвести звук:", error);
        });
    }

    
    
    if(window.location.pathname=='/my_script/all_leads_save/select.php'){

                    
        function search_new_mes() {
            $.get('https://san-dez.ru/my_script/Teletype/api.php', {type: 'all_new_mes'}, function(data){ 
                $('.blok_notifications').html(data);
            });
        }
        
        setInterval(search_new_mes, 10000);
        
        function notise_audio() {
            $.get('https://san-dez.ru/my_script/Teletype/api.php', {type: 'notise_audio'}, function(data){ 
                if(data==1){
                    
                    playNotificationSound();
                }
            });
        }
        
        setInterval(notise_audio, 10000);
    }
    
    
    
    $('body').on('click','.wz_mes_images', function(){ 
        $('body').append('<div class="bg_wiev_foto"><img src="'+$(this).attr('src')+'" class="wiev_foto"></div>');
    });
    
    $('body').on('click','.bg_wiev_foto', function(){
        $('.bg_wiev_foto').remove();
    });
    
    

    $('body').on('click','.menu_mes', function(){
        $(this).next('.menu_mes_spisok').fadeIn();
    });
    
    
    $('body').on('click','.menu_mes_spisok p', function(){
        var comanda = $(this).html();
        var id_mes = $(this).parent('div').parent('div').attr('id');
        if(comanda == 'Ответить'){
            var mes_copy = $(this).parent('div').parent('div').children('.mes_chat').html();
            $('.but_mes_sent').attr('data-id_mes_reply',id_mes);
            $('.but_mes_sent').attr('data-type_mes','reply');
            $('.reply_mes_text').css('visibility', 'visible');
            $('.reply_mes_text').fadeIn();
            if(mes_copy.length>30){
                
                mes_copy = mes_copy.substring(0, 30);
                var lastIndex = mes_copy.lastIndexOf(" ");       // позиция последнего пробела
                mes_copy = '"'+mes_copy.substring(0, lastIndex) + '..."'; // обрезаем до последнего слова
                $('.reply_mes_text span').html(mes_copy);
   
            }else{$('.reply_mes_text span').html('"'+mes_copy+'"');}
            
        }
        if(comanda == 'Редактировать'){
            var mes_copy = $(this).parent('div').parent('div').children('.mes_chat').html();
            $('.but_mes_sent').attr('data-id_mes_reply',id_mes);
            $('.but_mes_sent').attr('data-type_mes','edit');
            $('.mes_wz_sent textarea').val(mes_copy);
        }
        if(comanda == 'Удалить'){
            var isAdmin = confirm("Вы уверены?");
            if( isAdmin == true){
                $.get('https://san-dez.ru/my_script/wappi/api.php', {
                    phone: $('.wz_phone').html(), 
                    type_mes: 'delete', 
                    mes: '', 
                    id_men: $('.wz_id_men').val(), 
                    name_men: $('.wz_name_men').val(), 
                    id_mes: id_mes
                    
                }, function(data){
                    //alert(data);
                    $('.mes_wz_sent textarea').val('');
                    setTimeout(showmessage($('.wz_phone').html()), 2000);
                    
                });
            }

            
        }
    });
    
    
    
    $('body').on('click','.reply_mes_text img', function(){
        $('.but_mes_sent').removeAttr('data-id_mes_reply');
        $('.but_mes_sent').attr('data-type_mes','text');
        $('.reply_mes_text').fadeOut();
    });

    
    
    // #2 вариант (события всплывают)   
    $('body').on('mouseenter','.mes-client, .mes-manager', function(){
         // навели курсор на объект 
        if($('.wz_dialogId').val()==''){ 
            $(this).children('.menu_mes').fadeIn();
        }
    })
    $('body').on('mouseleave','.mes-client, .mes-manager', function(){
        // отвели курсор с объекта
        if($('.wz_dialogId').val()==''){
            $(this).children('.menu_mes, .menu_mes_spisok').fadeOut();
        }
    });
    
    
    
    $('body').on('click','.but_mes_file', function(){
        if($('.wz_dialogId').val()==''){
            $('#js-file').click();
            $('.but_mes_sent').attr('data-type_mes','file');
        }
    });
    
    
    
    $('body').on('click','.file_load_del', function(){
        $('.file_load').remove();
        $('.but_mes_sent').attr('data-type_mes','text');
    });
    
    
    
    $("#js-file").change(function(){
        if (window.FormData === undefined) {
            alert('В вашем браузере FormData не поддерживается')
        } else {
            var formData = new FormData();
            formData.append('file', $("#js-file")[0].files[0]);
     
            $.ajax({
                type: "POST",
                url: 'https://san-dez.ru/my_script/all_leads_save/upload_file.php',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                dataType : 'json',
                success: function(msg){
                    if (msg.error == '') {
                        //$("#js-file").hide();
                        $('.mes_wz_sent').prepend(msg.success);
                        //alert(msg.success);
                    } else {
                        $('.file_load').html(msg.success);
                        //alert(msg.error);
                    }
                }
            });
        }
    });
    
    
    
    
    
    $('.calls_lead').on('click', function(){
        $.get('https://san-dez.ru/my_script/Mango/index.php', {phone: $(this).attr('data-phone')}, function(data){
            //alert(data);
            $('.calls_leads_info').html(data);
            $('.calls_leads_info, .bg_fon').fadeIn();
        });
        
    });
    
    $('.bg_fon').on('click', function(){
        $('.calls_leads_info, .bg_fon').fadeOut();
    });
    
    
    
    
    
    
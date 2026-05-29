
// возвращает куки с указанным name,
// или undefined, если ничего не найдено
function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}



function get_clientID(){
        var yclid;
        ym('97574764', 'getClientID', function(clientID) { 
            yclid = clientID;
        });
        return yclid;
    }
 
$(document).ready(function(){
    



});   



$(window).load(function () {//дожидаемся полной загрузки страницы

    /*// возвращает куки с указанным name,
    // или undefined, если ничего не найдено
    function getCookie(name) {
      let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
      ));
      return matches ? decodeURIComponent(matches[1]) : undefined;
    }*/


console.log("Установлен номер визита: " + getCookie('roistat_visit'));
var roistat_visit = getCookie('roistat_visit');


//  ПРоверка наличия роистат и в базе, если есть показываем номер телефона статичный, без отправки конверсий.  
    $.get("https://san-dez.ru/my_script/script.php",{ roistat_id: roistat_visit }, onAjaxSuccess );
            function onAjaxSuccess(data){ 
                if(data==1){
                    $('.roistat_phone').attr('href','tel:84993467847').html('8 (499) 346-78-47');
                    console.log("Есть контакт: " + roistat_visit);
                }
                else {
                    console.log("Новый визит: " + roistat_visit);
                }
            }




const getUtmParameter = (sParam) => {
  const url = window.location.search.substring(1);
  const urlVariables = url.split('&');

  for (let i = 0; i < urlVariables.length; i++) {
    const variables = urlVariables[i].split('=');

    if (variables[0] === sParam) {
      return variables[1]
    }
  }

};
/*$('.input_utm_source').val(getUtmParameter('utm_source'));
$('.input_utm_medium').val(getUtmParameter('utm_medium'));
$('.input_utm_campaign').val(getUtmParameter('utm_campaign'));
$('.input_utm_content').val(getUtmParameter('utm_content'));
$('.input_utm_term').val(getUtmParameter('utm_term'));
$('.input_referrer_url').val(document.referrer);
$('.input_url').val(window.location.hostname + window.location.pathname);
$('.roistat_visit').val(roistat_visit);
*/









function input_hidden_val() {
    $('.input_utm_source').val(getUtmParameter('utm_source'));
    $('.input_utm_medium').val(getUtmParameter('utm_medium'));
    $('.input_utm_campaign').val(getUtmParameter('utm_campaign'));
    $('.input_utm_content').val(getUtmParameter('utm_content'));
    $('.input_utm_term').val(getUtmParameter('utm_term'));
    $('.input_referrer_url').val(document.referrer);
    $('.input_url').val(window.location.hostname + window.location.pathname);
    $('.roistat_visit').val(roistat_visit);
    var yclid = get_clientID(); 
    if(roistat_visit==''){
        location.reload();
    }
    $('.input_yclid').val(yclid);
    $('.input_referrer_url').val(document.referrer);
    $('.input_url').val(window.location.hostname+window.location.pathname);
        
        //alert(roistat_visit);
    $.ajax({
        url: 'https://san-dez.ru/my_script/visits/insert.php',         /* Куда пойдет запрос */
        method: 'get',             /* Метод передачи (post или get) */
        //dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
        data: {
            roistat_visit: $('.roistat_visit').val(),
            utm_term: getUtmParameter("utm_term"),
            utm_content: getUtmParameter("utm_content"),
            utm_medium: getUtmParameter("utm_medium"),
            utm_campaign: getUtmParameter("utm_campaign"),
            utm_source: getUtmParameter("utm_source"),
            yclid: yclid,
            referrer_url: document.referrer,
            site: window.location.hostname,
            url: window.location.hostname+window.location.pathname
        },/* Параметры передаваемые в запросе. */
        success: function(data){   /* функция которая будет выполнена после успешного запроса.  */
                //alert(data);            /* В переменной data содержится ответ от index.php. */
        }
    });
    
    var urlWZ = 'https://wa.me/79271653614?text=Здравствуйте! Отправьте это сообщение и я сразу пришлю цены на дезинсекцию тараканов и клопов. Код на скидку - '+roistat_visit;
    $('#but_form_whp').attr('href',urlWZ);
    
    /*var mes = 'Визит на сайт '+getUtmParameter('utm_campaign');
    $.get("https://san-dez.ru/my_script/script.php",{ send_notification: mes }, onAjaxSuccess );*/
    /*
    if(getUtmParameter('utm_source') != ' '){
        window.location.href = urlWZ;
    }
    */
    //$('[href="https://t.me/seembol1_bot"]').attr('href',$('[href="https://t.me/seembol1_bot"]').attr('href')+'?start='+yclid);
}
    
setTimeout(input_hidden_val, 2000);


function wz() {
    var urlWZ = 'https://api.whatsapp.com/send/?phone=79271653614&text=Здравствуйте! Отправьте это сообщение и я сразу пришлю цены на дезинсекцию тараканов и клопов. Код на скидку - '+roistat_visit;
    //var urlWZ = 'https://wa.me/79999804122?text=Здравствуйте! Отправьте это сообщение и я сразу пришлю цены на дезинсекцию тараканов и клопов. Код на скидку - '+roistat_visit;
    //alert(window.screen.width);
    /**/
    if(window.screen.width<750){ //МОб
        //if(getUtmParameter('utm_source') != ' '){
            //if(getUtmParameter('utm_campaign') != 'Poisk_MSK_Klopy_ot13_04_2025'){
                //var mes = 'Переход в ватсап '+getUtmParameter('utm_campaign');
                //$.get("https://san-dez.ru/my_script/script.php",{ send_notification: mes }, onAjaxSuccess );
            
                /*window.location.href = urlWZ;*/
                
            //}
        //}
    }
}
setTimeout(wz, 6000);

// Обновляем страницу если не определен роистат визит
if(roistat_visit=='undefined' || roistat_visit==''){
    var mes = 'ОБН Визит роистат - '+roistat_visit+' - Yclid - '+$('.input_yclid').val()+' - utm_campaign - '+getUtmParameter('utm_campaign');
    $.get("https://san-dez.ru/my_script/script.php",{ send_notification: mes }, onAjaxSuccess );
        
        setTimeout(() => { location.reload(); }, 2000);
    
}

/*else {
    $('.roistat_visit').val(roistat_visit);
    var mes = 'Визит роистат - '+roistat_visit+' - Yclid - '+$('.input_yclid').val()+' - utm_campaign - '+getUtmParameter('utm_campaign');
    $.get("https://san-dez.ru/my_script/script.php",{ send_notification: mes }, onAjaxSuccess );
        function onAjaxSuccess(data){  }
}*/


/*Подмена заголовков
if(getUtmParameter('utm_content')==5463845112){//Дезинсекция тараканов
    $('.title_offer span').html('Дезинсекция и Дезинфекция тараканов. Уничтожим тараканов горячим/холодным туманом.');
}
if(getUtmParameter('utm_content')==5463845113){//Обработка от тараканов
    $('.title_offer span').html('Дезинфекция и обработка от Тараканов горячим/холодным туманом.');
}
if(getUtmParameter('utm_content')==5463845114){//Уничтожение тараканов
    $('.title_offer span').html('Травля тараканов. Уничтожим тараканов профессиональными и безопасными препаратами.');
}
if(getUtmParameter('utm_content')==5463845117){//Отравить тараканов
    $('.title_offer span').html('Потравим Тараканов горячим/холодным туманом.');
}
*/





document.addEventListener('wpcf7mailsent', function (event) {
            //if ('777' == event.detail.contactFormId) {
                ym(97574764,'reachGoal','lead');
                location = '/spasibo/';
            //}
        }, false);





function telephoneCheck(str) {
  var isphone = /^[\d\+][\d\(\)\ -]{4,14}\d$/.test(str);
  return isphone;
}



$(function(){
    $nav = $('#vidjet_f');
    $nav.css('width', $nav.outerWidth());
    $window = $(window);
    $h = $nav.offset().top;
    $window.scroll(function(){ 
        if ($window.scrollTop() > $h && $window.scrollTop() < $('.block_content').height()+400) { 
            $nav.addClass('fixed');
        } else {
            $nav.removeClass('fixed');
        }
    });
});



$('.frm_calb_but').on('click', function(){
    var phone = $('.frm_calb').val();

    if(telephoneCheck(phone)){
        $('.inp_phone').val(phone);
        $('.but_form1').click();
    }else{alert('net');}
});

/*
$('#but_form_whp').on('click', function(ew){
    ew.preventDefault();
    alert('j');
});

*/
$('#open_chat').on('click', function(ew){
    ew.preventDefault();
 
});


$('.ast-custom-button-link').on('click', function(ewd){
    ewd.preventDefault(); 
});


//$('[href="tel:84959999999"],.roistat_phone').attr('href','tel:+74958856936').html('8 (495) 885-69-36')


var vvod_phone_form = document.querySelectorAll('[type="tel"]');

    vvod_phone_form.forEach(vvod_phone_f => {
        vvod_phone_f.onkeyup = () => {  
            $.get("https://san-dez.ru/my_script/script.php",{ phone: vvod_phone_f.value, prov_phone:'gg', utm_source: getUtmParameter('utm_source'), utm_medium: getUtmParameter('utm_medium'), utm_campaign: getUtmParameter('utm_campaign'), utm_content: getUtmParameter('utm_content'), utm_term: getUtmParameter('utm_term'), referrer_url: document.referrer, roistat_visit: roistat_visit, input_url: window.location.hostname + window.location.pathname, yclid: $('.input_yclid').val()}, onAjaxSuccess );
            function onAjaxSuccess(data){ 
                if(data=='yes'){
                    $('.wpcf7-submit').detach();
                    
                    alert('Мы получили вашу заявку. В ближайшее время с вами свяжется специалист.');
                    setTimeout(() => { 
                        //location.reload(); 
                        location = '/spasibo/';
                    }, 3000);
                }
            }
            //alert(vvod_phone_f.value);
        };
    });




// текущая дата
var date = new Date();
var Hours = date.getHours();
// час в текущей временной зоне
console.log( 'час в текущей временной зоне - '+date.getHours() );


/*
var capcha_F = document.querySelectorAll('[name="checkbox-108"]');
capcha_F.forEach(capcha => {
    capcha.onclick = () => {
        if(Hours==00 || Hours==01 || Hours==02 || Hours==03 && Hours==04 || Hours==05 || Hours==06 || Hours==07){
            $('.wpcf7-submit').detach();
            
            $.get("https://san-dez.ru/my_script/script.php",{ phone: $('[type="tel"').val(), spam_phone:'gg', utm_source: getUtmParameter('utm_source'), utm_medium: getUtmParameter('utm_medium'), utm_campaign: getUtmParameter('utm_campaign'), utm_content: getUtmParameter('utm_content'), utm_term: getUtmParameter('utm_term'), referrer_url: document.referrer, roistat_visit: roistat_visit, input_url: window.location.hostname + window.location.pathname, yclid: $('.input_yclid').val()}, onAjaxSuccess );
            function onAjaxSuccess(data){ }
            location = '/spasibo/';
        }
        else {
            if(capcha.value != 7){
                $('.wpcf7-submit').detach();
                var mes = 'Капчу не прошел - '+roistat_visit+' - Телефон - '+$('[type="tel"').val()+' - Yclid - '+$('.input_yclid').val()+' - utm_campaign - '+getUtmParameter('utm_campaign');
                $.get("https://san-dez.ru/my_script/script.php",{ send_notification: mes }, onAjaxSuccess );
                function onAjaxSuccess(data){  }
                
                $.get("https://san-dez.ru/my_script/script.php",{ phone: $('[type="tel"').val(), spam_phone:'gg', utm_source: getUtmParameter('utm_source'), utm_medium: getUtmParameter('utm_medium'), utm_campaign: getUtmParameter('utm_campaign'), utm_content: getUtmParameter('utm_content'), utm_term: getUtmParameter('utm_term'), referrer_url: document.referrer, roistat_visit: roistat_visit, input_url: window.location.hostname + window.location.pathname, yclid: $('.input_yclid').val()}, onAjaxSuccess );
                function onAjaxSuccess(data){ }
                
                setTimeout(() => { location.reload(); }, 2000);
            }
        }
        
    };
});
*/



})




(function( $ ) { 
	
	function getCookieName(name) {
		let cookie = document.cookie;
		let search = name + "=";
		let result = "";
		let offset = end = 0;

		if (cookie.length > 0) {
			offset = cookie.indexOf(search);
			if (offset !== -1) {
				offset += search.length;
				end = cookie.indexOf(";", offset)
				if (end === -1) {
					end = cookie.length;
				}
				result = unescape(cookie.substring(offset, end));
			}
		}

		return result;
	}	
	
	
	
	
	
	function setCookie(name, value, days){
		var date = new Date();
		date.setTime(date.getTime() + (days*24*60*60*1000)); 
		var expires = "; expires=" + date.toGMTString();
		document.cookie = name + "=" + value + expires + ";path=/";
	}
	
	//Извлечение yclid и изменение скрытого поля
	
	function readCookie(name) { 
		var n = name + "="; 
		var cookie = document.cookie.split(';'); 
		for(var i=0;i < cookie.length;i++) {      
			var c = cookie[i];      
			while (c.charAt(0)==' '){c = c.substring(1,c.length);}      
			if (c.indexOf(n) == 0){return c.substring(n.length,c.length);} 
		} 
		return null; 
	} 
	 
	
	function getParam(p){
		var match = RegExp('[?&]' + p + '=([^&]*)').exec(window.location.search);
		return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
	}
	
	
	function get_clientID(){
		var yclid;
		ym('97574764', 'getClientID', function(clientID) { 
			yclid = clientID;
		});
		return yclid;
	}
	
	
	
	/*
	function scrollPercent(){
		const div = document.querySelector('.chat_online_body');
		div.scrollBy(0, Math.ceil(div.scrollHeight));
	}
	*/
	
	function openChat() {
		$('.viewWidgetButton').fadeOut(); $('.chat_online').css('visibility','visible');
		//scrollPercent();
	}
	
	function closeChat() {
		$('.viewWidgetButton ').fadeIn(); $('.chat_online').css('visibility','hidden');
	}
	
	
	function validateEmail(email) {
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	}
	
	function validatePhone(phone) {
		let regex = /^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/;
		return regex.test(phone);
	}
	
	var getUrlParameter = function getUrlParameter(sParam) {
		var sPageURL = decodeURIComponent(window.location.search.substring(1)),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;
		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : sParameterName[1];
			}
		}
	}
	
	
	
	
		
		
	$( document ).ready(function() { 
		var referrer_url = document.referrer;
		//console.log('ur - '+referrer_url);  вот ваша строка
		var url = window.location.hostname + window.location.pathname;
		var user_cookie = '';

		
		setTimeout(() => { //через 3 секуны опр метрика ид
		
			if(readCookie('yclid')){
				var yclid = readCookie('yclid');
			}
			else {
				//ym(87597554, 'getClientID', function(clientID) { user_cookie = clientID;} );
				var yclid = get_clientID();
				//var yclid = getParam('yclid');
				if(yclid){
					setCookie('yclid', yclid, 90);
				}
			}
			
			$('.input_yclid').val(yclid);
		
			 
			
			// Добавляем на сайт чат
			$.get('/my_script/chat/chat.php', {user_cookie: yclid, action : "start"}, function(data) {
				$( "body" ).append(data);
			});
			$.get('/my_script/chat/chat.php', {user_cookie: yclid, action : "load_mes"}, function(data) {
				$( ".chat_online_body" ).append(data);
			});
			
		}, 3000);
		
		
		
		
		
		
		
		
		// Показываем чат. Скрываем кнопку.
		$('body').on('click', '#open_chat', function(){ 
			openChat();
		});
		
		// Показываем кнопку. Скрываем чат.
		$('body').on('click', '.ch_on_header_close', function(){ 
			closeChat();
		});
		
		/*/ Показываем чат. Скрываем кнопку. Через 8 сек.
		setTimeout(() => {
			openChat();
		}, 8000);
		*/
		
		// Отправляем сообщение user
		$('body').on('click', '.send-button', function(){ 
			var mes = $('.chat_online_footer textarea').val().replace(/(<([^>]+)>)/ig,"");
			$('.chat_online_footer textarea').val('');
			var utm = window.location.href.slice(window.location.href.indexOf('?') + 1);
			if(mes != ''){
				$.get('/my_script/chat/chat.php', {user_cookie: yclid, action : "new_mes", user_mes : mes, utm : utm, referrer_url : referrer_url, url : url, yclid : yclid}, function(data) {
					$( ".chat_online_body" ).append(data);
					if(data.indexOf('konvers_mes') != -1) { ym(97574764,'reachGoal','lead'); }
					
				});
			} else { alert('Введите сообщение'); }
		});
		
		
		// Сохраняем форму 
		$('body').on('click', '.contact_button button', function(){
			
			var contact_name = $('.contact_name input').val();
			var contact_phone = $('.contact_phone input').val();
			if( validatePhone(contact_phone)==true) {
				//alert(contact_mail+' '+contact_phone);
				//$( ".chat_online_body" ).html('');
				$('.servise-mes-contact, .chat_form_contact').fadeOut();
				var utm = window.location.href.slice(window.location.href.indexOf('?') + 1);
				$.get('/my_script/chat/chat.php', {user_cookie: yclid, action : "save_contact", contact_name : contact_name, contact_phone : contact_phone, utm : utm, referrer_url : referrer_url, url : url, yclid : yclid}, function(data) {
					$( ".chat_online_body" ).append(data);
					if(data.indexOf('konvers_mes') != -1) { ym(97574764,'reachGoal','lead'); }
				});
			}else{alert('Ведите номер телефона');}
			
		});
		
		/*
		// Сохраняем Email и показываем форму телефон
		$('body').on('click', '.contact_button button', function(){
			if($('.contact_button button').attr('id') == 'phone_visibl'){
				var contact_mail = $('.contact_mail input').val();
				var contact_phone = $('.contact_phone input').val();
				if( validatePhone(contact_phone)==true) {
					//alert(contact_mail+' '+contact_phone);
					//$( ".chat_online_body" ).html('');
					$('.servise-mes-contact, .chat_form_contact').fadeOut();
					var utm = window.location.href.slice(window.location.href.indexOf('?') + 1);
					$.get('/my_script/chat/chat.php', {user_cookie: yclid, action : "save_contact", contact_mail : contact_mail, contact_phone : contact_phone, utm : utm, referrer_url : referrer_url, url : url}, function(data) {
						$( ".chat_online_body" ).append(data);
						if(data.indexOf('konvers_mes') != -1) { ym(97574764,'reachGoal','lead'); }
					});
				}else{alert('Ведите номер телефона');}
			}
			else { 
				var contact_mail = $('.contact_mail input').val(); 
				if( validateEmail(contact_mail)==true) {
				
					$('.contact_button button').attr('id','phone_visibl');
					$('.contact_phone').css('display','flex');
				}else{alert('Ведите ваш Email');}
			}
		});
		*/
		
		/*
		// Показываем чат. Скрываем кнопку. Через 8 сек. задаем вопрос и показываем кнопки - варианты
		setTimeout(() => {
			openChat();
			$.get('/my_script/chat/chat.php', {user_cookie: yclid, action : "load_mes_vopros"}, function(data) {
				$( ".chat_online_body" ).append(data);
				//scrollPercent();
			});
		}, 8000);
		*/
		
		
		// Клик по кнопке с ваиантом ответа
		$('body').on('click', '.variant_button .var1', function(){
			var mes = $('.variant_button .var1').html();
			var utm = window.location.href.slice(window.location.href.indexOf('?') + 1);
			$.get('/my_script/chat/chat.php', {user_cookie: yclid, action : "new_mes", user_mes : mes, utm : utm, referrer_url : referrer_url, url : url, yclid : yclid}, function(data) {
				$( ".chat_online_body" ).append(data);
				//scrollPercent();
			});
		});
		$('body').on('click', '.variant_button .var2', function(){
			var mes = $('.variant_button .var2').html();
			var utm = window.location.href.slice(window.location.href.indexOf('?') + 1);
			$.get('/my_script/chat/chat.php', {user_cookie: yclid, action : "new_mes", user_mes : mes, utm : utm, referrer_url : referrer_url, url : url, yclid : yclid}, function(data) {
				$( ".chat_online_body" ).append(data);
				//scrollPercent();
			});
		});
		$('body').on('click', '.variant_button .var3', function(){
			var mes = $('.variant_button .var3').html();
			var utm = window.location.href.slice(window.location.href.indexOf('?') + 1);
			$.get('/my_script/chat/chat.php', {user_cookie: yclid, action : "new_mes", user_mes : mes, utm : utm, referrer_url : referrer_url, url : url, yclid : yclid}, function(data) {
				$( ".chat_online_body" ).append(data);
				//scrollPercent();
			});
		});
		$('body').on('click', '.variant_button .var4', function(){
			var mes = $('.variant_button .var4').html();
			var utm = window.location.href.slice(window.location.href.indexOf('?') + 1);
			$.get('/my_script/chat/chat.php', {user_cookie: yclid, action : "new_mes", user_mes : mes, utm : utm, referrer_url : referrer_url, url : url, yclid : yclid}, function(data) {
				$( ".chat_online_body" ).append(data);
				//scrollPercent();
			});
		});
		
		
		
	});
	
})( jQuery );
(function( $ ) { console.log('hello');

	
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
	
	

$('.qrkodwhatsapp').attr('src','https://qrcode.tec-it.com/API/QRCode?data=https%3a%2f%2fapi.whatsapp.com%2fsend%3fphone%3d79268320702%26source%3d%26data%3d%26app_absent%3d%26text%3d%25D0%259E%25D0%25B1%25D1%258F%25D0%25B7%25D0%25B0%25D1%2582%25D0%25B5%25D0%25BB%25D1%258C%25D0%25BD%25D0%25BE%2520%25D0%25BE%25D1%2582%25D0%25BF%25D1%2580%25D0%25B0%25D0%25B2%25D1%258C%25D1%2582%25D0%25B5%2520%25D1%258D%25D1%2582%25D0%25BE%2520%25D1%2581%25D0%25BE%25D0%25BE%25D0%25B1%25D1%2589%25D0%25B5%25D0%25BD%25D0%25B8%25D0%25B5%2520%25D0%25B8%2520%25D0%25B4%25D0%25BE%25D0%25B6%25D0%25B4%25D0%25B8%25D1%2582%25D0%25B5%25D1%2581%25D1%258C%2520%25D0%25BE%25D1%2582%25D0%25B2%25D0%25B5%25D1%2582%25D0%25B0.%2520%25D0%2592%25D0%25B0%25D1%2588%2520%25D0%25BD%25D0%25BE%25D0%25BC%25D0%25B5%25D1%2580%3a%2520'+getCookieName('roistat_visit')+'&backcolor=%23ffffff');
	
	$('.qrkodtelegramm').attr('src','https://qrcode.tec-it.com/API/QRCode?data=https%3a%2f%2fsalebot.site%2fUnikod_start_1%3froistat%3d'+getCookieName("roistat_visit")+utmggg+'&backcolor=%23ffffff');
	
	$('.MDChatFooterQuickAnswer').on('click', function(){
		ym(87597554,'reachGoal','lead');
        window.open('https://api.whatsapp.com/send?phone=79268320702&source=&data=&app_absent=&text=Здравствуйте! '+$(this).text()+' Обязательно отправьте это сообщение и дождитесь ответа. Ваш номер: '+getCookieName('roistat_visit'),'_blank');
	});
	
	$('.MDChatFooterInputSubmit').on('click', function(){
		if($('.MDChatFooterInput').val().replace(/(<([^>]+)>)/ig,"")!=''){
			ym(87597554,'reachGoal','lead');
			window.open('https://api.whatsapp.com/send?phone=79268320702&source=&data=&app_absent=&text= '+$('.MDChatFooterInput').val().replace(/(<([^>]+)>)/ig,"")+' Обязательно отправьте это сообщение и дождитесь ответа. Ваш номер: '+getCookieName('roistat_visit'),'_blank');
		}
	});
	
	$('.MDModalButtonWhatsapp').on('click', function(){
		ym(87597554,'reachGoal','lead');
		window.open('https://api.whatsapp.com/send?phone=79268320702&source=&data=&app_absent=&text=Обязательно отправьте это сообщение и дождитесь ответа. Ваш номер: '+getCookieName('roistat_visit'),'_blank');
	});
	
	$('.MDModalButtonTelegram').on('click', function(){
		ym(87597554,'reachGoal','lead');
		window.open('https://salebot.site/Unikod_start_1?roistat='+getCookieName('roistat_visit')+utmggg,'_blank');
	});
	
	
	$('.MDChatHeaderCloseButton').on('click', function(){
		$('.viewWidgetButtonWrapper').fadeIn("slow");
		$('.MDChat').fadeOut("slow");
	});
	
	$('.MDModalButtonClose').on('click', function(){
		$('.MDModalOverlay').fadeOut("slow");
		$('.MDModal').fadeOut("slow");
		$('.viewWidgetButton').fadeIn("slow");
	});
	
	$('.viewWidgetButton').on('click', function(){
		$('.viewWidgetButton').fadeOut("slow");
		$('.MDModalOverlay').css('display','flex').fadeIn("slow");
		$('.MDModal').css('display','flex').fadeIn("slow");
	});
	
	
	function addZero(i) {
		if (i < 10) {
			i = "0" + i;
		}
		return i;
	}
	
	function openChat(){
		var dt = new Date();
		var time = addZero(dt.getHours()) + ":" + addZero(dt.getMinutes());
		$('.MDChatMessageTime').text(time);
		$('.MDChat').fadeIn("slow");
		//$('.MDChat').css('disply','block');
		//$('.viewWidgetButtonWrapper').fadeOut("slow");
	}
	
    setTimeout(openChat, 3000);
	
	/**/function explode2(){
            $('.mess2, .MDChatFooterQuickAnswerCtx').fadeIn("slow");
            $('.MDChatBody').css('min-height','60px');
        }setTimeout(explode2, 5000);



})( jQuery );
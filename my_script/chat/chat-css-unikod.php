<?
// CSS кнопки чата
echo'
<style>
/**** Чат ****/



.MDChatHeader {
    all: unset;
    box-sizing: border-box;
    position: sticky;
    z-index: 9;
    top: 0px;
    left: 0px;
    width: 100%;
    background-color: var(--MD-chat-whatsapp-background);
    display: flex;
    justify-content: space-between;
    padding: 18px;
    gap: 16px;
}

.MDChatHeaderAvatarCtx {
    all: unset;
    display: flex;
    align-items: center;
    width: calc(100% - 40px);
    gap: 8px;
}

.MDChatHeaderAvatar {
    --s: 40px;
    all: unset;
    display: flex;
    width: var(--s);
    height: var(--s);
    object-fit: cover;
    flex-shrink: 0;
    border-radius: 50%;
    overflow: hidden;
}

.MDChatHeaderAvatarLabel {
    all: unset;
    display: flex;
    flex-direction: column;
    width: calc(100% - 40px);
    gap: 4px;
}

.MDChatHeaderOperatorName {
    all: unset;
    display: inline;
    font-style: normal;
    font-weight: 500;
    font-size: 16px;
    line-height: 19px;
    letter-spacing: -0.3px;
    color: rgb(0, 0, 0);
    width: 100%;
    text-overflow: ellipsis;
    font-family: Roboto, sans-serif !important;
    white-space: nowrap;
    overflow: hidden;
}

.MDChatHeaderStatus {
    all: unset;
    display: inline;
    font-style: normal;
    font-weight: 400;
    font-size: 12px;
    line-height: 16px;
    color: rgb(142, 142, 147);
    font-family: Roboto, sans-serif !important;
}

.MDChatHeaderCloseCtx {
    all: unset;
    flex-shrink: 0;
}

.MDChatHeaderCloseButton {
    all: unset;
    display: flex;
    cursor: pointer;
}

.MDChatHeaderCloseButtonIcon {
    --s: 24px;
    all: unset;
    display: flex;
    width: var(--s);
    height: var(--s);
    color: var(--pf-disabled);
}

svg:not(:root) {
    overflow-clip-margin: content-box;
    overflow: hidden;
}

.MDChatBody {
    all: unset;
    box-sizing: border-box;
    height: 100%;
    min-height: 260px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 16px;
}

.MDChatBodyItem {
    all: unset;
    display: flex;
    padding-top: 8px;
    position: relative;
    animation-name: MDChatMessageFadeIn;
    animation-duration: 1s;
}

.MDChatMessage {
    all: unset;
    position: relative;
    box-sizing: border-box;
    display: inline-flex;
    flex-direction: column;
    margin-left: 4px;
    max-width: calc(100% - 25px);
    min-width: 80px;
    padding: 8px 8px 22px;
    background: rgb(250, 250, 250);
    border-radius: 8px;
}

.mess2 {
    display: none;
}

.MDChatMessageText {
    all: unset;
    text-overflow: ellipsis;
    overflow-wrap: anywhere;
    max-width: 100%;
    color: rgb(0, 0, 0);
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 21px;
    display: -webkit-box !important;
    -webkit-line-clamp: 5 !important;
    -webkit-box-orient: vertical !important;
    font-family: Roboto, sans-serif !important;
    overflow: hidden;
}

.MDChatMessageTime {
    all: unset;
    position: absolute;
    bottom: 10px;
    right: 14px;
    display: inline;
    overflow-wrap: anywhere;
    max-width: 100%;
    color: rgba(0, 0, 0, 0.25);
    font-style: normal;
    font-weight: 400;
    font-size: 11px;
    line-height: 13px;
    font-family: Roboto, sans-serif !important;
}

.MDChatMessageShape {
    all: unset;
    position: absolute;
    z-index: 1;
    bottom: 6px;
    right: calc(100% - 4px);
}

.MDChatMessageShapeIcon {
    all: unset;
    display: flex;
    color: rgb(250, 250, 250);
    width: 10px;
    height: 14px;
}

svg:not(:root) {
    overflow-clip-margin: content-box;
    overflow: hidden;
}

.MDChatFooter {
    all: unset;
    box-sizing: border-box;
    position: sticky;
    z-index: 9;
    bottom: 0px;
    left: 0px;
    width: 100%;
    display: flex;
    flex-direction: column;
}

#MDChatFooterQuickAnswerCtxAnimation.MDChatFooterQuickAnswerCtxAnimationStart {
    max-height: 200px;
    opacity: 1;
}

#MDChatFooterQuickAnswerCtxAnimation {
    background-color: rgb(237, 232, 230);
    position: relative;
    overflow: hidden;
    max-height: 0px;
    opacity: 0;
    transition: opacity 1s cubic-bezier(0.175, 0.885, 0.32, 1) 0s, max-height 1s cubic-bezier(0.175, 0.885, 0.32, 1) 0s;
}

.MDChatFooterQuickAnswerCtx {
    all: unset;
    box-sizing: border-box;
    display: grid;
    grid-template-columns: 1fr 1fr;
    padding: 16px;
    gap: 6px;
    display: none;
}

.MDChatFooterQuickAnswer {
    all: unset;
    user-select: none;
    display: block;
    box-sizing: border-box;
    background-color: rgb(250, 250, 250);
    box-shadow: rgba(33, 33, 33, 0.16) 0px 1px 2px;
    text-align: center;
    width: 100%;
    text-overflow: ellipsis;
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 130%;
    color: rgb(0, 122, 255);
    cursor: pointer;
    font-family: Roboto, sans-serif !important;
    padding: 8px;
    margin: 2px;
    border-radius: 8px;
    white-space: nowrap;
    overflow: hidden;
}

.MDChatFooterCtx {
    all: unset;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    background-color: var(--pf-chat-whatsapp-background);
    padding: 12px 16px 24px;
    gap: 8px;
}

.MDChatFooterInputCtx {
    all: unset;
    display: flex;
    align-items: center;
    width: 100%;
}

.MDChatFooterInput {
    all: unset;
    width: 100%;
    display: flex;
    font-size: 16px;
    line-height: 1;
    cursor: text;
    color: var(--pf-primary);
    font-family: Roboto, sans-serif !important;
    background: rgb(255, 255, 255);
    border-width: 1px;
    border-style: solid;
    border-color: rgb(233, 233, 233);
    border-image: initial;
    border-radius: 18px;
    padding: 10px 16px;
}

.MDChatFooterInputSubmit {
    all: unset;
    flex-shrink: 0;
    cursor: pointer;
    margin-right: -8px;
}

.MDChatFooterInputSubmitIcon {
    --s: 44px;
    all: unset;
    display: flex;
    width: var(--s);
    height: var(--s);
}

svg:not(:root) {
    overflow-clip-margin: content-box;
    overflow: hidden;
}


    .MDChat {
        position: fixed;
        width: 342px;
        /*height: calc(100vh - 170px);*/
        max-height: 555px;
        border-radius: 20px;
        background-color: rgb(229, 220, 214);
        box-shadow: rgba(33, 33, 33, 0.04) 0px 10px 20px -4px, rgba(33, 33, 33, 0.04) 0px 20px 40px -6px;
        flex-direction: column;
        
        z-index: 9999999;
        display: flex;
        overflow: auto;
        display: none;
    }


    .PFChatOverlayPositionBottomRight {
        right: 50%;
        bottom: calc(100% + 24px);
    }
    
    .PFChatReset {
        position: absolute;
        opacity: 0;
        display: none;
        transition: opacity 0.6s cubic-bezier(0.175, 0.885, 0.32, 1) 0s;
    }


    .MDChatOverlayPositionBottomRight {
        right: 0px;
        bottom: 0px;
    }
    
    .MDChat {
        right: 40px;
        bottom: 40px;
    }


    .MDChatAnimateIn {
        transition: transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.2) 0s;
    }

    

    
.PFMessage, .MDChat, .MDModal {
    --MD-primary: #212121;
    --MD-secondary: #757575;
    --MD-disabled: #9e9e9e;
    --MD-main-blue: #2962ff;
    --MD-main-blue-dark: #1d4ed6;
    --MD-main-blue-light: #5481ff;
    --MD-blue-shade-50: #94b0ff;
    --MD-blue-shade-8: #eef3ff;
    --MD-blue-shade-4: #f7f9ff;
    --MD-background: #f8f9fb;
    --MD-main-yellow: #ffa726;
    --MD-yellow-shade-12: #fff4e5;
    --MD-main-green: #4caf50;
    --MD-green-shade-8: #f3faf3;
    --MD-main-red: #d32f2f;
    --MD-red-shade-50: #e99797;
    --MD-red-shade-8: #fbeeee;
    --MD-red-shade-4: #fdf7f7;
    --MD-grey-900: #212121;
    --MD-grey-800: #424242;
    --MD-grey-700: #616161;
    --MD-grey-600: #757575;
    --MD-grey-500: #9e9e9e;
    --MD-grey-400: #bdbdbd;
    --MD-grey-300: #e0e0e0;
    --MD-grey-200: #eee;
    --MD-grey-100: #f5f5f5;
    --MD-white: #fff;
    --MD-modal-telegram-color: #2aabee;
    --MD-modal-whatsapp-color: #5ed169;
    --MD-chat-whatsapp-background: #f6f6f6;
}

@media (max-width: 612px) {
    .MDChat {
        /*all: unset;*/
        width: 100%;
        max-height: 100%;
        bottom: 0px;
        left:0px;
    }
    
    .viewWidgetButtonWrapper {
        width:60px;
        height:60px;
    }
    
    .MDModalDualCardItemQrcode {
        display: none;
    }
    
    .MDModalDualCardContainer {
        display: block;
    }
}


/**** Чат конец ****/


/**** Модальное окно ****/

    .MDModalOverlay {
    --MD-modal-scale: 1;
    --ty: calc(-150px * var(--MD-modal-scale));
    all: unset;
    position: fixed;
    box-sizing: border-box;
    z-index: 9999;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: rgba(0, 0, 0, 0.23);
    opacity: 0;
    display: none;
    transition: opacity 0.6s cubic-bezier(0.175, 0.885, 0.32, 1) 0s;
}


.MDModal.MDModalBgTop {
    flex-direction: column;
    max-width: calc(620px * var(--MD-modal-scale));
}

.MDModal:not([dark="true"]), .MDModal:not([dark="true"]) .MDModalButtonClose {
    /*background-color: var(--MD-white);*/
}

.MDModalAnimateIn {
    transition: transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.3) 0s;
    transform: translate3d(0px, 0px, 0px);
}

.MDModal {
    all: unset;
    position: relative;
    display: hidden;
    width: 100%;
    box-shadow: rgba(33, 33, 33, 0.04) 0px 10px 20px 1px;
    flex-direction: column;
    max-width: calc(620px * var(--MD-modal-scale));
    border-radius: calc(24px * var(--MD-modal-scale));
    overflow: hidden;
    background: #fff;
}

.MDModalButtonClose {
    --s: calc(32px * var(--MD-modal-scale));
    all: unset;
    position: absolute;
    z-index: 2;
    top: calc(24px * var(--MD-modal-scale));
    right: calc(24px * var(--MD-modal-scale));
    display: flex;
    align-items: center;
    justify-content: center;
    width: var(--s);
    height: var(--s);
    cursor: pointer;
    border-radius: 50%;
}

.MDModalBody {
    all: unset;
    position: relative;
    box-sizing: border-box;
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: calc(24px * var(--MD-modal-scale)) calc(24px * var(--MD-modal-scale)) calc(70px * var(--MD-modal-scale)) calc(24px * var(--MD-modal-scale));
    gap: calc(16px * var(--MD-modal-scale));
}

.MDModalHeader {
    all: unset;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    gap: calc(16px * var(--MD-modal-scale));
}

#MDModal.MDModalIsAppearance .MDModalHeaderText {
    font-weight: 700 !important;
    font-size: calc(24px * var(--MD-modal-scale)) !important;
    line-height: calc(32px * var(--MD-modal-scale)) !important;
    letter-spacing: 0px !important;
    padding-top: calc(4px * var(--MD-modal-scale)) !important;
}

.MDModalDualCardContainer {
    all: unset;
    width: 100%;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
}

.MDModalDualCardItem {
    all: unset;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    background-color: transparent;
    box-sizing: border-box;
    padding-top: calc(16px * var(--MD-modal-scale));
    padding-left: calc(16px * var(--MD-modal-scale));
    padding-right: calc(16px * var(--MD-modal-scale));
    gap: calc(24px * var(--MD-modal-scale));
    border-width: 0px;
}

.MDModalDualCardItemButton {
    all: unset;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: calc(16px * var(--MD-modal-scale));
}

.MDModalDualCardItemButtonFooter {
    all: unset;
    width: 100%;
    display: flex;
    box-sizing: border-box;
}

.MDModalButton.MDModalButtonWhatsapp {
    background-color: var(--MD-modal-whatsapp-color);
}

.MDModalButton.MDModalButtonTelegram {
    background-color: var(--MD-modal-telegram-color);
}

.MDModalButton {
    all: unset;
    box-sizing: border-box;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    cursor: pointer;
    background-color: var(--MD-grey-200);
    min-height: calc(48px * var(--MD-modal-scale));
    color: var(--MD-white);
    user-select: none;
    font-style: normal;
    font-weight: 400;
    font-size: calc(14px * var(--MD-modal-scale));
    line-height: calc(20px * var(--MD-modal-scale));
    letter-spacing: calc(0.17px * var(--MD-modal-scale));
    box-shadow: rgba(89, 104, 143, 0.06) 0px 1px 5px;
    text-align: center;
    font-family: Roboto, sans-serif !important;
    overflow-wrap: anywhere !important;
    padding: calc(6px * var(--MD-modal-scale)) calc(8px * var(--MD-modal-scale));
    gap: calc(8px * var(--MD-modal-scale));
    border-radius: calc(6px * var(--MD-modal-scale));
}

.MDModalButtonTelegram .MDModalButtonIcon {
    --icon: url(data:image/svg+xml,%3Csvg viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath d="M21.5 7.53138L18.6528 21.3755C18.6528 21.3755 18.2544 22.3354 17.16 21.8751L10.5907 17.017L10.5602 17.0027C11.4476 16.2342 18.3286 10.2671 18.6293 9.99658C19.0949 9.57767 18.8059 9.32829 18.2653 9.64473L8.10117 15.8703L4.17987 14.5977C4.17987 14.5977 3.56277 14.386 3.5034 13.9257C3.44326 13.4646 4.20018 13.2152 4.20018 13.2152L20.1861 7.16672C20.1861 7.16672 21.5 6.60994 21.5 7.53138Z" fill="currentColor"/%3E%3C/svg%3E%0A);
}

.MDModalButtonWhatsapp .MDModalButtonIcon {
    --icon: url(data:image/svg+xml,%3Csvg viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath d="M21.5732 6.91667C19.6916 5.04167 17.1829 4 14.5348 4C9.02961 4 4.56969 8.44444 4.56969 13.9306C4.56969 15.6667 5.05749 17.4028 5.89373 18.8611L4.5 24L9.79617 22.6111C11.2596 23.375 12.8624 23.7917 14.5348 23.7917C20.0401 23.7917 24.5 19.3472 24.5 13.8611C24.4303 11.2917 23.4547 8.79167 21.5732 6.91667ZM19.3432 17.4722C19.1341 18.0278 18.1585 18.5833 17.6707 18.6528C17.2526 18.7222 16.6951 18.7222 16.1376 18.5833C15.7892 18.4444 15.3014 18.3056 14.7439 18.0278C12.2352 16.9861 10.6324 14.4861 10.493 14.2778C10.3537 14.1389 9.44774 12.9583 9.44774 11.7083C9.44774 10.4583 10.0749 9.90278 10.284 9.625C10.493 9.34722 10.7718 9.34722 10.9808 9.34722C11.1202 9.34722 11.3293 9.34722 11.4686 9.34722C11.608 9.34722 11.8171 9.27778 12.0261 9.76389C12.2352 10.25 12.723 11.5 12.7927 11.5694C12.8624 11.7083 12.8624 11.8472 12.7927 11.9861C12.723 12.125 12.6533 12.2639 12.5139 12.4028C12.3746 12.5417 12.2352 12.75 12.1655 12.8194C12.0261 12.9583 11.8868 13.0972 12.0261 13.3056C12.1655 13.5833 12.6533 14.3472 13.4199 15.0417C14.3955 15.875 15.162 16.1528 15.4408 16.2917C15.7195 16.4306 15.8589 16.3611 15.9983 16.2222C16.1376 16.0833 16.6254 15.5278 16.7648 15.25C16.9042 14.9722 17.1132 15.0417 17.3223 15.1111C17.5314 15.1806 18.7857 15.8056 18.9948 15.9444C19.2735 16.0833 19.4129 16.1528 19.4826 16.2222C19.5523 16.4306 19.5523 16.9167 19.3432 17.4722Z" fill="currentColor"/%3E%3C/svg%3E%0A);
}

.MDModalDualCardItemQrcode {
    all: unset;
    box-sizing: border-box;
    width: 100%;
    display: flex;
    flex-direction: column-reverse;
    align-items: center;
    gap: calc(8px * var(--MD-modal-scale));
    padding: calc(20px * var(--MD-modal-scale)) 0;
    border-radius: calc(4px * var(--MD-modal-scale));
}

@media (min-width: 960px){
    .MDModalDualCardItemQrcode, .MDModalSoloCardQrcode {
        display: flex;
    }
}

.MDModalDualCardItemQrcodeHeader {
    all: unset;
    display: inline-flex;
    user-select: none;
    font-style: normal;
    font-weight: 400;
    font-size: calc(12px * var(--MD-modal-scale));
    line-height: calc(19px * var(--MD-modal-scale));
    text-align: center;
    max-width: calc(180px * var(--MD-modal-scale));
    font-family: Roboto, sans-serif !important;
    overflow-wrap: anywhere !important;
    padding: 0 calc(8px * var(--MD-modal-scale));
}

.MDModalDualCardItemQrcodeFooter {
    --s: calc(150px * var(--MD-modal-scale));
    all: unset;
    box-sizing: border-box;
    display: inline-flex;
    aspect-ratio: 1 / 1;
    height: var(--s);
    width: var(--s);
    background-color: var(--MD-white);
    border-radius: calc(4px * var(--MD-modal-scale));
    overflow: hidden;
}

.MDModalDualCardItem {
    all: unset;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    background-color: transparent;
    box-sizing: border-box;
    padding-top: calc(16px * var(--MD-modal-scale));
    padding-left: calc(16px * var(--MD-modal-scale));
    padding-right: calc(16px * var(--MD-modal-scale));
    gap: calc(24px * var(--MD-modal-scale));
    border-width: 0px;
}

.MDModalFooter {
    all: unset;
    width: 100%;
    position: absolute;
    left: 50%;
    bottom: calc(20px * var(--MD-modal-scale));
    transform: translateX(-50%);
    display: flex;
    justify-content: center;
    text-align: center;
}

/**** Модальное окно конец ****/

/**** Кнопка ватсап ****/

.viewWidgetButtonGif{
    all: unset;
    display: block;
    max-width: 100%;
    aspect-ratio: 1 / 1;
    border-radius: 50%;
    overflow: hidden;
}

.viewWidgetButton {
    all: unset;
    position: absolute;
    z-index: 3;
    width: 100%;
    aspect-ratio: 1 / 1;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transform: scale(1);
    color: white;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    border-radius: 50%;

    transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.5) 0s, opacity 0.3s cubic-bezier(0.175, 0.885, 0.32, 1) 0s;
}

.viewWidgetButtonWrapperVisible {
    /**/display: flex;
}

.viewWidgetButtonWrapper {
    all: unset;
    position: fixed;
    /*display: none;*/
    aspect-ratio: 1 / 1;
    z-index: 2147483646;
    width:80px;
    height:80px;
	left: calc(100% - 180px);
	bottom:25px;
}

.viewWidgetButtonWaveColorMulti {
    animation: 10s linear 0s infinite normal none running viewWidgetButtonWaveColorMulti;
}

.viewWidgetButtonWaveColor {
    all: unset;
    display: block;
    position: absolute;
    z-index: 1;
    width: 100%;
    aspect-ratio: 1 / 1;
    color: #009688;
}

.viewWidgetButtonWave {
    all: unset;
    display: block;
    position: absolute;
    z-index: 1;
    width: 100%;
    aspect-ratio: 1 / 1;
    animation-timeline: auto;
    animation-range-start: normal;
    animation-range-end: normal;
    border-radius: 50%;
    /**/background: radial-gradient(rgba(255, 255, 255, 0), currentcolor);
    animation: 4s ease 0s infinite normal none running viewWidgetButtonWaveSonic;
}

.viewWidgetButton:hover {
    transform: scale(1.15);
}


@keyframes viewWidgetButtonWaveSonic {
    0% {
        transform: scale(1);
        opacity: 0;
    }
    60% {
        transform: scale(1);
        opacity: 0;
    }

    70% {
        opacity: 0.4;
    }

    100% {
        transform: scale(2);
        opacity: 0;
    }
}

@keyframes viewWidgetButtonWaveColorMulti {
    0% {
        color: rgb(0, 136, 204);
    }
    22% {
        color: rgb(0, 136, 204);
    }
    28.8% {
        color: rgb(37, 211, 102);
    }
    82% {
        color: rgb(37, 211, 102);
    }
    88% {
        color: rgb(0, 136, 204);
    }
    100% {
        color: rgb(0, 136, 204);
    }
}


@media (max-width: 425px) {
    .MDChat {
        /*all: unset;*/
        width: 100%;
        max-height: 100%;
        bottom: 0px;
        left:0px;
    }
    
    .viewWidgetButtonWrapper {
        width:60px;
        height:60px;
		left: calc(100% - 80px);
    }
    
    .MDModalDualCardItemQrcode {
        display: none;
    }
    
    .MDModalDualCardContainer {
        display: block;
    }
}
/**** Кнопка ватсап конец ****/


</style>
';
?>
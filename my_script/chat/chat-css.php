<?
// CSS кнопки чата
echo'
<style>
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

/*
    .button_chat {
        bottom: 0px;
        right: 150px;
        z-index: 1999999999;
        cursor: pointer;
        position: fixed;
        border-radius: 7px 7px 0 0;
        border-top: 4px solid rgba(0,0,0,.15);
        font-size: 16px;
        background: #f8dd47;
        color: #333;
        
        padding: 1em;
    -webkit-box-shadow: 0 0 5px rgba(0,0,0,.2);
        box-shadow: 0 0 5px rgba(0,0,0,.2);
        display: flex;
        align-items: center;
    }
    
    .button_chat svg {
        top: 0.5em;
        font-size: 1.5em;
        position: absolute;
        max-width: 100%;
        max-height: 100%;
        fill: currentColor;
        color: inherit;
        height: 1em;
        vertical-align: -0.2em;
        display: inline-block;
    }
    
    .button_chat span {
        padding-left: 2.4em;
        white-space: nowrap;
    }
    */
</style>
';

// CSS ЧАТА

echo '
<style>
    .chat_online {
        font-size: medium;
        line-height: 1;
        font-family: inherit;
        color: #000;
        font-style: normal;
        font-weight: 400;
        text-decoration: none;
        list-style-type: disc;
        direction: ltr;
        text-align: left;
        pointer-events: initial;
        color: #595959;
        
        right: 150px;
        width: 342px;
        height: 500px;
        bottom: 53px;
        
        -webkit-transition: -webkit-transform .2s ease,-webkit-box-shadow .2s ease;
        transition: -webkit-transform .2s ease,-webkit-box-shadow .2s ease;
    -o-transition: transform .2s ease,box-shadow .2s ease;
        transition: transform .2s ease,box-shadow .2s ease;
        transition: transform .2s ease,box-shadow .2s ease,-webkit-transform .2s ease,-webkit-box-shadow .2s ease;
        
        position: fixed;
        z-index: 1999999999 ;
        
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
        
        border-radius: 20px ;
        border: 0px ;
        background: #fff ;
        box-shadow: 0 0 10px rgba(17,17,17,.2);
        
        display: flex;
        overflow: hidden;
        
        letter-spacing: 0;
        
        visibility: hidden;
        
    }
    
    .chat_online_header {
        color: #333;
        padding: 1em 1.5em;
        background: #f6f6f6;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-direction: normal;
        justify-content: space-between;
        align-items: center;
        /*border-bottom: 2px solid #f8dd47;*/
        
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
    
    .ch_on_header_text {
        font-weight: 700;
    }
    
    .ch_on_header_close  {
        margin: 0px;
        border-radius: 50%;
        -webkit-transition: all .2s ease;
        -o-transition: all .2s ease;
        transition: all .2s ease;
        padding: 0.5em;
        cursor: pointer;
        width: 16px;
        font-size: 1.0em;
    }
    
    .chat_online_body_full {
        height: 100%;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        /* position: relative; */
        top: 0;
        left: 0;
        bottom: 0;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-direction: normal;
        -webkit-box-flex: 1;
        /* -webkit-flex: 1 1; */
        -ms-flex: 1 1;
        /* flex: 1 1; */
        background: #fff;
        /* position: relative; */
        /* -webkit-transition: border-radius .2s ease; */
        -o-transition: border-radius .2s ease;
        /* transition: border-radius .2s ease; */
        justify-content: space-between;
        overflow: auto;

    }
    
    .chat_online_body {
        height: 100%;
        padding: 20px;
        overflow: auto;
        overflow-anchor: none;
        -ms-overflow-style: none;
        -ms-touch-action: auto;
        touch-action: auto;
        background: #e5dcd6;    
    }
    
    .first-message-date {
        color: #818ea3;
        text-align: center;
        padding: 2em 0;
        font-size: 14px;
    }
    
    .mes-wrapper-operator {
        -webkit-box-align: end;
        -webkit-align-items: flex-end;
        -ms-flex-align: end;
        align-items: flex-end;
        
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
    -webkit-box-direction: normal;
    
        margin: 5px 0px;
        justify-content: flex-start;
        flex-direction: row;
    }
    
    .mes-wrapper-user {
        -webkit-box-align: end;
        -webkit-align-items: flex-end;
        -ms-flex-align: end;
        align-items: flex-end;
        
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
    -webkit-box-direction: normal;
    
        margin: 5px 0px;
        justify-content: flex-end;
        flex-direction: row;
    }
    
    .chat_ava-operator {
        margin-right: 0.5em;
        width: 40px
    }
    
    .chat_ava-operator img {
        border-radius: 30em;
        line-height: 0;
        width: 100%;
        height: 100%;
        overflow: clip;
    }
    
    .mes-operator, .servise-mes-contact {
        
        padding: 1em;
        border-radius: 10px ;
        border-bottom-left-radius: 0;
        background: #fff;
        color: #414243;
        text-align: left;
        line-height: 1.4em;
        font-size: 14px;
    }
    
    .mes-operator {
        width: 100%;
    }
    
    .MDChatMessageShape {
        color: #fff;
        margin-bottom: -3px;
        margin-right: -3px;
    }
    
    .mes-user {
        padding: 1em;
        border-radius: 10px ;
        border-bottom-right-radius: 0;
        background: #fff;
        color: #414243;
        text-align: left;
        line-height: 1.4em;
        font-size: 14px;
    }
    
    .operator-name {
        font-weight: 600;
    }
    
    .message-time-operator {
        color: #818ea3;
        font-size: 11px;
        margin-bottom: 2em;
        margin-left: 8px
    }
    
    .message-time-user {
        color: #818ea3;
        font-size: 11px;
        margin-bottom: 2em;
        display: flex;
        flex-direction: row-reverse;
    }
    
    .chat_form_contact {
        border: 1px solid #e1e5eb!important;
        border-radius: 1em!important;
    -webkit-box-shadow: 0 0 10px rgba(225,229,235,.7)!important;
        box-shadow: 0 0 10px rgba(225,229,235,.7)!important;
        margin: 10px 0;
    }
    
    .contact_name, .contact_phone {
        padding: 5px;
        display: flex;
        flex-direction: row;
        align-items: center;
        background: #fff;
    }
    /*
    .contact_phone {
        display: none;
    }
    */
    .contact_name i, .contact_name svg, .contact_phone i {
        margin-left: 10px;
        width: 16px;
    }
    
    .chat_form_contact input {
        width: 100%;
        border: 0px;
        padding: 8px 14px;
        font-size: 14px;
    }
    
    .contact_button button {
        width: 100%;
        border: 0px;
        border-radius: 0px 0 15px 15px;
        font-size: 16px;
        font-weight: 500;
        background-color: #595959;
        color: #fff;
        height: 48px;
        cursor: pointer;
    }
    
    .contact_button button:hover {
        background-color: #8F76B9;
        color: #fff;
    }
    
    .keep-online-message {
        text-align: center!important;
        margin: 1em!important;
        font-size: 1.2em!important;
        line-height: 1.5em!important;
    }
    
    .variant_button {
        margin: 8px 0px;
        text-align: right;
    }
    
    .variant_button button {
        border-radius: 15px;
        background: #595959;
        color: #fff;
        padding: 8px 10px;
        border: 0px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 400;
    }
    
    .variant_button button:hover {
        background: #8F76B9;
        color: #ffffff;
    }
    
    .chat_online_footer {
        background: #f6f6f6;
        color: #595959;
        border: 1px solid #d5d5d5;
        border-radius: 3px;
        padding-top: 0;
        -ms-flex-direction: row;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
    }
    
    .ch_on_footer_textarea {
        padding-right: 3em ;
        padding-left: 1.5em ;
        padding-top: 0.5em;
        height: 58px;
        background: rgba(0,0,0,0);
        border: none;
        
        color: inherit;
    -webkit-transition: -webkit-box-shadow .2s ease;
        transition: -webkit-box-shadow .2s ease;
    -o-transition: box-shadow .2s ease;
        transition: box-shadow .2s ease;
        transition: box-shadow .2s ease, -webkit-box-shadow .2s ease;
        margin: 0; 
        resize: none;
        width: auto;
        font-size: 16px;
        
    }
    
    .send-button {
        display: inline-block;
        cursor: pointer;
        width: 2em;
        margin-right: -0.75em;
        letter-spacing: inherit;
        color: #8F76B9;
        position: absolute;
        white-space: nowrap;
        right: 1.5em;
        bottom: 10px;
    }
    
    
    
    @media (max-width: 425px) {
    
        .chat_online {
            right: 0px;
            width: 100%;
            height: 500px;
            max-height: 100%;
            bottom: 0px;
        }
    }
</style>
';
?>
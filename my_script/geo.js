
ymaps.ready(init);



function init() {
    var geolocation = ymaps.geolocation,
        myMap = new ymaps.Map('map', {
            center: [55, 34],
            zoom: 10
        }, {
            searchControlProvider: 'yandex#search'
        });

    // Сравним положение, вычисленное по ip пользователя и
    // положение, вычисленное средствами браузера.
    geolocation.get({
        provider: 'yandex',
        mapStateAutoApply: true
    }).then(function (result) {
        // Красным цветом пометим положение, вычисленное через ip.
        result.geoObjects.options.set('preset', 'islands#redCircleIcon');
        result.geoObjects.get(0).properties.set({
            balloonContentBody: 'Мое местоположение'
        });
        myMap.geoObjects.add(result.geoObjects);
    });

    geolocation.get({
        provider: 'browser',
        mapStateAutoApply: true
    }).then(function (result) {
        // Синим цветом пометим положение, полученное через браузер.
        // Если браузер не поддерживает эту функциональность, метка не будет добавлена на карту.
        result.geoObjects.options.set('preset', 'islands#blueCircleIcon');
        myMap.geoObjects.add(result.geoObjects);
    
        
        const cit = result.geoObjects.get(0).properties.get('metaDataProperty').GeocoderMetaData.Address.Components;
        $('.site-logo-img').append('<p class="city_user"><span class="cit">г. Москва</span> <!--a style="color: #000;" href="tel:84959999999">8 (495) 999-99-99</a--></p>');
        for (let entry of cit) {
            if(entry.kind=='locality'){
                console.log(entry.name);
                $('.cit').html('г. '+entry.name);
                //alert(entry.name);
            }
        } 


    });



}
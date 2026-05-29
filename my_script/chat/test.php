<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заголовок страницы</title>
    <link rel="stylesheet" href="./styles/style.css">

    <meta property="og:title" content="Заголовок страницы в OG">
    <meta property="og:description" content="Описание страницы в OG">
    <meta property="og:image" content="https://example.com/image.jpg">
    <meta property="og:url" content="https://example.com/">
  </head>
  <body>
    <header>
      <h1>Личный сайт</h1>
      <p>Который сделан на основе готового шаблона</p>
      <nav>
        <ul>
          <li><a href="index.html">Эта страница</a></li>
          <li><a href="catalog.html">Другая страница</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <article>
        <section>
          <h2>Первая секция</h2>
          <p>Она обо мне</p>
          <img src="images/image.png" alt="Человек и пароход">
          <p>Но может быть и о семантике, я пока не решил.</p>
        </section>
        <section>
          <h2>Вторая секция</h2>
          <p>Она тоже обо мне</p>
        </section>
        <section>
          <h2>И третья</h2>
          <p>Вы уже должны были начать догадываться.</p>
        </section>
      </article>
    </main>
    <footer>
      <div class="footer_info">
        <div class="inform">2023 © mirmil.ru Все права защищены</div>
        <div class="PayLogo">
          <img src="https://mirmil.ru/wp-content/uploads/2024/02/mir.png">
          <img src="https://mirmil.ru/wp-content/uploads/2024/02/visa.png">
          <img src="https://mirmil.ru/wp-content/uploads/2024/02/mastercard.png">
          </div>
      </div>
    </footer>
    
    <!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();
   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(71240389, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/71240389" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

    
    <!-- Roistat Counter Start -->
<script>
(function(w, d, s, h, id) {
    w.roistatProjectId = id; w.roistatHost = h;
    var p = d.location.protocol == "https:" ? "https://" : "http://";
    var u = /^.*roistat_visit=[^;]+(.*)?$/.test(d.cookie) ? "/dist/module.js" : "/api/site/1.0/"+id+"/init?referrer="+encodeURIComponent(d.location.href);
    var js = d.createElement(s); js.charset="UTF-8"; js.async = 1; js.src = p+h+u; var js2 = d.getElementsByTagName(s)[0]; js2.parentNode.insertBefore(js, js2);
})(window, document, 'script', 'cloud.roistat.com', '434d60c084d791c3acb23ca7fc55d690');
</script>
<!-- Roistat Counter End -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <!-- сюда можно подключить jquery --><script src="/my_scripts/chat/chat.js" defer></script> 
    
  </body>
</html>
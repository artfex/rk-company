<?php
/**
 * @author Ашурбеков Магомед <director@algoritm.tech>
 * @description Подвал сайта
 * @version 201701.06
 */
include_once '/clickfrogru_udp_tcp.php';
?>
<!--
<a href="//clickfrog.ru/?page=registration&amp;referrer_id=7516">
    <img src="//stat.clickfrog.ru/img/clfg_ref/icon_1.png" alt="click fraud detection"/>
</a>
-->
<div id="clickfrog_counter_container" style="width:0px;height:0px;overflow:hidden;">

</div>
<script type="text/javascript">
    (function (d, w) {
        var clickfrog = function () {
            if (!d.getElementById('clickfrog_js_container')) {
                var sc = document.createElement('script');
                sc.type = 'text/javascript';
                sc.async = true;
                sc.src = "//stat.clickfrog.ru/c.js?r=" + Math.random();
                sc.id = 'clickfrog_js_container';
                var c = document.getElementById('clickfrog_counter_container');
                c.parentNode.insertBefore(sc, c);
            }
        };
        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", clickfrog, false);
        } else {
            clickfrog();
        }
    })(document, window);
</script>
<noscript>
<div style="width:0px;height:0px;overflow:hidden;">
    <img src="//stat.clickfrog.ru/no_script.php?img" style="width:0px; height:0px;" alt=""/>
</div>
</noscript>
<script type="text/javascript">
    var clickfrogru_uidh = '76ca2deaa98923cf6d98eadf42e2caf5';
</script>
</body>
</html>

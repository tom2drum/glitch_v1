<!doctype html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta name="description" content="image glitch online generator destroy image glitch art">
    <meta name="yandex-verification" content="edfef70b9c2f52dc" />
    <link rel="stylesheet" href="<?= ROOT?>css/mini/styles.css">
    <link rel="icon" href="<?= ROOT?>favicon/favicon-16.png" sizes="16x16" type="image/png">
    <link rel="icon" href="<?= ROOT?>favicon/favicon-32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="<?= ROOT?>favicon/favicon-48.png" sizes="48x48" type="image/png">
    <link rel="icon" href="<?= ROOT?>favicon/favicon-62.png" sizes="62x62" type="image/png">
    <link rel="apple-touch-icon" href="<?= ROOT?>favicon/favicon-120.png">
    <title>Glitch your image online</title>
    
    <meta property="og:title" content="ohhhh glitch" />
    <meta property="og:url" content="http://glitch.ohhhh.me/" />
</head>
<body>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-79833879-2', 'auto');
        ga('send', 'pageview');

    </script>
    <aside class="toolbar">
        <form method="post" action="<?= ROOT?>" ENCTYPE="multipart/form-data" target="rFrame" class="hidden-form" id="hiddenForm">
        </form>
        <form method="post" action="<?= ROOT?>" class="btn-form">
            <button type="submit" name="new" class="btn tooltip" onclick="FindFile();" formmethod="post" formaction="<?= ROOT?>" form="hiddenForm" data-tooltip="upload image">
                <div class="iconWrapper">
                    <div class="plus icon"></div>
                </div>
            </button>
            <div class="hiddenInput">
                <input type="file" name="userfile" id="my_hidden_file" onchange="LoadFile();" form="hiddenForm">
                <input type="submit" name="upload" value="upload" id="my_hidden_load" style="display: none" formmethod="post" formaction="<?= ROOT?>" form="hiddenForm">
            </div>
            <button type="submit" name="glitch" class="btn <? if(!$btn_glitch) {echo 'tooltip';} ?><?= $btn_glitch ?>" <?= $btn_glitch ?> data-tooltip="make glitch">
                <div class="iconWrapper">
                    <div class="picture-solid icon"></div>
                </div>
            </button>
            <button type="submit" name="undo" class="btn <? if(!$btn_undo) {echo 'tooltip';} ?><?= $btn_undo ?>" <?= $btn_undo ?> data-tooltip="undo action">
                <div class="iconWrapper">
                    <div class="undo icon"></div>
                </div>
            </button>
            <button type="submit" name="save" class="btn <? if(!$btn_save) {echo 'tooltip';} ?><?= $btn_save ?>" <?= $btn_save ?> data-tooltip="save result">
                <div class="iconWrapper">
                    <div class="download icon"></div>
                </div>
            </button>
        </form>
        <iframe id="rFrame" name="rFrame" style="display: none"> </iframe>
    </aside>
    <section class="content">
        <? if ($content_msg != '') : ?>
            <div class="desc">
                <p><?= $content_msg ?></p>
            </div>
        <? else: ?>
            <? if ($content_image != '') : ?>
                <img class="bg-img" src="<?= $content_image ?><?='?='.rand(1,99999)?>">
            <? else: ?>
                <div class="desc">
                    <h1>This is online tool using which you can create glitch effect.</h1>
                    <p>Hello there.</p>
                    <p>This simple web-tool can help you to create your own image glitch. There are 3 easy steps that you should do:</p>
                    <ul>
                        <li>upload your image <span class="hint">// please use jpg- or png- files with total size not more than 4Mb</span></li>
                        <li>glitch it as many times as you want; glitch effects applies absolutely randomly; if you are not satisfied with result, you always can take one step back and make glitch again</li>
                        <li>save the result to your hard drive at anytime you want <span class="hint">// if saved image is not what you see, just make printscreen of the page</span></li>
                    </ul>
                    <p>Note that this tool uses algorithms that corrupt images indeed (no filters, no imitations, no fake). So there is a chance that your will corrupt your image completely and it cannot be displayed by your web-browser <span class="hint">// just use 'step back' button in that case</span><br>Remember, if doubt, glitch it again.<br>Good luck!</p>
                </div>
                <div class="credits">&copy; created by <a href="https://www.facebook.com/tom.ohhhh.me">tom</a></div>
            <?endif; ?>
        <? endif; ?>
    </section>
    <script src="<?= ROOT?>js/script.js"> </script>
</body>
</html>
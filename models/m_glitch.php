<?php

function isImageSafe($file, $prefmode = 'gd'){
    $ss = explode('.', basename($file));
    if (count($ss) < 2){
        return false;
    }
    if (!is_file($file)){
        return false;
    }
    $logfile = tempnam('/tmp', 'ivl_');

    $result = false;
    switch (strtolower(end($ss))){

        case 'jpg': case 'jpeg': case 'jpe':
        if ($prefmode == 'gd'){
            $er = error_reporting();
            error_reporting($er & 0xFFFD);
            $i = imagecreatefromjpeg($file);
            error_reporting($er);
            if ($i){
                $result = true;
            }
            unset($i);
        } else {
            `identify -verbose $file 2>$logfile`;
            $c = strtolower(file_get_contents($logfile));
            if (strpos($c, 'corrupt jpeg data') === false || strpos($c, 'premature end of jpeg file') === false){
                $result = true;
            }
        }
        break;

        case 'gif':
            `identify -verbose $file 2>$logfile`;
            $c = strtolower(file_get_contents($logfile));
            if (strpos($c, 'corrupt image') === false){
                $result = true;
            }
            break;

        case 'png':
            if ($prefmode == 'gd'){
                $er = error_reporting();
                error_reporting($er & 0xFFFD);
                $i = imagecreatefrompng($file);
                error_reporting($er);
                if ($i){
                    $result = true;
                }
                unset($i);
            } else {
                `identify -verbose $file 2>$logfile`;
                $c = strtolower(file_get_contents($logfile));
                if (strpos($c, 'corrupt image') === false || strpos($c, 'read exception') === false){
                    $result = true;
                }
            }
            break;

        default:
            return false;
    }

    unlink($logfile);
    return $result;
}

function delete_part ($str, $point, $len) {
    /* delete part of string in % from beginning */

    return substr_replace($str, '', strlen($str) * $point, $len);
}

function replace_part ($str, $point_start, $point_end, $pattern, $replacement) {
    /* substitute part of string */

    $str_start = substr($str, 0, strlen($str) * $point_start);
    $str_mid = substr($str, strlen($str) * $point_start, strlen($str) * $point_end);
    $str_end = substr($str, strlen($str) * $point_end, strlen($str));

    $str_mid = strtr($str_mid, $pattern, $replacement);

    return $str_start.$str_mid.$str_end;
}

function insert_part ($str, $point, $ins_str) {
    /* insert string into the file */

    $str_start = substr($str, 0, strlen($str) * $point);
    $str_end = substr($str, strlen($str) * $point, strlen($str));
    return $str_start.$ins_str.$str_end;
}

function insert_part_multi ($str, $points = [], $ins_str) {
    /* insert a string in many places of the string */

    foreach ($points as $point) {
        $str = insert_part($str, $point, $ins_str);
    }

    return $str;
}

function get_limit_0 ($file) {
    $limit = 0.01;
    $precision = 0.0001;
    $str = file_get_contents($file);
    file_put_contents('tmp.jpg', $str);

    while (isImageSafe('tmp.jpg')) {
        $str = delete_part($str, $limit, 150);
        file_put_contents('tmp.jpg', $str);
        $limit = $limit - $precision;
        $str = file_get_contents($file);
    }

//    if (isImageSafe('tmp.jpg')) {echo 'true';} else {echo 'false';}

    return $limit;
}

function get_limit () {
    return (rand(0, 995) + 5) / 1000;
}

function apply_method ($str) {
    $id = rand(0, 11);

//    echo $id;

    switch ($id) {
        case 0:
        case 1:
        case 2:
        case 3:
        case 10:
        case 11:
            $point = get_limit();   // need to define lowest limit
            $len = rand(0, strlen($str) * 0.001);                // or absolute value / or more complex

            return delete_part($str, $point, $len);

            break;
        case 4:
        case 5:
        case 6:
        case 7:
            $point = get_limit();   // need to define lowest limit
            $id_ins = rand(0, 5);
            switch ($id_ins) {
                case 0: $ins_str = 'W’kü1..ıù#í8ÂtIú±ñ¡l|⁄A›Ä»$ÙŒıes∞¸YÂ€ïTQ„ì<<Ù°"Gè√\sÀ?,◊>≠÷”ß7úpÚøôèàÉÕèól±çx/á∂9û;&HRüï∆5cÛÌ]:Qé•·ª˚('; //light
                    break;
                case 1: $ins_str = 'hñk{x˛%ƒí2Ehï ∆˜$ÁóSYÀÑﬁ¸3¯Ω∆[Éñ$¥õÛ\'üÙØ,¸Ÿw=Y~\;Yá/§mÅ∂:€';   //dark
                    break;
                case 2: $ins_str = '9ñh∂Pπ”ù\∞9’öuß¿<,xµ˙M≈¯∞;]Ò<RüÙ';        //dark
                    break;
                case 3: $ins_str = '2π’±#∂›GZz]mª¿ÔÙƒã';          //light
                    break;
                case 4: $ins_str = '¢;±<™°Ë É8…•õYtc9f…¶ôŸn*Å®”FƒH¿‘“Ì:MéuõãS$Àp¨ˆµ‹à4ú‘“Ï›@ç∑4—¥à„Fz‘´6óCc{‘kCßÄg ∑J9EiT98≠Fj ŒM]öMÖm∫T§X‘ÑÁaYkÑ†©ÿQUÂNjƒ®ü•iïyÂV3U]∑≠"&aìÅÙ≠2oàWc∏ÌT=dD˘vÙ
´ ˙úö‘JàdBàªmrV@ÃI˜¨ÿ‘≠ò>ıç4˙—R©Ú‘å–G$ÖÌV#2ÂŸH¬ÙÆ∏π‰Øéµ∂K¶:ÍëT!∑J ∂5mE-π„ü·@ÖÈ@v†@z‘”nÙz@‡9yr†^∆Å{fÅco~tÉø_j(ﬂæ{Q∂y{–Í0Gj ˚‚Åt†zç∑ÂQO$$lÁÂQíZõ”R*Z@ÒÎöU≈ƒægﬂ8\'ß”ïgÆoï Ôâ·¿|t˛“ﬁ7$@ç#c˘â«ﬂ∂+èVÓ…=;tq‚÷7√∂yU§C·\'Ôe g 9≠yÌwæ
‚‹Rfæ∏πäh‹yv€OzÊÆ„åJe.áúÊ∑§Qéqsz⁄—ûWﬂWÚı…ÌÌW\2∏eíÍÊ[ñÁ–Ä
á˘ﬁ¶õPel∂rÜÁ\Íê º{‚*$u–ÌÈÍ*Y≥)∂á∂K€^« nÁPÒ
!∞{n>µ¨Ølµ©´$˚∑¯åødÅÂ–@NÂ\∞Êi:ü≠gÜY‹^ ºJıârøπçá.∫è“µlúD∆kñç∂K‹&5¶u±#v\'π¸Oµf¸∫_
êmen3èÅÄõ˜¡Ë:◊¥∆Ωí4+à¿≤ùOúÈ@:ûæÍ+>n”ƒ—ÆÀL_Jƒπ$l	ﬂ€;oz±ÁÀ{pó‹Xq;b%»±ÜÂ®…KçGptÀª,«Œù∫:√)oÀY·
XKníƒ\'ì˜∫O3ú§ ˇ (;˝ZÛaˇ ?≈ÀÙœ˚ø˙üÕÍ ~?ÖèÍæı?˜\Õ˘6∞=≤J¶‚d‹π8#?2ˇ ‘y„µw¬\ÚÔæ\'è˘NÆ_Öá·„Ê˘ˇ è˘g™9–0¿Á©€jÏÚ»Ô~‡ÜY˙uo7ëF⁄˜ÊP;V|¶W”¥‚ºEmÆöI¨6»∫§#aè·^˘\'óqÎVŸ9§ñÒGÒ\'õåﬂ1l¨K≤!9“†ÏπÎ‹ûß⁄òÓﬁÍﬂRÃgf?≈ñQÆ8 æù™€¶$ÓÆõÜp◊6cÁ~ïÂœ.^â8t¸.ﬂ≈‚Î&@‘e-—„Qü√v"Ω8Õ›8eudsª⁄A®iÁ§„?ÊﬂJÙ<˛ŸºZÂ¢Ö03Á\'
œ®?O∆ßñúˇ ªé“5f∑7Z§>';                     //dark
                case 5: $ins_str = 'ÍaîŒs˚ÏËæ';            //little change
            }

            return insert_part($str, $point, $ins_str);

            break;
        case 8:
            $point[] = get_limit();
            $point[] = get_limit();
            $point[] = get_limit();


            $id_ins = rand(0, 9);
            switch ($id_ins) {
                case 0:
                case 1:
                case 2:
                    $ins_str = 'À?,◊>≠÷”üï∆5cÛÌ]:Qé•·ª˚('; //
                    break;
                case 3:
                case 4:
                case 5:
                    $ins_str = 'hñk{x˛%ƒí2Ehï ∆˜$ÁóSYÀÑﬁ¸3¯Ω∆[Éñ$¥õÛ\'üÙØ,¸Ÿw=Y~\;Yá/§mÅ∂:€';   //dark
                    break;
                case 6:
                case 7:
                case 8:
                    $ins_str = '9ñh∂Pπ”ù\∞9’öuß¿<,xµ˙M≈¯∞;]Ò<RüÙ';        //dark
                    break;
                case 9: $ins_str = '2π’±#∂›GZz]mª¿ÔÙƒã';          //light - stand alone pixel effect!
                    break;
            }

            return insert_part_multi($str, $point, $ins_str);

            break;

        case 9:
            for ($i = 1; $i <= 10; $i++) {
                $point[] = get_limit();
            }
            $ins_str = 'RB';

            return insert_part_multi($str, $point, $ins_str);

            break;
    }
}
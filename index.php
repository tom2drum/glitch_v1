<?php

session_start();
include_once ('models/m_glitch.php');
include_once ('models/m_system.php');
define('UPLOAD_DIR', 'img/');
// TODO: change address when upload to server
define('ROOT', '/');

$content_image = '';
$content_btn['glitch'] = '';
$content_btn['undo'] = '';
$content_btn['save'] = '';


if (count($_POST) > 0) {
    if (isset($_POST['upload'])) {
        $result = img_upload($_FILES['userfile'], UPLOAD_DIR);

        if (isset($result['error'])) {
            $_SESSION['msg'] = $result['error'];
        } else {
            if (isset($_SESSION['msg'])) {
                unset($_SESSION['msg']);
            }
            move_uploaded_file($_FILES['userfile']['tmp_name'], $result['filename']);
            setcookie('img', $result['filename'], time() + 3600 * 24 * 30);
            $_SESSION['img'] = $result['filename'];
            $content_image = $result['filename'];
        }

        jsOnResponse();

    } else {
        if (isset($_SESSION['img'])) {
            $img_b = $_SESSION['img'];
            $img_n = file_name_increment($img_b);

            if (!file_exists($img_n)) {
                file_put_contents($img_n, file_get_contents($img_b));
            }

            if (isset($_POST['glitch'])) {
                $str = file_get_contents($img_n);

                file_put_contents($img_b, $str);
                file_put_contents($img_n, apply_method($str));

                $content_image = $img_n;

            } elseif (isset($_POST['undo'])) {
                $str = file_get_contents($img_b);
                file_put_contents($img_n, $str);

                $content_image = $img_n;

                $content_btn['undo'] = 'disabled';

            } elseif (isset($_POST['save'])) {
                $mm_type="application/octet-stream";

//                header("Cache-Control: public, must-revalidate"); // кешировать
                header("Pragma: hack");
                header("Content-Type: " . $mm_type);
                header("Content-Length: " .(string)(filesize($img_n)) );

                header('Content-Type: application/jpg');
                header('Content-Disposition: attachment; filename="image.jpg"');
                readfile($img_n);

                $content_image = $img_n;
            }
        }
    }
} else {
    if(!isset($_COOKIE['img']) || !file_exists($_SESSION['img'])) {
        $content_btn = [
            'glitch' => 'disabled',
            'undo' => 'disabled',
            'save' => 'disabled'
        ];
    }
}

if (isset($_COOKIE['img']) && $content_image === '') {
    $content_image = $_COOKIE['img'];
    $content_btn['undo'] = 'disabled';
}

$content_msg = (isset($_SESSION['msg'])) ? $_SESSION['msg'] : null;

/* ---------------------------*/
/* include page templates */
/* ---------------------------*/

$html = template_include('main.php', [            //main page template
    'page_title' => 'glitch it',
    'content_image' => $content_image,
    'btn_glitch' => $content_btn['glitch'],
    'btn_undo' => $content_btn['undo'],
    'btn_save' => $content_btn['save'],
    'content_msg' => $content_msg
]);

echo $html;


/* ============================*/
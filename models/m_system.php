<?php



function template_include ($path, $vars = []) {
    extract($vars);
    ob_start();
    include ("views/$path");
    return ob_get_clean();
}

function file_extention ($filename) {
    return strtolower(substr($filename, strpos($filename, '.') + 1));            // extension of the file
}

function file_name_increment ($filename) {
    $ext = file_extention($filename);
    return substr(stristr($filename, $ext, true), 0, -2).'1.'.$ext;

}

function img_upload ($file, $upload_dir) {
    //for this function use $file as $_FILE['userfile']

    $filename = $file['name'];
    $max_filesize = 4 * 1024 * 1024; //not more than 2Mb


    // variables for checks
    $ext = file_extention($filename);            // extension of the file
    $whitelist = ['jpg', 'jpeg'];                                                // !!! set allowed extensions
    $whitelist_c = [];
    foreach ($whitelist as $item) {
        array_push($whitelist_c, 'image/'.$item);
    }
    $imageinfo = getimagesize($file['tmp_name']);


    if(!in_array($ext, $whitelist )){                                             // check file extension
        return ['error' => 'You can upload only .jpg or .png files'];
    }
    elseif (!in_array($imageinfo['mime'], $whitelist_c)) {                     //check file content
        return ['error' => 'You can upload only image files in .jpg or .png format'];
    }
    elseif($file['size'] > $max_filesize || $file['size'] == 0) {                   //check file size
        return ['error' => 'File is too large. Maximum allowed size is '.intval($max_filesize/(1024*1024)).'Mb'];
    }
    else {
        $name_mask = date('ymdHisT');
        $filename_new = $upload_dir.$name_mask.'0.'.$ext;
        return ['filename' => $filename_new, 'name_mask' => $name_mask];
    }
}

function jsOnResponse() {
    echo '<script type="text/javascript"> window.parent.onResponse(); </script> ';
}

function jsShowError($msg) {
    echo '<script type="text/javascript"> window.parent.showErrorMsg("'.$msg.'"); </script> ';
}

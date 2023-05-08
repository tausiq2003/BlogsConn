<?php

    function resize_image($target, $output, $w, $h, $ext){
        list($org_w, $org_h) = getimagesize($target);
        $scale_ratio = $org_w / $org_h;

        // the below condition helps you to change the width or height of the newly created resized image according to the aspect ratio of the original image i.e ig orginial img is tall or if its really wide image. Hence the below condtions will help you resize the new image with proper height and width 

        if (($w/$h) > $scale_ratio){
            $w = $h * $scale_ratio;
        } else {
            $h = $w / $scale_ratio;
        }
        $img = "";
        if ($ext == "jpg" || $ext == "JPG"){
            $img = imagecreatefromjpeg($target);
        } else if ($ext == "png" || $ext == "PNG"){
            $img = imagecreatefrompng($target);
        }
        $tci = imagecreatetruecolor($w, $h);
        imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $org_w, $org_h);
        imagejpeg($tci, $output, 80);
    }

?>
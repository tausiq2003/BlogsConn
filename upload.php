<?php
    // include "dbLogic.php";

    // if (isset($_REQUEST['new_img'])){
    //     $image = $_FILES['img-input'];
    //     $imgOrder = $_REQUEST['img_order'];

    //     $imgName = $_FILES['img-input']['name'];
    //     $imgTmpName  = $_FILES['img-input']['tmp_name'];
    //     $imgSize = $_FILES['img-input']['size'];
    //     $imgError = $_FILES['img-input']['error'];
    //     $imgType = $_FILES['img-input']['type'];

    //     $fileExt = explode('.', $imgName);                          // gets the extension of the file i.e. image.jpg so extensions will have jpg only
    //     $fileActualExtension = strtolower(end($fileExt));           // this converts fileExt like "JPG" to "jpg" for fair compatison

    //     $extensions = array('jpg', 'jpeg', 'png', 'pdf');

    //     if (in_array($fileActualExtension, $extensions)){
    //         if($imgError === 0){
    //             if($imgSize < 1000000000){
                    
    //                 $imgNameNew = uniqid("IMG-", true).".".$fileActualExtension;
    //                 $imgDestination = "uploads/".$imgNameNew;
    //                 move_uploaded_file($imgTmpName, $imgDestination);

    //                 // --------------------------
    //                 include_once('imgResize.php');
    //                 $targetfile = "uploads/".$imgNameNew;
    //                 $resizedfile = "uploads/resized_".$imgNameNew;
    //                 $width = 860;
    //                 $height = 600;
    //                 resize_image($targetfile, $resizedfile, $width, $height, $fileActualExtension);
    //                 //---------------------------
            

    //                 // Insert into db
    //                 $sql = "INSERT INTO images(image_order, image) VALUES('$imgOrder','$imgNameNew ')";
    //                 mysqli_query($conn, $sql);
    //                 header('Location: banner.php?uploaded'); 
    //             } else {
                    
    //                 echo "Your file is too large";
    //             }
    //         } else {
    //             echo 'There was an error uploading the file';
    //         }
    //     } else {
    //         echo 'you cannot upload files of this type';
    //     }

    // }

?>
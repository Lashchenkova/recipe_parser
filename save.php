<?php

//save pics to images folder
if (isset($_POST) && !empty($_POST)) {
    $ingredients = "<ul>" . $_POST['ingredients'] . "</ul>";
    saveIngredients($_POST['dishName'], $ingredients);
    makeMirrorPic($_POST['photoPath'], 'images/' . $_POST['dishName'] . '.jpg');
}

function saveIngredients($fileName, $str)
{
    $handle = fopen("ingredients/{$fileName}.txt", "c");
    fwrite($handle, $str);
    fclose($handle);
}
//changing images
function makeMirrorPic($fileImg, $newFile)
{
    $source = imagecreatefromjpeg($fileImg);
    $size = getimagesize($fileImg);
    $img = imagecreatetruecolor($size[0], $size[1]);
//mirror
    for ($x = 0; $x < $size[0]; $x++) {
        for ($y = 0; $y < $size[1]; $y++) {
            $color = imagecolorat($source, $x, $y);
            imagesetpixel($img, ($size[0] - 1) - $x, $y, $color);
        }
    }
//rotate
    $degrees = 2;
    $img = imagerotate($img, $degrees, 0);

//cut pic
    $cut = ceil($size[0] * sin(deg2rad($degrees)));

    $img_o = imagecreatetruecolor($size[0] - $cut, $size[1] - $cut);
    imagecopy($img_o, $img, 0, 0, $cut, $cut, $size[0] - $cut, $size[1] - $cut);
    imagejpeg($img_o, $newFile);

    imagedestroy($img);
    imagedestroy($img_o);
}

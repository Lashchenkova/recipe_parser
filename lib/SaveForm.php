<?php


class SaveForm
{
    public static function saveDish()
    {
        $ingredients = "<ul>" . $_POST['ingredients'] . "</ul>";

        self::makeMirrorPic($_POST['photoPath'], 'images/' . $_POST['dishName'] . '.jpg');
        self::saveIngredients($_POST['dishName'], $ingredients);

        header('Location: /');
    }

    public static function saveIngredients($fileName, $str)
    {
        $handle = fopen("ingredients/{$fileName}.txt", "c");
        fwrite($handle, $str);
        fclose($handle);
    }
//changing images (uniqueness)
    public static function makeMirrorPic($fileImg, $newFile)
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
        $cut = ceil($size[0] * sin(deg2rad($degrees)));//leg length

        $img_o = imagecreatetruecolor($size[0] - $cut, $size[1] - $cut);
        imagecopy($img_o, $img, 0, 0, $cut, $cut, $size[0] - $cut, $size[1] - $cut);
        imagejpeg($img_o, $newFile);//saving new pic

        imagedestroy($img);
        imagedestroy($img_o);
    }

}

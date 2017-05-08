<?php


class Cookbook
{
    public static function showRecipes()
    {
        $files = glob("ingredients/*.txt");

        $content = "<section style='display: flex; justify-content: space-between; flex-wrap: wrap; width: 90%; margin: 0 auto; padding-top: 4%'>";

        foreach($files as $file){
            $name = basename($file, ".txt");
            $src = 'images/' . $name . '.jpg';

            $content .= "<div style='width: 30%; padding-bottom: 3%'>";
            $content .= "<img src='{$src}' width='90%'>";
            $content .= "<h3>" . $name . "</h3>";
            $content .= file_get_contents($file);
            $content .= "</div>";
        }
        $content .= "</section>";

       return $content;
    }
}

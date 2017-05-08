<?php


class App
{
    public static function run()
    {
        $default_view = file_get_contents("view/index.html");

        if(isset($_GET['dishes']) && $_GET['dishes']){//cookbook view
            $content = Cookbook::showRecipes();
        } else {//default parser view
            $content = file_get_contents("view/tpls/search_form.html");

            if (isset($_GET['q']) && !empty($_GET['q'])) {
                $query = $_GET['q'];

                $parser = new Parser($query);
                $gallery = $parser->parsePics();
                $dishes = $parser->parseIngredients();

                //render content in index.html
                $save_form = file_get_contents('view/tpls/save_form.html');//form for saving dishes
                $save_form = str_replace("{{ query }}", $query, $save_form);//input value = $query
                $content = str_replace("{{ save_form }}", $save_form, $content);
                $content = str_replace("{{ gallery }}", $gallery, $content);
                $content = str_replace("{{ dishes }}", $dishes, $content);
            } else {
                $content = stristr($content, '{{ save_form }}', true);//return only search_form
            }

            if (isset($_POST) && !empty($_POST)) {
                SaveForm::saveDish();//save new dish
            }
        }

        $default_view = str_replace("{{ content }}", $content, $default_view);//render views
        echo $default_view;
    }
}
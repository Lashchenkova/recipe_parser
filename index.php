<?php

include_once('index.html');

if (isset($_GET['q']) && !empty($_GET['q'])) {

    $query = $_GET['q'];
    $save_form = file_get_contents('form.html');//form for saving pics
    echo str_replace("{{ query }}", $query, $save_form);

    //parse pics
    $path = file_get_contents('https://www.bing.com/images/search?q='.urlencode($query));
    preg_match_all('/https?:\/\/[a-z0-9\-\.\/]+\.(jpe?g)/i', $path, $img);

    $num = array_slice($img[0], 0, 8);//number of pictures
    echo "<div class='gallery'>";
    foreach ($num as $url) {
        echo "<a href='javascript:void(0)'><img src='{$url}' width='24%' class='dish_img'></a>";
    }
    echo "</div>";
    //parse ingredients
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTMLFile('http://eda.ru/recipesearch?q=' . urlencode($query));
    $finder = new DomXPath($dom);

    $class = "horizontal-tile__item-title item-title";//find all recipe titles
    $titles = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $class ')]");

    $classname = "ingredients-list__content";//find all ingredients
    $elements = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");


    //show ingredients
    if (!is_null($elements) && !is_null($titles)) {

        for ($i = 0; $i < $titles->length; $i++) {

            $nodes = $titles[$i]->childNodes;
            $recipes = $elements[$i]->childNodes;

            echo "<a href='javascript:void(0)' style='text-decoration: none; color: black'><div class='dish'>";
            foreach ($nodes as $node) {//show dishName
                $node = trim($node->nodeValue);
                if (!empty($node)) {
                    echo '<h3>' . $node . '</h3>';
                }
            }


            //show ingredients
            echo "<ul class='recipe'>";

            foreach ($recipes as $recipe) {
                $recipe = trim($recipe->nodeValue);
                $recipe = preg_replace("/\s+/", " ", $recipe);
                if (!empty($recipe)) {
                    echo '<li>' . $recipe . '</li>';
                }
            }
            echo "</ul></div></a><hr>";
        }
    }
}

?>

<script type="text/javascript" src="js/saveDish.js"></script>
<?php


class Parser
{
    public $query;//query from search_form
    public $gallery;//string to replace gallery in view
    public $dishes;//string to replace dishes in view

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function parsePics()
    {
        $path = file_get_contents('https://www.bing.com/images/search?q='.urlencode($this->query));
        preg_match_all('/https?:\/\/[a-z0-9\-\.\/]+\.(jpe?g)/i', $path, $img);//pull {name}.jpg

        $num = array_slice($img[0], 0, 8);//number of pictures = 8

        foreach ($num as $url) {
            $this->gallery .=  "<a href='javascript:void(0)'><img src='{$url}' width='23%' class='dish_img'></a>";
        }

        return $this->gallery;
    }

    public function parseIngredients()
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTMLFile('http://eda.ru/recipesearch?q=' . urlencode($this->query));
        $finder = new DomXPath($dom);

        $class = "horizontal-tile__item-title item-title";//find all recipe titles
        $titles = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $class ')]");

        $classname = "ingredients-list__content";//find all ingredients
        $elements = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");

        if (!is_null($elements) && !is_null($titles)) {

            for ($i = 0; $i < $titles->length; $i++) {

                $nodes = $titles[$i]->childNodes;

                $this->dishes .= "<a href='javascript:void(0)' style='text-decoration: none; color: black'><div class='dish'>";

                foreach ($nodes as $node) {//dishName
                    $node = trim($node->nodeValue);
                    if (!empty($node)) {
                        $this->dishes .= '<h3>' . $node . '</h3>';
                    }
                }


                $recipes = $elements[$i]->childNodes;

                $this->dishes .= "<ul class='recipe'>";

                foreach ($recipes as $recipe) {//ingredients
                    $recipe = trim($recipe->nodeValue);
                    $recipe = preg_replace("/\s+/", " ", $recipe);
                    if (!empty($recipe)) {
                        $this->dishes .= '<li>' . $recipe . '</li>';
                    }
                }

                $this->dishes .= "</ul></div></a><hr>";
            }

        }

        return $this->dishes;
    }
}
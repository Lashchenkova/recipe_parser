<?php

include_once('tpls/nav.html');

$files = glob("ingredients/*.txt");
$img_dir = glob("images/*.jpg");

echo "<section style=' display: flex; justify-content: space-between; flex-wrap: wrap; width: 90%; margin: 0 auto'>";
foreach($files as $file){
    $name = basename($file, ".txt");
    $src = 'images/' . $name . '.jpg';
    echo "<div style='width: 30%; padding-bottom: 3%'>";
    echo "<img src='{$src}' width='90%'>";
    echo "<h2>" . $name . "</h2>";
    include_once($file);
    echo "</div>";
}
echo "</section>";

<?php
$files = scandir('/ingredients');
foreach ($files as $file) {
    file_get_contents($file);
}
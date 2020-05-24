<?php
include __DIR__ . "/../vendor/autoload.php";

$hello = new \aitor\seobiro\Seobiro();
echo $hello->getUrl('https://aitor.me');

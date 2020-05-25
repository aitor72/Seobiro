<?php
include __DIR__ . "/../vendor/autoload.php";

$hello = new \aitor\seobiro\Seobiro();
$array = [
	"https://aitor.me",
	"aitor.me",
	"https://tuqueso.es",
	"http://example.com",
	"https://example.com",
	"https://www.example.com",
	"example.com"];

foreach($array as $item) {
 try {
	 $content = $hello->getUrl($item);
  echo $hello->getText($content);

}
catch (Exception $e) {
    echo $e->getMessage();
}
echo PHP_EOL;
}

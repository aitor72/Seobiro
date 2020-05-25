<?php
include __DIR__ . "/../vendor/autoload.php";

$seobiro = new \aitor\seobiro\Seobiro();
$array = [
	"https://www.aitor.me"];

foreach($array as $item) {
 try {
	 $content = $seobiro->getUrl($item);
   $text = $seobiro->getText($content);
   $language = $seobiro->getLanguage($text);
   $tokens = $seobiro->getTokens($text);
   $normalized = $seobiro->getNormalizedTokens($tokens);
   $frequency = $seobiro->getFrequencyDistribution($normalized);
   print_r($seobiro->removeStopWords($normalized,$language));
   //print_r($frequency->getKeyValuesByWeight());

}
catch (Exception $e) {
    echo $e->getMessage();
}
echo PHP_EOL;
}

<?php
include __DIR__ . "/../vendor/autoload.php";



$dataforseo = new \aitor\seobiro\Dataforseo("aitor.rodriguez03@estudiant.upf.edu","43a65714c6ce82da");

$results = $dataforseo->get_organic_results("aitor rodriguez");
print_r($results);



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
   $tokens = $seobiro->removeStopWords($normalized,$language);
   //print_r($frequency->getKeyValuesByWeight());
   $tokens = $seobiro->getStemmedTokens($tokens);

   //print_r($tokens);

}
catch (Exception $e) {
    echo $e->getMessage();
}
echo PHP_EOL;
}

<?php
include __DIR__ . "/../vendor/autoload.php";


$rustart = getrusage();

$dataforseo = new \aitor\seobiro\Dataforseo("aitor.rodriguez03@estudiant.upf.edu", "43a65714c6ce82da");
/*
$results = $dataforseo->get_organic_results("aitor rodriguez");
echo count($results);
*/

$seobiro = new \aitor\seobiro\Seobiro();

$results = [["url" => "https://www.vozpopuli.com/bienestar/como-adelgazar-truco-perder-peso_0_1329768405.html"]];

foreach ($results as $item) {
    try {
        $content = $seobiro->getUrl($item["url"]);
        $text = $seobiro->getText($content);
        $item["content"] = $text;
        $title = $seobiro->getTitle($content);
        $item["title"] =$title;
        $headers = $seobiro->getHeaders($content);
        $item["headers"] =$headers;
        $language = $seobiro->getLanguage($text);
        $item["lang"] = $language;
        $tokens = $seobiro->getTokens($text);
        $normalized = $seobiro->getNormalizedTokens($tokens);
        $frequency = $seobiro->getFrequencyDistribution($normalized);
        $tokens = $seobiro->removeStopWords($normalized, $language);
        //print_r($frequency->getKeyValuesByWeight());
        $tokens = $seobiro->getStemmedTokens($tokens);

        print_r($item);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    echo PHP_EOL;
}




function rutime($ru, $rus, $index)
{
    return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
     -  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
}

$ru = getrusage();
echo "This process used " . rutime($ru, $rustart, "utime") .
    " ms for its computations\n";
echo "It spent " . rutime($ru, $rustart, "stime") .
    " ms in system calls\n";

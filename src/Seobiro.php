<?php

declare(strict_types=1);

namespace aitor\seobiro;

use Goutte\Client;
use \Exception as Exception;
use Symfony\Component\HttpClient\HttpClient;
use andreskrey\Readability\Readability;
use andreskrey\Readability\Configuration;
use andreskrey\Readability\ParseException;
use yooper;
use LanguageDetector;
use voku\helper\StopWords;
use Wamania\Snowball\French;

use AsyncRequest;

class Seobiro
{
    public function __construct()
    {
    }




    public function getUrl(string $url):object
    {
        $client = new Client(HttpClient::create(array(
        'timeout' => 3,
        'verify_peer' => false,
        'verify_host' => false,
        'headers' => array(
            'user-agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:73.0) Gecko/20100101 Firefox/73.0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Language' => 'en-US,en;q=0.5',
            'Referer' => 'https://google.com',
            'Upgrade-Insecure-Requests' => '1',
            'Save-Data' => 'on',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'no-cache',
        ),
    )));

        $client->setServerParameter('HTTP_USER_AGENT', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:73.0) Gecko/20100101 Firefox/73.0');


        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception("Not a valid url");
        }

        try {
            $crawler = $client->request('GET', $url);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        $response = $client->getInternalResponse();

        if ($response->getStatusCode() == 200) {
            return $crawler;
        } else {
            throw new Exception("Failed to open the url");
        }
    }


    public function getUrls(array $urls):array
    {
        $asyncRequest = new AsyncRequest\AsyncRequest();

        foreach ($urls as &$url) {
            if (!filter_var($url["url"], FILTER_VALIDATE_URL)) {
                throw new Exception("Not a valid url");
            }
            $request = new AsyncRequest\Request($url["url"]);
            $asyncRequest->enqueue($request, function (AsyncRequest\Response $response) {
                echo $response->getHttpCode();
            });
        }

        $asyncRequest->run();
        return $urls;
    }


    public function getText(object $content):string
    {
        $configuration = new Configuration([
          'NormalizeEntities' => false,
          'SubstituteEntities' => false
      ]);
        try {
            $readability = new Readability($configuration);
            $readability->parse($content->html());
            $text = $readability->getcontent();
            $text =  $this->clean($text);

            return $text;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function removeStopWords(array $tokens, string $language):array
    {
        $stopWords = new StopWords();
        $stopWords = $stopWords->getStopWordsFromLanguage($language);
        $tokens = array_diff($tokens, $stopWords);
        return $tokens;
    }


    public function getTokens(string $text):array
    {
        return tokenize($text);
    }

    public function getNormalizedTokens(array $tokens):array
    {
        return normalize_tokens($tokens);
    }

    public function getFrequencyDistribution(array $tokens):object
    {
        return freq_dist($tokens);
    }

    public function getStemmedTokens(array $tokens):array
    {
        return stem($tokens, \TextAnalysis\Stemmers\SnowballStemmer::class);
    }

    public function getLanguage(string $text):string
    {
        $detector = new LanguageDetector\LanguageDetector();
        $language = $detector->evaluate($text)->getLanguage();
        return $language;
    }


    public function clean(string $text):string
    {
        $text = strip_tags($text);
        // Fix strange chatacters bug
        $text = str_replace("&#xD;", "", $text);
        // Remove line-breaks
        $text = preg_replace("/\r|\n/", "", $text);
        // Remove multiple white spaces
        $text = preg_replace('!\s+!', ' ', $text);
        //Remove accents
        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                      'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                      'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                      'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                      'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
        $text = strtr($text, $unwanted_array);
        // Allow only asscii
        $text = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $text);
        //Remove punctuation
        $text = preg_replace("#[[:punct:]]#", " ", $text);

        return $text;
    }


    public function getHeaders(object $content):array
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($content->html());
        $h1 =   $dom->getElementsByTagName('h1');
        $headers["h1"] = [];
        foreach ($h1 as $node) {
            array_push($headers["h1"], $this->clean($node->textContent));
        }
        $h2 =   $dom->getElementsByTagName('h2');
        $headers["h2"] = [];
        foreach ($h2 as $node) {
            array_push($headers["h2"], $this->clean($node->textContent));
        }
        $h3 =   $dom->getElementsByTagName('h3');
        $headers["h3"] = [];
        foreach ($h3 as $node) {
            array_push($headers["h3"], $this->clean($node->textContent));
        }
        $h4 =   $dom->getElementsByTagName('h4');
        $headers["h4"] = [];
        foreach ($h4 as $node) {
            array_push($headers["h4"], $this->clean($node->textContent));
        }
        $h5 =   $dom->getElementsByTagName('h5');
        $headers["h5"] = [];
        foreach ($h5 as $node) {
            array_push($headers["h5"], $this->clean($node->textContent));
        }
        $h4 =   $dom->getElementsByTagName('h6');
        $headers["h6"] = [];
        foreach ($h4 as $node) {
            array_push($headers["h6"], $this->clean($node->textContent));
        }

        return $headers;
    }
}

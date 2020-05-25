<?php

declare(strict_types=1);

namespace aitor\seobiro;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class Seobiro
{
    public function __construct()
    {
        // constructor body
    }


    public function echoPhrase(string $phrase): string
    {
        return $phrase;
    }


    public function getUrl(string $url):string
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
            return "Not a valid url";
            exit();
        }

        try {
            $crawler = $client->request('GET', $url);
        } catch (Exception $e) {
            return $e->getMessage();
            exit();
        }

        $response = $client->getInternalResponse();

        if ($response->getStatusCode() == 200) {
            return $crawler->html();
        } else {
            return "Failed to open";
        }
    }
}

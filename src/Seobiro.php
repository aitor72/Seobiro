<?php

declare(strict_types=1);

namespace aitor\seobiro;

use Goutte\Client;
use \Exception as Exception;
use Symfony\Component\HttpClient\HttpClient;

class Seobiro
{
    public function __construct()
    {
        // constructor body
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
}

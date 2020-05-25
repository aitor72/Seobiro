<?php

declare(strict_types=1);

namespace aitor\seobiro;

use \Exception as Exception;
use  aitor\seobiro\RestClient;

class Dataforseo
{
    public $api_url = 'https://api.dataforseo.com/';
    public $api_email;
    public $api_key;
    public $client;

    public function __construct($api_email, $api_key)
    {
        $this->api_email = $api_email;
        $this->api_key = $api_key;

        try {
            $client = new RestClient($this->get_api_url(), null, $api_email, $api_key);
            $this->set_client($client);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function set_api_url($api_url)
    {
        $this->api_url = $api_url;
    }
    public function get_api_url()
    {
        return $this->api_url;
    }

    public function set_api_key($api_key)
    {
        $this->api_key = $api_key;
    }
    public function get_api_key()
    {
        return $this->api_key;
    }

    public function set_client($client)
    {
        $this->client = $client;
    }
    public function get_client()
    {
        return $this->client;
    }

    public function set_api_email($api_email)
    {
        $this->api_email = $api_email;
    }
    public function get_api_email()
    {
        return $this->api_email;
    }

    public function get_organic_results($keyword, $language_code = "es", $location_code = "1005424")
    {
        $post_array[] = array(
  "language_code" => $language_code,
  "location_code" => $location_code,
  "keyword" => mb_convert_encoding($keyword, "UTF-8")
);

        try {
            $result =   $this->client->post('/v3/serp/google/organic/live/regular', $post_array);

            return $result["tasks"][0]["result"][0]["items"];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}

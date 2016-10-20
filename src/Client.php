<?php

namespace RecastAI;

/**
 * Class Client
 * @package RecastAI
 */
class Client
{
    const API_ENDPOINT = 'https://api.recast.ai/v2/request';

    /**
     * Client constructor.
     * @param null $token
     * @param null $language
     */
    public function __construct($token = null, $language = null)
    {
        $this->token = $token;
        $this->language = $language;
    }

    /**
     * Sends a text request to Recast and returns the response.
     *
     * @param string $text
     *
     * @return \RecastAI\Response
     *
     * @throws Token is missing
     */
    public function textRequest($text, $options = null)
    {
        if ($options === null) {
            $token = $this->token;
        } else if (array_key_exists('token', $options)) {
            $token = $options['token'];
        }

        if ($this->language) {
            $params = array('text' => $text, 'language' => $this->language);
        } else {
            $params = array('text' => $text);
        }

        if (!$token) {
            return ('Token is missing');
        } else {
            $headers = array('Content-Type' => 'application/json', 'Authorization' => "Token " . $token);

            $res = $this->requestPrivate(self::API_ENDPOINT, $headers, $params);
            return (new Response($res));
        }
    }

    /**
     * Sends a request to Recast and returns the response.
     *
     * @param string $url
     * @param array $headers
     * @param array $params
     *
     * @return Response               $res
     */
    protected function requestPrivate($url, $headers, $params)
    {
        $res = \Requests::post($url, $headers, json_encode($params));

        return ($res);
    }

    /**
     * Sends a request to Recast and returns the response.
     *
     * @param string $url
     * @param array $params
     *
     * @return Response               $res
     */
    protected function requestFilePrivate($url, $params)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', $url, $params);

        return ($res);
    }

    /**
     * Sends a file request to Recast and returns the response.
     *
     * @param string $file
     *
     * @return Response
     *
     * @throws Token is missing
     */
    public function fileRequest($file, $options = null)
    {
        if ($options === null) {
            $token = $this->token;
        } else if (array_key_exists('token', $options)) {
            $token = $options['token'];
        }

        if (!$token) {
            return ('Token is missing');
        } else {
            $url = self::API_ENDPOINT;

            if (!$this->language) {
                $params = [
                    'headers' => [
                        'Authorization' => "Token " . $token
                    ],
                    'multipart' => [
                        [
                            'Content-Type' => 'multipart/form-data',
                            'name' => 'voice',
                            'contents' => fopen($file, 'r')
                        ],
                    ]
                ];
            } else {
                $params = [
                    'headers' => [
                        'Authorization' => "Token " . $token
                    ],
                    'multipart' => [
                        [
                            'Content-Type' => 'multipart/form-data',
                            'name' => 'voice',
                            'contents' => fopen($file, 'r')
                        ],
                        [
                            'name' => 'language',
                            'contents' => $this->language
                        ],
                    ]
                ];
            }
            $res = $this->requestFilePrivate($url, $params);
            return (new Response($res));
        }
    }

    /**
     * @param $text
     * @param null $conversation_token
     * @param null $options
     * @return Conversation|string
     */
    public function textConverse($text, $conversation_token = null, $options = null)
    {
        if ($options === null) {
            $token = $this->token;
        } else if ($options['token']) {
            $token = $options['token'];
        }

        if ($this->language) {
            $params = array('text' => $text, 'language' => $this->language, 'conversation_token' => $conversation_token);
        } else {
            $params = array('text' => $text, 'conversation_token' => $conversation_token);
        }

        if (!$token) {
            return ('Token is missing');
        } else {
            $headers = array('Content-Type' => 'application/json', 'Authorization' => "Token " . $token);
            $res = $this->requestPrivate(Conversation::API_ENDPOINT_CONVERSATION, $headers, $params);

            return (new Conversation(($res)));
        }
    }
}

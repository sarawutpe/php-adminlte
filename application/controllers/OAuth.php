<?php
defined('BASEPATH') or exit('No direct script access allowed');

use GuzzleHttp\Client;

class oauth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->client = new Client();
    }

    public function signin()
    {
        try {
            // $channelId = '2005832808';
            // $callbackUrl = base_url() . 'api/callbackLine';
            // $response = $this->client->get('https://access.line.me/oauth2/v2.1/authorize', [
            //     'query' => [
            //         'response_type' => 'code',
            //         'client_id' => $channelId,
            //         'redirect_uri' => $callbackUrl,
            //         'state' => '1234',
            //         'scope' => 'profile openid',
            //     ],
            //     'allow_redirects' => false
            // ]);
            // if ($response->getStatusCode() == 302 && $response->hasHeader('Location')) {
            //     $authUrl = $response->getHeaderLine('Location');
            // } else {
            //     throw new Exception('Failed to get authorization URL');
            // }

            $channelId = '2005832808';
            $callbackUrl = urlencode(base_url() . 'api/callbackLine');
            $authUrl = 'https://access.line.me/oauth2/v2.1/authorize?' . http_build_query([
                'response_type' => 'code',
                'client_id' => $channelId,
                'redirect_uri' => $callbackUrl,
                'state' => '1234',
                'scope' => 'profile openid',
            ]);

            redirect($authUrl);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function signout()
    {
        $this->session->sess_destroy();
        redirect('home');
    }
}

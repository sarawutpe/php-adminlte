<?php
// defined('BASEPATH') or exit('No direct script access allowed');

use GuzzleHttp\Client;

class API extends CI_Controller
{
    private $client;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->client = new Client();
    }

    public function index()
    {
        // Example endpoint to check if API is running
        $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode(['status' => 'success', 'message' => 'ok']));
    }

    public function callbackLine()
    {
        // Get authorization code from query parameter
        $code = $this->input->get('code');

        // Line Login credentials
        $client_id = '2005832808';
        $client_secret = 'f0cdc9eb9f54f2e4e58054ab7526e397';

        // Redirect URI should match the one registered with Line Login
        $redirect_uri = base_url('api/callbackLine');

        // Make POST request to retrieve access token
        try {
            $response = $this->client->post('https://api.line.me/oauth2/v2.1/token', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => $redirect_uri,
                    'client_id' => $client_id,
                    'client_secret' => $client_secret,
                ]
            ]);
            $body = $response->getBody();
            $data = json_decode($body, true);
            redirect('api/profile?access_token=' . $data['access_token']);
            // access_token
            // token_type
            // refresh_token
            // expires_in
            // scope
            // id_token
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Handle exceptions (e.g., network issues, API errors)
            $error = $e->getMessage();
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode(['error' => $error]));
        }
    }

    public function profile()
    {
        $accessToken = $this->input->get('access_token');
        // $accessToken = 'eyJhbGciOiJIUzI1NiJ9.D8KH3DBxJPrLc224oQmuahPuwnkK4jk3kxXNBbXVZTQDMJmOk2iWxayT9nuxbWd1v_0kBe5f82_CaOfeFoP_KtrdJ-Nn7NYf8OAIzLGPIs4jWakZY3rLoWOboX7YLmlnQrUSM01BMyeXQr65QJYPiM0xtOtDla1ZPvaFBzpCCGI.5A3RLdPu0he27ESZ5KP8gJEHUaON6D4xYOgh-vQ_tCU';
        $response = $this->client->get('https://api.line.me/v2/profile', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ],
            'http_errors' => false,
        ]);

        $body = $response->getBody();

        // userId
        // displayName
        // pictureUrl
        $data = json_decode($body, true);
        $newdata = array(
            'userId'  => $data['userId'],
            'displayName' => $data['displayName'],
            'pictureUrl' => $data['pictureUrl']
        );
        // print_r($newdata);
        $this->session->set_userdata($newdata);
        redirect('home');
    }

    public function lineNotify()
    {
        $clientId = 'zjyiijxNwJ0jiWkwjJWKxo';
        $redirectUri = 'http://localhost:8000/api/callbackLineNotify';
        $authUrl = "https://notify-bot.line.me/oauth/authorize?response_type=code&client_id={$clientId}&redirect_uri={$redirectUri}&scope=notify&state=csrfToken";
        redirect($authUrl);
    }

    public function callbackLineNotify()
    {
        $code = $this->input->get('code');
        $clientId = 'zjyiijxNwJ0jiWkwjJWKxo';
        $clientSecret = 'bL7BPsbTGuGdJYFGTTpEWhM39AMWsk5JhhWLBNqRl3k';
        $redirectUri = base_url('api/callbackLineNotify');

        // Exchange the code for an access token
        $response = $this->client->post('https://notify-bot.line.me/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $redirectUri,
                'client_id' => $clientId,
                'client_secret' => $clientSecret
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        $this->session->set_userdata('line_notify_access_token', $data['access_token']);
        redirect('home');
    }

    public function notify()
    {
        try {
            $access_token =  $this->session->userdata('line_notify_access_token');
            $response = $this->client->post('https://notify-api.line.me/api/notify', [
                'headers' => [
                    'Authorization' => "Bearer {$access_token}"
                ],
                'form_params' => [
                    'message' => 'hello'
                ]
            ]);
            $statusCode = $response->getStatusCode();
            if ($statusCode == 200) {
                $this->session->set_flashdata('message', (string) $response->getBody());
                redirect('home');
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function revoke()
    {
        try {
            $access_token =  $this->session->userdata('line_notify_access_token');
            $response = $this->client->post('https://notify-api.line.me/api/revoke', [
                'headers' => [
                    'Authorization' => "Bearer {$access_token}"
                ]
            ]);
            $statusCode = $response->getStatusCode();
            if ($statusCode == 200) {
                $this->session->set_flashdata('message', (string) $response->getBody());
                redirect('home');
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function status()
    {
        try {
            $access_token =  $this->session->userdata('line_notify_access_token');
            $response = $this->client->get('https://notify-api.line.me/api/status', [
                'headers' => [
                    'Authorization' => "Bearer {$access_token}"
                ]
            ]);
            $statusCode = $response->getStatusCode();
            if ($statusCode == 200) {
                $this->session->set_flashdata('message', (string) $response->getBody());
                redirect('home');
            }
            // {
            //     "status": 200,
            //     "message": "ok",
            //     "targetType": "USER",
            //     "target": "เป้"
            // }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

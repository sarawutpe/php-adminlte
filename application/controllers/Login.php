<?php
defined('BASEPATH') or exit('No direct script access allowed');

use GuzzleHttp\Client;

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		try {
			$channelId = '2005832808';
			$channelSecret = 'f0cdc9eb9f54f2e4e58054ab7526e397';
			$callbackUrl = base_url() . 'api/callbackLine';

			$client = new Client();
			$response = $client->get('https://access.line.me/oauth2/v2.1/authorize', [
				'query' => [
					'response_type' => 'code',
					'client_id' => $channelId,
					'redirect_uri' => $callbackUrl,
					'state' => '1234',
					'scope' => 'profile openid',
				],
				'allow_redirects' => false
			]);

			if ($response->getStatusCode() == 302 && $response->hasHeader('Location')) {
				$authUrl = $response->getHeaderLine('Location');
			} else {
				throw new Exception('Failed to get authorization URL');
			}

			header('Location: ' . $authUrl);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}

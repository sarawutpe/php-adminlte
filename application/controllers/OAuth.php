<?php
defined('BASEPATH') or exit('No direct script access allowed');

use GuzzleHttp\Client;

class OAuth extends CI_Controller
{
    private $client;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->client = new Client();
    }

    public function signout()
    {
        $this->session->sess_destroy();
        redirect('home');
    }
}

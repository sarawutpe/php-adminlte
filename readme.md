$php -S localhost:8000

  public function getTodos()
    {
        $url = 'https://jsonplaceholder.typicode.com/todos';

        try {
            $response = $this->client->request('GET', $url);
            $body = $response->getBody();
            $data = json_decode($body, true);

            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($data));
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $error = $e->getMessage();
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode(['error' => $error]));
        }
    }"# php-adminlte" 

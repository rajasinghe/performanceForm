<?php


class Request
{

    private $requestBody;
    private $requestParams;
    public $contentType;
    public $headers;
    public $arguments;

    public function __construct()
    {
        $headers = getallheaders();
        if (Router::$requestMethod == 'POST') {

            if (isset($headers['Content-Type'])) {
                if ($headers['Content-Type'] == 'application/json' || 'json') {
                    $this->handleJsonData();
                } else if ($headers['Content-Type'] == 'application/x-www-form-urlencoded') {
                    $this->requestBody = $_POST;
                }
            }
        } else if (Router::$requestMethod == 'GET') {
            $this->requestParams = $_GET;
        }
    }

    function handleJsonData()
    {
        $json = file_get_contents('php://input');
        if ($json) {
            $requestBody = json_decode($json, true);
            $this->requestBody = $requestBody;
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Send error response if JSON is invalid
                http_response_code(400); // Bad Request
                echo json_encode(["error" => "Invalid JSON"]);
            }
        }
    }

    function storeParametrizedArguments($arguments)
    {
        $this->arguments = $arguments;
    }

    public function getRequestBody()
    {
        return $this->requestBody;
    }

    public function getRequestParams()
    {
        return $this->requestParams;
    }
}

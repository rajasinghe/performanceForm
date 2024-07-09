<?php


class Controller
{

    public function __construct()
    {
        try {
            new DB();
        } catch (Exception $e) {
            print_r($e);
        }
    }

    /**
     *send the response to the client 
     *@param mixed $response 
     *@param int $status Defaults to null
     *@return void
     */
    public function sendResponse($response, $status = null)
    {
        header('Content-Type: application/json');
        if ($status != null && $status) {
            http_response_code($status);
        }
        echo json_encode($response);
        exit();
    }
    public function view($path, $data = [])
    {

        require "./views/" . $path;
    }
}

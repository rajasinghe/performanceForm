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

    public function sendResponse($response)
    {
        echo json_encode($response);
        exit();
    }
    public function view($path, $data = [])
    {
        extract($data);
        include "./views/" . $path;
    }
}

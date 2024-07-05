<?php


class Route
{


    public $route;

    public $callback;


    public function __construct($route, $callback)
    {
        $this->route = $route;
        $this->callback = $callback;
    }
}

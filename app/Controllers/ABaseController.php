<?php


abstract class ABaseController {
    protected $data = array();
    protected $view = "";
    protected $head = array("title" => "", "description" => "");

    abstract function show();
}
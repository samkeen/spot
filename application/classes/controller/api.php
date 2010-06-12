<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api extends Controller {

    public function  __construct($request) {
        $this->json_callback = Arr::get($_GET, 'callback');
        return parent::__construct($request);
    }
    public function json_response($data) {
        $json_data = !is_resource($data)?json_encode($data):null;
        $json_data = $this->json_callback!==null
                ? "{$this->json_callback}({$json_data})"
                : $json_data;
        $this->request->response = $json_data;
    }
}
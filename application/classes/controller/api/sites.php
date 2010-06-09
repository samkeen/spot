<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Sites extends Controller {

    public function action_index($id=null) {
        $this->request->response = json_encode($this->orm_as_array('site',$id));
    }
  
}
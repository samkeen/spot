<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Spaces extends Controller {

    public function action_index($id=null) {
        $this->request->response = json_encode(
           ORM::factory('space')->find_all()
//           $this->orm_as_array('space',$id)
        );
    }

    public function action_with($marker_identifier=null) {
        $this->request->response = json_encode($this->orm_as_array('space',$marker_identifier));
    }

    

}
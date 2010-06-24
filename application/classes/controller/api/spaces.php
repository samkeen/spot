<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Spaces extends Controller_Api {

    public function before() {
        $this->add_allowed_action(array('with'=>array('get')));
        return parent::before();
    }
    /**
     * rest method, recieves GET requests
     * @param string $id
     */
    public function action_index($id=null) {
        $this->request->response = json_encode(
            $this->orm_as_array('space', $id)
        );
    }
    /**
     * restful method, recieves PUT requests
     * 
     * 
     */
    public function action_update() {
        $data = $this->payload;
        var_dump($data);
    }
    public function action_with($marker_identifier=null) {
        
        return $this->json_response(
             ORM::factory('marker', array('email' => $marker_identifier))
                ->get_space_by_email()
        );

    }
}
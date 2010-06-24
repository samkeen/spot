<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Markers extends Controller_Api {

    public function action_index($id=null) {
        $this->request->response = json_encode($this->orm_as_array('marker', $id));
    }

    /**
     * restful method, recieves PUT requests
     *
     *
     */
    public function action_update() {
        // get the data sent in the PUT request
        $data = $this->payload;
        $marker = ORM::factory('marker', Arr::get($data, 'id'));
        if ($marker) {
            $marker->email = Arr::get($_POST, 'email');
            $marker->spaces->x = Arr::get($data, 'x');
            $marker->y = Arr::get($data, 'y');
            if (Arr::get($data, 'space_id')) {
                $marker->site->id = Arr::get($data, 'space_id');
            }
            if ($marker->validate()) {
                $marker->save();
                echo 'yeah';
            } else {
                echo 'boo';
            }
        }
    }

}
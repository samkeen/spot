<?php defined('SYSPATH') or die('No direct script access.');

class Model_Marker extends ORM {

    protected $_belongs_to = array(
        'space' => array(
            'model'=>'space'
        )
    );
    protected $_filters = array(
        TRUE => array('trim' => array()),
        'x' => array('numeric' => array()),
        'y'    => array('numeric' => array()),
    );

    protected $_rules = array(
        'email' => array('not_empty' => array()),
    );

//
//    public function save(array $marker=array(), $marker_id = null) {
//        $result = array(
//                'success'=>false,
//                'error' => ''
//        );
//
//        $valid = true;
//        $marker = $this->get_trimmed_allowed(
//                $marker,
//                array('space_id','email','x','y','active')
//        );
//        if(isset($marker['space_id']) && !valid::digit($marker['space_id'])) {
//            $valid = false;
//        }
//        if(isset($marker['email']) && !valid::email($marker['email'])) {
//            $valid = false;
//        }
//        if(isset($marker['x']) && !valid::numeric($marker['x'])) {
//            $valid = false;
//        }
//        if(isset($marker['y']) && !valid::numeric($marker['y'])) {
//            $valid = false;
//        }
//        if(isset($marker['active']) && !valid::digit($marker['active'])) {
//            $valid = false;
//        }
//        if($valid) {
//            if($marker_id) {//UPDATE
//                $this->db
//                        ->from('markers')
//                        ->set($marker)
//                        ->where(array('id' => (int)$marker_id)
//                        )->update();
//                $result['success']=true;
//
//            } else { // INSERT
//                $new_marker = $this->db
//                        ->from('markers')
//                        ->set($marker)
//                        ->insert();
//                $result['success']=true;
//                $marker_id = $new_marker->insert_id();
//            }
//            $marker = $this->db->select('markers.*')
//                    ->from('markers')
//                    ->where(array('id' => $marker_id))
//                    ->get();
//            $marker = $this->result_as_array($marker);
//            $result['marker']=$marker;
//        } else {
//            $result['error']="The supplied data was invalid";
//        }
//
//
//        return $result;
//
//    }
//    public function remove($marker_id) {
//        $result = array(
//                'success'=>false,
//                'error' => ''
//        );
//        $this->db
//                ->from('markers')
//                ->where(
//                array(
//                'id' => $marker_id
//                )
//                )
//                ->delete();
//        $result['success']=true;
//        return $result;
//    }


}
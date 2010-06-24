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
    /**
     * For a the given unique identifier for a marker (email),
     * Find all the spaces where that marker has presence.
     * For each of those spaces include all the other markers in that
     * space.
     * This is the core heavy lifter method that populates the floor plans.
     * 
     * @return array
     * ex
     * [0] => Array (
        [site] => Array(
                [id] => 1
                [name] => Mountain View
                [lat] => 37.389280000000
                [long] => -122.083114000000
                [active] => 1)
        [building] => Array(
                [id] => 1
                [site_id] => 1
                [name] => Main Office
                [lat] => 37.3893
                [long] => -122.083
                [active] => 1)
        [space] => Array(
                [id] => 1
                [image_uri] => mtview0_3.gif
                [index] => 3
                [name] => 3rd floor)
     *  [placements] => array(
     *      [0] => array (
     *          id      => 1,
     *          x       => 581,
     *          y       => 112,
     *          focus   => true,
     *          marker  => array(
     *              id => 1,
     *              email => joe@somewhere.com
     *          )
     *      ),
     *      [1] => array (
     *          id      => 2,
     *          x       => 555,
     *          y       => 152,
     *          focus   => false,
     *          marker  => array(
     *              id => 1,
     *              email => joe@somewhere.com
     *          )
     *      )     *
     *  )
        [markers] => Array(
                [0] => Array(
                        [id] => 1
                        [email] => sam@somewhere.com
                        [active] => 1
                        [marker_id] => 1
                        [space_id] => 1
                        [x] => 581
                        [y] => 112
                        [focus] => true)
                [1] => Array(
                        [id] => 2
                        [email] => joe@somewhere.com
                        [active] => 1
                        [marker_id] => 2
                        [space_id] => 1
                        [x] => 710
                        [y] => 132
                        [focus] => false)
                ... more markers ...
            )
       )
       [1] => Array  (... next space this marker resides in ....)
     */
    public function get_space_by_email() {
        $out = array();
        if($this->email) {
            // get all the spaces this marker is in
            $spaces = $this->spaces->find_all();
                // for each space, get all its info
                foreach ($spaces as $space) {
                    // fully populate the object (lazy loading)
                    $space->building->site;
                    $markers = array();
                    foreach ($space->markers->find_all()->as_array() as $marker) {
                        $marker = $marker->as_array();
                        $marker['focus'] = $this->email == $marker['email'];
                        $markers[]=$marker;
                    }
//                    die;
                    
                    $space = $space->as_array();
                    var_dump($space);
                    $reorg['site'] = $space['building']['site'];
                    unset ($space['building']['site']);
                    $reorg['building'] = $space['building'];
                    $reorg['space'] = array(
                        'id' => $space['space_id'],
                        'image_uri' =>
                            Kohana::config('core.paths.space_images_folder')
                            ."/{$space['img_filename']}",
                        'index' => $space['index'],
                        'name' => $space['name'],
                    );
                    $reorg['markers'] = $markers;
                    $out[] = $reorg;
                }
        }
        return $out;
    }
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
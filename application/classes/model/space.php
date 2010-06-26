<?php defined('SYSPATH') or die('No direct script access.');

class Model_Space extends ORM {

    protected $_belongs_to = array('building' => array());
    protected $_has_many = array(
        'markers' => array(
            'model' => 'marker'
        )
    );
    
    protected $_filters = array(
        true => array('trim' => array()),
    );

    protected $_rules = array(
        'name' => array('not_empty' => array()),
        'index' => array('numeric' => array()),
    );

    /**
     * For a the given unique identifier for a marker (email),
     * Find all the spaces where that marker has presence.
     * For each of those spaces include all the other markers in that
     * space.
     * This is the core heavy lifter method that populates the floor plans.
     * 
     * @param string $email
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
        [markers] => Array(
                [0] => Array(
                        [id] => 1
                        [email] => sam@somewhere.com
                        [active] => 1
                        [x] => 581
                        [y] => 112
                        [focus] => true)
                [1] => Array(
                        [id] => 2
                        [email] => joe@somewhere.com
                        [active] => 1
                        [x] => 710
                        [y] => 132
                        [focus] => false)
                ... more markers ...
     */
    public static function with_marker($email) {

        $payload = array();
        // get the marker for this email
        $focus_marker = Orm::factory('marker',array('email'=>$email));

        if($focus_marker->space->building->site->loaded()) {
            // unwind and flatten the data hierarchy
            $array_data = $focus_marker->space->as_array();
            $payload['site']=$array_data['building']['site'];
            unset ($array_data['building']['site']);
            $payload['building']=$array_data['building'];
            unset ($array_data['building']);
            $payload['space']=$array_data;
            $payload['space']['image_uri'] =
                Kohana::config('core.paths.space_images_folder')
                ."/{$payload['space']['img_filename']}";
            foreach ($focus_marker->space->markers->find_all() as $marker) {
                $marker = $marker->as_array();
                $marker['focus'] = $marker['id'] == $focus_marker->pk();
                $payload['markers'][] = $marker;
            }
        } else { // marker was not found
            // @todo return error
        }
        return $payload;
    }

    

}
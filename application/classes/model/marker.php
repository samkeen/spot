<?php defined('SYSPATH') or die('No direct script access.');

class Model_Marker extends ORM {

    protected $_has_many = array('spaces' => array('through' => 'placements'));

    protected $_filters = array(
        TRUE => array('trim' => array()),
    );

    protected $_rules = array(
        'email' => array('not_empty' => array()),
    );

    public function get_space_by_email() {
        $out = array();
        if($this->email) {
            // get all the spaces this marker is in
            $spaces = $this->spaces->find_all();
                // for each space, get all its info
                foreach ($spaces as $space) {
                    // fully populate the object (lazy loading)
                    $space->building->site;
                    $space = $space->as_array();
//                    print_r($space);
                    $reorg['site'] = $space['building']['site'];
                    unset ($space['building']['site']);
                    $reorg['building'] = $space['building'];
                    $reorg['space'] = array(
                        'id' => $space['space_id'],
                        'image_uri' => $space['img_uri'],
                        'index' => $space['index'],
                        'name' => $space['name']
                    );
                    $reorg['marker'] = array(
                        'id' => $space['id'],
                        'email' => $this->email,
                        'x' => $space['x'],
                        'y' => $space['y'],
                    );
                    $out[] = $reorg;
                }
        }
        return $out;
      
        
//        $markers = $this->result_as_array($markers);
        foreach ($markers as $marker) {
            if($marker['email']==$email) {
                $focus_marker=$marker;
                break;
            }
        }
        $location_info =
                DB::select(
                'spaces.name AS space_name, spaces.index AS space_index,
       spaces.img_uri AS space_img_uri, spaces.active AS space_active,
       buildings.name AS building_name, buildings.lat AS building_lat,
       buildings.long AS building_long, buildings.active AS building_active,
       sites.name AS site_name, sites.lat AS site_lat,
       sites.long AS site_long, sites.active AS site_active'
                )
                ->from('spaces')
                ->join('placements','space.id', 'placements.space_id')
                ->join('buildings','spaces.building_id', 'buildings.id')
                ->join('sites','buildings.site_id', 'sites.id')
                
                ->where('spaces.id','=', $marker['space_id'])->execute()->as_array();

//        $location_info = $this->result_as_array($location_info);
        $location_info = $this->split_out_array_result(array('space','building','site'), $location_info);
        return array(
                'markers'=>$markers,'space'=>$location_info['space'],
                'building'=>$location_info['building'], 'site'=>$location_info['site'],
                'focus'=>$focus_marker
        );
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
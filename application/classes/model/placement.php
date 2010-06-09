<?php defined('SYSPATH') or die('No direct script access.');

class Model_Placement extends ORM {

    protected $_belongs_to = array('space' => array(), 'marker' => array());

    protected $_filters = array(
        TRUE => array('trim' => array()),
    );
    protected $_rules = array(
        'x' => array('numeric' => array()),
        'y'    => array('numeric' => array()),
    );

    /**
     * Find all the spacial info for this placement with the given email id.
     * Also return all the accompanying placements in the same space.
     *
     * @param string $email
     * @return array
     * @TODO Only supporting single space right now
     */
    public function get_by_email($email) {
        $placements_for_space = array();
        // get the placement and all spacial info for this email
        $focus_placement = null;
        $focus_placement_info =
                $this->db->select(
                'markers.id AS placement_id, markers.email AS placement_email,
           placements.x AS placement_x, placements.y AS placement_y,
           spaces.id AS space_id, spaces.name AS space_name,
           spaces.img_uri AS space_img_uri, spaces.index AS space_index,
           buildings.name AS building_name, buildings.lat AS building_lat,
           buildings.long AS building_long, buildings.active AS building_active,
           sites.name AS site_name, sites.lat AS site_lat,
           sites.long AS site_long, sites.active AS site_active'
                )
                ->from('placements')
                ->join('markers','placements.marker_id','markers.id')
                ->join('spaces','placements.space_id', 'spaces.id')
                ->join('buildings','spaces.building_id', 'buildings.id')
                ->join('sites','buildings.site_id', 'sites.id')
                ->where(array('markers.email'=>$email, 'markers.active' => 1))
                ->get();
        $focus_placement_info = $this->result_as_array($focus_placement_info);
        /**
         * Now, get the rest of the placements that share this space
         */
        if($focus_placement_info) {
            $focus_placement_info = $this->split_out_array_result(array('placement', 'space','building','site'), $focus_placement_info);
            $focus_placement_info['placement']['focus'] = true;

            $additional_placements =
                    $this->db->select(
                    "markers.id, markers.email,
           placements.x , placements.y"
                    )
                    ->from('placements')
                    ->join('markers','placements.marker_id','markers.id')
                    ->where(array(
                    'placements.space_id' => $focus_placement_info['space']['id'],
                    'markers.active' => 1,
                    'markers.id !=' => $focus_placement_info['placement']['id']
                    ))
                    ->get();

            $additional_placements = $this->result_as_array($additional_placements);

            foreach ($additional_placements as &$placements) {
                $placements['focus']=false;
            }
            array_push($additional_placements, $focus_placement_info['placement']);
            $placements_for_space = array(
                    'placements'=> $additional_placements,
                    'space'=>$focus_placement_info['space'],
                    'building'=>$focus_placement_info['building'],
                    'site'=>$focus_placement_info['site']
            );
        }

        return $placements_for_space;
    }

}
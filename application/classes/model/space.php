<?php defined('SYSPATH') or die('No direct script access.');

class Model_Space extends ORM {

    protected $_belongs_to = array('building' => array());
    protected $_has_many = array('markers' => array('through' => 'placements'));

    protected $_filters = array(
        true => array('trim' => array()),
    );

    protected $_rules = array(
        'name' => array('not_empty' => array()),
        'index' => array('numeric' => array()),
    );

    public function get_markers($space_id) {
        // get the info for this floor
        $space = $this->db->select('spaces.*')
                ->from('spaces')
                ->where(
                array(
                'spaces.id' => $space_id,
                'spaces.active' => '1'
                )
                )
                ->get();
        $space = $this->result_as_array($space);
        // add all the markers
        $markers =
                $this->db->select('markers.*')
                ->from('markers')
                ->where(
                array(
                'space_id' => $space['id'],
                'markers.active' => '1'
                )
                )
                ->get();
        $space['markers'] = $this->result_as_array($markers);
        return $space;
    }

}
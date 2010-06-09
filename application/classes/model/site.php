<?php defined('SYSPATH') or die('No direct script access.');

class Model_Site extends ORM {

    protected $_has_many = array('buildings'=>array());

    protected $_filters = array(
        true => array('trim' => array()),
    );

    protected $_rules = array(
        'name' => array('not_empty' => array()),
        'lat' => array('numeric' => array()),
        'long' => array('numeric' => array()),
    );

    protected $_callbacks = array(
        'lat' => array('validate_latlong_required_as_pair'),
        'long' => array('validate_latlong_required_as_pair'),
    );

    public function validate_latlong_required_as_pair(Validate $validate, $field) {
        // if we are already invalid, just return
        if (array_key_exists($field, $validate->errors())) {
            return;
        }
        $other_field = $field=='lat'?'long':'lat';
        if( ! empty($validate[$field]) && empty($validate[$other_field])) {
            $validate->error($other_field, 'required_if_other_given', array($field));
        }
    }

}
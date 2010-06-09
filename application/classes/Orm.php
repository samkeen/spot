<?php defined('SYSPATH') or die('No direct script access.');

class ORM extends Kohana_ORM {

    /**
     * Add convienience call to $this->_validate->errors
     *
     * @param string  file to load error messages from
     * @param mixed   translate the message
     * @return array
     */
    public function errors($file = null, $translate = true) {
        $file = $file!==null ? $file : strtolower(str_replace('Model_', '',get_class($this)));
        return $this->_validate->errors( $file, $translate );
    }
    /**
     * @TODO create a add_complete
     * First delete all relations then add all with one query
     */
    public function add_complete($alias, ORM $model, $data = NULL) {
        return new Exception('Need to Implement'.__METHOD__);
    }
    /**
     * Removes all relationships between this model and another.
     *
     * @param   string   alias of the has_many "through" relationship
     * @return  ORM
     */
    public function remove_all($alias) {
        DB::delete($this->_has_many[$alias]['through'])
                ->where($this->_has_many[$alias]['foreign_key'], '=', $this->pk())
                ->execute($this->_db);
        return $this;
    }

}
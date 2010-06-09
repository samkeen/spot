<?php defined('SYSPATH') or die('No direct script access.');

class Controller extends Kohana_Controller {
    //                                    label     path
    protected $static_crumb_base = array('home' => '/admin');

    /**
     * works well for structured portions of the site (like admin interfaces)
     * 
     * @return array
     */
    protected function auto_crumb() {

        $crumbs[] = $this->static_crumb_base;
        /*
         * build | base / controller / action
         */
        $crumb_base_path = current($this->static_crumb_base);
        $crumb_base_path == '/'?'':$crumb_base_path;
        if(!empty($this->request->controller)) {
            $controller_path = "{$crumb_base_path}/{$this->request->controller}";
            array_push($crumbs, array($this->request->controller => $controller_path));
        }
        if(!empty($this->request->action) && strtolower($this->request->action) !='index' ) {
            $action_path = "{$controller_path}/{$this->request->action}";
            array_push($crumbs, array($this->request->action => $action_path));
        }
        // de-link the tail
        array_push($crumbs,array(key(array_pop($crumbs))));
        return $crumbs;
    }

    /**
     * @TODO get this hacked into Orm
     * ORM::factory($model_name,$id)->as_array();  // works
     * ORM::factory($model_name)->find_all()->as_array(); // no work, returns an
     *    array of objects
     * 
     * @param string $model_name
     * @param sting $id The pk of the model if we are looking for one
     * @return array An array of row arrays
     */
    protected function orm_as_array($model_name, $id=null) {
        $array_results = array();
        $orm_results = array();
        if($id===null) {
            $orm_results = ORM::factory($model_name)->find_all();
            foreach ($orm_results as $site) {
                $array_results[] = $site->as_array();
            }
        } else {
            $array_results[] = ORM::factory($model_name,$id)->as_array();
        }
        return $array_results;
    }
}
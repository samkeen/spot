<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Home extends Controller_Template {

    public $template = 'admin/template';

    /**
     * @todo right now jsut using sites_index,  eventually build into
     * a 'dashboard thing
     */
    public function action_index() {
        $this->template->title = 'Placements::Admin::Home';
        $this->template->breadcrumbs = array(array('home'));
        $this->template->content = View::factory('admin/pages/home');
    }

}
<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Buildings extends Controller_Template {

    public $template = 'admin/template';

    public function before() {
        parent::before();
        $this->template->breadcrumbs = $this->auto_crumb();
    }

    public function action_index($id=null) {
        $this->template->title = 'Placements::Admin::Buildings';
        $this->template->content = View::factory('admin/pages/buildings_index');
        $this->template->content->buildings = ORM::factory('building')->find_all();
    }
  
    public function action_add() {
        $this->template->title = 'Buildings :: Add';
        $this->template->content = new View('admin/pages/buildings_add');
        $building = ORM::factory('building');
        if ($_POST) {
            $building->values($_POST);
            if ($building->check()) {
                $building->save();
                client::messageSend("The Building '{$building->name}' Was Saved", E_USER_NOTICE);
                $this->request->redirect('admin/buildings');
            } else {
                client::validation_results($building->errors());
                client::messageSend("There were errors in some fields", E_USER_WARNING);
            }
        }
        $this->template->content->building = $building;
    }
    public function action_edit($edit_id=null) {
        if( ! $edit_id) {
            client::messageSend("Invalid Request", E_USER_WARNING);
            $this->request->redirect('buildings');
        }
        $this->template->title = 'Buildings :: Edit';
        $this->template->content = new View('admin/pages/buildings_edit');
        $this->template->content->sites_list = ORM::factory('site')->find_all()->as_array('id','name');
        $building = ORM::factory('building')->find($edit_id);
        if ($_POST) {
            $building->site_id = Arr::get($_POST, 'site_id');
            $building->name = Arr::get($_POST, 'name');
            $building->lat = Arr::get($_POST, 'lat');
            $building->long = Arr::get($_POST, 'long');
            if ($building->validate()) {
              $building->save();
              client::messageSend("The Building '{$building->name}' Was Saved", E_USER_NOTICE);
              $this->request->redirect('admin/buildings');
            } else {
              client::validation_results($building->errors());
              client::messageSend("There were errors in some fields", E_USER_WARNING);
            }
        }
        $this->template->content->building = $building;
    }
  
    public function action_delete($delete_id) {
        if( ! $delete_id) {
            client::messageSend("Invalid Request", E_USER_WARNING);
            $this->request->redirect('buildings');
        }
        $building = ORM::factory('building')->find($delete_id);
        if($building->id) {
            $building->delete($delete_id);
            client::messageSend('The Building "'.HTML::chars($building->name).'" was removed', E_USER_NOTICE);
        } else {
            client::messageSend("Building not found", E_USER_WARNING);
        }
        $this->request->redirect('admin/buildings');
  }

}
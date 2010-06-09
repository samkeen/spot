<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Spaces extends Controller_Template {

    public $template = 'admin/template';

    public function before() {
        parent::before();
        $this->template->breadcrumbs = $this->auto_crumb();
    }

    public function action_index($id=null) {
        $this->template->title = 'Placements::Admin::Spaces';
        $this->template->content = View::factory('admin/pages/spaces_index');
        $this->template->content->spaces = ORM::factory('space')->find_all();
    }
  
    public function action_add() {
        $this->template->title = 'Spaces :: Add';
        $this->template->content = new View('admin/pages/spaces_add');
        $space = ORM::factory('space');
        if ($_POST) {
            $space->values($_POST);
            if ($space->check()) {
                $space->save();
                client::messageSend("The Space '{$space->name}' Was Saved", E_USER_NOTICE);
                $this->request->redirect('admin/spaces');
            } else {
                client::validation_results($space->errors());
                client::messageSend("There were errors in some fields", E_USER_WARNING);
            }
        }
        $this->template->content->space = $space;
    }
    public function action_edit($edit_id=null) {
        if( ! $edit_id) {
            client::messageSend("Invalid Request", E_USER_WARNING);
            $this->request->redirect('spaces');
        }
        $this->template->title = 'Spaces :: Edit';
        $this->template->content = new View('admin/pages/spaces_edit');
        $this->template->content->buildings_list = ORM::factory('building')->find_all()->as_array('id','name');
        $space = ORM::factory('space')->find($edit_id);
        if ($_POST) {
            $space->name = Arr::get($_POST, 'name');
            $space->index = Arr::get($_POST, 'index');
            $space->img_url = Arr::get($_POST, 'img_url');
            if ($space->validate()) {
              $space->save();
              client::messageSend("The Space '{$space->name}' Was Saved", E_USER_NOTICE);
              $this->request->redirect('admin/spaces');
            } else {
              client::validation_results($space->errors());
              client::messageSend("There were errors in some fields", E_USER_WARNING);
            }
        }
        $this->template->content->space = $space;
    }
  
    public function action_delete($delete_id) {
        if( ! $delete_id) {
            client::messageSend("Invalid Request", E_USER_WARNING);
            $this->request->redirect('spaces');
        }
        $space = ORM::factory('space')->find($delete_id);
        if($space->id) {
            $space->delete($delete_id);
            client::messageSend('The Space "'.HTML::chars($space->name).'" was removed', E_USER_NOTICE);
        } else {
            client::messageSend("Space not found", E_USER_WARNING);
        }
        $this->request->redirect('admin/spaces');
  }

}
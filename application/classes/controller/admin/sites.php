<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Sites extends Controller_Template {

    public $template = 'admin/template';

    public function before() {
        parent::before();
        $this->template->breadcrumbs = $this->auto_crumb();
    }

    public function action_index($id=null) {
        $this->template->title = 'Placements::Admin::Home';
        $this->template->content = View::factory('admin/pages/sites_index');
        $this->template->content->sites = ORM::factory('site')->find_all();
    }
  
    public function action_add() {
        $this->template->title = 'Sites :: Add';
        $this->template->content = new View('admin/pages/sites_add');
        $site = ORM::factory('site');
        if ($_POST) {
            $site->values($_POST);
            if ($site->check()) {
                $site->save();
                client::messageSend("The Site '{$site->name}' Was Saved", E_USER_NOTICE);
                $this->request->redirect('admin/sites');
            } else {
                client::validation_results($site->errors());
                client::messageSend("There were errors in some fields", E_USER_WARNING);
            }
        }
        $this->template->content->site = $site;
    }
    public function action_edit($edit_id=null) {
        if( ! $edit_id) {
            client::messageSend("Invalid Request", E_USER_WARNING);
            $this->request->redirect('sites');
        }
        $this->template->title = 'Sites :: Edit';
        $this->template->content = new View('admin/pages/sites_edit');
        
        $site = ORM::factory('site')->find($edit_id);
        if ($_POST) {
            $site->name = Arr::get($_POST, 'name');
            $site->lat = Arr::get($_POST, 'lat');
            $site->long = Arr::get($_POST, 'long');
            if ($site->validate()) {
              $site->save();
              client::messageSend("The Site '{$site->name}' Was Saved", E_USER_NOTICE);
              $this->request->redirect('admin/sites');
            } else {
              client::validation_results($site->errors());
              client::messageSend("There were errors in some fields", E_USER_WARNING);
            }
        }
        $this->template->content->site = $site;
    }
  
    public function action_delete($delete_id) {
        if( ! $delete_id) {
            client::messageSend("Invalid Request", E_USER_WARNING);
            $this->request->redirect('sites');
        }
        $site = ORM::factory('site')->find($delete_id);
        if($site->id) {
            $site->delete($delete_id);
            client::messageSend('The Site "'.HTML::chars($site->name).'" was removed', E_USER_NOTICE);
        } else {
            client::messageSend("Site not found", E_USER_WARNING);
        }
        $this->request->redirect('admin/sites');
  }

}
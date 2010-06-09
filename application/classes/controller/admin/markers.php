<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Markers extends Controller_Template {

    public $template = 'admin/template';

    public function before() {

        parent::before();
        $this->template->breadcrumbs = $this->auto_crumb();
    }

    public function action_index($id=null) {
        $this->template->title = 'Placements::Admin::Markers';
        $this->template->content = View::factory('admin/pages/markers_index');
        $this->template->content->markers = ORM::factory('marker')->find_all();
    }
  
    public function action_add() {
        $this->template->title = 'Markers :: Add';
        $this->template->content = new View('admin/pages/markers_add');
        $marker = ORM::factory('marker');
        if ($_POST) {
            $marker->values($_POST);
            if ($marker->check()) {
                $marker->save();
                client::messageSend("The Marker '{$marker->email}' Was Saved", E_USER_NOTICE);
                $this->request->redirect('admin/markers');
            } else {
                client::validation_results($marker->errors());
                client::messageSend("There were errors in some fields", E_USER_WARNING);
            }
        }
        $this->template->content->marker = $marker;
    }
    public function action_edit($edit_id=null) {
        if( ! $edit_id) {
            client::messageSend("Invalid Request", E_USER_WARNING);
            $this->request->redirect('markers');
        }
        $this->template->title = 'Markers :: Edit';
        $this->template->content = new View('admin/pages/markers_edit');
        $marker = ORM::factory('marker',$edit_id);
//        echo Kohana::debug($marker->has('spaces',orm::factory('space',1)));die;
        $this->template->content->spaces_list = ORM::factory('space')->find_all()->as_array('id','name');
        if ($_POST) {
//            var_dump($_POST);die;
            $marker->email = Arr::get($_POST, 'email');
            if(Arr::get($_POST, 'space')) {
                $marker->remove_all('spaces');
                foreach (Arr::get($_POST, 'space', array()) as $space_id) {
                    $space = ORM::factory('space', $space_id);
                    $marker->add('spaces', $space);
                }
            }
            if ($marker->validate()) {
              $marker->save();
              client::messageSend("The Marker '{$marker->email}' Was Saved", E_USER_NOTICE);
              $this->request->redirect('admin/markers');
            } else {
              client::validation_results($marker->errors());
              client::messageSend("There were errors in some fields", E_USER_WARNING);
            }
        }
        $this->template->content->marker = $marker;
    }
  
    public function action_delete($delete_id) {
        if( ! $delete_id) {
            client::messageSend("Invalid Request", E_USER_WARNING);
            $this->request->redirect('markers');
        }
        $marker = ORM::factory('marker')->find($delete_id);
        if($marker->id) {
            $marker->delete($delete_id);
            client::messageSend('The Marker "'.HTML::chars($marker->email).'" was removed', E_USER_NOTICE);
        } else {
            client::messageSend("Marker not found", E_USER_WARNING);
        }
        $this->request->redirect('admin/markers');
  }

}
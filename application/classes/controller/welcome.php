<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {

	public function action_index() {
        $resp = '<div id="kohana-profiler">'.View::factory('profiler/stats').'</div>';

		$this->request->response = $resp;
	}

} // End Welcome

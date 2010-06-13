<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Hybrid rest controller
 * By default request methods map thusly
 * 		'GET'    => 'index',
 * 		'PUT'    => 'update',
 * 		'POST'   => 'create',
 * 		'DELETE' => 'delete',
 *
 * $this->add_allowed_action allows an action outside of the 4 above to be
 * requested.
 *
 */
class Controller_Api extends Controller {

    protected $jsonp_callback = null;
    protected $request_method = null;
    protected $original_action = '';

    protected $action_map = array (
		'GET'    => 'index',
		'PUT'    => 'update',
		'POST'   => 'create',
		'DELETE' => 'delete',
	);
    /**
     *
     * ex: array('actionx' => array('get','post'))
     * the action 'actionx' would be responsible all the request methods listed
     */
    protected $additional_actions = array();
    protected $requesting_additional_action = false;
    
    public function  __construct($request) {
        $this->json_callback = Arr::get($_GET, 'callback');
        // default to get
        $this->request_method = Arr::get($_GET, '_method','get');
        return parent::__construct($request);
    }
    /**
     * Checks the requested method against the available methods. If the method
	 * is supported, sets the request action from the map. If not supported,
	 * the "invalid" action will be called.
     * 
     * @return void
     */
    public function before() {
        $this->json_callback = Arr::get($_GET, 'callback');
		$this->original_action = $this->request->action;
        // emulated REST, just looking for _meod= in GET
        $request_method = strtoupper(Arr::get($_GET, '_method','get'));
        // switch to this for a true REST
        // $request_method = Request::$method;\

        $this->requesting_additional_action = key_exists($this->original_action, $this->additional_actions);
        if($this->requesting_additional_action
           && in_array($request_method, $this->additional_actions[$this->original_action])) {
            return parent::before();
        } else {
           $this->request->action = 'invalid';
        }
        $this->request->action = ! isset($this->action_map[$request_method])
            ? 'invalid'
            : $this->action_map[$request_method];
        return parent::before();
	}
    /**
     *
     * @param array $allowed_action An allowed action exception that will not
     *        be held to REST rules
     *        in the form:
     *          array('action' => 'get') OR array('action' => array('get'))
     *        where request_method is one of get|post|put|delete
     *        If multiple request method for the action are allowed, the for is:
     *          array('action' => array('get','post',...))
     */
    protected function add_allowed_action(array $allowed_action) {
        $action = key($allowed_action);
        $request_methods = current($allowed_action);
        $request_methods = is_array($request_methods)?$request_methods:array($request_methods);
        $request_methods = array_map('strtoupper', $request_methods);
        $this->additional_actions[$action] = $request_methods;
    }

    /**
	 * Sends a 405 "Method Not Allowed" response and a list of allowed actions.
	 */
	public function action_invalid() {
		// Send the "Method Not Allowed" response
		$this->request->status = 405;
        if($this->requesting_additional_action) {
            $allowed_headers = implode(', ', $this->additional_actions[$this->original_action]);
        } else {
            $allowed_headers = implode(', ', array_keys($this->action_map));
        }
		$this->request->headers['Allow'] = $allowed_headers;

	}
    /**
     * json encoe the $data array applying jsonp callback if requested
     * 
     * @param array $data
     */
    public function json_response($data) {
        $json_data = !is_resource($data)?json_encode($data):null;
        $json_data = $this->json_callback!==null
                ? "{$this->json_callback}({$json_data})"
                : $json_data;
        $this->request->response = $json_data;
    }
}
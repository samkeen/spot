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

    protected $payload = array();

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

    protected $error_status_code = 400;
    protected $error_message = '';
    
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
        // $request_method = Request::$method;

        // little upfront sanity check
        if( in_array($request_method, array('PUT','DELETE'))
            && ! $this->request->param('id')) {
            $this->build_error_response(400,'Missing required parameter: [id]');
        } else {
            $this->requesting_additional_action = key_exists($this->original_action, $this->additional_actions);
            if($this->requesting_additional_action) {
                if(in_array($request_method, $this->additional_actions[$this->original_action])) {
                   return parent::before();
                } else {
                   $this->build_error_response(405);
                }
            }
            if(! isset($this->action_map[$request_method])) {
                $this->build_error_response(405);
            } else {
                $this->action_map[$request_method];
            }
            
            $this->set_payload($request_method);
        }
        return parent::before();
	}
    /**
     * abstract how we get data for PUT and POST and DELETE since it is all
     * currently comming through GET
     */
    protected function set_payload($request_method) {
        if(in_array($request_method, array('POST','PUT'))) {
            $this->payload = Arr::get($_GET, 'payload');
        }
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
     * Sets action to $this->action_invalid and defines the response
     *   code (default 400), and an optional error message.  If
     *   error_message not given, we use stock Request::$messages[]
     *
     * @param int $respose_code
     * @param string $error_message
     */
    protected function build_error_response($respose_code=400,$error_message=null) {
        $this->request->action = 'invalid';
        $this->error_status_code = $respose_code;
        $this->error_message = $error_message
            ? $error_message
            : Arr::get(Request::$messages, $respose_code);
    }

    /**
	 * Sends a error response.
	 */
	public function action_invalid() {
		// Send the "Method Not Allowed" response
		$this->request->status = $this->error_status_code;
        
        if($this->request->status == 405) { // "Method Not Allowed"
            if($this->requesting_additional_action) {
                $allowed_headers = implode(', ', $this->additional_actions[$this->original_action]);
            } else {
                $allowed_headers = implode(', ', array_keys($this->action_map));
            }
            $this->request->headers['Allow'] = $allowed_headers;
        }
        $this->request->response = json_encode(array('error'=>$this->error_message));
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
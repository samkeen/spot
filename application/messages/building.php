<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'lat'     => array(
        'required_if_other_given' => ':field required if :param1 given'
    ),
    'long'    => array(
        'required_if_other_given' => ':field required if :param1 given'
    )
);
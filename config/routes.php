<?php

defined('BASEPATH') or exit('No direct script access allowed');

$route['pjk3/pjk3/(:num)/(:any)'] = 'pjk3/index/$1/$2';

/**
 * @since 2.0.0
 */
$route['pjk3/list'] = 'mypjk3/list';
$route['pjk3/add'] = 'mypjk3/add';
$route['pjk3/show/(:num)/(:any)'] = 'mypjk3/show/$1/$2';
$route['pjk3/office/(:num)/(:any)'] = 'mypjk3/office/$1/$2';
$route['pjk3/pdf/(:num)'] = 'mypjk3/pdf/$1';

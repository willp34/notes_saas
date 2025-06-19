<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/teams', 'Teams::index');

/**
* team pages
*/

$routes->group('api', function($routes){
	
	$routes->get('teams', 'Api\Team::index');
	// creat team and add to database 
	$routes->post('teams', 'Api\Team::create');
	
	
	//invite team member 
	$routes->get('invite/(:num)', 'Api\Team::invite/$1');
	$routes->post('invite/(:num)', 'Api\Team::invite/$1');
	
	
	
	// users in team
	$routes->get('getUsersforTeam/(:num)', 'Api\Team::getUsersforTeam/$1');
	$routes->post('getUsersforTeam/(:num)', 'Api\Team::getUsersforTeam/$1');
	
});


#home controller 


$routes->group('home', function($routes){
	$routes->get('test', 'Home::test');
	$routes->get('login', 'Home::logon');
	
	$routes->get('forgotPassword', 'Home::forgotPassword');
	$routes->get('resetPassword/(:segment)', 'Home::resetPassword/$1');
});

#Auththentication
$routes->group('auth', function($routes){
	
	$routes->post('loggedin', 'Auth::login');
	$routes->get('loggedin', 'Auth::login');
	$routes->get('logout', 'Auth::logOut');
	$routes->post('sendResetLink', 'Auth::sendResetLink');
	//$routes->get('sendResetLink', 'Auth::sendResetLink');
});


## User pages

$routes->post('/api/addUser', 'Api\User::create');
//$routes->get('/api/addUser', 'Api\User::create');

$routes->get('/api/users/(:num)/(:segment)', 'Api\User::getUsers/$1/$2');
 

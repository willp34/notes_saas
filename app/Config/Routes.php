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

// Huffman encoding
$routes->group('encoding', function($routes){
	
	// Huffman encoding result 
	
	$routes->post('huffman', 'Encoding_methods\Huffman_encoding::index');
	//$routes->get('huffman', 'Encoding_methods\Huffman_encoding::index');
	
	
	
});
// Api Controllers
$routes->group('api', function($routes){
	
	$routes->get('teams', 'Api\Team::index');
	// creat team and add to database 
	$routes->post('teams', 'Api\Team::create');
	
	// Notes
	$routes->get('notes', 'Api\Note::index');
	
	//invite team member 
	$routes->get('invite/(:num)', 'Api\Team::invite/$1');
	$routes->post('invite/(:num)', 'Api\Team::invite/$1');
	
	// users in team
	$routes->get('getUsersforTeam/(:num)', 'Api\Team::getUsersforTeam/$1');
	$routes->post('getUsersforTeam/(:num)', 'Api\Team::getUsersforTeam/$1');
	
	// notes  
	$routes->post( 'notes' ,'Api\Note::create'   )  ;
	
	
		
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
	
	$routes->post('loggedin', 'Api\Auth::login');
	$routes->get('loggedin', 'Api\Auth::login');
	$routes->get('logout', 'Api\Auth::logOut');
	$routes->post('sendResetLink', 'Api\Auth::sendResetLink');
	//$routes->get('sendResetLink', 'Auth::sendResetLink');
	
	
	//Trusted device verification link
	
	$routes->get('verifyLogin/(:segment)', 'Api\Auth::verifyLogin/$1');
	
});

//Security
#Auththentication
$routes->group('security', function($routes){
	$routes->post('enable2fa', 'Api\Security::enable2FA');
	$routes->post('disable2fa', 'Api\Securiy::disable2FA');
	
	$routes->get('enable2fa', 'Api\Security::enable2FA');
	$routes->get('disable2fa', 'Api\Security::disable2FA');
	$routes->post('confirm2fa', 'Api\Security::confirm2FA');

});



#Dashboard
$routes->group('dashboard', function($routes){
	
	$routes->get('/', 'Dashboard::index');
	$routes->get('images', 'Dashboard::image_thresholding');
	$routes->get('settings', 'Dashboard::settingsPage');
	
	
});

## User pages

$routes->post('/api/addUser', 'Api\User::create');
//$routes->get('/api/addUser', 'Api\User::create');

$routes->get('/api/users/(:num)/(:segment)', 'Api\User::getUsers/$1/$2');
 
//services 
	$routes->get( 'services' ,'Services::index'   )  ;
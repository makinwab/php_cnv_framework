<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makinwab
 * Date: 8/14/13
 * Time: 10:01 PM
 * To change this template use File | Settings | File Templates.
 */

// Directory constants
// Always provide a TRAILING SLASH (/) after a path
define('URL','http://localhost/Connverg_Framework/');
define('_CONTROLLER_','controllers');
define('DOCUMENT_ROOT', dirname(__FILE__));
define('DS',DIRECTORY_SEPARATOR);
define('LIBS', 'libs/');

//Database connection constants
define('DB_TYPE','mysql');
define('DB_HOST','localhost');
define('DB_NAME','Framework');
define('DB_USER','root');
define('DB_PASS','makinwab');

// The site wide hash key, does not change this is because its used for passwords!

// This is for other hash keys ... not sure yet
define('HASH_GENERAL_KEY','xxxxx');

// This is used for database passwords only
define('HASH_PASSWORD_KEY','xxxx');


//Application specific constants

// for pagination
define('ITEM_PER_PAGE',5);

//URL definitions
define('LOGOUT',URL.'user/logout');
define('LOGIN', URL.'index');


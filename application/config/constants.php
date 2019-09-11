<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/*Constants for the table name and there fields*/

defined('CREATED_ON')    OR define('CREATED_ON', 'created_on');  // Common field for all tables
defined('UPDATED_ON')    OR define('UPDATED_ON', 'updated_on');  // Common field for all tables
defined('STATUS')        OR define('STATUS', 'status');  		 // Common field for all tables
defined('WEEKDAYS')		 OR define('WEEKDAYS', '5');

/*----------------------------------------------------------------------*/

defined('ROLE')        			OR define('ROLE', 'role');  // Table name
defined('ROLE_ID')        		OR define('ROLE_ID', 'role_id');  //field name
defined('ROLE_NAME')        	OR define('ROLE_NAME', 'role_name');  //field name
defined('ROLE_DESCRIPTION')     OR define('ROLE_DESCRIPTION', 'role_description');  //field name
defined('SEQUENCE')        		OR define('SEQUENCE', 'sequence');  //field name

/*----------------------------------------------------------------------*/

defined('REGION')       OR define('REGION', 'region');  // Table name
defined('REG_ID')       OR define('REG_ID', 'reg_id');  //field name
defined('REG_CODE')     OR define('REG_CODE', 'region_code');  //field name
defined('REG_NAME')     OR define('REG_NAME', 'region_name');  //field name

/*----------------------------------------------------------------------*/

defined('SITE')       OR define('SITE', 'site');  // Table name
defined('SITE_ID')       OR define('SITE_ID', 'site_id');  //field name
defined('SITE_CODE')     OR define('SITE_CODE', 'site_code');  //field name
defined('SITE_NAME')     OR define('SITE_NAME', 'site_name');  //field name
defined('SITE_OWNER')       OR define('SITE_OWNER', 'site_owner');  //field name
defined('SITE_REG_ID')     OR define('SITE_REG_ID', 'region_id');  //field name
defined('SITE_CC_ID')     OR define('SITE_CC_ID', 'cost_center_id');  //field name
defined('SITE_HRS_WEEK')       OR define('SITE_HRS_WEEK', 'workhours_per_week');  //field name
defined('SITE_TIMEZONE')     OR define('SITE_TIMEZONE', 'timezone');  //field name

/*----------------------------------------------------------------------*/

defined('COST_CENTER')       OR define('COST_CENTER', 'cost_center');  // Table name
defined('CC_ID')       OR define('CC_ID', 'cc_id');  //field name
defined('CC_CODE')     OR define('CC_CODE', 'cost_center_code');  //field name
defined('CC_NAME')     OR define('CC_NAME', 'cost_center_name');  //field name

/*----------------------------------------------------------------------*/

defined('USER')        				OR define('USER', 'users');  // Table name
defined('USER_ID')        			OR define('USER_ID', 'user_id');  //field name
defined('USERNAME')        		OR define('USERNAME', 'username');  //field name
defined('EMPLOYEE_ID')        		OR define('EMPLOYEE_ID', 'employee_id');  //field name
defined('USER_CODE')        		OR define('USER_CODE', 'user_code');  //field name
defined('USER_FIRST_NAME')        	OR define('USER_FIRST_NAME', 'first_name');  //field name
defined('USER_MIDDLE_NAME')        	OR define('USER_MIDDLE_NAME', 'middle_name');  //field name
defined('USER_LAST_NAME')        	OR define('USER_LAST_NAME', 'last_name');  //field name
defined('USER_EMAIL')        		OR define('USER_EMAIL', 'email_id');  //field name
defined('USER_PASSWORD')        	OR define('USER_PASSWORD', 'password');  //field name
defined('USER_PROFILE_PIC')        	OR define('USER_PROFILE_PIC', 'profile_pic');  //field name
defined('USER_SITE_ID')        		OR define('USER_SITE_ID', 'site_id');  //field name
defined('USER_IS_FIRSTTIME')       	OR define('USER_IS_FIRSTTIME', 'is_firsttime');  //field name
defined('SUPERV_ID')        	OR define('SUPERV_ID', 'supervisor_id');  //field name

/*----------------------------------------------------------------------*/

defined('USER_ROLE_MAPPING')        OR define('USER_ROLE_MAPPING', 'users_role_mapping');  // Table name
defined('USER_ROLE_MAPPING_ID')     OR define('USER_ROLE_MAPPING_ID', 'users_role_mapping_id');

/*----------------------------------------------------------------------*/

defined('ROLE_MENU')			OR define('ROLE_MENU', 'role_menu'); //Table Name
defined('MENU_ID')				OR define('MENU_ID', 'menu_id');
defined('MENU_NAME')			OR define('MENU_NAME', 'menu_name');
defined('MENU_LINK')			OR define('MENU_LINK', 'menu_link');
defined('MENU_ICON')			OR define('MENU_ICON', 'menu_icon');
defined('MENU_FOLDER')			OR define('MENU_FOLDER', 'menu_folder');
defined('MENU_CONTROLLER')		OR define('MENU_CONTROLLER', 'menu_controller');
defined('MENU_FUNCTION_NAME')	OR define('MENU_FUNCTION_NAME', 'menu_function_name');

/*----------------------------------------------------------------------*/

defined('ROLE_MENU_MAPPING')	OR define('ROLE_MENU_MAPPING', 'role_menu_mapping'); //Table Name

/*----------------------------------------------------------------------*/

defined('PROJECTS')				OR define('PROJECTS', 'projects'); //Table Name
defined('PROJECT_ID')			OR define('PROJECT_ID', 'id');
defined('SAP_NO')			OR define('SAP_NO', 'project_id');
defined('PROJECT_NAME')			OR define('PROJECT_NAME', 'project_name');
defined('PROJECT_DESCRIPTION')	OR define('PROJECT_DESCRIPTION', 'project_description');
defined('PROJECT_BUDGET')		OR define('PROJECT_BUDGET', 'project_budget');
defined('PROJECT_SITE_ID')			OR define('PROJECT_SITE_ID', 'site_id');
defined('SUPERVISOR_ID')        	OR define('SUPERVISOR_ID', 'supervisor_id');  //field name
defined('PROJECT_EXP_SUBTASK')			OR define('PROJECT_EXP_SUBTASK', 'explicite_subtask');
defined('PROJECT_TYPE')		OR define('PROJECT_TYPE', 'project_type');
defined('PROJECT_START_DATE')		OR define('PROJECT_START_DATE', 'start_date');
defined('PROJECT_END_DATE')			OR define('PROJECT_END_DATE', 'end_date');
defined('PROJECT_CREATED_BY')	OR define('PROJECT_CREATED_BY', 'created_by');

/*----------------------------------------------------------------------*/

defined('SUBTASK')				OR define('SUBTASK', 'subtask'); //Table Name
defined('SUBTASK_ID')			OR define('SUBTASK_ID', 'subtask_id');
defined('SUBTASK_NAME')			OR define('SUBTASK_NAME', 'subtask_name');
defined('SAP_NUMBER')			OR define('SAP_NUMBER', 'sap_number');
defined('SUB_PROJECT_ID')			OR define('SUB_PROJECT_ID', 'project_id');
defined('SUBTASK_HOURS')			OR define('SUBTASK_HOURS', 'estimated_hours');
defined('CREATED_BY')	OR define('CREATED_BY', 'created_by');

/*----------------------------------------------------------------------*/

defined('PORTAL')       OR define('PORTAL', 'portals');  // Table name
defined('PORTAL_ID')       OR define('PORTAL_ID', 'portal_id');  //field name
defined('PORTAL_NAME')     OR define('PORTAL_NAME', 'portal_name');  //field name

/*----------------------------------------------------------------------*/

defined('ADMIN_PORTAL')       OR define('ADMIN_PORTAL', 'subadmin_portals');  // Table name
defined('ADMIN_PORTAL_ID')       OR define('ADMIN_PORTAL_ID', 'portal_id');  //field name
defined('ADMIN_USER_ID')     OR define('ADMIN_USER_ID', 'user_id');  //field name

/*----------------------------------------------------------------------*/

defined('ASSIGN_PROJECT')       OR define('ASSIGN_PROJECT', 'assign_project');  // Table name
defined('ASSIGN_ID')       OR define('ASSIGN_ID', 'id');  //field name
defined('ASSIGN_PROJECT_ID')     OR define('ASSIGN_PROJECT_ID', 'project_id');  //field name
defined('SUBTASK_IDS')     OR define('SUBTASK_IDS', 'subtask_ids');  //field name
defined('ASSIGN_USER_ID')       OR define('ASSIGN_USER_ID', 'user_id');  //field name
defined('START_DATE')     OR define('START_DATE', 'start_date');  //field name
defined('END_DATE')       OR define('END_DATE', 'end_date');  //field name
defined('ASSIGN_PROJECT_BY')     OR define('ASSIGN_PROJECT_BY', 'assign_by');  //field name
defined('ASSIGN_TO_ROLE')     OR define('ASSIGN_TO_ROLE', 'assign_to_role');  //field name

/*----------------------------------------------------------------------*/

defined('LOG_HISTORY')				OR define('LOG_HISTORY', 'log_history'); //Table Name
defined('LOG_EVENT')				OR define('LOG_EVENT', 'log_event');
defined('LOG_EVENT_DESCRIPTION')				OR define('LOG_EVENT_DESCRIPTION', 'log_event_description');
defined('LOG_DATE')				OR define('LOG_DATE', 'log_date');

const HOLIDAY_PROJECTS = array('holiday', 'leave', 'travel', 'vacation');
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

defined('EMAIL_SENDER') 	   OR define('EMAIL_SENDER','AdminSC@est.or.th');
defined('EMAIL_SENDER_NAME')   OR define( 'EMAIL_SENDER_NAME' ,'SEANES 2018 Submission and Review');
defined('UPLOAD_PATH') 	   OR define('UPLOAD_PATH','./uploads/');
defined('PAPER_PREFIX') 	   OR define('PAPER_PREFIX','EST');
defined('DOC_VIEWER') 	   OR define('DOC_VIEWER','https://docs.google.com/gview?url=');
defined('CONSENT_PATH') 	   OR define('CONSENT_PATH','./document/SEANES2018-Transfer_of_Copyright_Agreement.docx');
defined('USER_GUIDE_PATH') 	   OR define('USER_GUIDE_PATH','./document/PaperSubmissionUserGuide01-v2.pdf');
defined('REVIEWER_GUIDE_PATH') 	   OR define('REVIEWER_GUIDE_PATH','./document/ReviewerUserManual.pdf');
defined('REG_NON_AUTHOR_GUIDE_PATH') 	   OR define('REG_NON_AUTHOR_GUIDE_PATH','./document/RegistrationUserManualForNon-Author.pdf');
defined('REG_AUTHOR_GUIDE_PATH') 	   OR define('REG_AUTHOR_GUIDE_PATH','./document/RegistrationUserManualForAuthor.pdf');


defined('USER_ROLE') OR define("USER_ROLE", serialize (array (
																	1 => "Author",
																	2 => "Scientific Committee/Reviewer",
																	3 => "Participant",
																	4 => "Admin (Editor)",
																	5 => "Admin (Treasurer)"
														)));
														
defined('USER_ROLE_TOP') OR define("USER_ROLE_TOP", serialize (array (2,4,5)));

defined('USER_ROLE_AUTHOR') OR define("USER_ROLE_AUTHOR", serialize (array (1,2,4,5)));
																	
defined('PAPER_STATUS') OR define("PAPER_STATUS", serialize (array (
																	1 => "Waiting",
																	2 => "In Review",
																	3 => "In Correction",
																	4 => "In Press"
																 )));	
																 
defined('EVALUATION_STATUS') OR define("EVALUATION_STATUS", serialize (array (
																			1 => array(
																					'text' => 'Waiting',
																					'label' => 'secondary'
																					),
																			2 => array(
																					'text' => 'Accept',
																					'label' => 'primary'
																					),
																			3 => array(
																					'text' => 'Reject',
																					'label' => 'danger'
																					),
																			4 => array(
																					'text' => 'Completed',
																					'label' => 'success'
																					)
																		)));																	

defined('EVALUATION_Q') OR define("EVALUATION_Q", serialize (array (
																	"q1" => "Title of the article",
																	"q2" => "Abstract",
																	"q3" => "Content of article",
																	"q4" => "Style of manuscript preparation",
																	"q5" => "English Grammar",
																	"q6" => "Tables",
																	"q7" => "Figures",
																	"q8" => "Adequacy of the discussion",
																	"q9" => "Technical accuracy",
																	"q10" => "Originally of the presented work",
																	"q11" => "References",
																	"q12" => "Over all"
																 ))); 
																 
defined('EVALUATION_CONFERENCE') OR define("EVALUATION_CONFERENCE", serialize (array (
																	1 => "Unacceptable",
																	2 => "Acceptable after major revision",
																	3 => "Acceptable after minor revision",
																	4 => "Acceptable in its present form"
																 )));
																 
defined('EVALUATION_JOURNAL') OR define("EVALUATION_JOURNAL", serialize (array (
																	1 => "Not appropriated",
																	2 => "Weak selected",
																	3 => "Strong selected",
																	4 => "Very strong selected"
																 ))); 	

defined('REGISTRATION_TYPE') OR define("REGISTRATION_TYPE", serialize (array (
																	1 => "SEANES member or Developing Countries",
																	2 => "IEA Federated Societies",
																	3 => "Others participants",
																	4 => "Students"
																 ))); 																			 
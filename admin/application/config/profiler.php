<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Profiler Sections
| -------------------------------------------------------------------------
| This file lets you determine whether or not various sections of Profiler
| data are displayed when the Profiler is enabled.
| Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/profiling.html
|
*/

/*
benchmarks          Elapsed time of Benchmark points and total execution time 	TRUE
config              CodeIgniter Config variables 	TRUE
controller_info     The Controller class and method requested 	TRUE
get                 Any GET data passed in the request 	TRUE
http_headers        The HTTP headers for the current request 	TRUE
memory_usage        Amount of memory consumed by the current request, in bytes 	TRUE
post                Any POST data passed in the request 	TRUE
queries             Listing of all database queries executed, including execution time 	TRUE
uri_string          The URI of the current request 	TRUE
session_data        Data stored in the current session 	TRUE
query_toggle_count  The number of queries after which the query block will default to hidden. 	25
*/
$config['benchmarks']          = FALSE;
$config['config']         = FALSE;
$config['get']         = FALSE;
$config['http_headers']         = FALSE;
$config['memory_usage']         = FALSE;
$config['session_data']         = FALSE;

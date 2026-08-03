<?php
// Temporary directory for linux (with trailing slash)
define('pdw_tmpdir', '/tmp/');
// Temporary directory for windows (with trailing slash)
// define('pdw_tmpdir', 'C:/TEMP/');

// Full path to phpdocwriter directory (change it only if necessary)
define('pdw_full_path',  dirname(__FILE__, 2));

// Full path to linux export command (change it only if necessary)
define('export_script_path', "\"".\PDW_FULL_PATH."/conf/export.sh\"");
// Full path to windows export command (change it only if necessary)
// define('export_script_path', "\"".pdw_full_path."/conf/export.bat\"");
?>
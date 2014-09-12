<?php

/**
 *	powered by @cafewebmaster.com
 *	free for private use
 *	please support us with donations
 */


header("Content-type: text/plain");

set_time_limit(0);

$count = 0;

$path	= dirname(__FILE__) ;
$path = "C:\\Users\\NovakSolutions\\UniServerZ\\www";
$checkMd5BeforeReplacing = true;

$results = php_grep("MIIDIDCCAomg", $path);

function php_grep($q, $path){
    global $count;
    global $checkMd5BeforeReplacing;
    $ret = '';
    $fp = opendir($path);
    while($f = readdir($fp)){
        $count++;
        if($count > 1000000){
            echo "Hit File Limit\n";
            break;
        }
        if( preg_match('/^\.+$/', $f) ) continue; // ignore files that start with periods
        $file_full_path = $path. DIRECTORY_SEPARATOR .$f;
        if(is_dir($file_full_path)) {
            php_grep($q, $file_full_path);
        } else {
            if($f == 'infusionsoft.pem'){
                if(stristr(file_get_contents($file_full_path), $q) ) {
                    $file_contents = file_get_contents($file_full_path);
                    $file_contents_no_spaces_or_line_breaks = preg_replace('/[\t\s\r\n]+/', '', $file_contents);
                    //echo $file_contents_no_spaces_or_line_breaks . "\n";
                    $md5 = md5($file_contents_no_spaces_or_line_breaks);

                    echo "Found $q in: $file_full_path - $md5\n";

                    if(!$checkMd5BeforeReplacing || $md5 == '4817bc7a603ac87f7f60200775076314'){
                        echo "  Updating File: $file_full_path\n";
                        file_put_contents($file_full_path, file_get_contents('infusionsoft.pem'));
                    } else {
                        echo "  Md5 doesn't match, so we're skipping this file.\n";
                    }

                    flush();
                } else {
                    echo "Nothing Found In: $file_full_path\n";
                    flush();
                }
            }
        }
    }
}
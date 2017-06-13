<?php

$redis = new Redis();
$redis->connect(REDIS_HOST, REDIS_PORT);

function is_admin($msg){
    if($msg['from']['id'] == ADMIN_ID){
        return true;
    }else{
        return false;
    }
}

function save_log($data){
    if(!$data){
        return false;
    }else{
        $text = date('[D, j F Y \a\t G:i:s]');
        $file = fopen('data/log.txt', 'a');
        fwrite($file, $text . " -> " . $data . "\n");
        fclose($file);
    }
}

?>

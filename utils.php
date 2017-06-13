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

function collect_stats($msg){
    global $redis;
    if($msg){
        if($msg['from']['id']){
            $redis->sadd(BOT_NAME . ':BotUsers', $msg['from']['id']);
        }
        if($msg['text'] == '/start'){
            $redis->incr(BOT_NAME . ':StartNums');
        }
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

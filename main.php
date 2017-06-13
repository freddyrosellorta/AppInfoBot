<?php

require_once 'data/config.php';
require_once 'utils.php';
require_once 'methods.php';

function message_processor($msg, $matches) {
    // Process Incoming Messages
    global $redis;
    if($matches[0] == '/start'){
        sendMessage($msg['chat']['id'], "لطفا نام برنامه مورد نظر را ارسال کنید :", "Markdown");
    }elseif($matches){
        $url = 'https://elhost.online/CafeBazaar/api/v1/search.php?app=' . urlencode($msg['text']);
        $req = file_get_contents($url);
        $jdat = json_decode($req, true);
        if(count($jdat) == 0){
            sendMessage($msg['chat']['id'], "هیچ برنامه ای مطابق با برنامه مورد نظر شما یافت نشد!", "Markdown");
            exit;
        }
        $redis->set(BOT_NAME . ":AppName:" . $msg['from']['id'], urlencode($msg['text']));
        for($i=0; ; $i++){
            if($i == count($jdat)){
                break;
            }
            $keyboard['inline_keyboard'][$i] = array(
                array(
                    'text'=>$jdat[$i]['title'],
                    'callback_data'=>$jdat[$i]['package'],
                )
            );
        }
        sendKeyboard($msg['chat']['id'], "لیست برنامه های یافت شده :\nبرای دریافت اطلاعات روی نام برنامه کلیک کنید 📃", $keyboard, 'Markdown');
    }
}

function callback_query($msg, $matches){
    // Process Inline Keyboards
    global $redis;
    $app = $redis->get(BOT_NAME . ":AppName:" . $msg['from']['id']);
    $url = 'https://elhost.online/CafeBazaar/api/v1/search.php?app=' . $app;
    $req = file_get_contents($url);
    $jdat = json_decode($req, true);
    if($matches[0] == 'back'){
        for($i=0; ; $i++){
            if($i == count($jdat)){
                break;
            }
            $keyboard['inline_keyboard'][$i] = array(
                array(
                    'text'=>$jdat[$i]['title'],
                    'callback_data'=>$jdat[$i]['package'],
                )
            );
        }
        editTextMessage($msg['message']['chat']['id'], $msg['message']['message_id'], "لیست برنامه های یافت شده :\nبرای دریافت اطلاعات روی نام برنامه کلیک کنید 📃", $keyboard);
    }elseif($matches){
        foreach($jdat as $result){
            if($result['package'] == $msg['data']){
                $req = file_get_contents('http://elhost.online/CafeBazaar/api/v1/download.php?packagename=' . $result['package']);
                if($req == 'false'){
                    $keyboard['inline_keyboard'] = array(
                        array(
                            array(
                                'text'=>'🌐 لینک در کافه بازار 🌐',
                                'url'=>$result['url']
                            )
                        ),
                        array(
                            array(
                                'text'=>"🔙 بازگشت 🔙",
                                'callback_data'=>"back"
                            )
                        )
                    );
                }else{
                    $keyboard['inline_keyboard'] = array(
                        array(
                            array(
                                'text'=>'🌐 لینک در کافه بازار 🌐',
                                'url'=>$result['url']
                            )
                        ),
                        array(
                            array(
                                'text'=>'⏬ لینک دانلود ⏬',
                                'url'=>$req
                            )
                        ),
                        array(
                            array(
                                'text'=>"🔙 بازگشت 🔙",
                                'callback_data'=>"back"
                            )
                        )
                    );
                }
                editTextMessage($msg['message']['chat']['id'], $msg['message']['message_id'], "✏️ نام برنامه :  _" . $result['title'] . "_\n📦 نام پکیج : *" . $result['package'] . "*\n📱 آیکون برنامه : \n[" . $result['icon'] . "](" . $result['icon'] . ")", $keyboard);
            }
        }
    }
}

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if(isset($update)){
	if (isset($update['message'])) {
	    $matches = explode(' ', $update['message']['text']);
		message_processor($update['message'], $matches);
	}elseif(isset($update['callback_query'])) {
	    $matches = explode(' ', $update['callback_query']['data']);
		callback_query($update['callback_query'], $matches);
	}
}else{
	exit();
}

?>

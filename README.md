# AppInfoBot
Telegram [App Finder Bot](https://telegram.me/AppInfoBot) Source Code

# Requirements: 
- `php`
- `pecl`
- `redis-server`
- `redis-php`

# Setup Packages:
```bash
# Tested On Centos 6,7
$ yum update
$ yum upgrade
$ yum intall pecl
$ yum install redis
$ pecl install redis
```

# How To Use?
>> 1. Set Webhook:
>
> Use this url to set webhook :
>
> [https://api.telegram.org/bot<TOKEN>/setWebHook?url=https://your_site.ir/AppInfoBot/main.php](https://api.telegram.org/bot<TOKEN>/setWebHook?url=https://your_site.ir/AppInfoBot/main.php)
> 
>> 2. Set token and admin id:
>
> Open [data/config.php](https://github.com/CruelTm/AppInfoBot/blob/master/data/config.php) and set bot token, your id, redis host and port. Example:
>```php
>define(BOT_TOKEN, '352752169:BBESuA68DpesrHoV4WCxmXPi3TkqjQgoe49');
>define(ADMIN_ID, 179071599);
>define(REDIS_HOST, '127.0.0.1');
>define(REDIS_PORT, '6379');
>```
>
>> 3. Send /start to your bot and enjoy!

# AppInfoBot
Telegram App Finder Bot Source Code

# Requirements: 
- `redis-php`
- `redis-server`
- `php`

# Setup Packages:
```bash
# Tested On Centos 6,7
$ pecl install redis
```

# How To Use?
> 1. Set Webhook:
> •Use this url to set webhook :
> https://api.telegram.org/bot<TOKEN>/setWebHook?url=https://your_site.ir/AppInfoBot/main.php
> 
> 2. Set token and admin id:
> Open data/config.php and set bot token and your id.
>
> 3. Send /start to bot and enjoy!

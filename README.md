# TelegramBotClient

[![License](https://poser.pugx.org/alxmsl/telegrambotclient/license)](https://packagist.org/packages/alxmsl/telegrambotclient)
[![Latest Stable Version](https://poser.pugx.org/alxmsl/telegrambotclient/version)](https://packagist.org/packages/alxmsl/telegrambotclient)
[![Build Status](https://travis-ci.org/alxmsl/TelegramBotClient.svg)](https://travis-ci.org/alxmsl/TelegramBotClient)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alxmsl/TelegramBotClient/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alxmsl/TelegramBotClient/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/alxmsl/TelegramBotClient/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/alxmsl/TelegramBotClient/?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/55b5ffd4653762002000002f/badge.svg?style=flat)](https://www.versioneye.com/user/projects/55b5ffd4653762002000002f)
[![Total Downloads](https://poser.pugx.org/alxmsl/telegrambotclient/downloads)](https://packagist.org/packages/alxmsl/telegrambotclient)

Powerful client for [Telegram Bot API](https://core.telegram.org/bots)

## Advantages

1. Lightweight. You could use only two classes for work: [API client](/source/Client.php) and 
 [response](/source/Response.php)
2. Powerful. Same time you could use all 16 Bot API [types](https://core.telegram.org/bots/api#available-types) and all 
 13 Bot API [methods](https://core.telegram.org/bots/api#available-methods)  
3. `composer` support makes installation simplified
4. Independent namespace helps to use Bot API client on different projects and frameworks
5. [CLI utility](/bin/call.php) helps you to test Bot API interactions

## Installation

For simplified usage all what you need is require packet via composer

```
    $ composer require alxmsl/telegrambotclient
```

In third-party projects, require packet in your `composer.json`

```
    "alxmsl/telegrambotclient": "*"
```

...and update composer: `composer update`

## Usages

First what you need is client instance. Just create it

```
    use alxmsl\Telegram\Bot\Client;
    $Client = new Client('123456789:Y0uR5EcREtT0KEn');
```

....then you could call bot methods directly and got API response string 

```
    $result = $Client->call(<method name>, <call parameters>);
    printf("%s\n", $result);
```

...or use methods wrappers 

```
    $updates = $Client->getUpdates(0, 1);
    var_dump($updates);
```

Method wrappers helps you to return specific result types as described in 
 [API documentation](https://core.telegram.org/bots/api#available-types). For example, using `getUpdates` you be 
 returned array of [Update](/source/Type/Update.php) instances, `sendMessage` wrapper returns you 
 [Message](/source/Type/Message.php) object etc.

```
    use alxmsl\Telegram\Bot\Client;
    use alxmsl\Telegram\Bot\Type\Message;
    
    $Client  = new Client('123456789:Y0uR5EcREtT0KEn');
    $Message = $Client->sendMessage(34567, 'hello');
    ($Message instanceof Message); // that's TRUE 
```

When something wrong, wrapper throws `UnsuccessfulException`. For example code

```
    $Client = new Client('123456789:Br0KEnT0kEN');
    try {
        $Message = $Client->getMe();
    } catch (UnsuccessfulException $Ex) {
        printf("%s\n%s", $Ex->getCode(), $Ex->getMessage());
    }
```

is showed you

```
401
Error: Unauthorized
```

## Console usage

You could use script `call.php` to call Telegram Bot API directly

```
    $ php bin/call.php -h
    Using: /usr/local/bin/php bin/call.php [-h|--help] -m|--method [-p|--parameters] -t|--token
    -h, --help  - show help
    -m, --method  - bot method name
    -p, --parameters  - method calls parameters
    -t, --token  - authentication token
```

Using utility you could test your bot's authentication token 

```
    $ php bin/call.php -t='123456789:Y0uR5EcREtT0KEn' -m='getMe' 
    {"ok":true,"result":{"id":123456789,"first_name":"alxmslClientBot","username":"alxmslClientBot"}}
```

When something wrong^ utility will show you error response from Bot API

```
    $ php bin/call.php -t='123456789:Br0KEnT0kEN' -m='getMe' 
    {"ok":false,"error_code":401,"description":"Error: Unauthorized"}
```

... got updates etc.

```
    $ php bin/call.php -t='123456789:Y0uR5EcREtT0KEn' -m='getUpdates' -p='{"limit":1}' 
    {"ok":true,"result":[{"update_id":7654321,"message":{"message_id":2,"from":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"chat":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"date":1435870467,"text":"\/start"}}]}
```

## Tests

For completely tests running just call `phpunit` command

```
    $ phpunit
    PHPUnit 4.7.5 by Sebastian Bergmann and contributors.
    
    Runtime:	PHP 5.5.23
    
    ................
    
    Time: 190 ms, Memory: 9.00Mb
    
    OK (16 tests, 784 assertions)
```

## License

Copyright 2015 Alexey Maslov <alexey.y.maslov@gmail.com>

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

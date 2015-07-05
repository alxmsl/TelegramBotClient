<?php
/**
 * Copyright 2015 Alexey Maslov <alexey.y.maslov@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * Utility for Telegram Bot API method call
 * @author alxmsl
 */

include __DIR__ . '/../vendor/autoload.php';

use alxmsl\Cli\CommandPosix;
use alxmsl\Cli\Option;
use alxmsl\Cli\Exception\RequiredOptionException;
use alxmsl\Telegram\Bot\Client;

$key        = '';
$methodName = '';
$parameters = [];

$Command = new CommandPosix();
$Command->appendHelpParameter('show help');
$Command->appendParameter(new Option('method', 'm', 'bot method name', Option::TYPE_STRING, true)
    , function($name, $value) use (&$methodName) {
        $methodName = $value;
    });
$Command->appendParameter(new Option('parameters', 'p', 'method calls parameters', Option::TYPE_STRING)
    , function($name, $value) use (&$parameters) {
        $parameters = json_decode($value, true);
    });
$Command->appendParameter(new Option('token', 't', 'authentication token', Option::TYPE_STRING, true)
, function($name, $value) use (&$key) {
        $key = $value;
});

try {
    $Command->parse(true);

    $Client = new Client($key);
    $result = $Client->call($methodName, $parameters);
    printf("%s\n", $result);
} catch (RequiredOptionException $Ex) {
    $Command->displayHelp();
}

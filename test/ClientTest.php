<?php
/*
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
 */

namespace alxmsl\Test\Telegram\Bot\Type;

use alxmsl\Telegram\Bot\Client;
use PHPUnit_Framework_TestCase;

/**
 * Bot API client test
 * @author alxmsl
 */
final class ClientTest extends PHPUnit_Framework_TestCase {
    public function testProperties() {
        $Client = new Client();
        
        $Client->setConnectTimeout(0.);
        $this->assertSame(0, $Client->getConnectTimeout());
        $Client->setConnectTimeout(6.9);
        $this->assertSame(6, $Client->getConnectTimeout());
        $Client->setConnectTimeout('123abc');
        $this->assertSame(123, $Client->getConnectTimeout());
        $Client->setConnectTimeout('abc123');
        $this->assertSame(0, $Client->getConnectTimeout());

        $Client->setRequestTimeout(0.);
        $this->assertSame(0, $Client->getRequestTimeout());
        $Client->setRequestTimeout(6.9);
        $this->assertSame(6, $Client->getRequestTimeout());
        $Client->setRequestTimeout('123abc');
        $this->assertSame(123, $Client->getRequestTimeout());
        $Client->setRequestTimeout('abc123');
        $this->assertSame(0, $Client->getRequestTimeout());
    }
}

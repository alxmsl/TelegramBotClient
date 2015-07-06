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
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_MockObject_Stub_ConsecutiveCalls;
use PHPUnit_Framework_TestCase;

/**
 * Abstract class for Bot API calls tests
 * @author alxmsl
 */
abstract class AbstractCallTest extends PHPUnit_Framework_TestCase {
    protected function getClientMock(PHPUnit_Framework_MockObject_Stub_ConsecutiveCalls $ConsecutiveCalls) {
        /** @var Client|PHPUnit_Framework_MockObject_MockObject $ClientMock */
        $ClientMock = $this->getMock(Client::class, ['call']);
        $ClientMock->expects($this->any())->method('call')->will($ConsecutiveCalls);
        return $ClientMock;
    }
}

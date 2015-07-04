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
use alxmsl\Telegram\Bot\Type\User;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

/**
 * Telegram Bot API Client test class
 * @author alxmsl
 */
final class ClientTest extends PHPUnit_Framework_TestCase {
    public function testGetUpdates() {
        /** @var Client|PHPUnit_Framework_MockObject_MockObject $ClientMock */
        $ClientMock = $this->getMock(Client::class, ['call']);
        $ClientMock->expects($this->any())->method('call')->willReturn('{"ok":true,"result":[{"update_id":70933586,"message":{"message_id":2,"from":{"id":39150,"first_name":"Alexey","last_name":"Maslov"},"chat":{"id":39150,"first_name":"Alexey","last_name":"Maslov"},"date":1435870467,"text":"\/start"}}]}');
        $updates = $ClientMock->getUpdates();
        $this->assertCount(1, $updates);
        $this->assertEquals(70933586, $updates[0]->getUpdateId());
        $this->assertEquals(2, $updates[0]->getMessage()->getMessageId());
        $this->assertEquals(1435870467, $updates[0]->getMessage()->getDate());
        $this->assertEquals('/start', $updates[0]->getMessage()->getText());
        $this->assertEquals(39150, $updates[0]->getMessage()->getFrom()->getId());
        $this->assertEquals('Alexey', $updates[0]->getMessage()->getFrom()->getFirstName());
        $this->assertEquals('Maslov', $updates[0]->getMessage()->getFrom()->getLastName());
        $this->assertInstanceOf(User::class, $updates[0]->getMessage()->getChat());
        $this->assertEquals(39150, $updates[0]->getMessage()->getChat()->getId());
        $this->assertEquals('Alexey', $updates[0]->getMessage()->getChat()->getFirstName());
        $this->assertEquals('Maslov', $updates[0]->getMessage()->getChat()->getLastName());
    }
}

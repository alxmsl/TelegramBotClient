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

use alxmsl\Telegram\Bot\Exception\UnsuccessfulException;
use alxmsl\Telegram\Bot\Type\Message;
use alxmsl\Telegram\Bot\Type\User;

/**
 * Bot API sendMessage method test
 * @author alxmsl
 */
final class SendMessageTest extends AbstractCallTest {
    public function test() {
        $ClientMock = $this->getClientMock($this->onConsecutiveCalls(
            '{"ok":false,"error_code":401,"description":"Error: Unauthorized"}'
            , '{"ok":false,"error_code":400,"description":"Error: PEER_ID_INVALID"}'
            , '{"ok":false,"error_code":400,"description":"Error: Bad Request: text is empty"}'
            , '{"ok":false,"error_code":400,"description":"Error: Bad Request: message not found"}'
            , '{"ok":true,"result":{"message_id":19,"from":{"id":122334455,"first_name":"alxmslClientBot","username":"alxmslClientBot"},"chat":{"id":123456,"first_name":"Alexey","last_name":"Maslov","username":"alxmsl"},"date":1436218862,"text":"hello"}}'
        ));

        try {
            $ClientMock->sendMessage(1, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(401, $Ex->getCode());
            $this->assertEquals('Error: Unauthorized', $Ex->getMessage());
        }

        try {
            $ClientMock->sendMessage(1, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: PEER_ID_INVALID', $Ex->getMessage());
        }

        try {
            $ClientMock->sendMessage(1, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: Bad Request: text is empty', $Ex->getMessage());
        }

        try {
            $ClientMock->sendMessage(1, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: Bad Request: message not found', $Ex->getMessage());
        }

        $Result = $ClientMock->sendMessage(1, '');
        $this->assertInstanceOf(Message::class, $Result);
        $this->assertEquals(19, $Result->getMessageId());
        $this->assertEquals(1436218862, $Result->getDate());
        $this->assertEquals('hello', $Result->getText());
        $this->assertInstanceOf(User::class, $Result->getFrom());
        $this->assertEquals(122334455, $Result->getFrom()->getId());
        $this->assertEquals('alxmslClientBot', $Result->getFrom()->getFirstName());
        $this->assertEmpty($Result->getFrom()->getLastName());
        $this->assertEquals('alxmslClientBot', $Result->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $Result->getChat());
        $this->assertEquals(123456, $Result->getChat()->getId());
        $this->assertEquals('Alexey', $Result->getChat()->getFirstName());
        $this->assertEquals('Maslov', $Result->getChat()->getLastName());
        $this->assertEquals('alxmsl', $Result->getChat()->getUsername());
    }
}

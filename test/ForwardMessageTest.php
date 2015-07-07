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
 * Bot API forwardMessage method test
 * @author alxmsl
 */
final class ForwardMessageTest extends AbstractCallTest {
    public function test() {
        $ClientMock = $this->getClientMock($this->onConsecutiveCalls(
            '{"ok":false,"error_code":401,"description":"Error: Unauthorized"}'
            , '{"ok":false,"error_code":400,"description":"Error: Bad Request: user not found"}'
            , '{"ok":false,"error_code":400,"description":"Error: Bad Request: Wrong from_chat_id"}'
            , '{"ok":false,"error_code":400,"description":"Error: Bad Request: message not found"}'
            , '{"ok":true,"result":{"message_id":27,"from":{"id":122334455,"first_name":"alxmslClientBot","username":"alxmslClientBot"},"chat":{"id":123456,"first_name":"Alexey","last_name":"Maslov","username":"alxmsl"},"date":1436245150,"forward_from":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"forward_date":1436244859,"text":"a"}}'
        ));

        try {
            $ClientMock->forwardMessage(1, 2, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(401, $Ex->getCode());
            $this->assertEquals('Error: Unauthorized', $Ex->getMessage());
        }

        try {
            $ClientMock->forwardMessage(1, 2, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: Bad Request: user not found', $Ex->getMessage());
        }

        try {
            $ClientMock->forwardMessage(1, 2, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: Bad Request: Wrong from_chat_id', $Ex->getMessage());
        }

        try {
            $ClientMock->forwardMessage(1, 2, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: Bad Request: message not found', $Ex->getMessage());
        }

        $Result = $ClientMock->forwardMessage(1, 2, '');
        $this->assertInstanceOf(Message::class, $Result);
        $this->assertEquals(27, $Result->getMessageId());
        $this->assertEquals(1436245150, $Result->getDate());
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
        $this->assertInstanceOf(User::class, $Result->getForwardFrom());
        $this->assertEquals(34567, $Result->getForwardFrom()->getId());
        $this->assertEquals('Alexey', $Result->getForwardFrom()->getFirstName());
        $this->assertEquals('Maslov', $Result->getForwardFrom()->getLastName());
        $this->assertEmpty($Result->getForwardFrom()->getUsername());
        $this->assertEquals('a', $Result->getText());
        $this->assertSame(1436244859, $Result->getForwardDate());
    }
}

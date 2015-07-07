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
use alxmsl\Telegram\Bot\Type\Document;
use alxmsl\Telegram\Bot\Type\Message;
use alxmsl\Telegram\Bot\Type\User;

/**
 * Bot API sendDocument method test
 * @author alxmsl
 */
final class SendDocumentTest extends AbstractCallTest {
    public function test() {
        $ClientMock = $this->getClientMock($this->onConsecutiveCalls(
            '{"ok":false,"error_code":401,"description":"Error: Unauthorized"}'
            , '{"ok":false,"error_code":400,"description":"Error: Bad Request: user not found"}'
            , '{"ok":false,"error_code":400,"description":"Error: Bad Request: there is no document in request"}'
            , '{"ok":true,"result":{"message_id":29,"from":{"id":122334455,"first_name":"alxmslClientBot","username":"alxmslClientBot"},"chat":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"date":1436245806,"document":{"file_name":"\u0417\u0430\u0447\u0435\u043c.pdf","mime_type":"application\/pdf","thumb":{},"file_id":"ABCDEFGHIJKLMNOPQRSTUVXYZBBAA","file_size":2421982}}}'
        ));

        try {
            $ClientMock->sendDocument(1, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(401, $Ex->getCode());
            $this->assertEquals('Error: Unauthorized', $Ex->getMessage());
        }

        try {
            $ClientMock->sendDocument(1, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: Bad Request: user not found', $Ex->getMessage());
        }

        try {
            $ClientMock->sendDocument(1, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: Bad Request: there is no document in request', $Ex->getMessage());
        }

        $Result = $ClientMock->sendDocument(1, '');
        $this->assertInstanceOf(Message::class, $Result);
        $this->assertEquals(29, $Result->getMessageId());
        $this->assertEquals(1436245806, $Result->getDate());
        $this->assertInstanceOf(User::class, $Result->getFrom());
        $this->assertEquals(122334455, $Result->getFrom()->getId());
        $this->assertEquals('alxmslClientBot', $Result->getFrom()->getFirstName());
        $this->assertEmpty($Result->getFrom()->getLastName());
        $this->assertEquals('alxmslClientBot', $Result->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $Result->getChat());
        $this->assertEquals(34567, $Result->getChat()->getId());
        $this->assertEquals('Alexey', $Result->getChat()->getFirstName());
        $this->assertEquals('Maslov', $Result->getChat()->getLastName());
        $this->assertEmpty($Result->getChat()->getUsername());
        $this->assertInstanceOf(Document::class, $Result->getDocument());
        $this->assertEquals('Зачем.pdf', $Result->getDocument()->getFileName());
        $this->assertEquals('application/pdf', $Result->getDocument()->getMimeType());
        $this->assertNull($Result->getDocument()->getThumb());
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUVXYZBBAA', $Result->getDocument()->getFileId());
        $this->assertSame(2421982, $Result->getDocument()->getFileSize());
    }
}

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
use alxmsl\Telegram\Bot\Type\PhotoSize;
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
            , '{"ok":true,"result":{"message_id":46,"from":{"id":123456,"first_name":"Alexey","last_name":"Maslov","username":"alxmsl"},"chat":{"id":123456,"first_name":"Alexey","last_name":"Maslov","username":"alxmsl"},"date":1436475020,"document":{"file_name":"WP_20150705_007.jpg","mime_type":"image\/jpeg","thumb":{"file_id":"ABCDEFGHIJKLMNOPQRSTUVXYZBBBB","file_size":1998,"width":60,"height":60},"file_id":"ABCDEFGHIJKLMNOPQRSTUVXYZBBBBoE","file_size":2241139}}}'
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

        $Result1 = $ClientMock->sendDocument(1, '');
        $this->assertInstanceOf(Message::class, $Result1);
        $this->assertEquals(29, $Result1->getMessageId());
        $this->assertEquals(1436245806, $Result1->getDate());
        $this->assertInstanceOf(User::class, $Result1->getFrom());
        $this->assertEquals(122334455, $Result1->getFrom()->getId());
        $this->assertEquals('alxmslClientBot', $Result1->getFrom()->getFirstName());
        $this->assertEmpty($Result1->getFrom()->getLastName());
        $this->assertEquals('alxmslClientBot', $Result1->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $Result1->getChat());
        $this->assertEquals(34567, $Result1->getChat()->getId());
        $this->assertEquals('Alexey', $Result1->getChat()->getFirstName());
        $this->assertEquals('Maslov', $Result1->getChat()->getLastName());
        $this->assertEmpty($Result1->getChat()->getUsername());
        $this->assertInstanceOf(Document::class, $Result1->getDocument());
        $this->assertEquals('Зачем.pdf', $Result1->getDocument()->getFileName());
        $this->assertEquals('application/pdf', $Result1->getDocument()->getMimeType());
        $this->assertNull($Result1->getDocument()->getThumb());
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUVXYZBBAA', $Result1->getDocument()->getFileId());
        $this->assertSame(2421982, $Result1->getDocument()->getFileSize());

        $Result2 = $ClientMock->sendDocument(1, '');
        $this->assertInstanceOf(Message::class, $Result2);
        $this->assertEquals(46, $Result2->getMessageId());
        $this->assertEquals(1436475020, $Result2->getDate());
        $this->assertInstanceOf(User::class, $Result2->getFrom());
        $this->assertEquals(123456, $Result2->getFrom()->getId());
        $this->assertEquals('Alexey', $Result2->getFrom()->getFirstName());
        $this->assertEquals('Maslov', $Result2->getFrom()->getLastName());
        $this->assertEquals('alxmsl', $Result2->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $Result2->getChat());
        $this->assertEquals(123456, $Result2->getChat()->getId());
        $this->assertEquals('Alexey', $Result2->getChat()->getFirstName());
        $this->assertEquals('Maslov', $Result2->getChat()->getLastName());
        $this->assertEquals('alxmsl', $Result2->getChat()->getUsername());
        $this->assertInstanceOf(Document::class, $Result2->getDocument());
        $this->assertEquals('WP_20150705_007.jpg', $Result2->getDocument()->getFileName());
        $this->assertEquals('image/jpeg', $Result2->getDocument()->getMimeType());
        $this->assertInstanceOf(PhotoSize::class, $Result2->getDocument()->getThumb());
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUVXYZBBBB', $Result2->getDocument()->getThumb()->getFileId());
        $this->assertSame(1998, $Result2->getDocument()->getThumb()->getFileSize());
        $this->assertSame(60, $Result2->getDocument()->getThumb()->getHeight());
        $this->assertSame(60, $Result2->getDocument()->getThumb()->getWidth());
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUVXYZBBBBoE', $Result2->getDocument()->getFileId());
        $this->assertSame(2241139, $Result2->getDocument()->getFileSize());
    }
}

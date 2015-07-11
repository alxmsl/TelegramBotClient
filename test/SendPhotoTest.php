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
use alxmsl\Telegram\Bot\Type\ForceReply;
use alxmsl\Telegram\Bot\Type\Message;
use alxmsl\Telegram\Bot\Type\PhotoSize;
use alxmsl\Telegram\Bot\Type\User;

/**
 * Bot API sendPhoto method test
 * @author alxmsl
 */
final class SendPhotoTest extends AbstractCallTest {
    public function test() {
        $ClientMock = $this->getClientMock($this->onConsecutiveCalls(
            '{"ok":false,"error_code":401,"description":"Error: Unauthorized"}'
            , '{"ok":false,"error_code":400,"description":"Error: Bad Request: there is no sticker in request"}'
            , '{"ok":false,"error_code":400,"description":"Error: Bad Request: group chat not found"}'
            , '{"ok":true,"result":{"message_id":11,"from":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"chat":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"date":1436211814,"photo":[{"file_id":"ABCDEFGHIJKLMNOPQRSTUV12345","file_size":1105,"width":67,"height":90},{"file_id":"ABCDEFGHIJKLMNOPQRSTUV123456","file_size":13517,"width":239,"height":320},{"file_id":"ABCDEFGHIJKLMNOPQRSTUV123457","file_size":64033,"width":597,"height":800},{"file_id":"ABCDEFGHIJKLMNOPQRSTUV123458","file_size":124021,"width":956,"height":1280}]}}'
        ));

        try {
            $ClientMock->sendPhoto(1, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(401, $Ex->getCode());
            $this->assertEquals('Error: Unauthorized', $Ex->getMessage());
        }

        try {
            $ClientMock->sendPhotoByFileId(1, '', '', 17);
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: Bad Request: there is no sticker in request', $Ex->getMessage());
        }

        try {
            $ClientMock->sendPhotoFile(1, __FILE__, 'some caption', 17, new ForceReply());
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: Bad Request: group chat not found', $Ex->getMessage());
        }

        $Result = $ClientMock->sendPhoto(1, '');
        $this->assertInstanceOf(Message::class, $Result);
        $this->assertEquals(11, $Result->getMessageId());
        $this->assertEquals(1436211814, $Result->getDate());
        $this->assertInstanceOf(User::class, $Result->getFrom());
        $this->assertEquals(34567, $Result->getFrom()->getId());
        $this->assertEquals('Alexey', $Result->getFrom()->getFirstName());
        $this->assertEquals('Maslov', $Result->getFrom()->getLastName());
        $this->assertEmpty($Result->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $Result->getChat());
        $this->assertEquals(34567, $Result->getChat()->getId());
        $this->assertEquals('Alexey', $Result->getChat()->getFirstName());
        $this->assertEquals('Maslov', $Result->getChat()->getLastName());
        $this->assertEmpty($Result->getChat()->getUsername());
        $this->assertCount(4, $Result->getPhoto());
        $this->assertInstanceOf(PhotoSize::class, $Result->getPhoto()[0]);
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUV12345', $Result->getPhoto()[0]->getFileId());
        $this->assertSame(1105, $Result->getPhoto()[0]->getFileSize());
        $this->assertSame(67, $Result->getPhoto()[0]->getWidth());
        $this->assertSame(90, $Result->getPhoto()[0]->getHeight());
        $this->assertInstanceOf(PhotoSize::class, $Result->getPhoto()[1]);
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUV123456', $Result->getPhoto()[1]->getFileId());
        $this->assertSame(13517, $Result->getPhoto()[1]->getFileSize());
        $this->assertSame(239, $Result->getPhoto()[1]->getWidth());
        $this->assertSame(320, $Result->getPhoto()[1]->getHeight());
        $this->assertInstanceOf(PhotoSize::class, $Result->getPhoto()[2]);
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUV123457', $Result->getPhoto()[2]->getFileId());
        $this->assertSame(64033, $Result->getPhoto()[2]->getFileSize());
        $this->assertSame(597, $Result->getPhoto()[2]->getWidth());
        $this->assertSame(800, $Result->getPhoto()[2]->getHeight());
        $this->assertInstanceOf(PhotoSize::class, $Result->getPhoto()[3]);
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUV123458', $Result->getPhoto()[3]->getFileId());
        $this->assertSame(124021, $Result->getPhoto()[3]->getFileSize());
        $this->assertSame(956, $Result->getPhoto()[3]->getWidth());
        $this->assertSame(1280, $Result->getPhoto()[3]->getHeight());
    }
}

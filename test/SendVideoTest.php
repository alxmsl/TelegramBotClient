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
use alxmsl\Telegram\Bot\Type\PhotoSize;
use alxmsl\Telegram\Bot\Type\User;
use alxmsl\Telegram\Bot\Type\Video;

/**
 * Bot API sendVideo method test
 * @author alxmsl
 */
final class SendVideoTest extends AbstractCallTest {
    public function test() {
        $ClientMock = $this->getClientMock($this->onConsecutiveCalls(
            '{"ok":false,"error_code":401,"description":"Error: Unauthorized"}'
            , '{"ok":false,"error_code":400,"description":"Error: Bad Request: there is no video in request"}'
            , '{"ok":false,"error_code":400,"description":"Error: PEER_ID_INVALID"}'
            , '{"ok":false,"error_code":400,"description":"Error: Bad Request: user not found"}'
            , '{"ok":false,"error_code":400,"description":"Error: Bad Request: Wrong persistent file_id specified: can\'t unserialize it. Wrong last symbol"}'
            , '{"ok":false,"error_code":400,"description":"Error: Bad Request: Type of file to send mismatch"}'
            , '{"ok":true,"result":{"message_id":33,"from":{"id":122334455,"first_name":"alxmslClientBot","username":"alxmslClientBot"},"chat":{"id":123456,"first_name":"Alexey","last_name":"Maslov","username":"alxmsl"},"date":1436257015,"video":{"duration":39,"caption":"","width":360,"height":640,"thumb":{"file_id":"AAQCTHUMB","file_size":2521,"width":49,"height":90},"file_id":"AAQC-FULL","file_size":4204035}}}'
            , '{"ok":true,"result":{"message_id":34,"from":{"id":122334455,"first_name":"alxmslClientBot","username":"alxmslClientBot"},"chat":{"id":123456,"first_name":"Alexey","last_name":"Maslov","username":"alxmsl"},"date":1436257020,"video":{"duration":39,"caption":"","mime_type":"video\/mp4","width":360,"height":640,"thumb":{"file_id":"AAQCTHUMB","file_size":2521,"width":49,"height":90},"file_id":"AAQC-FULL","file_size":4204035}}}'
        ));

        try {
            $ClientMock->sendVideo(1, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(401, $Ex->getCode());
            $this->assertEquals('Error: Unauthorized', $Ex->getMessage());
        }

        try {
            $ClientMock->sendVideo(1, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: Bad Request: there is no video in request', $Ex->getMessage());
        }

        try {
            $ClientMock->sendVideo(1, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: PEER_ID_INVALID', $Ex->getMessage());
        }

        try {
            $ClientMock->sendVideo(1, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: Bad Request: user not found', $Ex->getMessage());
        }

        try {
            $ClientMock->sendVideo(1, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: Bad Request: Wrong persistent file_id specified: can\'t unserialize it. Wrong last symbol', $Ex->getMessage());
        }

        try {
            $ClientMock->sendVideo(1, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: Bad Request: Type of file to send mismatch', $Ex->getMessage());
        }

        $Result1 = $ClientMock->sendVideo(1, '');
        $this->assertInstanceOf(Message::class, $Result1);
        $this->assertEquals(33, $Result1->getMessageId());
        $this->assertEquals(1436257015, $Result1->getDate());
        $this->assertInstanceOf(User::class, $Result1->getFrom());
        $this->assertEquals(122334455, $Result1->getFrom()->getId());
        $this->assertEquals('alxmslClientBot', $Result1->getFrom()->getFirstName());
        $this->assertEmpty($Result1->getFrom()->getLastName());
        $this->assertEquals('alxmslClientBot', $Result1->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $Result1->getChat());
        $this->assertEquals(123456, $Result1->getChat()->getId());
        $this->assertEquals('Alexey', $Result1->getChat()->getFirstName());
        $this->assertEquals('Maslov', $Result1->getChat()->getLastName());
        $this->assertEquals('alxmsl', $Result1->getChat()->getUsername());
        $this->assertInstanceOf(Video::class, $Result1->getVideo());
        $this->assertSame(39, $Result1->getVideo()->getDuration());
        $this->assertEmpty($Result1->getVideo()->getCaption());
        $this->assertSame(360, $Result1->getVideo()->getWidth());
        $this->assertSame(640, $Result1->getVideo()->getHeight());
        $this->assertEquals('AAQC-FULL', $Result1->getVideo()->getFileId());
        $this->assertSame(4204035, $Result1->getVideo()->getFileSize());
        $this->assertEmpty($Result1->getVideo()->getMimeType());
        $this->assertInstanceOf(PhotoSize::class, $Result1->getVideo()->getThumb());
        $this->assertEquals('AAQCTHUMB', $Result1->getVideo()->getThumb()->getFileId());
        $this->assertSame(2521, $Result1->getVideo()->getThumb()->getFileSize());
        $this->assertSame(49, $Result1->getVideo()->getThumb()->getWidth());
        $this->assertSame(90, $Result1->getVideo()->getThumb()->getHeight());

        $Result2 = $ClientMock->sendVideo(1, '');
        $this->assertInstanceOf(Message::class, $Result2);
        $this->assertEquals(34, $Result2->getMessageId());
        $this->assertEquals(1436257020, $Result2->getDate());
        $this->assertInstanceOf(User::class, $Result2->getFrom());
        $this->assertEquals(122334455, $Result2->getFrom()->getId());
        $this->assertEquals('alxmslClientBot', $Result2->getFrom()->getFirstName());
        $this->assertEmpty($Result2->getFrom()->getLastName());
        $this->assertEquals('alxmslClientBot', $Result2->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $Result2->getChat());
        $this->assertEquals(123456, $Result2->getChat()->getId());
        $this->assertEquals('Alexey', $Result2->getChat()->getFirstName());
        $this->assertEquals('Maslov', $Result2->getChat()->getLastName());
        $this->assertEquals('alxmsl', $Result2->getChat()->getUsername());
        $this->assertInstanceOf(Video::class, $Result2->getVideo());
        $this->assertSame(39, $Result2->getVideo()->getDuration());
        $this->assertEmpty($Result2->getVideo()->getCaption());
        $this->assertSame(360, $Result2->getVideo()->getWidth());
        $this->assertSame(640, $Result2->getVideo()->getHeight());
        $this->assertEquals('AAQC-FULL', $Result2->getVideo()->getFileId());
        $this->assertSame(4204035, $Result2->getVideo()->getFileSize());
        $this->assertEquals('video/mp4', $Result2->getVideo()->getMimeType());
        $this->assertInstanceOf(PhotoSize::class, $Result2->getVideo()->getThumb());
        $this->assertEquals('AAQCTHUMB', $Result2->getVideo()->getThumb()->getFileId());
        $this->assertSame(2521, $Result2->getVideo()->getThumb()->getFileSize());
        $this->assertSame(49, $Result2->getVideo()->getThumb()->getWidth());
        $this->assertSame(90, $Result2->getVideo()->getThumb()->getHeight());
    }
}

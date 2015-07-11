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
use alxmsl\Telegram\Bot\Type\ReplyKeyboardHide;
use alxmsl\Telegram\Bot\Type\User;
use alxmsl\Telegram\Bot\Type\Sticker;
use alxmsl\Telegram\Bot\Type\PhotoSize;

/**
 * Bot API sendSticker method test
 * @author alxmsl
 */
final class SendStickerTest extends AbstractCallTest {
    public function test() {
        $ClientMock = $this->getClientMock($this->onConsecutiveCalls(
            '{"ok":false,"error_code":401,"description":"Error: Unauthorized"}'
            , '{"ok":false,"error_code":400,"description":"Error: Bad Request: there is no sticker in request"}'
            , '{"ok":false,"error_code":400,"description":"Error: Bad Request: group chat not found"}'
            , '{"ok":true,"result":{"message_id":32,"from":{"id":122334455,"first_name":"alxmslClientBot","username":"alxmslClientBot"},"chat":{"id":123456,"first_name":"Alexey","last_name":"Maslov","username":"alxmsl"},"date":1436246317,"sticker":{"width":310,"height":512,"thumb":{"file_id":"ABCDEFGHIJKLMNOPQRSTUVXYZ1","file_size":2282,"width":54,"height":90},"file_id":"ABCDEFGHIJKLMNOPQRSTUVXYZ1-2","file_size":39886}}}'
        ));

        try {
            $ClientMock->sendSticker(1, '');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(401, $Ex->getCode());
            $this->assertEquals('Error: Unauthorized', $Ex->getMessage());
        }

        try {
            $ClientMock->sendStickerByFileId(1, '', 17);
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: Bad Request: there is no sticker in request', $Ex->getMessage());
        }

        try {
            $ClientMock->sendStickerByFileName(1, __FILE__, 8, new ReplyKeyboardHide());
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: Bad Request: group chat not found', $Ex->getMessage());
        }

        $Result = $ClientMock->sendSticker(1, '');
        $this->assertInstanceOf(Message::class, $Result);
        $this->assertEquals(32, $Result->getMessageId());
        $this->assertEquals(1436246317, $Result->getDate());
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
        $this->assertInstanceOf(Sticker::class, $Result->getSticker());
        $this->assertSame(310, $Result->getSticker()->getWidth());
        $this->assertSame(512, $Result->getSticker()->getHeight());
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUVXYZ1-2', $Result->getSticker()->getFileId());
        $this->assertEquals(39886, $Result->getSticker()->getFileSize());
        $this->assertInstanceOf(PhotoSize::class, $Result->getSticker()->getThumb());
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUVXYZ1', $Result->getSticker()->getThumb()->getFileId());
        $this->assertSame(2282, $Result->getSticker()->getThumb()->getFileSize());
        $this->assertSame(54, $Result->getSticker()->getThumb()->getWidth());
        $this->assertSame(90, $Result->getSticker()->getThumb()->getHeight());
    }
}

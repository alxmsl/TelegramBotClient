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
use alxmsl\Telegram\Bot\Type\Contact;
use alxmsl\Telegram\Bot\Type\Document;
use alxmsl\Telegram\Bot\Type\Location;
use alxmsl\Telegram\Bot\Type\Message;
use alxmsl\Telegram\Bot\Type\PhotoSize;
use alxmsl\Telegram\Bot\Type\Sticker;
use alxmsl\Telegram\Bot\Type\User;
use alxmsl\Telegram\Bot\Type\Video;

/**
 * Telegram Bot API Client test class
 * @author alxmsl
 */
final class GetUpdatesTest extends AbstractCallTest {
    public function test() {
        $ClientMock = $this->getClientMock($this->onConsecutiveCalls(
            '{"ok":false,"error_code":401,"description":"Error: Unauthorized"}'
            , '{"ok":true,"result":[]}'
            , '{"ok":true,"result":[{"update_id":765432187,"message":{"message_id":2,"from":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"chat":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"date":1435870467,"text":"\/start"}}]}'
            , '{"ok":true,"result":[{"update_id":765432188,
"message":{"message_id":9,"from":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"chat":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"date":1436211739,"text":"\/Start"}},{"update_id":765432189,
"message":{"message_id":10,"from":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"chat":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"date":1436211761,"text":"Hello"}},{"update_id":765432190,
"message":{"message_id":11,"from":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"chat":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"date":1436211814,"photo":[{"file_id":"ABCDEFGHIJKLMNOPQRSTUV12345","file_size":1105,"width":67,"height":90},{"file_id":"ABCDEFGHIJKLMNOPQRSTUV123456","file_size":13517,"width":239,"height":320},{"file_id":"ABCDEFGHIJKLMNOPQRSTUV123457","file_size":64033,"width":597,"height":800},{"file_id":"ABCDEFGHIJKLMNOPQRSTUV123458","file_size":124021,"width":956,"height":1280}]}},{"update_id":765432191,
"message":{"message_id":12,"from":{"id":123456,"first_name":"Alexey","last_name":"Maslov","username":"alxmsl"},"chat":{"id":123456,"first_name":"Alexey","last_name":"Maslov","username":"alxmsl"},"date":1436212006,"text":"\/startttt"}},{"update_id":765432192,
"message":{"message_id":13,"from":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"chat":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"date":1436212131,"video":{"duration":39,"caption":"","width":360,"height":640,"thumb":{"file_id":"ABCDEFGHIJKLMNOPQRSTUV678900","file_size":2521,"width":49,"height":90},"file_id":"ABCDEFGHIJKLMNOPQRSTUV678901-1","file_size":4204035}}},{"update_id":765432193,
"message":{"message_id":14,"from":{"id":123456,"first_name":"Alexey","last_name":"Maslov","username":"alxmsl"},"chat":{"id":123456,"first_name":"Alexey","last_name":"Maslov","username":"alxmsl"},"date":1436212191,"location":{"longitude":30.330694,"latitude":59.934798}}},{"update_id":765432194,
"message":{"message_id":15,"from":{"id":123456,"first_name":"Alexey","last_name":"Maslov","username":"alxmsl"},"chat":{"id":123456,"first_name":"Alexey","last_name":"Maslov","username":"alxmsl"},"date":1436212221,"contact":{"phone_number":"111","first_name":"09 \u041c\u043e\u0431.","last_name":"\u041f\u043e\u0440\u0442\u0430\u043b"}}},{"update_id":765432195,
"message":{"message_id":16,"from":{"id":123456,"first_name":"Alexey","last_name":"Maslov","username":"alxmsl"},"chat":{"id":123456,"first_name":"Alexey","last_name":"Maslov","username":"alxmsl"},"date":1436212247,"text":"\ud83c\udfe9"}},{"update_id":765432196,
"message":{"message_id":17,"from":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"chat":{"id":34567,"first_name":"Alexey","last_name":"Maslov"},"date":1436212283,"sticker":{"width":310,"height":512,"thumb":{"file_id":"ABCDEFGHIJKLMNOPQRSTUVXYZ1","file_size":2282,"width":54,"height":90},"file_id":"ABCDEFGHIJKLMNOPQRSTUVXYZ1-2","file_size":39886}}},{"update_id":765432197,
"message":{"message_id":18,"from":{"id":123456,"first_name":"Alexey","last_name":"Maslov","username":"alxmsl"},"chat":{"id":123456,"first_name":"Alexey","last_name":"Maslov","username":"alxmsl"},"date":1436212408,"document":{"file_name":"\u0417\u0430\u0447\u0435\u043c.pdf","mime_type":"application\/pdf","thumb":{},"file_id":"ABCDEFGHIJKLMNOPQRSTUVXYZBBAA","file_size":2421982}}}]}'
        ));

        try {
            $ClientMock->getUpdates();
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(401, $Ex->getCode());
            $this->assertEquals('Error: Unauthorized', $Ex->getMessage());
        }

        $emptyUpdates = $ClientMock->getUpdates();
        $this->assertSame([], $emptyUpdates);
        $this->assertCount(0, $emptyUpdates);

        $oneUpdates = $ClientMock->getUpdates();
        $this->assertCount(1, $oneUpdates);
        $this->assertEquals(765432187, $oneUpdates[0]->getUpdateId());
        $this->assertInstanceOf(Message::class, $oneUpdates[0]->getMessage());
        $this->assertEquals(2, $oneUpdates[0]->getMessage()->getMessageId());
        $this->assertEquals(1435870467, $oneUpdates[0]->getMessage()->getDate());
        $this->assertEquals('/start', $oneUpdates[0]->getMessage()->getText());
        $this->assertInstanceOf(User::class, $oneUpdates[0]->getMessage()->getFrom());
        $this->assertEquals(34567, $oneUpdates[0]->getMessage()->getFrom()->getId());
        $this->assertEquals('Alexey', $oneUpdates[0]->getMessage()->getFrom()->getFirstName());
        $this->assertEquals('Maslov', $oneUpdates[0]->getMessage()->getFrom()->getLastName());
        $this->assertEmpty($oneUpdates[0]->getMessage()->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $oneUpdates[0]->getMessage()->getChat());
        $this->assertEquals(34567, $oneUpdates[0]->getMessage()->getChat()->getId());
        $this->assertEquals('Alexey', $oneUpdates[0]->getMessage()->getChat()->getFirstName());
        $this->assertEquals('Maslov', $oneUpdates[0]->getMessage()->getChat()->getLastName());
        $this->assertEmpty($oneUpdates[0]->getMessage()->getChat()->getUsername());


        $allUpdates = $ClientMock->getUpdates();
        $this->assertCount(10, $allUpdates);

        // command text
        $this->assertEquals(765432188, $allUpdates[0]->getUpdateId());
        $this->assertInstanceOf(Message::class, $allUpdates[0]->getMessage());
        $this->assertEquals(9, $allUpdates[0]->getMessage()->getMessageId());
        $this->assertEquals(1436211739, $allUpdates[0]->getMessage()->getDate());
        $this->assertEquals('/Start', $allUpdates[0]->getMessage()->getText());
        $this->assertInstanceOf(User::class, $allUpdates[0]->getMessage()->getFrom());
        $this->assertEquals(34567, $allUpdates[0]->getMessage()->getFrom()->getId());
        $this->assertEquals('Alexey', $allUpdates[0]->getMessage()->getFrom()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[0]->getMessage()->getFrom()->getLastName());
        $this->assertEmpty($allUpdates[0]->getMessage()->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $allUpdates[0]->getMessage()->getChat());
        $this->assertEquals(34567, $allUpdates[0]->getMessage()->getChat()->getId());
        $this->assertEquals('Alexey', $allUpdates[0]->getMessage()->getChat()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[0]->getMessage()->getChat()->getLastName());
        $this->assertEmpty($allUpdates[0]->getMessage()->getChat()->getUsername());

        // text
        $this->assertEquals(765432189, $allUpdates[1]->getUpdateId());
        $this->assertInstanceOf(Message::class, $allUpdates[1]->getMessage());
        $this->assertEquals(10, $allUpdates[1]->getMessage()->getMessageId());
        $this->assertEquals(1436211761, $allUpdates[1]->getMessage()->getDate());
        $this->assertEquals('Hello', $allUpdates[1]->getMessage()->getText());
        $this->assertInstanceOf(User::class, $allUpdates[1]->getMessage()->getFrom());
        $this->assertEquals(34567, $allUpdates[1]->getMessage()->getFrom()->getId());
        $this->assertEquals('Alexey', $allUpdates[1]->getMessage()->getFrom()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[1]->getMessage()->getFrom()->getLastName());
        $this->assertEmpty($allUpdates[1]->getMessage()->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $allUpdates[1]->getMessage()->getChat());
        $this->assertEquals(34567, $allUpdates[1]->getMessage()->getChat()->getId());
        $this->assertEquals('Alexey', $allUpdates[1]->getMessage()->getChat()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[1]->getMessage()->getChat()->getLastName());
        $this->assertEmpty($allUpdates[1]->getMessage()->getChat()->getUsername());

        // photo
        $this->assertEquals(765432190, $allUpdates[2]->getUpdateId());
        $this->assertInstanceOf(Message::class, $allUpdates[2]->getMessage());
        $this->assertEquals(11, $allUpdates[2]->getMessage()->getMessageId());
        $this->assertEquals(1436211814, $allUpdates[2]->getMessage()->getDate());
        $this->assertInstanceOf(User::class, $allUpdates[2]->getMessage()->getFrom());
        $this->assertEquals(34567, $allUpdates[2]->getMessage()->getFrom()->getId());
        $this->assertEquals('Alexey', $allUpdates[2]->getMessage()->getFrom()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[2]->getMessage()->getFrom()->getLastName());
        $this->assertEmpty($allUpdates[2]->getMessage()->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $allUpdates[2]->getMessage()->getChat());
        $this->assertEquals(34567, $allUpdates[2]->getMessage()->getChat()->getId());
        $this->assertEquals('Alexey', $allUpdates[2]->getMessage()->getChat()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[2]->getMessage()->getChat()->getLastName());
        $this->assertEmpty($allUpdates[2]->getMessage()->getChat()->getUsername());
        $this->assertCount(4, $allUpdates[2]->getMessage()->getPhoto());
        $this->assertInstanceOf(PhotoSize::class, $allUpdates[2]->getMessage()->getPhoto()[0]);
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUV12345', $allUpdates[2]->getMessage()->getPhoto()[0]->getFileId());
        $this->assertSame(1105, $allUpdates[2]->getMessage()->getPhoto()[0]->getFileSize());
        $this->assertSame(67, $allUpdates[2]->getMessage()->getPhoto()[0]->getWidth());
        $this->assertSame(90, $allUpdates[2]->getMessage()->getPhoto()[0]->getHeight());
        $this->assertInstanceOf(PhotoSize::class, $allUpdates[2]->getMessage()->getPhoto()[1]);
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUV123456', $allUpdates[2]->getMessage()->getPhoto()[1]->getFileId());
        $this->assertSame(13517, $allUpdates[2]->getMessage()->getPhoto()[1]->getFileSize());
        $this->assertSame(239, $allUpdates[2]->getMessage()->getPhoto()[1]->getWidth());
        $this->assertSame(320, $allUpdates[2]->getMessage()->getPhoto()[1]->getHeight());
        $this->assertInstanceOf(PhotoSize::class, $allUpdates[2]->getMessage()->getPhoto()[2]);
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUV123457', $allUpdates[2]->getMessage()->getPhoto()[2]->getFileId());
        $this->assertSame(64033, $allUpdates[2]->getMessage()->getPhoto()[2]->getFileSize());
        $this->assertSame(597, $allUpdates[2]->getMessage()->getPhoto()[2]->getWidth());
        $this->assertSame(800, $allUpdates[2]->getMessage()->getPhoto()[2]->getHeight());
        $this->assertInstanceOf(PhotoSize::class, $allUpdates[2]->getMessage()->getPhoto()[3]);
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUV123458', $allUpdates[2]->getMessage()->getPhoto()[3]->getFileId());
        $this->assertSame(124021, $allUpdates[2]->getMessage()->getPhoto()[3]->getFileSize());
        $this->assertSame(956, $allUpdates[2]->getMessage()->getPhoto()[3]->getWidth());
        $this->assertSame(1280, $allUpdates[2]->getMessage()->getPhoto()[3]->getHeight());

        // text
        $this->assertEquals(765432191, $allUpdates[3]->getUpdateId());
        $this->assertInstanceOf(Message::class, $allUpdates[3]->getMessage());
        $this->assertEquals(12, $allUpdates[3]->getMessage()->getMessageId());
        $this->assertEquals(1436212006, $allUpdates[3]->getMessage()->getDate());
        $this->assertEquals('/startttt', $allUpdates[3]->getMessage()->getText());
        $this->assertInstanceOf(User::class, $allUpdates[3]->getMessage()->getFrom());
        $this->assertEquals(123456, $allUpdates[3]->getMessage()->getFrom()->getId());
        $this->assertEquals('Alexey', $allUpdates[3]->getMessage()->getFrom()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[3]->getMessage()->getFrom()->getLastName());
        $this->assertEquals('alxmsl', $allUpdates[3]->getMessage()->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $allUpdates[3]->getMessage()->getChat());
        $this->assertEquals(123456, $allUpdates[3]->getMessage()->getChat()->getId());
        $this->assertEquals('Alexey', $allUpdates[3]->getMessage()->getChat()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[3]->getMessage()->getChat()->getLastName());
        $this->assertEquals('alxmsl', $allUpdates[3]->getMessage()->getChat()->getUsername());

        // video
        $this->assertEquals(765432192, $allUpdates[4]->getUpdateId());
        $this->assertInstanceOf(Message::class, $allUpdates[4]->getMessage());
        $this->assertEquals(13, $allUpdates[4]->getMessage()->getMessageId());
        $this->assertEquals(1436212131, $allUpdates[4]->getMessage()->getDate());
        $this->assertInstanceOf(User::class, $allUpdates[4]->getMessage()->getFrom());
        $this->assertEquals(34567, $allUpdates[4]->getMessage()->getFrom()->getId());
        $this->assertEquals('Alexey', $allUpdates[4]->getMessage()->getFrom()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[4]->getMessage()->getFrom()->getLastName());
        $this->assertEmpty($allUpdates[4]->getMessage()->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $allUpdates[4]->getMessage()->getChat());
        $this->assertEquals(34567, $allUpdates[4]->getMessage()->getChat()->getId());
        $this->assertEquals('Alexey', $allUpdates[4]->getMessage()->getChat()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[4]->getMessage()->getChat()->getLastName());
        $this->assertEmpty($allUpdates[4]->getMessage()->getChat()->getUsername());
        $this->assertInstanceOf(Video::class, $allUpdates[4]->getMessage()->getVideo());
        $this->assertSame(39, $allUpdates[4]->getMessage()->getVideo()->getDuration());
        $this->assertEmpty($allUpdates[4]->getMessage()->getVideo()->getCaption());
        $this->assertSame(360, $allUpdates[4]->getMessage()->getVideo()->getWidth());
        $this->assertSame(640, $allUpdates[4]->getMessage()->getVideo()->getHeight());
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUV678901-1', $allUpdates[4]->getMessage()->getVideo()->getFileId());
        $this->assertSame(4204035, $allUpdates[4]->getMessage()->getVideo()->getFileSize());
        $this->assertInstanceOf(PhotoSize::class, $allUpdates[4]->getMessage()->getVideo()->getThumb());
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUV678900', $allUpdates[4]->getMessage()->getVideo()->getThumb()->getFileId());
        $this->assertSame(2521, $allUpdates[4]->getMessage()->getVideo()->getThumb()->getFileSize());
        $this->assertSame(49, $allUpdates[4]->getMessage()->getVideo()->getThumb()->getWidth());
        $this->assertSame(90, $allUpdates[4]->getMessage()->getVideo()->getThumb()->getHeight());
        
        // location        
        $this->assertEquals(765432193, $allUpdates[5]->getUpdateId());
        $this->assertInstanceOf(Message::class, $allUpdates[5]->getMessage());
        $this->assertEquals(14, $allUpdates[5]->getMessage()->getMessageId());
        $this->assertEquals(1436212191, $allUpdates[5]->getMessage()->getDate());
        $this->assertInstanceOf(User::class, $allUpdates[5]->getMessage()->getFrom());
        $this->assertEquals(123456, $allUpdates[5]->getMessage()->getFrom()->getId());
        $this->assertEquals('Alexey', $allUpdates[5]->getMessage()->getFrom()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[5]->getMessage()->getFrom()->getLastName());
        $this->assertEquals('alxmsl', $allUpdates[5]->getMessage()->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $allUpdates[5]->getMessage()->getChat());
        $this->assertEquals(123456, $allUpdates[5]->getMessage()->getChat()->getId());
        $this->assertEquals('Alexey', $allUpdates[5]->getMessage()->getChat()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[5]->getMessage()->getChat()->getLastName());
        $this->assertEquals('alxmsl', $allUpdates[5]->getMessage()->getChat()->getUsername());
        $this->assertInstanceOf(Location::class, $allUpdates[5]->getMessage()->getLocation());
        $this->assertSame(30.330694, $allUpdates[5]->getMessage()->getLocation()->getLongitude());
        $this->assertSame(59.934798, $allUpdates[5]->getMessage()->getLocation()->getLatitude());
        
        // contact
        $this->assertEquals(765432194, $allUpdates[6]->getUpdateId());
        $this->assertInstanceOf(Message::class, $allUpdates[6]->getMessage());
        $this->assertEquals(15, $allUpdates[6]->getMessage()->getMessageId());
        $this->assertEquals(1436212221, $allUpdates[6]->getMessage()->getDate());
        $this->assertInstanceOf(User::class, $allUpdates[6]->getMessage()->getFrom());
        $this->assertEquals(123456, $allUpdates[6]->getMessage()->getFrom()->getId());
        $this->assertEquals('Alexey', $allUpdates[6]->getMessage()->getFrom()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[6]->getMessage()->getFrom()->getLastName());
        $this->assertEquals('alxmsl', $allUpdates[6]->getMessage()->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $allUpdates[6]->getMessage()->getChat());
        $this->assertEquals(123456, $allUpdates[6]->getMessage()->getChat()->getId());
        $this->assertEquals('Alexey', $allUpdates[6]->getMessage()->getChat()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[6]->getMessage()->getChat()->getLastName());
        $this->assertEquals('alxmsl', $allUpdates[6]->getMessage()->getChat()->getUsername());
        $this->assertInstanceOf(Contact::class, $allUpdates[6]->getMessage()->getContact());
        $this->assertEquals('111', $allUpdates[6]->getMessage()->getContact()->getPhoneNumber());
        $this->assertEquals('09 Моб.', $allUpdates[6]->getMessage()->getContact()->getFirstName());
        $this->assertEquals('Портал', $allUpdates[6]->getMessage()->getContact()->getLastName());

        // emoji
        $this->assertEquals(765432195, $allUpdates[7]->getUpdateId());
        $this->assertInstanceOf(Message::class, $allUpdates[7]->getMessage());
        $this->assertEquals(16, $allUpdates[7]->getMessage()->getMessageId());
        $this->assertEquals(1436212247, $allUpdates[7]->getMessage()->getDate());
        $this->assertEquals('🏩', $allUpdates[7]->getMessage()->getText());
        $this->assertInstanceOf(User::class, $allUpdates[7]->getMessage()->getFrom());
        $this->assertEquals(123456, $allUpdates[7]->getMessage()->getFrom()->getId());
        $this->assertEquals('Alexey', $allUpdates[7]->getMessage()->getFrom()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[7]->getMessage()->getFrom()->getLastName());
        $this->assertEquals('alxmsl', $allUpdates[7]->getMessage()->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $allUpdates[7]->getMessage()->getChat());
        $this->assertEquals(123456, $allUpdates[7]->getMessage()->getChat()->getId());
        $this->assertEquals('Alexey', $allUpdates[7]->getMessage()->getChat()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[7]->getMessage()->getChat()->getLastName());
        $this->assertEquals('alxmsl', $allUpdates[7]->getMessage()->getChat()->getUsername());

        // sticker
        $this->assertEquals(765432196, $allUpdates[8]->getUpdateId());
        $this->assertInstanceOf(Message::class, $allUpdates[8]->getMessage());
        $this->assertEquals(17, $allUpdates[8]->getMessage()->getMessageId());
        $this->assertEquals(1436212283, $allUpdates[8]->getMessage()->getDate());
        $this->assertInstanceOf(User::class, $allUpdates[8]->getMessage()->getFrom());
        $this->assertEquals(34567, $allUpdates[8]->getMessage()->getFrom()->getId());
        $this->assertEquals('Alexey', $allUpdates[8]->getMessage()->getFrom()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[8]->getMessage()->getFrom()->getLastName());
        $this->assertEmpty($allUpdates[8]->getMessage()->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $allUpdates[8]->getMessage()->getChat());
        $this->assertEquals(34567, $allUpdates[8]->getMessage()->getChat()->getId());
        $this->assertEquals('Alexey', $allUpdates[8]->getMessage()->getChat()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[8]->getMessage()->getChat()->getLastName());
        $this->assertEmpty($allUpdates[8]->getMessage()->getChat()->getUsername());
        $this->assertInstanceOf(Sticker::class, $allUpdates[8]->getMessage()->getSticker());
        $this->assertSame(310, $allUpdates[8]->getMessage()->getSticker()->getWidth());
        $this->assertSame(512, $allUpdates[8]->getMessage()->getSticker()->getHeight());
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUVXYZ1-2', $allUpdates[8]->getMessage()->getSticker()->getFileId());
        $this->assertEquals(39886, $allUpdates[8]->getMessage()->getSticker()->getFileSize());
        $this->assertInstanceOf(PhotoSize::class, $allUpdates[8]->getMessage()->getSticker()->getThumb());
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUVXYZ1', $allUpdates[8]->getMessage()->getSticker()->getThumb()->getFileId());
        $this->assertSame(2282, $allUpdates[8]->getMessage()->getSticker()->getThumb()->getFileSize());
        $this->assertSame(54, $allUpdates[8]->getMessage()->getSticker()->getThumb()->getWidth());
        $this->assertSame(90, $allUpdates[8]->getMessage()->getSticker()->getThumb()->getHeight());

        // document
        $this->assertEquals(765432197, $allUpdates[9]->getUpdateId());
        $this->assertInstanceOf(Message::class, $allUpdates[9]->getMessage());
        $this->assertEquals(18, $allUpdates[9]->getMessage()->getMessageId());
        $this->assertEquals(1436212408, $allUpdates[9]->getMessage()->getDate());
        $this->assertInstanceOf(User::class, $allUpdates[9]->getMessage()->getFrom());
        $this->assertEquals(123456, $allUpdates[9]->getMessage()->getFrom()->getId());
        $this->assertEquals('Alexey', $allUpdates[9]->getMessage()->getFrom()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[9]->getMessage()->getFrom()->getLastName());
        $this->assertEquals('alxmsl', $allUpdates[9]->getMessage()->getFrom()->getUsername());
        $this->assertInstanceOf(User::class, $allUpdates[9]->getMessage()->getChat());
        $this->assertEquals(123456, $allUpdates[9]->getMessage()->getChat()->getId());
        $this->assertEquals('Alexey', $allUpdates[9]->getMessage()->getChat()->getFirstName());
        $this->assertEquals('Maslov', $allUpdates[9]->getMessage()->getChat()->getLastName());
        $this->assertEquals('alxmsl', $allUpdates[9]->getMessage()->getChat()->getUsername());
        $this->assertInstanceOf(Document::class, $allUpdates[9]->getMessage()->getDocument());
        $this->assertEquals('Зачем.pdf', $allUpdates[9]->getMessage()->getDocument()->getFileName());
        $this->assertEquals('application/pdf', $allUpdates[9]->getMessage()->getDocument()->getMimeType());
        $this->assertNull($allUpdates[9]->getMessage()->getDocument()->getThumb());
        $this->assertEquals('ABCDEFGHIJKLMNOPQRSTUVXYZBBAA', $allUpdates[9]->getMessage()->getDocument()->getFileId());
        $this->assertSame(2421982, $allUpdates[9]->getMessage()->getDocument()->getFileSize());
    }
}

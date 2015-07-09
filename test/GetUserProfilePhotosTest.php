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
use alxmsl\Telegram\Bot\Type\PhotoSize;
use alxmsl\Telegram\Bot\Type\UserProfilePhotos;

/**
 * Bot API getUserProfilePhotos method test
 * @author alxmsl
 */
final class GetUserProfilePhotosTest extends AbstractCallTest {
    public function test() {
        $ClientMock = $this->getClientMock($this->onConsecutiveCalls(
            '{"ok":false,"error_code":401,"description":"Error: Unauthorized"}'
            , '{"ok":false,"error_code":400,"description":"Error: Bad Request: user not found"}'
            , '{"ok":true,"result":{"total_count":1,"photos":[[{"file_id":"AgADAda-f1","file_size":9678,"width":160,"height":160},{"file_id":"AgADAda-f2","file_size":35454,"width":320,"height":320},{"file_id":"AgADAda-f3","file_size":125096,"width":640,"height":640},{"file_id":"AgADAda-f4","file_size":153422,"width":800,"height":800}]]}}'
        ));

        try {
            $ClientMock->getUserProfilePhotos(1, 0, 1);
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(401, $Ex->getCode());
            $this->assertEquals('Error: Unauthorized', $Ex->getMessage());
        }

        try {
            $ClientMock->getUserProfilePhotos(1);
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(400, $Ex->getCode());
            $this->assertEquals('Error: Bad Request: user not found', $Ex->getMessage());
        }

        $Result = $ClientMock->getUserProfilePhotos(1);
        $this->assertInstanceOf(UserProfilePhotos::class, $Result);
        $this->assertSame(1, $Result->getTotalCount());
        $this->assertCount(1, $Result->getPhotos());
        $this->assertCount(4, $Result->getPhotos()[0]);

        /** @var PhotoSize $Photo */
        $Photo = $Result->getPhotos()[0][0];
        $this->assertInstanceOf(PhotoSize::class, $Photo);
        $this->assertEquals('AgADAda-f1', $Photo->getFileId());
        $this->assertSame(9678, $Photo->getFileSize());
        $this->assertSame(160, $Photo->getWidth());
        $this->assertSame(160, $Photo->getHeight());

        /** @var PhotoSize $Photo */
        $Photo = $Result->getPhotos()[0][1];
        $this->assertInstanceOf(PhotoSize::class, $Photo);
        $this->assertEquals('AgADAda-f2', $Photo->getFileId());
        $this->assertSame(35454, $Photo->getFileSize());
        $this->assertSame(320, $Photo->getWidth());
        $this->assertSame(320, $Photo->getHeight());

        /** @var PhotoSize $Photo */
        $Photo = $Result->getPhotos()[0][2];
        $this->assertInstanceOf(PhotoSize::class, $Photo);
        $this->assertEquals('AgADAda-f3', $Photo->getFileId());
        $this->assertSame(125096, $Photo->getFileSize());
        $this->assertSame(640, $Photo->getWidth());
        $this->assertSame(640, $Photo->getHeight());

        /** @var PhotoSize $Photo */
        $Photo = $Result->getPhotos()[0][3];
        $this->assertInstanceOf(PhotoSize::class, $Photo);
        $this->assertEquals('AgADAda-f4', $Photo->getFileId());
        $this->assertSame(153422, $Photo->getFileSize());
        $this->assertSame(800, $Photo->getWidth());
        $this->assertSame(800, $Photo->getHeight());
    }
}

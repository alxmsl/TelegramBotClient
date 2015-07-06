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
use alxmsl\Telegram\Bot\Type\User;

/**
 * Bot API getMe method test
 * @author alxmsl
 */
final class GetMeTest extends AbstractCallTest {
    public function test() {
        $ClientMock = $this->getClientMock($this->onConsecutiveCalls(
            '{"ok":false,"error_code":401,"description":"Error: Unauthorized"}'
            , '{"ok":true,"result":{"id":123456789,"first_name":"alxmslClientBot","username":"alxmslClientBot"}}'
        ));

        try {
            $ClientMock->getMe();
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(401, $Ex->getCode());
            $this->assertEquals('Error: Unauthorized', $Ex->getMessage());
        }

        $User = $ClientMock->getMe();
        $this->assertInstanceOf(User::class, $User);
        $this->assertSame(123456789, $User->getId());
        $this->assertEquals('alxmslClientBot', $User->getFirstName());
        $this->assertEmpty($User->getLastName());
        $this->assertEquals('alxmslClientBot', $User->getUsername());
    }
}

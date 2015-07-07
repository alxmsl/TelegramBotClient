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

/**
 * Bot API setWebhook method test
 * @author alxmsl
 */
final class SetWebhookTest extends AbstractCallTest {
    public function test() {
        $ClientMock = $this->getClientMock($this->onConsecutiveCalls(
            '{"ok":false,"error_code":401,"description":"Error: Unauthorized"}'
            , '{"ok":true,"result":true,"description":"There is no webhook to delete"}'
            , '{"ok":true,"result":true,"description":"Webhook was set"}'
            , '{"ok":true,"result":true,"description":"Webhook was deleted"}'
        ));

        try {
            $ClientMock->setWebhook('');
            $this->fail();
        } catch (UnsuccessfulException $Ex) {
            $this->assertEquals(401, $Ex->getCode());
            $this->assertEquals('Error: Unauthorized', $Ex->getMessage());
        }

        $this->assertTrue($ClientMock->setWebhook(''));
        $this->assertTrue($ClientMock->setWebhook(''));
        $this->assertTrue($ClientMock->setWebhook(''));
    }
}

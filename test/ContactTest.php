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

use alxmsl\Telegram\Bot\Type\Contact;
use PHPUnit_Framework_TestCase;

/**
 * Test for contact data type
 * @author alxmsl
 */
final class ContactTest extends PHPUnit_Framework_TestCase {
    public function test() {
        $Contact1 = Contact::initializeByObject(json_decode('{"phone_number":"111","first_name":"09 \u041c\u043e\u0431.","last_name":"\u041f\u043e\u0440\u0442\u0430\u043b"}'));
        $this->assertInstanceOf(Contact::class, $Contact1);
        $this->assertEquals('111', $Contact1->getPhoneNumber());
        $this->assertEquals('09 Моб.', $Contact1->getFirstName());
        $this->assertEquals('Портал', $Contact1->getLastName());
        $this->assertEmpty($Contact1->getUserId());

        $Contact2 = Contact::initializeByObject(json_decode('{"phone_number":"111","first_name":"09 \u041c\u043e\u0431.","last_name":"\u041f\u043e\u0440\u0442\u0430\u043b","user_id":12345}'));
        $this->assertInstanceOf(Contact::class, $Contact2);
        $this->assertEquals('111', $Contact2->getPhoneNumber());
        $this->assertEquals('09 Моб.', $Contact2->getFirstName());
        $this->assertEquals('Портал', $Contact2->getLastName());
        $this->assertEquals(12345, $Contact2->getUserId());

        $Contact3 = Contact::initializeByObject(json_decode('{"phone_number":"111"}'));
        $this->assertInstanceOf(Contact::class, $Contact3);
        $this->assertEquals('111', $Contact3->getPhoneNumber());
        $this->assertEmpty($Contact3->getFirstName());
        $this->assertEmpty($Contact3->getLastName());
        $this->assertEmpty($Contact3->getUserId());

        $Contact4 = Contact::initializeByObject(json_decode('{"phone_number":"111","first_name":"09 \u041c\u043e\u0431."}'));
        $this->assertInstanceOf(Contact::class, $Contact4);
        $this->assertEquals('111', $Contact4->getPhoneNumber());
        $this->assertEquals('09 Моб.', $Contact4->getFirstName());
        $this->assertEmpty($Contact4->getLastName());
        $this->assertEmpty($Contact4->getUserId());

        $Contact5 = Contact::initializeByObject(json_decode('{"phone_number":"111","last_name":"\u041f\u043e\u0440\u0442\u0430\u043b"}'));
        $this->assertInstanceOf(Contact::class, $Contact5);
        $this->assertEquals('111', $Contact5->getPhoneNumber());
        $this->assertEmpty($Contact5->getFirstName());
        $this->assertEquals('Портал', $Contact5->getLastName());
        $this->assertEmpty($Contact5->getUserId());
    }
}

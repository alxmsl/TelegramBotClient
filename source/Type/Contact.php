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

namespace alxmsl\Telegram\Bot\Type;

use alxmsl\Telegram\Bot\ObjectInitializedInterface;
use stdClass;

/**
 * Class represents a phone contact
 * @author alxmsl
 */
final class Contact implements ObjectInitializedInterface {
    /**
     * @var string contact's phone number
     */
    private $phoneNumber = '';
    
    /**
     * @param string $phoneNumber contact's phone number
     * @return $this self instance
     */
    private function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = (string) $phoneNumber;
        return $this;
    }
    
    /**
     * @return string contact's phone number
     */
    public function getPhoneNumber() {
        return $this->phoneNumber;
    }
    
    /**
     * @var string Contact's first name
     */
    private $firstName = '';
    
    /**
     * @param string $firstName Contact's first name
     * @return $this self instance
     */
    private function setFirstName($firstName) {
        $this->firstName = (string) $firstName;
        return $this;
    }
    
    /**
     * @return string Contact's first name
     */
    public function getFirstName() {
        return $this->firstName;
    }
    
    /**
     * @var string contact's last name
     */
    private $lastName = '';
    
    /**
     * @param string $lastName contact's last name
     * @return $this self instance
     */
    private function setLastName($lastName) {
        $this->lastName = (string) $lastName;
        return $this;
    }
    
    /**
     * @return string contact's last name
     */
    public function getLastName() {
        return $this->lastName;
    }
    
    /**
     * @var string contact's user identifier in Telegram
     */
    private $userId = '';
    
    /**
     * @param string $userId contact's user identifier in Telegram
     * @return $this self instance
     */
    private function setUserId($userId) {
        $this->userId = (string) $userId;
        return $this;
    }
    
    /**
     * @return string contact's user identifier in Telegram
     */
    public function getUserId() {
        return $this->userId;
    }
    
    /**
     * @inheritdoc
     */
    public static function initializeByObject(stdClass $Object) {
        $Contact = new Contact();
        $Contact->setPhoneNumber($Object->phone_number);
        if (isset($Object->first_name)) {
            $Contact->setFirstName($Object->first_name);
        }
        if (isset($Object->last_name)) {
            $Contact->setLastName($Object->last_name);
        }
        if (isset($Object->user_id)) {
            $Contact->setUserId($Object->user_id);
        }
        return $Contact;
    }
}

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
 * Class represents a Telegram user or bot
 * @author alxmsl
 */
final class User implements ObjectInitializedInterface {
    /**
     * @var int unique identifier for this user or bot
     */
    private $id = 0;
    
    /**
     * @param int $id unique identifier for this user or bot
     * @return $this self instance
     */
    private function setId($id) {
        $this->id = (int) $id;
        return $this;
    }
    
    /**
     * @return int unique identifier for this user or bot
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @var string user‘s or bot’s first name
     */
    private $firstName = '';
    
    /**
     * @param string $firstName user‘s or bot’s first name
     * @return $this self instance
     */
    private function setFirstName($firstName) {
        $this->firstName = (string) $firstName;
        return $this;
    }
    
    /**
     * @return string user‘s or bot’s first name
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @var string user‘s or bot’s last name
     */
    private $lastName = '';
    
    /**
     * @param string $lastName user‘s or bot’s last name
     * @return $this self instance
     */
    private function setLastName($lastName) {
        $this->lastName = (string) $lastName;
        return $this;
    }
    
    /**
     * @return string user‘s or bot’s last name
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @var string user‘s or bot’s username
     */
    private $username = '';
    
    /**
     * @param string $username user‘s or bot’s username
     * @return $this self instance
     */
    private function setUsername($username) {
        $this->username = (string) $username;
        return $this;
    }
    
    /**
     * @return string user‘s or bot’s username
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @inheritdoc
     */
    public static function initializeByObject(stdClass $Object) {
        $User = new self();
        $User->setId($Object->id);
        $User->setFirstName($Object->first_name);
        if (isset($Object->last_name)) {
            $User->setLastName($Object->last_name);
        }
        if (isset($Object->username)) {
            $User->setUsername($Object->username);
        }
        return $User;
    }
}

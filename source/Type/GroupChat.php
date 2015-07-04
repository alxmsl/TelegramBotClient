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
 * Class represents a group chat
 * @author alxmsl
 */
final class GroupChat implements ObjectInitializedInterface {
    /**
     * @var int unique identifier for this group chat
     */
    private $id = 0;
    
    /**
     * @param int $id unique identifier for this group chat
     * @return $this self instance
     */
    private function setId($id) {
        $this->id = (int) $id;
        return $this;
    }
    
    /**
     * @return int unique identifier for this group chat
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @var string group name
     */
    private $title = '';
    
    /**
     * @param string $title group name
     * @return $this self instance
     */
    private function setTitle($title) {
        $this->title = (string) $title;
        return $this;
    }
    
    /**
     * @return string group name
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @inheritdoc
     */
    public static function initializeByObject(stdClass $Object) {
        $GroupChat = new GroupChat();
        $GroupChat->setId($Object->id);
        $GroupChat->setTitle($Object->title);
        return $GroupChat;
    }
}

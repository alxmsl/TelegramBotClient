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

use JsonSerializable;

/**
 * Class for requests client to display a reply interface to the user
 * @author alxmsl
 */
final class ForceReply implements JsonSerializable {
    /**
     * @var bool|null use this parameter if you want to show the keyboard to specific users only
     */
    private $isSelective = null;

    /**
     * @param bool|null $isSelective use this parameter if you want to show the keyboard to specific users only
     */
    public function __construct($isSelective = null) {
        if (!is_null($isSelective)) {
            $this->isSelective = (bool) $isSelective;
        }
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize() {
        $result = [
            'force_reply' => true,
        ];
        if (!is_null($this->isSelective)) {
            $result['selective'] = $this->isSelective;
        }
        return $result;
    }
}

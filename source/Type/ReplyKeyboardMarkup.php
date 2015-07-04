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
 * Class for representation a custom keyboard with reply options
 * @author alxmsl
 */
final class ReplyKeyboardMarkup implements JsonSerializable {
    /**
     * @var string[][] array of button rows
     */
    private $keyboard = [];

    /**
     * @var bool requests clients to resize the keyboard vertically for optimal fit
     */
    private $needResizeKeyboard = false;

    /**
     * @var bool requests clients to hide the keyboard as soon as it's been used
     */
    private $isOnTimeKeyboard = false;

    /**
     * @var bool|null use this parameter if you want to show the keyboard to specific users only
     */
    private $isSelective = null;

    /**
     * @param string[][] $keyboard array of button rows
     * @param bool $needResizeKeyboard requests clients to resize the keyboard vertically for optimal fit
     * @param bool $isOnTimeKeyboard requests clients to hide the keyboard as soon as it's been used
     * @param bool|null $isSelective use this parameter if you want to show the keyboard to specific users only
     */
    public function __construct(array $keyboard, $needResizeKeyboard = false, $isOnTimeKeyboard = false, $isSelective = null) {
        $this->keyboard           = $keyboard;
        $this->needResizeKeyboard = (bool) $needResizeKeyboard;
        $this->isOnTimeKeyboard   = (bool) $isOnTimeKeyboard;
        if (!is_null($isSelective)) {
            $this->isSelective = (bool) $isSelective;
        }
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize() {
        $result = [
            'keyboard'          => $this->keyboard,
            'resize_keyboard'   => $this->needResizeKeyboard,
            'one_time_keyboard' => $this->isOnTimeKeyboard,
        ];
        if (!is_null($this->isSelective)) {
            $result['selective'] = $this->isSelective;
        }
        return $result;
    }
}

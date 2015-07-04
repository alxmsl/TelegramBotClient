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
 * Class represents a sticker
 * @author alxmsl
 */
final class Sticker implements ObjectInitializedInterface {
    /**
     * @var string unique identifier for this file
     */
    private $fileId = '';

    /**
     * @param string $fileId unique identifier for this file
     * @return $this self instance
     */
    private function setFileId($fileId) {
        $this->fileId = (string) $fileId;
        return $this;
    }

    /**
     * @return string unique identifier for this file
     */
    public function getFileId() {
        return $this->fileId;
    }

    /**
     * @var int sticker width
     */
    private $width = 0;

    /**
     * @param int $width sticker width
     * @return $this self instance
     */
    private function setWidth($width) {
        $this->width = (int) $width;
        return $this;
    }

    /**
     * @return int sticker width
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * @var int sticker height
     */
    private $height = 0;

    /**
     * @param int $height sticker height
     * @return $this self instance
     */
    private function setHeight($height) {
        $this->height = (int) $height;
        return $this;
    }

    /**
     * @return int sticker height
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * @var PhotoSize|null sticker thumbnail in .webp or .jpg format
     */
    private $Thumb = null;

    /**
     * @param stdClass $Thumb sticker thumbnail in .webp or .jpg format
     * @return $this self instance
     */
    private function setThumb(stdClass $Thumb) {
        $this->Thumb = PhotoSize::initializeByObject($Thumb);
        return $this;
    }

    /**
     * @return PhotoSize|null sticker thumbnail in .webp or .jpg format
     */
    public function getThumb() {
        return $this->Thumb;
    }

    /**
     * @var int file size
     */
    private $fileSize = 0;

    /**
     * @param int $fileSize file size
     * @return $this self instance
     */
    private function setFileSize($fileSize) {
        $this->fileSize = (int) $fileSize;
        return $this;
    }

    /**
     * @return int file size
     */
    public function getFileSize() {
        return $this->fileSize;
    }

    /**
     * @inheritdoc
     */
    public static function initializeByObject(stdClass $Object) {
        $Sticker = new Sticker();
        $Sticker->setFileId($Object->file_id);
        $Sticker->setWidth($Object->width);
        $Sticker->setHeight($Object->height);
        $Sticker->setThumb($Object->thumb);
        if (isset($Object->file_size)) {
            $Sticker->setFileSize($Object->file_size);
        }
        return $Sticker;
    }
}

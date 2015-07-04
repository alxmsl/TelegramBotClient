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
 * Class represents a video file
 * @author alxmsl
 */
final class Video implements ObjectInitializedInterface {
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
     * @var int video width as defined by sender
     */
    private $width = 0;

    /**
     * @param int $width video width as defined by sender
     * @return $this self instance
     */
    private function setWidth($width) {
        $this->width = (int) $width;
        return $this;
    }

    /**
     * @return int video width as defined by sender
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * @var int video height as defined by sender
     */
    private $height = 0;

    /**
     * @param int $height video height as defined by sender
     * @return $this self instance
     */
    private function setHeight($height) {
        $this->height = (int) $height;
        return $this;
    }

    /**
     * @return int video height as defined by sender
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * @var int duration of the video in seconds as defined by sender
     */
    private $duration = 0;

    /**
     * @param int $duration duration of the video in seconds as defined by sender
     * @return $this self instance
     */
    private function setDuration($duration) {
        $this->duration = (int) $duration;
        return $this;
    }

    /**
     * @return int duration of the video in seconds as defined by sender
     */
    public function getDuration() {
        return $this->duration;
    }

    /**
     * @var PhotoSize|null video thumbnail
     */
    private $Thumb = null;

    /**
     * @param stdClass $Thumb video thumbnail
     * @return $this self instance
     */
    private function setThumb(stdClass $Thumb) {
        $this->Thumb = PhotoSize::initializeByObject($Thumb);
        return $this;
    }

    /**
     * @return PhotoSize|null video thumbnail
     */
    public function getThumb() {
        return $this->Thumb;
    }

    /**
     * @var string MIME type of the file as defined by sender
     */
    private $mimeType = '';

    /**
     * @param string $mimeType MIME type of the file as defined by sender
     * @return $this self instance
     */
    private function setMimeType($mimeType) {
        $this->mimeType = (string) $mimeType;
        return $this;
    }

    /**
     * @return string MIME type of the file as defined by sender
     */
    public function getMimeType() {
        return $this->mimeType;
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
     * @var string text description of the video (usually empty)
     */
    private $caption = '';
    
    /**
     * @param string $caption text description of the video (usually empty)
     * @return $this self instance
     */
    private function setCaption($caption) {
        $this->caption = (string) $caption;
        return $this;
    }
    
    /**
     * @return string text description of the video (usually empty)
     */
    public function getCaption() {
        return $this->caption;
    }
    
    /**
     * @inheritdoc
     */
    public static function initializeByObject(stdClass $Object) {
        $Video = new Video();
        $Video->setFileId($Object->file_id);
        $Video->setWidth($Object->width);
        $Video->setHeight($Object->height);
        $Video->setDuration($Object->duration);
        $Video->setThumb($Object->thumb);
        if (isset($Object->mime_type)) {
            $Video->setMimeType($Object->mime_type);
        }
        if (isset($Object->file_size)) {
            $Video->setFileSize($Object->file_size);
        }
        if (isset($Object->caption)) {
            $Video->setCaption($Object->caption);
        }
        return $Video;
    }
}

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
 * Class represents an audio file (voice note)
 * @author alxmsl
 */
final class Audio implements ObjectInitializedInterface {
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
     * @var int duration of the audio in seconds as defined by sender
     */
    private $duration = 0;
    
    /**
     * @param int $duration duration of the audio in seconds as defined by sender
     * @return $this self instance
     */
    private function setDuration($duration) {
        $this->duration = (int) $duration;
        return $this;
    }
    
    /**
     * @return int duration of the audio in seconds as defined by sender
     */
    public function getDuration() {
        return $this->duration;
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
     * @inheritdoc
     */
    public static function initializeByObject(stdClass $Object) {
        $Audio = new Audio();
        $Audio->setFileId($Object->file_id);
        $Audio->setDuration($Object->duration);
        if (isset($Object->mime_type)) {
            $Audio->setMimeType($Object->mime_type);
        }
        if (isset($Object->file_size)) {
            $Audio->setFileSize($Object->file_size);
        }
        return $Audio;
    }
}

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
 * Class represents a general file
 * @author alxmsl
 */
final class Document implements ObjectInitializedInterface {
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
     * @var PhotoSize|null Document thumbnail as defined by sender
     */
    private $Thumb = null;
    
    /**
     * @param stdClass $Object document data
     * @return $this self instance
     */
    private function trySetThumb(stdClass $Object) {
        if (!empty((array) $Object->thumb)) {
            $this->Thumb = PhotoSize::initializeByObject($Object->thumb);
        }
        return $this;
    }
    
    /**
     * @return PhotoSize|null Document thumbnail as defined by sender
     */
    public function getThumb() {
        return $this->Thumb;
    }
    
    /**
     * @var String original filename as defined by sender
     */
    private $fileName = '';
    
    /**
     * @param stdClass $Object document data
     * @return $this self instance
     */
    private function trySetFileName(stdClass $Object) {
        if (isset($Object->file_name)) {
            $this->fileName = (string) $Object->file_name;
        }
        return $this;
    }
    
    /**
     * @return String original filename as defined by sender
     */
    public function getFileName() {
        return $this->fileName;
    }

    /**
     * @var string MIME type of the file as defined by sender
     */
    private $mimeType = '';

    /**
     * @param stdClass $Object document data
     * @return $this self instance
     */
    private function trySetMimeType(stdClass $Object) {
        if (isset($Object->mime_type)) {
            $this->mimeType = (string) $Object->mime_type;
        }
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
     * @param stdClass $Object document data
     * @return $this self instance
     */
    private function trySetFileSize(stdClass $Object) {
        if (isset($Object->file_size)) {
            $this->fileSize = (int) $Object->file_size;
        }
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
        $Document = new Document();
        $Document->setFileId($Object->file_id)
            ->trySetThumb($Object->thumb)
            ->trySetFileName($Object->file_name)
            ->trySetMimeType($Object->mime_type)
            ->trySetFileSize($Object->file_size);
        return $Document;
    }
}

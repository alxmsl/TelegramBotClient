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
 * Method to get a list of profile pictures for a user
 * @author alxmsl
 */
final class UserProfilePhotos implements ObjectInitializedInterface {
    /**
     * @var int total number of profile pictures
     */
    private $totalCount = 0;

    /**
     * @var PhotoSize[][] requested profile pictures
     */
    private $photos = [];

    /**
     * @return int total number of profile pictures
     */
    public function getTotalCount() {
        return $this->totalCount;
    }

    /**
     * @param int $totalCount total number of profile pictures
     * @return $this self instance
     */
    private function setTotalCount($totalCount) {
        $this->totalCount = (int) $totalCount;
        return $this;
    }

    /**
     * @return PhotoSize[][] requested profile pictures
     */
    public function getPhotos() {
        return $this->photos;
    }

    /**
     * @param stdClass[][] $photos requested profile pictures
     * @return $this self instance
     */
    private function setPhotos($photos) {
        foreach ($photos as $photo) {
            $sizes = [];
            foreach ($photo as $size) {
                $sizes[] = PhotoSize::initializeByObject($size);
            }
            $this->photos[] = $sizes;
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function initializeByObject(stdClass $Object) {
        $Photos = new self();
        $Photos->setTotalCount($Object->total_count);
        $Photos->setPhotos($Object->photos);
        return $Photos;
    }
}

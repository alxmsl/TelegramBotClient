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
 * Class represents a point on the map
 * @author alxmsl
 */
final class Location implements ObjectInitializedInterface {
    /**
     * @var float longitude as defined by sender
     */
    private $longitude = .0;
    
    /**
     * @param float $longitude longitude as defined by sender
     * @return $this self instance
     */
    private function setLongitude($longitude) {
        $this->longitude = (float) $longitude;
        return $this;
    }
    
    /**
     * @return float longitude as defined by sender
     */
    public function getLongitude() {
        return $this->longitude;
    }
    
    /**
     * @var float $latitude as defined by sender
     */
    private $latitude = '';
    
    /**
     * @param float $latitude latitude as defined by sender
     * @return $this self instance
     */
    private function setLatitude($latitude) {
        $this->latitude = (float) $latitude;
        return $this;
    }
    
    /**
     * @return float $latitude as defined by sender
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * @inheritdoc
     */
    public static function initializeByObject(stdClass $Object) {
        $Location = new Location();
        $Location->setLatitude($Object->latitude);
        $Location->setLongitude($Object->longitude);
        return $Location;
    }
}

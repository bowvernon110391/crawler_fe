<?php

namespace App\Traits;

use DateTimeInterface;

/**
 * this trait forces model to use date as is stored in the db
 */
trait StandardDate {
    protected function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }
}

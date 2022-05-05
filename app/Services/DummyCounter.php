<?php

namespace App\Services;

use App\Contracts\CounterContract;

class DummyCounter implements CounterContract
{
    public function increment(String $key, array $tags = null): int
    {
        return 0;
    }
}
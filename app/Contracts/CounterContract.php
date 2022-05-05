<?php

namespace App\Contracts;

interface CounterContract
{
    public function increment(String $key, array $tags = null): int;
}
<?php

namespace App\Model;

class Id
{
    public function __construct(
        private int|null $id = null
    ){}

    public function __invoke()
    {
        return $this->id;
    }
}
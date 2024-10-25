<?php

namespace Adminftr\Widgets\Future;

class Widget
{
    public array $col = [
        'sm' => 6,
        'md' => 3,
        'xl' => 3,
    ];

    public function col($md = 6, $sm = 6, $xl = 3)
    {
        $this->col = [
            'sm' => $sm,
            'md' => $md,
            'xl' => $xl,
        ];

        return $this;
    }
}

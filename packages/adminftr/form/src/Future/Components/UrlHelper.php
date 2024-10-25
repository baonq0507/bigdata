<?php

namespace Adminftr\Form\Future\Components;

class UrlHelper
{
    protected static ?string $url = null;

    public static function getUrl(): ?string
    {
        return self::$url;
    }

    public static function setUrl(string $url): void
    {
        self::$url = $url;
    }
}

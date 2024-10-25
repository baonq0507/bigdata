<?php
namespace Adminftr\Core\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RouteAccessed
{
    use Dispatchable, SerializesModels;

    public $url;

    public function __construct($url)
    {
        $this->url = $url;
    }
}

<?php
namespace Cyberduck\LaravelWpApi\Facades;

use Illuminate\Support\Facades\Facade;

class WpApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Cyberduck\LaravelWpApi\WpApi::class;
    }
}

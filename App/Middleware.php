<?php


namespace App;


class Middleware
{
    public static function init(): array
    {
        return [
            "admin" => Auth::getUser()->role_id == 1
        ];
    }
}
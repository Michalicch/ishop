<?php

namespace wfm;

trait TSimgleton
{
    private static ?self $instance = null; //в него записывается экземпляр класса, по умолчанию null

    private function __construct(){} //приватный конструктор

    public static function getInstance(): static
    {
        return static::$instance ?? static::$instance = new static(); //если у нас есть чтото в статик инстанс мы запишем его, если там null, то тогда запишем экземпляр класса.
    }
}
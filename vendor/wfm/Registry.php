<?php

namespace wfm;

class Registry
{
    use TSimgleton;

    protected static array $properties = []; //массив куда мы будем вкладывать различные данные

    public function setProperty($name, $value) //метод который будет записывать в контейнер данные
    {
        self::$properties[$name] = $value;
    }
    public function getProperty($name) //метод который будет считывать из контейнера данные, если они есть
    {
        return self::$properties[$name] ?? null;
    }
    public function getProperties(): array //отладочный метод, который будет возвращать массив всего что есть
    {
        return self::$properties;
    }
}
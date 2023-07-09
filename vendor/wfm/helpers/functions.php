<?php

function debug($data, $die = false)
{
    echo '<pre>' . print_r($data, 1) . '</pre>';
    if($die){
        die;
    }
}
// укороченная функция для удаления тегов или скрипта передаваемого на страницу через View, для защиты от исполения нежелательного кода или поломки верстки
function h($str)
{
    return htmlspecialchars($str);
}
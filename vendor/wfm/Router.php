<?php

namespace wfm;

class Router
{
    protected static array $routes = []; //будет содержаться таблица маршрутов
    protected static array $route = []; //конкретный один маршрут

    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;

    }
    public static function getRoutes(): array //метод вовращает все имеющиеся маршруты
    {
        return self::$routes;
    }
    public static function getRoute(): array //метод возвращает конкретный маршрут найденный по соответствию
    {
        return self::$route;
    }
    protected static function removeQueryString($url)
    {
        if($url){
            $params = explode('&', $url, 2);
            if(false === str_contains($params[0], '=')){
                return rtrim($params[0], '/');
            }
        }
        return '';
    }
    public static function dispatch($url)
    {
        $url = self::removeQueryString($url);
        if(self::matchRoute($url)){
            $controller = 'app\controllers\\' . self::$route['admin_prefix'] . self::$route['controller'] . 'Controller';
            if(class_exists($controller)) {

                /** @var Controller $controllerObject */
                $controllerObject = new $controller(self::$route);

                $controllerObject->getModel();

                $action = self::lowerCamelCase(self::$route['action'] . 'Action');
                if(method_exists($controllerObject, $action)){
                    $controllerObject->$action();
                    $controllerObject->getView();

                }else{
                    throw new \Exception("Метод {$controller}::{$action} не найден!", 404);
                }
            }else{
                throw new \Exception("Контроллер {$controller} не найден!", 404);
            }
        }else{
            throw new \Exception("Страница не найдена!", 404);
        }
    }
    public static function matchRoute($url): bool
    {
        foreach (self::$routes as $pattern => $route){
           if(preg_match("#{$pattern}#", $url, $matches)){
               foreach ($matches as $k=>$v){
                   if(is_string($k)){
                       $route[$k] = $v;
                   }
               }
               if(empty($route['action'])){
                   $route['action'] = 'index';
               }
               if(!isset($route['admin_prefix'])){
                    $route['admin_prefix'] = '';
               }else{
                   $route['admin_prefix'] .= '\\'; // "\\" нужен для пространства имен
               }

               $route['controller'] = self::upperCamelCase($route['controller']);
               self::$route = $route;
               return true;
           }
        }
        return false;
    }
    //CamelCase
    protected static function upperCamelCase($name): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
        //детализация верхней строки
//        $name = str_replace('-', ' ', $name);  // в строке заменяем "-" на пробел (new-product => new product)
//        $name = ucwords($name); // все слова в строке делаем с большой буквы (new product => New Product)
//        $name = str_replace(' ', '', $name); // заменяем пробел пустой строкой (New Product => NewProduct)
    }
    //camelCase
    protected static function lowerCamelCase($name): string
    {
        return lcfirst(self::upperCamelCase($name)); //после отработки метода upperCamelCase делаем первую букву маленькой (для имен методов)
    }


}
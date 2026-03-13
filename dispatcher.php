<?php
function dispatch($routing, $action_url){
    if(!isset($routing[$action_url])){
        $view_name = 'error_view';
        $model = ['message' => 'Page not found.'];
    }
    else{
        $controller_name = $routing[$action_url];
        $model = [];
        $view_name = $controller_name($model);
    }
    buildResponse($view_name,$model);
}
function buildResponse($view, $model){
    if(strpos($view, 'redirect:') === 0){
        $url = substr($view, strlen('redirect:'));
        header('Location: ' . $url);
        exit;

    } else {
        render($view , $model);
    }
}
function render($view_name, $model){
    extract($model);
    include "views/$view_name.php";
}
<?php

$curUrl = $_SERVER['REQUEST_URI'];

switch ($curUrl) {
    case '/':
        require_once('templates/main.php');
        break;
    case '/login': //логин
        require_once('templates/login.php');
        break;
    case '/registration': //регистрация
        require_once('templates/registration.php');
        break;
    case '/logout'://выход
        require_once('templates/logout.php');
        break;
    case '/hold'://отложить
        require_once('templates/hold.php');
        break;
    case '/postponed'://отложено
        echo "Отложено";
        break;
    case '/invites'://приглашения
        echo "Приглашения";
        break;
    case '/settings'://настройки
        require_once('templates/settings.php');
        break;
    default:
       echo "Кажется, такой страницы нет";
}

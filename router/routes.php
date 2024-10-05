<?php

use App\Services\Router;
use App\Controllers\Auth;


Router::page(uri:'/home', page_name:'home');
Router::page(uri:'/login', page_name:'login');
Router::page(uri:'/register', page_name:'register');
Router::page(uri:'/content', page_name:'content');
Router::page(uri:'/profile', page_name:'profile');

//перейдя по адресу '/auth/register' мы из класса Auth вызовем метод register
Router::post(uri:'/auth/register', class:Auth::class, method:'register', formdata:true);
Router::post(uri:'/auth/login', class:Auth::class, method:'login', formdata:true);
Router::post(uri:'/auth/logout', class:Auth::class, method:'logout');

Router::post(uri:'/auth/change_profile', class:Auth::class, method:'change_profile', formdata:true);



/* Router::enable(); */
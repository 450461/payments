<?php

//автолоадер для загрузки классов
function autoloader_app($id){
	$id=(str_replace('\\', '/', $id));
	include $id.'.php';
}
spl_autoload_register('autoloader_app');
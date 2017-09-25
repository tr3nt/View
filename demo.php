<?php

include_once 'View.php';

// Create a new View. By default, it will search for main.html layout
// Crear una nueva Vista. Por default, buscará el layout main.html
$view = new View('index.html');

// Add external source files to <head> of Layout
// Agregar archivos externos al <head> del Layout
$view->source('styles.css', 'css');
$view->source('functions.js');

// Add data to {h} & {h} variables of index.html
// Agregar datos a las variables {h} y {h} de index.html
$view->add([
    'h' => 'Hello',
    'w' => 'World!'
]);

// Print view
// Imprimir vista
$view->render();
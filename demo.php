<?php

include_once 'View.php';

// Create a new View. By default, it will search for main.html layout
// Crear una nueva Vista. Por default, buscará el layout main.html
$view = new View();

// Set index.html as file to get contents (only name)
// Elegir a index.html como el archivo para el contenido (solo el nombre)
$view->setView('index');

// Add external source files to <head> of Layout
// Agregar archivos externos al <head> del Layout
$view->addHeader('css/styles.css', 'css');
$view->addHeader('js/functions.js');

// Add data to {h} & {w} variables from index.html
// Agregar datos a las variables {h} y {w} de index.html
$view->add([
    'h' => 'Hello',
    'w' => 'World!'
]);

// Print view
// Imprimir vista
$view->render();

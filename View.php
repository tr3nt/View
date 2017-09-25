<?php

/***************************************************
 * Generate Views usign main Layout and HTML files *
 *                                                 *
 * Generar Vistas usando un Layout y archivos HTML *
 *                                                 *
 * @author Tr3nt                                   *
 *                                                 *
 ***************************************************/

class View
{
    // Define HTML and Layout folders
    // Definir la carpeta de Layouts y de HTMLs
    const URL_HTML    = 'view/';            // Folder to HTML files
    const URL_LAYOUT  = 'view/layout/';     // Folder to Layout files
    const URL_SOURCES = 'view/';            // Folder to JS and CSS files

    private $layout;
    private $html;
    public  $data;

    // If is Layout is not defined, will search into main.html
    // Si no hay un Layout definido, buscará en las carpetas main.html
    public function __construct(string $html = 'index.html', string $layout = 'main.html')
    {
        // If name of Layout is 'ajax', View will not load Layout, only HTML file
        // Si el nombre del Layout es 'ajax' no se cargará el Layout, solo el archivo HTML
        if ($layout != 'ajax') {
            $this->layout = file_get_contents(self::URL_LAYOUT . $layout);
        }
        $this->html = file_get_contents(self::URL_HTML . $html);

        // Add {sources} to <head> of your Layout to load external sources with source()
        // Agrega {sources} al <head> de tu Layout para cargar archivos externos con source()
        $this->data['sources'] = '';
    }

    // Generate JS and CSS tags and adds to Layout. Can generate other tags
    // Generar etiquetas JS y CSS y las agrega al Layout. Puede generar otras etiquetas
    public function source(string $fileName, string $type = 'js')
    {
        switch($type) {
            case 'css': $this->data['sources'] .= "<link rel='stylesheet' href='".self::URL_SOURCES."css/{$fileName}'>\n";
                break;
            case 'js' : $this->data['sources'] .= "<script src='".self::URL_SOURCES."js/{$fileName}'></script>\n";
                break;
            default   : $this->data['sources'] .= "{$fileName}\n";
        }
    }

    // Add data to Views searching for variables with curly braces {var}
    // Agrega datos a las Vistas buscando variables con llaves {var}
    public function add(array $data)
    {
        $this->data = array_merge($this->data, $data);
    }

    // Print View on screen. Add {content} to <body> of Layout
    // Imprimir la Vista en la pantalla. Agregar {content} al <body> del Layout
    public function render()
    {
        if (is_null($this->layout)) {
            foreach ($this->data as $k => $i) {
                $this->html = str_replace("{{$k}}", $i, $this->html);
            }
            echo $this->html;
        }
        else {
            $this->layout  = str_replace("{content}", $this->html, $this->layout);
            foreach ($this->data as $k => $i) {
                $this->layout = str_replace("{{$k}}", $i, $this->layout);
            }
            echo $this->layout;
        }
    }
}

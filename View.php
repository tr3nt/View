<?php

/**
 * Generate Views usign main Layout and HTML files
 * Generar Vistas usando un Layout y archivos HTML
 *
 * @author Tr3nt
 */
class View
{
    /**
     * Define constants (recommended to put them in a config.inc.php)
     * Definir constantes (se recomienda ponerlas en un archivo config.inc.php)
     */
    const BASE_DIR = __DIR__ . '/';
    /** Full domain name */
    const BASE_URL = 'http://localhost';
    /** HTML files folder */
    const DIR_HTML = self::BASE_DIR . 'views';
    /** Layout template files folder */
    const DIR_LAYOUT = self::BASE_DIR . 'views/layout';
    /** JS and CSS folders location */
    const URL_STATIC = self::BASE_URL . '/' . 'public';

    /**
     * @var string $url
     * @var string $layout
     * @var array $data
     */
    private $url;
    private $layout;
    public  $data;

    /**
     * Initialize plugin section and flash message section
     * Iniciar sección de plugins y de mensaje flash
     */
    public function __construct()
    {
        $this->data = [];
        $this->add([
            'headers' => '',
            'flash' => ''
        ]);
    }

    /**
     * Define html file and layout file
     * For html only (without layout) use $template = 'ajax' value
     *
     * Definir cual es el archivo HTML y el Layout a usar
     * Para una respuesta sin layout, el param $template debe ser 'ajax'
     *
     * @param string $url nombre del archivo HTML
     * @param string $template nombre del layout, default main
     */
    public function setView(string $url, string $template = 'main')
    {
        $this->url = file_get_contents(self::DIR_HTML . "/{$url}.html");
        if ($template != 'ajax') {
            $this->layout = file_get_contents(self::DIR_LAYOUT . "/{$template}.html");
        }
        $this->flash();
    }

    /**
     * Create JS and CSS libraries to <head> section
     * Agregar librerías CSS y JS al header del archivo HTML
     *
     * @param string $arch nombre del archivo
     * @param string $tipo tipo del archivo, default .js
     * @return string tag de carga del archivo
     */
    public function addHeader(string $arch, string $tipo = 'js')
    {
        switch($tipo) {
            case 'css': $txt = /** @lang text */
                "<link rel='stylesheet' href='" . self::URL_STATIC . "/{$arch}'>\r\n";
                break;
            case 'js' : $txt = /** @lang text */
                "<script src='" . self::URL_STATIC . "/{$arch}'></script>\r\n";
                break;
            default   : $txt = /** @lang text */
                "{$arch}\r\n";
        }
        $this->data['headers'] .= $txt;
    }

    /**
     * Add data to Views searching for variables with curly braces {var}
     * Agrega datos a las Vistas buscando variables con llaves {var}
     *
     * @param array $data
     */
    public function add(array $data)
    {
        $this->data = array_merge($this->data, $data);
    }

    /**
     * Print View on screen. Add {content} to <body> of Layout
     * Imprimir la Vista en la pantalla. Agregar {content} al <body> del Layout
     */
    public function render()
    {
        if (is_null($this->layout)) {
            // Loads data variables without layout
            // Se cargan los data del html sin layout
            foreach ($this->data as $k => $i) {
                $this->url = str_replace("{{$k}}", $i, $this->url);
            }
            echo $this->url;
        }
        else {
            // Loads html file into layout file
            // Se carga el html en el layout
            $this->layout  = str_replace("{content}", $this->url, $this->layout);
            // Loads data values into layout file
            // Se cargan los datos en el layout
            foreach ($this->data as $k => $i) {
                $this->layout = str_replace("{{$k}}", $i, $this->layout);
            }
            echo $this->layout;
        }
    }

    /**
     * Get flash message from $_SESSION variable and remove it
     * Obtiene un mensaje flash de una variable de $_SESSION y después lo elimina
     */
    private function flash()
    {
        // Check if Flash message exists, then get the value
        // Checa si un mensaje Flash existe, entonces obtiene su valor
        if (isset($_SESSION['flash'])) {
            $this->data['flash'] = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }
    }
}

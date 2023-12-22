<?php
/**
 * Plugin Name: Redirects
 * Description: The plugin that allows you to process redirects
 * Version:     1.0.0
 * Author:      TetianaDev
 */

namespace redirects;

use redirects\classes\CSVHandler;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

final class App {
    const TEXT_DOMAIN = 'redirects';
    const PLUGIN_VERSION = '1.0.0';
    public static $pluginURL = null;
    public static $pluginDIR = __DIR__;

    public function __construct() {
        self::$pluginURL = plugin_dir_url( __FILE__ );

        $this->autoload();

        add_action('template_redirect', [$this, 'redirectsHandler'], 1);
    }

    public function redirectsHandler() {
        global $wp;

        $currentURL = rtrim(urldecode(home_url($wp->request)), '/');
        $transientKey = 'redirects_data';
        $csvContent = get_transient($transientKey);

        if (!$csvContent) {
            // For local debug
            $csvHandler = new CSVHandler(self::$pluginDIR . '/source/local_redirects.csv');
            $csvContent = $csvHandler->getCSVContent();
            set_transient($transientKey, $csvContent);
        }

        foreach ($csvContent as $column) {
            $source_link = rtrim(mb_convert_encoding($column[0], 'Latin1', 'UTF-8'), '/');

            if ($source_link === $currentURL) {
                wp_redirect($column[2], $column[1]);
                exit;
            }
        }
    }

    private function autoload() {
        require_once self::$pluginDIR . '/Autoloader.php';
        $autoloader = new Autoloader( [
            'directory'        => self::$pluginDIR,
            'namespace_prefix' => 'redirects',
            'classes_dir'      => [ '' ],
        ] );
        $autoloader->init();
    }
}

new App();
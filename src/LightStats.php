<?php

namespace IconicCodes\LightStats;

use Traversable;

class LightStats {
    private static $custom_print = [];
    public static function ldump($key, $value) {
        self::$custom_print[$key] = $value;
    }
    public function getStats($start_time) {
        $end_time = microtime(true);
        $time_taken = $end_time - $start_time;
        $memory_used = memory_get_usage();
        $memory_used = $memory_used / 1024 / 1024;

        $php_version = phpversion();
        $server = $_SERVER['SERVER_SOFTWARE'];

        $classes_used = get_included_files();
        $classes_used_count_unique = array_unique($classes_used);
        $headers = getallheaders();

        return array_merge([
            'Time Taken' => $time_taken,
            'Memory Used' => $memory_used,
            'PHP Version' => $php_version,
            'Server' => $server,
            'Opcache' => ini_get('opcache.enabled') ? 'Enabled' : 'Disabled',
            'Classes Used' => $classes_used_count_unique,
            'Headers' => $headers,
            'Server' => $_SERVER,
            'Cookies' => $_COOKIE,
            'Session' => $_SESSION ?? 'Session not started',
            'GET' => $_GET,
            'POST' => $_POST,
            'Files' => $_FILES,
            'Request' => $_REQUEST,
            'Server' => $_SERVER,
            'Env' => $_ENV,
            'Globals' => $GLOBALS
        ], self::$custom_print);
    }


    function objectToArrayAll() {

    }
    function inspect($start_time) {
        $stats = $this->getStats($start_time);
        

        if (isset($_REQUEST['DISABLE_LSTATS'])) {
            echo json_encode($stats);
            return;
        }
        

        $html = "";
        foreach ($stats as $key => $value) {
            $html .= '<tr><td title="'. $this->extraInfo($stats[$key]) .'">'.  $key .
            // '<div class="ls__type__label">' . str_replace("\n", '<br>', $this->extraInfo($stats[$key])) . '</div>' .
            '</td><td>';

            if (!is_array($value) && !is_object($value)) {
                $html .= '<pre title="'. $this->extraInfo($value) .  '">' . $value . 
                '</pre>' .
                '<div class="ls__type__label">' . str_replace("\n", '<br>', $this->extraInfo($value)) . '</div>';
            } else {

                $html .= '<div style="margin-left: 3px;"><details><summary title="' . $this->extraInfo($stats[$key]) . '">';
                $html .= $key .
                '</summary><p>';
                $html .= '<div class="ls__type__label">' . str_replace("\n", '<br>', $this->extraInfo($stats[$key])) . '</div>';
                $html .= $this->getStatsAsDetailsTag($value);
                $html .= '</p></details></div>';
            }

            $html .= '</td></tr>';
        }
        
        include __DIR__ . "/view.php";
    }

    public function getStatsAsDetailsTag($stats) {
        $html = '<table>';
        foreach ($stats as $key => $value) {
            $html .= '<tr><td title="' . $this->extraInfo($stats[$key]) . '">'.  $key . 
            // '<div class="ls__type__label">' . str_replace("\n", '<br>', $this->extraInfo($stats[$key])) . '</div>' .
            '</td><td title="' . $this->extraInfo($stats[$key]) . '">';

            if (!is_array($value) && !is_object($value)) {
                $html .= '<pre>' . $value . '</pre>';
                $html .= '<div class="ls__type__label">' . str_replace("\n", '<br>', $this->extraInfo($value)) . '</div>';

            } else {
                if (empty($value)) {
                    $value = 'Empty';
                } else {
                    if (is_array($value) || ($value instanceof Traversable)) {
                        $html .= '<div style="margin-left: 3px;"><details><summary title="' . $this->extraInfo($stats[$key]) . '">';
                        $html .= " $key </summary><p>";
                        $html .= '<div class="ls__type__label">' . str_replace("\n", '<br>', $this->extraInfo($stats[$key])) . '</div>';
                        $html .= $this->getStatsAsDetailsTag($value);
                        $html .= '</p></details></div>';
                    }

                }
            }
            $html .= '</td></tr>';
        }
        $html .= '</table>';

        return $html;
    }

    public function extraInfo($variable) {
        $extraInfo = 'Type: ' . gettype($variable) . "\n";
        $extraInfo .= is_countable($variable) ? 'Size: ' . count($variable) : '';
        $extraInfo .= is_string($variable) ? 'Length: ' . strlen($variable) : '';

        return $extraInfo;
    }
}


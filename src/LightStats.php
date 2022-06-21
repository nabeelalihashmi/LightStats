<?php

namespace IconicCodes\LightStats;

class LightStats {
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

        return [
            'Time Taken' => $time_taken,
            'Memory Used' => $memory_used . ' MB',
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
        ];
    }


    function showHtmlStatsBox($start_time) {

        $stats = $this->getStats($start_time);
        $html = "";
        foreach ($stats as $key => $value) {
            $html .= '<tr><td>' . $key . '</td><td>';
            if (!is_array($value) && !is_object($value)) {
                $html .= '<pre>' . $value . '</pre>';
            } else {

                $html .= '<div style="margin-left: 10px;"><details><summary>';
                $html .= "$key </summary><p>";
                $html .= $this->getStatsAsDetailsTag($value);
                $html .= '</p></details></div>';
            }

            $html .= '</td></tr>';
        }
        include __DIR__ . "/view.min.php";
    }

    public function getStatsAsDetailsTag($stats) {
        $html = '<table>';
        foreach ($stats as $key => $value) {
            $html .= '<tr><td>' . $key . '</td><td>';

            if (!is_array($value) && !is_object($value)) {
                $html .= '<pre>' . $value . '</pre>';
            } else {
                // if value if empty then string Empty
                if (empty($value)) {
                    $value = 'Empty';
                } else {

                    $html .= '<div style="margin-left: 10px;"><details><summary>';
                    $html .= " $key </summary><p>";
                    $html .= $this->getStatsAsDetailsTag($value);
                    $html .= '</p></details></div>';
                }
            }
            $html .= '</td></tr>';
        }
        $html .= '</table>';

        return $html;
    }
}
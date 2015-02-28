<?php
    /**
     * Created by Prowect
     * Author: Raffael Kessler
     * Date: 04.02.15 - 09:58
     */

    if (!isset($_GET['__route__'])) {
        $_GET['__route__'] = "/";
    }

    if (substr($_GET['__route__'], 0, 1) != "/") {
        $_GET['__route__'] = "/" . $_GET['__route__'];
    }

    require_once 'routes.php';

    if (array_key_exists($_GET['__route__'], $routes)) {
        $path = 'contents/' . $routes[$_GET['__route__']] . '.php';
        if (file_exists($path)) {
            ob_start();
            require_once $path;
            $content = ob_get_contents();
            ob_end_clean();
            $active = $_GET['__route__'];
            if (isset($template)) {
                $template = str_replace(".", "/", $template);
                $tplPath = "templates/$template.php";
                if (file_exists($tplPath)) {
                    require_once $tplPath;
                } else {
                    echo "Template nicht gefunden";
                }
            } else {
                echo $content;
            }
        } else {
            $error = 404;
        }
    } else {
        $error = 404;
    }

    if (isset($error) && $error == 404) {
        echo "ERROR 404";
    }
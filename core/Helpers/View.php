<?php

namespace app\core\Helpers;

class View {
    public static function head_HTML(string $title = 'Document'): string {
        return sprintf('
            <!doctype html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport"
                      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>%s</title>
            </head>
            <body>
        ', $title);
    }

    public static function body_HTML(): string {
        return '</body></html>';
    }

}
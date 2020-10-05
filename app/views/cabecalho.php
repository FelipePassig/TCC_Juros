<?php
//error_reporting(0);
//ini_set('display_errors', 0);
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../semantic/dist/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
    <link rel="icon" type="image/x-icon'/" href="../../imagens/icon.ico">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>QrList</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="../../semantic/dist/semantic.min.js"></script>
    <script type="text/javascript" src="instascan.min.js"></script>
    <script src="../../semantic/dist/components/visibility.js"></script>
    <script src="../../semantic/dist/components/sidebar.js"></script>
    <script src="../../semantic/dist/components/transition.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script>
        $(document)
            .ready(function() {

                // fix menu when passed
                $('.masthead')
                    .visibility({
                        once: false,
                        onBottomPassed: function() {
                            $('.fixed.menu').transition('fade in');
                        },
                        onBottomPassedReverse: function() {
                            $('.fixed.menu').transition('fade out');
                        }
                    })
                ;
                $('.ui.sidebar')
                    .sidebar('attach events', '.toc.item')
                ;

            })
        ;
    </script>
    <link type="text/css" rel="stylesheet" charset="UTF-8" href="https://translate.googleapis.com/translate_static/css/translateelement.css">
</head>

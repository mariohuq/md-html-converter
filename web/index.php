<?php

require_once "../src/MarkdownGrammar.php";

use Mariohuq\MarkdownGrammar;

$grammar = new MarkdownGrammar();

$markdown_input =
    <<<EOM
    texto **bold __and italic__**
    some other __italic ~~and strike~~__
    nexto ~~strike `and code with *_`~~
    suprevento `code`
    [link **title**](https://www.google.com)
    EOM;

$markdown_input = $_POST['markdown_text'] ?? $markdown_input;

$html_output = $grammar->parse($markdown_input) ?? $markdown_input;

?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test converter</title>
    <style>
        html, body {
            min-height: 100vh;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, serif;
        }

        main {
            max-width: 65ch;
            padding: 10px;
        }

        .label {
            font-style: italic;
            margin-bottom: 0.25em;
        }

        .block + .block {
            margin-top: 1em;
        }

        .block textarea {
            width: 100%;
            box-sizing: border-box;
        }

        #output {
            border: 1px rgb(224, 224, 224) inset;
            border-bottom-style: outset;
            border-right-style: outset;
            padding: 2px;
            font-size: 12px;
        }
    </style>
</head>
<body>
<main>
    <form action="index.php" method="post" class="block">
        <div class="label"><label for="markdown_text">Markdown input</label></div>
        <textarea name="markdown_text" id="markdown_text" rows="6"><?= $markdown_input ?></textarea>
        <br>
        <input type="submit" value="Convert to HTML">
    </form>
    <div class="block">
        <div class="label"><label for="html_output">HTML output</label></div>
        <textarea name="html_output" id="html_output" rows="6"><?= $html_output ?></textarea>
    </div>
    <div class="block">
        <div class="label">Output</div>
        <div id="output"><?= $html_output ?></div>
    </div>
</main>
</body>
</html>
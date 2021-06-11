<?php

require_once "../src/MarkdownGrammar.php";

use Mariohuq\MarkdownGrammar;

$grammar = new MarkdownGrammar();

$markdown_inputs = [
    <<<EOM
    texto **bold**
    some other __italic__
    nexto ~~strike~~
    suprevento `code`
    how to basic [link title](https://www.google.com)
    EOM,
    "texto **bold** some other __italic__ exto ~~strike~~ suprevento `code` how to basic [link title](https://www.google.com)",
    "text1 **bold1 __italic1__** ~~`code1`~~",
    "**TEXT**",
    "**bold1__italic1__**"];

$markdown_input = $_POST['markdown_text'] ?? $markdown_inputs[0];

$html_output = $grammar->parse($markdown_input) ?? $markdown_input;

?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test converter</title>
</head>
<body>

<form action="index.php" method="post">
    <label for="markdown_text">Markdown input</label>
    <br>
    <textarea name="markdown_text" id="markdown_text" cols="30" rows="6"><?= $markdown_input ?></textarea>
    <br>
    <input type="submit" value="Convert to HTML">
</form>

<label for="html_output">HTML output</label>
<br>
<textarea name="html_output" id="html_output" cols="30" rows="6"><?= $html_output ?></textarea>

<div>
    <?= $html_output ?>
</div>

</body>
</html>
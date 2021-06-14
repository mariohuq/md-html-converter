# PHP Inline Markdown → HTML converter

This converter based on [PHP PEG Parser](https://github.com/wouterj/peg) by wouterj.

## Installation

Install `md-html-converter` using [Composer](https://getcomposer.org/download/):

```bash
$ composer require mariohuq/md-html-converter:dev-master
```

## Usage

Use `MarkdownGrammar#parse()` to parse input strings using this grammar.
The return value is *the part* of the string that matched or `null` when there is no match:

```php
use Mariohuq\MarkdownGrammar;

$grammar = new MarkdownGrammar();

echo $grammar->parse('text1 **bold1 __italic1__** ~~`code1`~~');
// text1 <strong>bold1 <em>italic1</em></strong> <s><code>code1</code></s>
```

## Try converter in action

You can try this converter on test page, located at [`/web/index.php`](web/index.php).

Start local web server with root at this directory and port 8080 (or any other) and
open [localhost:8080](localhost:8080).

## Markdown syntax supported

This converter supports Telegram's Markdown for users as such

```
**bold**
__italics__
~~strike~~
`code`
[link title](https://www.example.com)
```

Bold, italics and strike can be nested in various ways, link title can be bold, italic, struck or code.
All syntax within backticks is ignored.
Escaping characters is not supported yet.

## PEG Grammmar

```
BLOCK_OR_LINK_S <- (BLOCK / LINK)+
BLOCK           <- BOLD / ITALICS / STRIKE / CODE / ANY
BOLD            <- ASTERISK BLOCK_OR_LINK_S ASTERISK
ITALICS         <- UNDERLINE BLOCK_OR_LINK_S UNDERLINE
STRIKE          <- TILDA BLOCK_OR_LINK_S TILDA
CODE            <- BACKTICK ANY BACKTICK
LINK            <- LBRACK BLOCK+ LINK_SEP ANY RPAREN

ASTERISK  <- '**'
UNDERLINE <- '__'
TILDA     <- '~~'
BACKTICK  <- [`]
LBRACK    <- '['
LINK_SEP  <- ']['
RPAREN    <- ')'
ANY       <- [^)*[\]_`~]+
ANY_CODE  <- [^`]+
```
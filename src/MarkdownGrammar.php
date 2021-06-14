<?php

namespace Mariohuq;

require __DIR__ . '/../vendor/autoload.php';

use WouterJ\Peg\Grammar;
use WouterJ\Peg\Definition;

class MarkdownGrammar extends Grammar
{
    public function __construct()
    {
        parent::__construct('BLOCK_OR_LINK_S', [
            //BLOCK_OR_LINK_S <- (BLOCK / LINK)+
            new Definition('BLOCK_OR_LINK_S', ['repeat', ['choice', [
                ['identifier', 'BLOCK'],
                ['identifier', 'LINK']
            ]], 1], function ($nested) {
                return join('', $nested);
            }),
            //BLOCK <- BOLD / ITALICS / STRIKE / CODE / ANY
            new Definition('BLOCK', ['choice', [
                ['identifier', 'BOLD'],
                ['identifier', 'ITALICS'],
                ['identifier', 'STRIKE'],
                ['identifier', 'CODE'],
                ['identifier', 'ANY'],
            ]]),
            //BOLD <- ASTERISK BLOCK_OR_LINK_S ASTERISK
            new Definition('BOLD', ['sequence', [
                ['identifier', 'ASTERISK'],
                ['identifier', 'BLOCK_OR_LINK_S'],
                ['identifier', 'ASTERISK'],
            ]], function ($nested) {
                return '<strong>' . $nested[1] . '</strong>';
            }),
            //ITALICS <- UNDERLINE BLOCK_OR_LINK_S UNDERLINE
            new Definition('ITALICS', ['sequence', [
                ['identifier', 'UNDERLINE'],
                ['identifier', 'BLOCK_OR_LINK_S'],
                ['identifier', 'UNDERLINE'],
            ]], function ($nested) {
                return '<em>' . $nested[1] . '</em>';
            }),
            //STRIKE <- TILDA BLOCK_OR_LINK_S TILDA
            new Definition('STRIKE', ['sequence', [
                ['identifier', 'TILDA'],
                ['identifier', 'BLOCK_OR_LINK_S'],
                ['identifier', 'TILDA'],
            ]], function ($nested) {
                return '<s>' . $nested[1] . '</s>';
            }),
            //CODE <- BACKTICK ANY BACKTICK
            new Definition('CODE', ['sequence', [
                ['identifier', 'BACKTICK'],
                ['identifier', 'ANY_CODE'],
                ['identifier', 'BACKTICK'],
            ]], function ($nested) {
                return '<code>' . $nested[1] . '</code>';
            }),
            //LINK <- LBRACK BLOCK+ LINK_SEP ANY RPAREN
            new Definition('LINK', ['sequence', [
                ['identifier', 'LBRACK'],
                ['repeat', ['identifier', 'BLOCK'], 1],
                ['identifier', 'LINK_SEP'],
                ['identifier', 'ANY'],
                ['identifier', 'RPAREN'],
            ]], function ($nested) {
                return '<a href="' . $nested[3] . '">' . join('', $nested[1]) . '</a>';
            }),
            //ASTERISK  <- '**'
            new Definition('ASTERISK', ['literal', '**']),
            //UNDERLINE <- '__'
            new Definition('UNDERLINE', ['literal', '__']),
            //TILDA     <- '~~'
            new Definition('TILDA', ['literal', '~~']),
            //BACKTICK  <- [`]
            new Definition('BACKTICK', ['characterClass', '`']),
            //LBRACK    <- '['
            new Definition('LBRACK', ['literal', '[']),
            //LINK_SEP  <- ']['
            new Definition('LINK_SEP', ['literal', '](']),
            //RPAREN    <- ')'
            new Definition('RPAREN', ['literal', ')']),
            //ANY       <- [^)*[\]_`~]+
            new Definition('ANY', ['repeat', ['characterClass', '^)*[\]_`~'], 1]),
            //ANY_CODE  <- [^`]+
            new Definition('ANY_CODE', ['repeat', ['characterClass', '^`'], 1]),
        ]);
    }
}
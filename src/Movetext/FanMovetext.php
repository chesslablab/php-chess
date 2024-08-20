<?php

namespace Chess\Movetext;

use Chess\Variant\Classical\PGN\Move;

class FanMovetext extends AbstractMovetext
{
    public array $metadata;

    public SanMovetext $sanMovetext;

    public function __construct(Move $move, string $movetext)
    {
        $this->sanMovetext = new SanMovetext($move, $this->toSan($movetext));
        $this->move = $this->sanMovetext->move;
        $this->movetext = $this->sanMovetext->movetext;
        $this->moves = array_map(function($move) {
            return $this->toFan($move);
        }, $this->sanMovetext->moves);

        $this->metadata = [
            'firstMove' => $this->toFan($this->sanMovetext->metadata['firstMove']),
            'lastMove' => $this->toFan($this->sanMovetext->metadata['lastMove']),
            'turn' => $this->sanMovetext->metadata['turn'],
        ];
    }

    protected function beforeInsert(): FanMovetext
    {
    }

    protected function insert(): void
    {
    }

    public function validate(): string
    {
        $this->sanMovetext->validate();

        return $this->toFan($this->sanMovetext->validated);
    }

    public function filtered($comments = true, $nags = true): string
    {
        $filtered = $this->sanMovetext->filtered($comments, $nags);

        return $this->toFan($filtered);
    }

    private function toFan(string &$movetext): string
    {
        $this->replace('R', '♖', $movetext);
        $this->replace('N', '♘', $movetext);
        $this->replace('B', '♗', $movetext);
        $this->replace('Q', '♕', $movetext);
        $this->replace('K', '♔', $movetext);

        return $movetext;
    }

    private function toSan(string $movetext): string
    {
        $movetext = str_replace('♖', 'R', $movetext);
        $movetext = str_replace('♘', 'N', $movetext);
        $movetext = str_replace('♗', 'B', $movetext);
        $movetext = str_replace('♕', 'Q', $movetext);
        $movetext = str_replace('♔', 'K', $movetext);

        return $movetext;
    }

    private function replace($letter, $unicode, &$movetext): void
    {
        preg_match_all('/' . Move::KING . '/', $movetext, $matches);
        $this->move($letter, $unicode, $matches, $movetext);
        preg_match_all('/' . Move::KING_CAPTURES . '/', $movetext, $matches);
        $this->move($letter, $unicode, $matches, $movetext);
        preg_match_all('/' . Move::KNIGHT . '/', $movetext, $matches);
        $this->move($letter, $unicode, $matches, $movetext);
        preg_match_all('/' . Move::KNIGHT_CAPTURES . '/', $movetext, $matches);
        $this->move($letter, $unicode, $matches, $movetext);
        preg_match_all('/' . Move::PIECE . '/', $movetext, $matches);
        $this->move($letter, $unicode, $matches, $movetext);
        preg_match_all('/' . Move::PIECE_CAPTURES . '/', $movetext, $matches);
        $this->move($letter, $unicode, $matches, $movetext);
    }

    private function move($letter, $unicode, $matches, &$movetext): void
    {
        array_map(function($match) use ($letter, $unicode, &$movetext) {
            $replaced = str_replace($letter, $unicode, $match);
            $movetext = str_replace($match, $replaced, $movetext);
        }, $matches[0]);
    }
}
# PHP Chess

✨ [PHP Chess](https://github.com/chesslablab/php-chess) is a chess library offering move validation, common formats, multiple variants, UCI engine support, explanation of chess positions, image recognition, PGN parsing and knowledge extraction from games.

## Installation

### Requirements

- PHP >= 8.1
- Stockfish >= 15.1

### Composer installation

```text
composer require chesslablab/php-chess
```

## Features

### Formats Supported

- Chess moves in LAN and PGN formats.
- Movetext processing in LAN, SAN and RAV formats.
- NAG support for SAN and RAV movetexts.
- UCI protocol.
- Chess board to PNG and JPG image.
- PNG and JPG image to FEN.
- FEN to chess board.
- Chess board to MP4 video.

| Acronym | Description                    |
| :------ | :----------------------------- |
| LAN     | Long Algebraic Notation        |
| PGN     | Portable Game Notation         |
| SAN     | Standard Algebraic Notation    |
| RAV     | Recursive Annotation Variation |
| NAG     | Numeric Annotation Glyphs      |
| UCI     | Universal Chess Interface      |
| FEN     | Forsyth-Edwards Notation       |

### Chess Variants

Multiple variants are supported with the default one being classical chess.

| Variant | Chessboard |
| ------- | ---------- |
| Capablanca | [Chess\Variant\Capablanca\Board](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Variant/Capablanca/BoardTest.php) |
| Capablanca-Fischer | [Chess\Variant\CapablancaFischer\Board](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Variant/CapablancaFischer/BoardTest.php) |
| Chess960 | [Chess\Variant\Chess960\Board](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Variant/Chess960/BoardTest.php) |
| Classical | [Chess\Variant\Classical\Board](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Variant/Classical/BoardTest.php) |
| Dunsany | [Chess\Variant\Dunsany\Board](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Variant/Dunsany/BoardTest.php) |
| Losing Chess | [Chess\Variant\Losing\Board](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Variant/Losing/BoardTest.php) |
| RacingKings | [Chess\Variant\RacingKings\Board](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Variant/RacingKings/BoardTest.php) |

### UCI Engines

Listed below are the UCI engines available at the moment.

- Stockfish

### Object-Oriented

The chess board representation is an object of type [SplObjectStorage](https://www.php.net/manual/en/class.splobjectstorage.php) as opposed to a bitboard.

### Thoroughly Tested

PHP Chess has been developed with a test-driven development (TDD) approach.

The [tests/unit](https://github.com/chesslablab/php-chess/tree/main/tests/unit) folder contains plenty of real examples. Almost every class in the [src](https://github.com/chesslablab/php-chess/tree/main/src) folder represents a concept that is tested accordingly in the [tests/unit](https://github.com/chesslablab/php-chess/tree/main/tests/unit) folder.

The PHP Chess docs are more of a tutorial rather than an API description. The unit tests are the best documentation. For further details on how to use a particular class, please feel free to browse the codebase and check out the corresponding tests.

### Lightweight

PHP dependencies required:

- Rubix ML for machine learning.
- Imagine for image processing.

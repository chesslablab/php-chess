# Formats

## FEN to Board

✨ FEN stands for Forsyth-Edwards Notation and is the standard way for describing chess positions using text strings.

The factory of chessboards allows to convert a FEN string into a chessboard object for further processing.

```php
use Chess\Variant\Classical\FenToBoardFactory;

$board = FenToBoardFactory::create('rnbqkb1r/pp2pppp/3p1n2/8/3NP3/8/PPP2PPP/RNBQKB1R w KQkq -');

$board->play('w', 'Nc3');
$board->play('b', 'Nc6');

echo $board->toFen();
```

```text
r1bqkb1r/pp2pppp/2np1n2/8/3NP3/2N5/PPP2PPP/R1BQKB1R w KQkq -
```

In this example the game history contains two moves only.

```php
var_dump($board->history);
```

```text
array(2) {
  [0]=>
  array(6) {
    ["pgn"]=>
    string(3) "Nc3"
    ["color"]=>
    string(1) "w"
    ["id"]=>
    string(1) "N"
    ["from"]=>
    string(2) "b1"
    ["to"]=>
    string(2) "c3"
    ["fen"]=>
    string(59) "rnbqkb1r/pp2pppp/3p1n2/8/3NP3/2N5/PPP2PPP/R1BQKB1R b KQkq -"
  }
  [1]=>
  array(6) {
    ["pgn"]=>
    string(3) "Nc6"
    ["color"]=>
    string(1) "b"
    ["id"]=>
    string(1) "N"
    ["from"]=>
    string(2) "b8"
    ["to"]=>
    string(2) "c6"
    ["fen"]=>
    string(60) "r1bqkb1r/pp2pppp/2np1n2/8/3NP3/2N5/PPP2PPP/R1BQKB1R w KQkq -"
  }
}
```

The initial FEN string can be accessed as shown below.

```php
echo $board->startFen;
```

```text
rnbqkb1r/pp2pppp/3p1n2/8/3NP3/8/PPP2PPP/RNBQKB1R w KQkq -
```

This is how to get LAN formatted moves out of the history array.

```php
$last = end($board->history);

$lan = $last['from'] . $last['to'];

echo $lan;
```

```text
b8c6
```

## Board to PNG Image

✨ PNG stands for Portable Network Graphics and is a widely used format for image files. Not to be confused with PGN, the text-based file format to annotate chess games.

[Chess\Media\BoardToPng](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Media/BoardToPngTest.php) converts a chess board object to a PNG image.

```php
use Chess\Media\BoardToPng;
use Chess\Variant\Classical\FenToBoardFactory;

$board = FenToBoardFactory::create('1rbq1rk1/p1b1nppp/1p2p3/8/1B1pN3/P2B4/1P3PPP/2RQ1R1K w - -');

$filename = (new BoardToPng($board, $flip = true))->output(__DIR__);
```

![Figure 1](https://raw.githubusercontent.com/chesslablab/php-chess/main/docs/formats_01.png)

Try this thing! Share a puzzling chess position with friends for further study.

## Board to JPG

[Chess\Media\BoardToJpg](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Media/BoardToJpgTest.php) converts a chess board object to a JPG image.

```php
use Chess\Media\BoardToJpg;
use Chess\Variant\Classical\FenToBoardFactory;

$board = FenToBoardFactory::create('1rbq1rk1/p1b1nppp/1p2p3/8/1B1pN3/P2B4/1P3PPP/2RQ1R1K w - -');

$filename = (new BoardToJpg($board, $flip = true))->output(__DIR__);
```

## Board to MP4

✨ Text-based PGN movetexts can be easily converted to MP4, a widely-used video format which comes in handy for pausing the games.

[Chess\Media\BoardToMp4](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Media/BoardToMp4Test.php) allows to convert a chess board object to an MP4 video.

```php
use Chess\Media\BoardToMp4;
use Chess\Variant\Classical\Board;

$movetext = '1.d4 Nf6 2.c4 c5 3.d5 e6 4.Nc3 exd5 5.cxd5 d6 6.e4 g6 7.Nf3 Bg7';

$board = new Board();

$filename = (new BoardToMp4(
    $movetext,
    $board,
    $flip = false
))->output(
    $filepath = __DIR__,
    $filename = '',
    $r = 2,
    $fps = 2,
    $crf = 28,
    $pixFmt = 'yuv420p'
);
```

FFmpeg is used under the hood to handle video with parameters that can be changed in the `output()` method:

```php
$filename = (new BoardToMp4(
    $movetext,
    $board,
    $flip = false
))->output(
    $filepath = __DIR__,
    $filename = '',
    $r = 2,
    $fps = 2,
    $crf = 36,
    $pixFmt = 'gray'
);
```

## Image to FEN

✨ A chess piece image recognizer has been created in the [chesslablab/perception](https://github.com/chesslablab/perception) repository with the help of a multilayer neural network.

[Chess\Media\ImgToPiecePlacement](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Media/ImgToPiecePlacementTest.php) relies on this recognizer to convert a GD image into a piece placement in FEN format.

```php
use Chess\Media\ImgToPiecePlacement;

$image = imagecreatefrompng(__DIR__ . '/01_kaufman.png');

$prediction = (new ImgToPiecePlacement($image))->predict();

echo $prediction;
```

```text
1rbq1rk1/p1b1nppp/1p2p3/8/1B1pN3/P2B4/1P3PPP/2RQ1R1K
```

For optimal use, it is recommended to make predictions on chessboard images using classical chess pieces like the Kaufman test attached below.

![Figure 2](https://raw.githubusercontent.com/chesslablab/php-chess/main/docs/formats_02.png)

# PGN Parsing

✨ The World Wide Web is bursting with Portable Game Notation (PGN) files that can be parsed for chess apps to use. Also you may want to publish your collection of games on your ChesslaBlab website. The thing though with such a huge amount of information is that it may not be always accurate.

However, PHP Chess provides syntax and semantic validation for chess games to make sure everything is working as expected.

## Syntax Validation

With syntax validation, the PGN parser checks that the games in the file don't contain any typos and are correctly formatted, following the syntax guidelines defined in the PGN specification.

The following example shows how to validate the syntax of a file containing 3 games by Anand.

```text
[Event "WCh 2013"]
[Site "Chennai IND"]
[Date "2013.11.12"]
[Round "3"]
[White "Carlsen,M"]
[Black "Anand,V"]
[Result "1/2-1/2"]
[WhiteElo "2870"]
[BlackElo "2775"]
[ECO "A07"]

1.Nf3 d5 2.g3 g6 3.c4 dxc4 4.Qa4+ Nc6 5.Bg2 Bg7 6.Nc3 e5 7.Qxc4 Nge7 8.O-O O-O
9.d3 h6 10.Bd2 Nd4 11.Nxd4 exd4 12.Ne4 c6 13.Bb4 Be6 14.Qc1 Bd5 15.a4 b6
16.Bxe7 Qxe7 17.a5 Rab8 18.Re1 Rfc8 19.axb6 axb6 20.Qf4 Rd8 21.h4 Kh7 22.Nd2 Be5
23.Qg4 h5 24.Qh3 Be6 25.Qh1 c5 26.Ne4 Kg7 27.Ng5 b5 28.e3 dxe3 29.Rxe3 Bd4
30.Re2 c4 31.Nxe6+ fxe6 32.Be4 cxd3 33.Rd2 Qb4 34.Rad1 Bxb2 35.Qf3 Bf6 36.Rxd3 Rxd3
37.Rxd3 Rd8 38.Rxd8 Bxd8 39.Bd3 Qd4 40.Bxb5 Qf6 41.Qb7+ Be7 42.Kg2 g5 43.hxg5 Qxg5
44.Bc4 h4 45.Qc7 hxg3 46.Qxg3 e5 47.Kf3 Qxg3+ 48.fxg3 Bc5 49.Ke4 Bd4 50.Kf5 Bf2
51.Kxe5 Bxg3+  1/2-1/2

[Event "43rd Olympiad 2018"]
[Site "Batumi GEO"]
[Date "2018.09.26"]
[Round "3.20"]
[White "Hansen,Eric"]
[Black "Anand,V"]
[Result "0-1"]
[WhiteElo "2629"]
[BlackElo "2771"]
[ECO "C60"]

1.e4 e5 2.Nf3 Nc6 3.Bb5 g6 4.c3 a6 5.Ba4 Bg7 6.d4 b5 7.Bb3 exd4 8.cxd4 d6
9.h3 Nf6 10.O-O O-O 11.Re1 Bb7 12.Nbd2 Nb4 13.Nf1 c5 14.a3 Nc6 15.d5 Nd4
16.Nxd4 cxd4 17.Qxd4 Nxd5 18.Qd3 Nb6 19.Rd1 Rc8 20.Ng3 Nc4 21.Rb1 h5 22.f3 Qb6+
23.Kh1 d5 24.exd5 Rfd8 25.Bf4 Qf6 26.Bc1 Rxd5 27.Qe2 Re5 28.Qf2 Rce8 29.Bxc4 bxc4
30.Nf1 Be4 31.Ra1 Bd3 32.Ne3 Qb6 33.Re1 R5e6  0-1

[Event "ARM-ROW Match"]
[Site "Moscow RUS"]
[Date "2004.06.14"]
[Round "5"]
[White "Leko,P"]
[Black "Anand,V"]
[Result "1-0"]
[WhiteElo "2741"]
[BlackElo "2774"]
[ECO "B48"]

1.e4 c5 2.Nf3 Nc6 3.d4 cxd4 4.Nxd4 Qc7 5.Nc3 e6 6.Be3 a6 7.Qd2 Nf6 8.O-O-O Bb4
9.f3 Na5 10.Kb1 Bxc3 11.bxc3 b5 12.Bf4 Qb6 13.Nb3 Nc4 14.Qd4 d5 15.Bxc4 Qxd4
16.cxd4 dxc4 17.Na5 Nd7 18.Bc7 O-O 19.d5 exd5 20.exd5 Nf6 21.Rhe1 Bd7 22.Be5 Rfe8
23.Kb2 Rac8 24.Bxf6 gxf6 25.Kc3 Kf8 26.Kd4 c3 27.Rxe8+ Rxe8 28.Kxc3 Rc8+
29.Kb3 Ke7 30.Rd2 Kd6 31.Kb4 Rb8 32.c3 f5 33.a3 f6 34.Rd4 h5 35.g3 Be8 36.Nc6 Rc8
37.Na5 Rb8 38.Nc6 Rc8 39.Ka5 Bxc6 40.dxc6+ Kxc6 41.Rh4 Kd6 42.Kb4 Rh8 43.c4 bxc4
44.Kxc4 Ke6 45.Kb4 Rb8+ 46.Ka4 Rd8 47.Ka5 Rd2 48.a4 f4 49.gxf4 Rd6 50.Rxh5 Rd4
51.Rc5 Rxf4 52.Rc3 Rh4 53.Rb3 Kd7 54.Rb4 Rxh2 55.Kxa6 Rc2 56.Kb6 Rc6+ 57.Kb5 Re6
58.Re4 Rd6 59.Rc4 Rd5+ 60.Kb4 Rd3 61.f4 Rd1 62.a5 Rb1+ 63.Ka4 Ra1+ 64.Kb5 Rb1+
65.Rb4 Rf1 66.Kb6 Kc8 67.Kc6 Re1 68.Kd6  1-0
```

```php
use Chess\PgnParser;
use Chess\Variant\Classical\PGN\Move;

$parser = new PgnParser(new Move(), __DIR__ . '/example.pgn');

$parser->onValidation(function(array $tags, string $movetext) {
    var_dump($tags);
    var_dump($movetext);
});

$parser->parse();

$result = $parser->getResult();

var_dump($result);
```

If a game is correct, both the tags and the movetext are returned on successful validation.

```text
array(10) {
  ["Event"]=>
  string(8) "WCh 2013"
  ["Site"]=>
  string(11) "Chennai IND"
  ["Date"]=>
  string(10) "2013.11.12"
  ["Round"]=>
  string(1) "3"
  ["White"]=>
  string(9) "Carlsen,M"
  ["Black"]=>
  string(7) "Anand,V"
  ["Result"]=>
  string(7) "1/2-1/2"
  ["WhiteElo"]=>
  string(4) "2870"
  ["BlackElo"]=>
  string(4) "2775"
  ["ECO"]=>
  string(3) "A07"
}
string(568) "1.Nf3 d5 2.g3 g6 3.c4 dxc4 4.Qa4+ Nc6 5.Bg2 Bg7 6.Nc3 e5 7.Qxc4 Nge7 8.O-O O-O 9.d3 h6 10.Bd2 Nd4 11.Nxd4 exd4 12.Ne4 c6 13.Bb4 Be6 14.Qc1 Bd5 15.a4 b6 16.Bxe7 Qxe7 17.a5 Rab8 18.Re1 Rfc8 19.axb6 axb6 20.Qf4 Rd8 21.h4 Kh7 22.Nd2 Be5 23.Qg4 h5 24.Qh3 Be6 25.Qh1 c5 26.Ne4 Kg7 27.Ng5 b5 28.e3 dxe3 29.Rxe3 Bd4 30.Re2 c4 31.Nxe6+ fxe6 32.Be4 cxd3 33.Rd2 Qb4 34.Rad1 Bxb2 35.Qf3 Bf6 36.Rxd3 Rxd3 37.Rxd3 Rd8 38.Rxd8 Bxd8 39.Bd3 Qd4 40.Bxb5 Qf6 41.Qb7+ Be7 42.Kg2 g5 43.hxg5 Qxg5 44.Bc4 h4 45.Qc7 hxg3 46.Qxg3 e5 47.Kf3 Qxg3+ 48.fxg3 Bc5 49.Ke4 Bd4 50.Kf5 Bf2 51.Kxe5 Bxg3+"
array(10) {
  ["Event"]=>
  string(18) "43rd Olympiad 2018"
  ["Site"]=>
  string(10) "Batumi GEO"
  ["Date"]=>
  string(10) "2018.09.26"
  ["Round"]=>
  string(4) "3.20"
  ["White"]=>
  string(11) "Hansen,Eric"
  ["Black"]=>
  string(7) "Anand,V"
  ["Result"]=>
  string(3) "0-1"
  ["WhiteElo"]=>
  string(4) "2629"
  ["BlackElo"]=>
  string(4) "2771"
  ["ECO"]=>
  string(3) "C60"
}
string(353) "1.e4 e5 2.Nf3 Nc6 3.Bb5 g6 4.c3 a6 5.Ba4 Bg7 6.d4 b5 7.Bb3 exd4 8.cxd4 d6 9.h3 Nf6 10.O-O O-O 11.Re1 Bb7 12.Nbd2 Nb4 13.Nf1 c5 14.a3 Nc6 15.d5 Nd4 16.Nxd4 cxd4 17.Qxd4 Nxd5 18.Qd3 Nb6 19.Rd1 Rc8 20.Ng3 Nc4 21.Rb1 h5 22.f3 Qb6+ 23.Kh1 d5 24.exd5 Rfd8 25.Bf4 Qf6 26.Bc1 Rxd5 27.Qe2 Re5 28.Qf2 Rce8 29.Bxc4 bxc4 30.Nf1 Be4 31.Ra1 Bd3 32.Ne3 Qb6 33.Re1 R5e6"
array(10) {
  ["Event"]=>
  string(13) "ARM-ROW Match"
  ["Site"]=>
  string(10) "Moscow RUS"
  ["Date"]=>
  string(10) "2004.06.14"
  ["Round"]=>
  string(1) "5"
  ["White"]=>
  string(6) "Leko,P"
  ["Black"]=>
  string(7) "Anand,V"
  ["Result"]=>
  string(3) "1-0"
  ["WhiteElo"]=>
  string(4) "2741"
  ["BlackElo"]=>
  string(4) "2774"
  ["ECO"]=>
  string(3) "B48"
}
string(752) "1.e4 c5 2.Nf3 Nc6 3.d4 cxd4 4.Nxd4 Qc7 5.Nc3 e6 6.Be3 a6 7.Qd2 Nf6 8.O-O-O Bb4 9.f3 Na5 10.Kb1 Bxc3 11.bxc3 b5 12.Bf4 Qb6 13.Nb3 Nc4 14.Qd4 d5 15.Bxc4 Qxd4 16.cxd4 dxc4 17.Na5 Nd7 18.Bc7 O-O 19.d5 exd5 20.exd5 Nf6 21.Rhe1 Bd7 22.Be5 Rfe8 23.Kb2 Rac8 24.Bxf6 gxf6 25.Kc3 Kf8 26.Kd4 c3 27.Rxe8+ Rxe8 28.Kxc3 Rc8+ 29.Kb3 Ke7 30.Rd2 Kd6 31.Kb4 Rb8 32.c3 f5 33.a3 f6 34.Rd4 h5 35.g3 Be8 36.Nc6 Rc8 37.Na5 Rb8 38.Nc6 Rc8 39.Ka5 Bxc6 40.dxc6+ Kxc6 41.Rh4 Kd6 42.Kb4 Rh8 43.c4 bxc4 44.Kxc4 Ke6 45.Kb4 Rb8+ 46.Ka4 Rd8 47.Ka5 Rd2 48.a4 f4 49.gxf4 Rd6 50.Rxh5 Rd4 51.Rc5 Rxf4 52.Rc3 Rh4 53.Rb3 Kd7 54.Rb4 Rxh2 55.Kxa6 Rc2 56.Kb6 Rc6+ 57.Kb5 Re6 58.Re4 Rd6 59.Rc4 Rd5+ 60.Kb4 Rd3 61.f4 Rd1 62.a5 Rb1+ 63.Ka4 Ra1+ 64.Kb5 Rb1+ 65.Rb4 Rf1 66.Kb6 Kc8 67.Kc6 Re1 68.Kd6"
array(2) {
  ["total"]=>
  int(3)
  ["valid"]=>
  int(3)
}
```

Syntax validation is required when loading hundreds of thousands of games into a database with the precondition that the games have probably been validated. This is the approach followed in the [cli/seed/games.php](https://github.com/chesslablab/chess-data/blob/main/cli/seed/games.php) script.

## Semantic Validation

Semantics deal with the meaning assigned to the movetext checking that the sequence of moves can be played as per the rules of the variant in use.

Let's now validate the semantics of the PGN file above. This time, though, an error has been added to the first game to see what will happen.

```text
[Event "WCh 2013"]
[Site "Chennai IND"]
[Date "2013.11.12"]
[Round "3"]
[White "Carlsen,M"]
[Black "Anand,V"]
[Result "1/2-1/2"]
[WhiteElo "2870"]
[BlackElo "2775"]
[ECO "A07"]

1.Nf3 Nf3 2.g3 g6 3.c4 dxc4 4.Qa4+ Nc6 5.Bg2 Bg7 6.Nc3 e5 7.Qxc4 Nge7 8.O-O O-O
9.d3 h6 10.Bd2 Nd4 11.Nxd4 exd4 12.Ne4 c6 13.Bb4 Be6 14.Qc1 Bd5 15.a4 b6
16.Bxe7 Qxe7 17.a5 Rab8 18.Re1 Rfc8 19.axb6 axb6 20.Qf4 Rd8 21.h4 Kh7 22.Nd2 Be5
23.Qg4 h5 24.Qh3 Be6 25.Qh1 c5 26.Ne4 Kg7 27.Ng5 b5 28.e3 dxe3 29.Rxe3 Bd4
30.Re2 c4 31.Nxe6+ fxe6 32.Be4 cxd3 33.Rd2 Qb4 34.Rad1 Bxb2 35.Qf3 Bf6 36.Rxd3 Rxd3
37.Rxd3 Rd8 38.Rxd8 Bxd8 39.Bd3 Qd4 40.Bxb5 Qf6 41.Qb7+ Be7 42.Kg2 g5 43.hxg5 Qxg5
44.Bc4 h4 45.Qc7 hxg3 46.Qxg3 e5 47.Kf3 Qxg3+ 48.fxg3 Bc5 49.Ke4 Bd4 50.Kf5 Bf2
51.Kxe5 Bxg3+  1/2-1/2
```

As you can see in this example, the first move `1.Nf3 Nf3` is incorrect, and for this reason it won't be dumped into the console.

```php
use Chess\PgnParser;
use Chess\Exception\UnknownNotationException;
use Chess\Play\SanPlay;
use Chess\Variant\Classical\FenToBoardFactory;
use Chess\Variant\Classical\PGN\Move;


$parser = new PgnParser(new Move(), __DIR__ . '/example.pgn');

$parser->onValidation(function(array $tags, string $movetext) {
    try {
        (new SanPlay($movetext, FenToBoardFactory::create()))->validate();
        var_dump($tags);
        var_dump($movetext);
    } catch (UnknownNotationException $e) {
    }
});

$parser->parse();

$result = $parser->getResult();

var_dump($result);
```

[Chess\Play\SanPlay](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Play/SanPlayTest.php) allows to play a bunch of moves at once throwing an exception of type `Chess\Exception\UnknownNotationException` if a move cannot be made.

```text
array(10) {
  ["Event"]=>
  string(18) "43rd Olympiad 2018"
  ["Site"]=>
  string(10) "Batumi GEO"
  ["Date"]=>
  string(10) "2018.09.26"
  ["Round"]=>
  string(4) "3.20"
  ["White"]=>
  string(11) "Hansen,Eric"
  ["Black"]=>
  string(7) "Anand,V"
  ["Result"]=>
  string(3) "0-1"
  ["WhiteElo"]=>
  string(4) "2629"
  ["BlackElo"]=>
  string(4) "2771"
  ["ECO"]=>
  string(3) "C60"
}
string(353) "1.e4 e5 2.Nf3 Nc6 3.Bb5 g6 4.c3 a6 5.Ba4 Bg7 6.d4 b5 7.Bb3 exd4 8.cxd4 d6 9.h3 Nf6 10.O-O O-O 11.Re1 Bb7 12.Nbd2 Nb4 13.Nf1 c5 14.a3 Nc6 15.d5 Nd4 16.Nxd4 cxd4 17.Qxd4 Nxd5 18.Qd3 Nb6 19.Rd1 Rc8 20.Ng3 Nc4 21.Rb1 h5 22.f3 Qb6+ 23.Kh1 d5 24.exd5 Rfd8 25.Bf4 Qf6 26.Bc1 Rxd5 27.Qe2 Re5 28.Qf2 Rce8 29.Bxc4 bxc4 30.Nf1 Be4 31.Ra1 Bd3 32.Ne3 Qb6 33.Re1 R5e6"
array(10) {
  ["Event"]=>
  string(13) "ARM-ROW Match"
  ["Site"]=>
  string(10) "Moscow RUS"
  ["Date"]=>
  string(10) "2004.06.14"
  ["Round"]=>
  string(1) "5"
  ["White"]=>
  string(6) "Leko,P"
  ["Black"]=>
  string(7) "Anand,V"
  ["Result"]=>
  string(3) "1-0"
  ["WhiteElo"]=>
  string(4) "2741"
  ["BlackElo"]=>
  string(4) "2774"
  ["ECO"]=>
  string(3) "B48"
}
string(752) "1.e4 c5 2.Nf3 Nc6 3.d4 cxd4 4.Nxd4 Qc7 5.Nc3 e6 6.Be3 a6 7.Qd2 Nf6 8.O-O-O Bb4 9.f3 Na5 10.Kb1 Bxc3 11.bxc3 b5 12.Bf4 Qb6 13.Nb3 Nc4 14.Qd4 d5 15.Bxc4 Qxd4 16.cxd4 dxc4 17.Na5 Nd7 18.Bc7 O-O 19.d5 exd5 20.exd5 Nf6 21.Rhe1 Bd7 22.Be5 Rfe8 23.Kb2 Rac8 24.Bxf6 gxf6 25.Kc3 Kf8 26.Kd4 c3 27.Rxe8+ Rxe8 28.Kxc3 Rc8+ 29.Kb3 Ke7 30.Rd2 Kd6 31.Kb4 Rb8 32.c3 f5 33.a3 f6 34.Rd4 h5 35.g3 Be8 36.Nc6 Rc8 37.Na5 Rb8 38.Nc6 Rc8 39.Ka5 Bxc6 40.dxc6+ Kxc6 41.Rh4 Kd6 42.Kb4 Rh8 43.c4 bxc4 44.Kxc4 Ke6 45.Kb4 Rb8+ 46.Ka4 Rd8 47.Ka5 Rd2 48.a4 f4 49.gxf4 Rd6 50.Rxh5 Rd4 51.Rc5 Rxf4 52.Rc3 Rh4 53.Rb3 Kd7 54.Rb4 Rxh2 55.Kxa6 Rc2 56.Kb6 Rc6+ 57.Kb5 Re6 58.Re4 Rd6 59.Rc4 Rd5+ 60.Kb4 Rd3 61.f4 Rd1 62.a5 Rb1+ 63.Ka4 Ra1+ 64.Kb5 Rb1+ 65.Rb4 Rf1 66.Kb6 Kc8 67.Kc6 Re1 68.Kd6"
array(2) {
  ["total"]=>
  int(3)
  ["valid"]=>
  int(3)
}
```

Semantic validation is a must for use cases like developing a chess variant with a TDD strategy like in the [sample_chess960()](https://github.com/chesslablab/php-chess/blob/main/tests/unit/Variant/Chess960/BoardTest.php#L21) test.

🎉 Let's parse PGN games using PHP Chess.


<?php

namespace Chess\UciEngine;

use Chess\UciEngine\Details\Limit;
use Chess\UciEngine\Details\Process;
use Chess\UciEngine\Details\UciInfoLine;
use Chess\UciEngine\Details\UciOption;
use Chess\Variant\Classical\Board;

class UciEngine
{
    /**
     * Process for the engine.
     *
     * @var Process
     */
    private Process $process;

    /**
     * Array of UciOptions
     *
     * @var array
     */
    private array $options;

    public function __construct(string $path)
    {
        $this->process = new Process($path);

        $this->process->writeLine('uci');
        $this->process->readUntil('uciok');

        $this->process->writeLine('isready');
        $this->process->readUntil('readyok');

        $this->options = $this->readOptions();
    }

    public function __destruct()
    {
        $this->process->writeLine('quit');
    }

    /**
     * Returns an array of key value pairs with the value
     * being the UciOption and the key being the name of the option.
     *
     * @return array
     */
    private function readOptions(): array
    {
        $this->process->writeLine('uci');

        $options = [];

        while (true) {
            $line = $this->process->readLine();

            if (str_contains($line, 'uciok')) {
                break;
            }

            if (str_contains($line, 'option')) {
                $option = UciOption::createFromLine($line);
                $options[$option->name] = $option;
            }
        }

        return $options;
    }

    /**
     * Get current UciOptions
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Set an uci option for the engine.
     *
     * @param string $name
     * @param string $value
     * @return \Chess\UciEngine\UciEngine
     */
    public function setOption(string $name, string $value): UciEngine
    {
        if (!array_key_exists($name, $this->options)) {
            throw new \InvalidArgumentException("Option $name does not exist");
        }

        if ($value === '') {
            $this->process->writeLine("setoption name $name");
        }

        $this->options[$name]->value = $value;

        $this->process->writeLine("setoption name $name value $value");

        return $this;
    }

    /**
     * Board analysis returning the bestmove and all uci info lines.
     *
     * @param Board $board
     * @param Limit $limit
     * @return array
     */
    public function analysis(Board $board, Limit $limit): array
    {
        $this->process->writeLine("position fen " . $board->toFen());
        $this->process->writeLine($this->buildGoCommand($limit));
        $output = $this->process->readUntil('bestmove');

        return [
            "bestmove" => explode(' ', end($output))[1],
            "info" => array_map(function ($line) {
                return new UciInfoLine($line);
            }, $output)
        ];
    }

    /**
     * Sends the ucinewgame command to the engine. Does not reset the options.
     *
     * @return void
     */
    public function newGame(): void
    {
        $this->process->writeLine("ucinewgame");
    }

    /**
     * Reset all options to their default values.
     *
     * @return void
     */
    public function resetOptions(): void
    {
        foreach ($this->options as $option) {
            $this->setOption($option->name, $option->default);
        }
    }

    /**
     * Build the go command based on the given limit.
     *
     * @param Limit $limit
     * @return string
     */
    private function buildGoCommand(Limit $limit): string
    {
        $command = 'go';

        if ($limit->movetime !== null) {
            $command .= ' movetime ' . $limit->movetime;
        }

        if ($limit->depth !== null) {
            $command .= ' depth ' . $limit->depth;
        }

        if ($limit->nodes !== null) {
            $command .= ' nodes ' . $limit->nodes;
        }

        if ($limit->mate !== null) {
            $command .= ' mate ' . $limit->mate;
        }

        if ($limit->wtime !== null) {
            $command .= ' wtime ' . $limit->wtime;
        }

        if ($limit->btime !== null) {
            $command .= ' btime ' . $limit->btime;
        }

        if ($limit->winc !== null) {
            $command .= ' winc ' . $limit->winc;
        }

        if ($limit->binc !== null) {
            $command .= ' binc ' . $limit->binc;
        }

        if ($limit->movestogo !== null) {
            $command .= ' movestogo ' . $limit->movestogo;
        }

        return $command;
    }
}

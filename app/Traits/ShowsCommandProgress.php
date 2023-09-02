<?php


namespace App\Traits;


trait ShowsCommandProgress
{
    public function report($message, $type = 'info'): void
    {
        if ($this->command) {
            $this->command?->newLine();
            $this->command?->{$type}($message);
        } else {
            dump($type.':'.$message );
        }

        logImportation("[$type] " . $message);
    }

    public function startProgressBar($total): void
    {
        $this->command?->getOutput()->progressStart($total);
    }

    public function advanceProgressBar(): void
    {
        $this->command?->getOutput()->progressAdvance();
    }

    public function finishProgressBar(): void
    {
        $this->command?->getOutput()->progressFinish();
    }

    public function iterateProgressBar($iterable, $callback): void
    {
        if ($this->command) {
            $this->command?->withProgressBar($iterable, $callback);
        } else {
            foreach ($iterable as $item) {
                $callback($item);
            }
        }
    }

}

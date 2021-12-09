<?php
/**
 * This file is part of SwowCloud
 * @license  https://github.com/swow-cloud/music-server/blob/main/LICENSE
 */

declare(strict_types=1);

namespace SwowCloud\Highlighter;

trait HighlighterTrait
{
    private function getFileLines($file)
    {
        if (!file_exists($file)) {
            throw new \RuntimeException('File %s does not exits');
        }

        return file($file);
    }

    /**
     * @param $max
     * @param $range
     * @param int $offset
     *
     * @return array
     */
    private function generateNumberSeries($max, $range, $offset = 0)
    {
        $series = [];

        for ($i = 1; $i <= $max; $i++) {
            $series[] = $i;
        }
        $offset = (int) ($offset - $range / 2);
        if ($offset < 0) {
            $offset = 0;
        }

        return array_slice($series, $offset, $range);
    }
}

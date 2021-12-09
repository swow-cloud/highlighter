<?php
/**
 * This file is part of SwowCloud
 * @license  https://github.com/swow-cloud/music-server/blob/main/LICENSE
 */

declare(strict_types=1);

namespace SwowCloud\Highlighter\Theme;

interface ThemeInterface
{
    public function getStringColor();

    public function getCommentColor();

    public function getKeywordColor();

    public function getDefaultColor();

    public function getHTMLColor();

    public function getVariableColor();

    public function getFuncColor();

    public function getLineBeginColor();

    public function getLineNumberColor();

    public function getLineNumberBgColor();

    public function getLineNumberHighlightedColor();

    public function getLineNumberHighlightedBgColor();

    public function getLineHighlightBgColor();
}

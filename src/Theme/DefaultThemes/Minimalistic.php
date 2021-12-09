<?php
/**
 * This file is part of SwowCloud
 * @license  https://github.com/swow-cloud/music-server/blob/main/LICENSE
 */

declare(strict_types=1);

namespace SwowCloud\Highlighter\Theme\DefaultThemes;

use SwowCloud\Highlighter\Theme\ThemeInterface;

class Minimalistic implements ThemeInterface
{
    public function getStringColor()
    {
        return 'yellow';
    }

    public function getCommentColor()
    {
        return 'dark_gray';
    }

    public function getKeywordColor()
    {
        return 'yellow';
    }

    public function getDefaultColor()
    {
        return 'white';
    }

    public function getHTMLColor()
    {
        return 'cyan';
    }

    public function getVariableColor()
    {
        return 'white';
    }

    public function getFuncColor()
    {
        return 'white';
    }

    public function getLineBeginColor()
    {
        return 'bg_yellow';
    }

    public function getLineNumberColor()
    {
        return 'black';
    }

    public function getLineNumberBgColor()
    {
        return 'none';
    }

    public function getLineNumberHighlightedColor()
    {
        return 'white';
    }

    public function getLineNumberHighlightedBgColor()
    {
        return 'none';
    }

    public function getLineHighlightBgColor()
    {
        return 'bg_light_red';
    }
}

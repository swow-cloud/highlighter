<?php
/**
 * This file is part of SwowCloud
 * @license  https://github.com/swow-cloud/music-server/blob/main/LICENSE
 */

declare(strict_types=1);

namespace SwowCloud\Highlighter\Renderer;

/**
 * Interface RendererInterface
 */
interface RendererInterface
{
    public function renderLine($line, $lineNum);
}

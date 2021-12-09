<?php
/**
 * This file is part of SwowCloud
 * @license  https://github.com/swow-cloud/music-server/blob/main/LICENSE
 */

declare(strict_types=1);

namespace SwowCloud\Highlighter;

use Exception;
use SwowCloud\Highlighter\Renderer\RendererInterface;
use SwowCloud\Highlighter\Renderer\StandardLineRenderer;
use SwowCloud\Highlighter\Theme\ThemeInterface;

/**
 * Class Highlighter
 */
class Highlighter
{
    use HighlighterTrait;

    public const TOKEN_DEFAULT = 'default';

    public const TOKEN_COMMENT = 'comment';

    public const TOKEN_STRING = 'string';

    public const TOKEN_HTML = 'html';

    public const TOKEN_KEYWORD = 'keyword';

    public const TOKEN_VARIABLE = 'variable';

    public const TOKEN_FUNC = 'func';

    /**
     * @var RendererInterface
     */
    public $lineRenderer;

    /**
     * Highlighter constructor.
     */
    public function __construct(RendererInterface $lineRenderer = null)
    {
        /* If specified custom line renderer - using it. Else - using standard line renderer */
        /* @var RendererInterface lineRenderer */
        if ($lineRenderer) {
            $this->lineRenderer = $lineRenderer;
        } else {
            $this->lineRenderer = new StandardLineRenderer();
        }
    }

    public function setTheme(ThemeInterface $theme)
    {
        $this->lineRenderer->setTheme([
            Highlighter::TOKEN_STRING => $theme->getStringColor(),
            Highlighter::TOKEN_COMMENT => $theme->getCommentColor(),
            Highlighter::TOKEN_KEYWORD => $theme->getKeywordColor(),
            Highlighter::TOKEN_DEFAULT => $theme->getDefaultColor(),
            Highlighter::TOKEN_HTML => $theme->getHTMLColor(),
            Highlighter::TOKEN_VARIABLE => $theme->getVariableColor(),
            Highlighter::TOKEN_FUNC => $theme->getFuncColor(),

            'line_begin_color' => $theme->getLineBeginColor(),
            'line_number_bg_color' => $theme->getLineNumberBgColor(),
            'line_number_color' => $theme->getLineNumberColor(),

            'line_number_highlighted_bg_color' => $theme->getLineNumberHighlightedBgColor(),
            'line_number_highlighted_color' => $theme->getLineNumberHighlightedColor(),

            'line_highlight_bg_color' => $theme->getLineHighlightBgColor(),
        ]);
    }

    /**
     * @param string $file
     * @param int $num
     *
     * @param bool $highlight
     *
     * @throws Exception
     * @return mixed
     */
    public function getLine($file, $num, $highlight = false)
    {
        /* Highlighting syntax of file and storing in into array in renderer */
        $this->lineRenderer->highlightSyntax(file_get_contents($file));

        return $this->lineRenderer->renderLine($num, $highlight);
    }

    /**
     * @param $file
     * @param $num
     * @param $range
     *
     * @throws Exception
     * @return string
     */
    public function getSnippet($file, $num, $range = 5)
    {
        $fileLines = $this->getFileLines($file);

        /** @var array $range */
        $range = $this->generateNumberSeries(count($fileLines), $range, $num);

        /* Highlighting syntax of file and storing in into array in renderer */
        $this->lineRenderer->highlightSyntax(file_get_contents($file));

        $result = '';

        /**
         * Building final result
         *
         * @var int $lineNum
         */
        foreach ($range as $lineNum) {
            $result .= $this->lineRenderer->renderLine($lineNum, ($lineNum == $num));
        }

        return $result;
    }

    /**
     * @param $file
     * @param mixed $from
     * @param mixed $to
     *
     * @throws Exception
     * @return string
     */
    public function getSpecifiedSnippet($file, $from, $to)
    {
        /* Highlighting syntax of file and storing in into array in renderer */
        $this->lineRenderer->highlightSyntax(file_get_contents($file));

        $result = '';

        /*
         * Building final result
         *
         * @var int $lineNum
         */
        for ($i = $from; $i <= $to; $i++) {
            $result .= $this->lineRenderer->renderLine($i);
        }

        return $result;
    }

    /**
     * @param $file
     *
     * @throws Exception
     * @return string
     */
    public function getWholeFile($file)
    {
        $fileLines = $this->getFileLines($file);

        /* Highlighting syntax of file and storing in into array in renderer */
        $this->lineRenderer->highlightSyntax(file_get_contents($file));

        $result = '';

        /**
         * Building final result
         *
         * @var int $lineNum
         */
        foreach (array_keys($fileLines) as $lineNum) {
            $result .= $this->lineRenderer->renderLine($lineNum + 1);
        }

        return $result;
    }

    /**
     * @param $file
     *
     * @param $num
     *
     * @throws Exception
     * @return string
     */
    public function getLineWithoutNumbers($file, $num)
    {
        /* Highlighting syntax of file and storing in into array in renderer */
        $this->lineRenderer->highlightSyntax(file_get_contents($file));

        $fileStore = $this->lineRenderer->getFileStore();

        return $fileStore[$num];
    }

    /**
     * @param $file
     * @param $num
     * @param int $range
     *
     * @throws Exception
     * @return string
     */
    public function getSnippetWithoutNumbers($file, $num, $range = 5)
    {
        $fileLines = $this->getFileLines($file);

        /** @var array $range */
        $range = $this->generateNumberSeries(count($fileLines), $range, $num);

        /* Highlighting syntax of file and storing in into array in renderer */
        $this->lineRenderer->highlightSyntax(file_get_contents($file));

        $result = '';

        $fileStore = $this->lineRenderer->getFileStore();

        /**
         * Building final result
         *
         * @var int $lineNum
         */
        foreach ($range as $lineNum) {
            $result .= $fileStore[$lineNum] . "\n";
        }

        return $result;
    }

    /**
     * @param $file
     * @param mixed $from
     * @param mixed $to
     *
     * @throws Exception
     * @return string
     */
    public function getSpecifiedSnippetWithoutNumbers($file, $from, $to)
    {
        $fileLines = $this->getFileLines($file);

        /* Highlighting syntax of file and storing in into array in renderer */
        $this->lineRenderer->highlightSyntax(file_get_contents($file));

        $result = '';

        $fileStore = $this->lineRenderer->getFileStore();

        /*
         * Building final result
         *
         * @var int $lineNum
         */
        for ($i = $from; $i <= $to; $i++) {
            $result .= $fileStore[$i] . "\n";
        }

        return $result;
    }

    /**
     * @param $file
     *
     * @throws Exception
     * @return string
     */
    public function getWholeFileWithoutNumbers($file)
    {
        /* Highlighting syntax of file and storing in into array in renderer */
        $this->lineRenderer->highlightSyntax(file_get_contents($file));

        $result = '';

        $fileStore = $this->lineRenderer->getFileStore();

        /**
         * Building final result
         *
         * @var int $lineNum
         */
        foreach ($fileStore as $line) {
            $result .= $line . "\n";
        }

        return $result;
    }
}

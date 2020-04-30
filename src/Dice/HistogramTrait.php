<?php

namespace arts19\Dice;

/**
 * A trait implementing HistogramInterface.
 */
trait HistogramTrait
{
    // /**
    //  * @var array $serie  The numbers stored in sequence.
    //  */
    // private $serie = [];
    //

    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function getAsText($arr)
    {
        $text = "";
        for ($i = 1; $i <= 6; $i++) {
            $currentLine = strval($i) . ": " . str_repeat("*", $this->countItemInArray($arr, $i)) . "\n";
            // echo $currentLine;
            $text .= $currentLine;
        }
        return $text;
    }

    public function countItemInArray($arr, $item)
    {
        $count = 0;
        for ($i = 0; $i < count($arr); $i++) {
            if ($arr[$i] === $item) {
                $count++;
            }
        }
        return $count;
    }


    // /**
    //  * Get the serie.
    //  *
    //  * @return array with the serie.
    //  */
    // public function getHistogramSerie()
    // {
    //     return $this->serie;
    // }
    //
    //
    //
    // /**
    //  * Get min value for the histogram.
    //  *
    //  * @return int with the min value.
    //  */
    // public function getHistogramMin()
    // {
    //     return 1;
    // }
    //
    //
    //
    // /**
    //  * Get max value for the histogram.
    //  *
    //  * @return int with the max value.
    //  */
    // public function getHistogramMax()
    // {
    //     return max($this->serie);
    // }
}

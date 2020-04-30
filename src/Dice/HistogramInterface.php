<?php

namespace arts19\Dice;

/**
 * A interface for a classes supporting histogram reports.
 */
interface HistogramInterface
{
    /**
     * @return int
     */
    public function countItemInArray($arr, $item);


    /**
     * Get min value for the histogram.
     *
     * @return string with the min value.
     */
    public function getAsText($arr);
}

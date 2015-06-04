<?php

namespace Curve\Core\Math;

class Statistics
{
    /**
     * Calculates the arithmetic mean of a set of numbers
     *
     * @param number[] $values input values
     * @return number the arithmetic mean, 0 if $values is empty
     */
    public static function mean($values)
    {
        $count = count($values);
        if ($count === 0) {
            return 0;
        }

        // Cannot use array_sum because it is too tolerant of non-numeric data
        $sum = 0;
        foreach ($values as $value) {
            if (!is_numeric($value)) {
                throw new \InvalidArgumentException('$values contains non-numeric data');
            }
            $sum += $value;
        }
        return $sum / $count;
    }

    /**
     * Calculates the corrected sample standard deviation assuming a biased sample variance
     * with N-1 degrees of freedom
     *
     * @param number[] $samples sample values
     * @return number the standard deviation, 0 if there are fewer than 2 samples
     */
    public static function sampleStandardDeviation($samples)
    {
        $degreesOfFreedom = count($samples);

        if ($degreesOfFreedom < 2) {
            return 0;
        }

        $mean = self::mean($samples);

        $sum = 0.0;
        foreach ($samples as $sample) {
            $sum += pow($sample - $mean, 2);
        }

        return sqrt($sum / ($degreesOfFreedom - 1));
    }
}

<?php

namespace Curve\Core\Math;

use Doctrine\Instantiator\Exception\InvalidArgumentException;

class StatisticsTest extends \PHPUnit_Framework_TestCase
{
    public function testMeanCalculatedCorrectly()
    {
        $values = array(1.0, 2.0);

        $mean = Statistics::mean($values);

        $this->assertEquals(1.5, $mean);
    }

    public function testMeanOfZeroSamplesIsZero()
    {
        $values = array();

        $mean = Statistics::mean($values);

        $this->assertEquals(0, $mean);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMeanThrowsExceptionIfValuesContainNonNumericData()
    {
        $values = array(2, "foo", 3);

        Statistics::mean($values);
    }

    public function testSampleStandardDeviationCalculatedCorrectly()
    {
        $values = array(2,7,0,8,2);

        $standardDeviation = Statistics::sampleStandardDeviation($values);

        $this->assertEquals(
            3.4928,
            $standardDeviation,
            "$standardDeviation does not match expected value 3.4928...",
            0.0001
        );
    }

    public function testSampleStandardDeviationOfOneSampleIsZero()
    {
        $values = array(2);

        $standardDeviation = Statistics::sampleStandardDeviation($values);

        $this->assertEquals(0, $standardDeviation);
    }

    public function testSampleStandardDeviationOfZeroSamplesIsZero()
    {
        $values = array();

        $standardDeviation = Statistics::sampleStandardDeviation($values);

        $this->assertEquals(0.0, $standardDeviation);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSampleStandardDeviationThrowsExceptionIfValuesContainNonNumericData()
    {
        $values = array(2, "foo", 3);

        Statistics::sampleStandardDeviation($values);
    }
}

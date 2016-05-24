<?php

namespace IpNetCalc;

/**
 * Class IpNetCalcTest
 * @package IpNetCalc
 *
 * @author Alexander Over <cyberline@php.net>
 */
class IpNetCalcTest extends \PHPUnit_Framework_TestCase
{
    /** @var IpNetCalc */
    protected $class;

    /**
     * Dataprovider for Test
     * @return array
     */
    public function dpCalcNetSum()
    {
        return [
            [['192.168.0.1', '192.168.2.40'], '192.168.0.0/22'],
            [['2a00:1450:8004::69', '2001:1af8:1:f006::6'], '2000::/4'],
            [['127.0.0.1', '127.0.0.1'], '127.0.0.1/32'],
        ];
    }

    /**
     *
     */
    public function setup()
    {
        $this->class = new IpNetCalc();
    }

    /**
     * @dataProvider dpCalcNetSum
     * @param $data
     * @param $expected
     */
    public function testCalcNetSum($data, $expected)
    {
        $this->assertEquals($expected, $this->class->calcNetSum($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCalcNetSumException() {
        $this->assertEquals([], $this->class->calcNetSum(['', '']));
    }
}

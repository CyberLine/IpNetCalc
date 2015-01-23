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
    /**
     * Dataprovider for Test
     * @return array
     */
    public function dpCalcNetSum() {
        return [
            [['192.168.0.1', '192.168.2.40'], '192.168.0.0/22'],
            [['2a00:1450:8004::69', '2001:1af8:1:f006::6'], '2000::/4'],
            [['127.0.0.1', '127.0.0.1'], '127.0.0.1/32'],
            [['', ''], false],
        ];
    }

    /**
     * @dataProvider dpCalcNetSum
     * @param $data
     * @param $expected
     */
    public function testCalcNetSum($data, $expected) {
        $class = new IpNetCalc;
        $this->assertEquals($expected, $class->calcNetSum($data));
    }
}

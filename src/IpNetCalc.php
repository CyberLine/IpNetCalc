<?php

namespace IpNetCalc;

/**
 * Class IpNetCalc
 *
 * Compute the common mask from multiple IP addresses
 *
 * @author Alexander Over <cyberline@php.net>
 */
class IpNetCalc
{
    /**
     * @param array $ips
     * @return string
     */
    public function calcNetSum(array $ips = array())
    {
        $v = $c = $n = $s = [];
        $i4 = $i6 = false;

        foreach ($ips as $ip) {
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) && !$i6) {
                $i4 = true;
                $v[] = $ip;
            } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) && !$i4) {
                $i6 = true;
                $v[] = $ip;
            } else {
                return false;
            }
        }

        $m0 = (($i4) ? 32 : 128);
        $m1 = (($i4) ? 4 : 6);
        asort($v);
        $c[] = $v[0];
        $c[] = $v[(count($v) - 1)];
        $t = '';

        foreach ($c as $k => $ip) {
            $s[$k] = implode('', $this->bitCalcIP($ip, $m1));
        }

        if ($s[0] === $s[1]) {
            $t = $s[0];
            $i = $m0;
        } else {
            $o = '';
            $len = strlen($s[0]);
            for ($i = 0; $i < $len; $i++) {
                if (substr($s[0], $i, 1) == substr($s[1], $i, 1)) {
                    $o .= substr($s[0], $i, 1);
                } else {
                    $t = str_pad($o, $m0, 0, STR_PAD_RIGHT);
                    break;
                }
            }
        }

        $q = str_split($t, 8);

        if ($i4) {
            foreach ($q as $b) {
                $n[] = bindec($b);
            }
            $n = implode('.', $n);
        } else {
            $len = count($q);
            for ($j = 0; $j < $len; $j += 2) {
                $n[$j] = dechex(bindec($q[$j])) .
                    str_pad(dechex(bindec($q[$j + 1])), 2, 0, STR_PAD_LEFT);
            }
            $n = inet_ntop(inet_pton(implode(':', $n)));
        }

        return $n . '/' . $i;
    }

    /**
     * @param string $ip
     * @param integer $t
     *
     * @return array
     */
    private function bitCalcIP($ip, $t)
    {
        $r = [];

        if (6 == $t) {
            $e = $this->handleV6($ip);
        } else {
            $e = explode('.', $ip);
        }

        foreach ($e as $b) {
            $r[] = str_pad(decbin($b), 8, 0, STR_PAD_LEFT);
        }

        return $r;
    }

    /**
     * @param string $ip
     * @return array
     */
    private function handleV6($ip)
    {
        $n = [];
        $u = unpack('H*', inet_pton($ip));
        $e = str_split($u[1], 4);
        for ($i = 0; $i < 8; $i++) {
            $n[] = hexdec(substr($e[$i], 0, 2));
            $n[] = hexdec(substr($e[$i], 2, 2));
        }
        return $n;
    }
}

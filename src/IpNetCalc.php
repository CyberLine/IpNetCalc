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
    public function calcNetSum(array $ips)
    {
        if (count($ips) < 2) {
            throw new \InvalidArgumentException('too few arguments');
        }

        $validated = $n = $s = [];
        $isV4 = $isV6 = false;

        foreach ($ips as $ip) {
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) && !$isV6) {
                $isV4 = true;
                $validated[] = $ip;
            } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) && !$isV4) {
                $isV6 = true;
                $validated[] = $ip;
            } else {
                throw new \InvalidArgumentException('mixing of IPs not allowed');
            }
        }

        $mask = (($isV4) ? 32 : 128);
        $ipType = (($isV4) ? 4 : 6);

        asort($validated);

        // we need only smalest and biggest ip
        $compare = [
            array_shift($validated),
            array_pop($validated)
        ];

        foreach ($compare as $key => $ip) {
            $s[$key] = implode('', $this->bitCalcIP($ip, $ipType));
        }

        $t = '';

        if ($s[0] === $s[1]) {
            $t = $s[0];
            $i = $mask;
        } else {
            $o = '';
            for ($i = 0, $len = strlen($s[0]); $i < $len; $i++) {
                if (substr($s[0], $i, 1) == substr($s[1], $i, 1)) {
                    $o .= substr($s[0], $i, 1);
                } else {
                    $t = str_pad($o, $mask, 0, STR_PAD_RIGHT);
                    break;
                }
            }
        }

        $q = str_split($t, 8);

        if ($isV4) {
            foreach ($q as $b) {
                $n[] = bindec($b);
            }
            $n = implode('.', $n);
        } else {
            for ($j = 0, $len = count($q); $j < $len; $j += 2) {
                $n[$j] = dechex(bindec($q[$j])) .
                    str_pad(dechex(bindec($q[$j + 1])), 2, 0, STR_PAD_LEFT);
            }
            $n = inet_ntop(inet_pton(implode(':', $n)));
        }

        return $n . '/' . $i;
    }

    /**
     * @param string $ip
     * @param integer $ipType
     *
     * @return array
     */
    private function bitCalcIP($ip, $ipType)
    {
        $r = [];

        if (6 == $ipType) {
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
        $unpack = unpack('H*', inet_pton($ip));
        $e = str_split($unpack[1], 4);
        for ($i = 0; $i < 8; $i++) {
            $n[] = hexdec(substr($e[$i], 0, 2));
            $n[] = hexdec(substr($e[$i], 2, 2));
        }
        return $n;
    }
}

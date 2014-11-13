<?php
/**
 * Class IPNetCalc
 */
class IPNetCalc
{
  /**
   * @param array $ips
   * @return string
   */
  public function calcNetSum($ips = array())
  {
    $v = $c = $n = $s = array();
    $i4 = $i6 = false;

    foreach ($ips as $ip)
    {
      if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) and !$i6)
      {
        $i4 = true;
        $v[] = $ip;
      }
      else if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) and !$i4)
      {
        $i6 = true;
        $v[] = $ip;
      }
      else
      {
        return false;
      }
    }

    $m0 = (($i4) ? 32 : 128);
    $m1 = (($i4) ? 4 : 6);
    asort($v);
    $c[] = $v[0];
    $c[] = $v[(count($v) - 1)];

    foreach ($c as $k => $ip)
    {
      $s[$k] = implode('', self::bitCalcIP($ip, $m1));
    }

    if ($s[0] === $s[1])
    {
      $t = $s[0];
      $i = $m0;
    }
    else
    {
      $o = '';
      for ($i = 0; $i < strlen($s[0]); $i++)
      {
        if (substr($s[0], $i, 1) == substr($s[1], $i, 1))
        {
          $o .= substr($s[0], $i, 1);
        }
        else
        {
          $t = str_pad($o, $m0, 0, STR_PAD_RIGHT);
          break;
        }
      }
    }

    $q = str_split($t, 8);

    if ($i4)
    {
      foreach ($q as $b)
      {
        $n[] = bindec($b);
      }
      $n = implode('.', $n);
    }
    else
    {
      for ($j = 0; $j < count($q); $j += 2)
      {
        $n[$j] = dechex(bindec($q[$j])) . str_pad(dechex(bindec($q[$j + 1])), 2, 0, STR_PAD_LEFT);
      }
      $n = inet_ntop(inet_pton(implode(':', $n)));
    }

    return $n . '/' . $i;
  }

    /**
     * @param $ip
     * @param $t
     *
     * @return array
     */
  private static function bitCalcIP($ip, $t)
  {
    $r = $n = array();

    if (6 == $t)
    {
      $u = unpack('H*', inet_pton($ip));
      $e = str_split($u[1], 4);
      for ($i = 0; $i < 8; $i++)
      {
        $n[] = hexdec(substr($e[$i], 0, 2));
        $n[] = hexdec(substr($e[$i], 2, 2));
      }
      $e = $n;
    }
    else
    {
      $e = explode('.', $ip);
    }

    foreach ($e as $b)
    {
      $r[] = str_pad(decbin($b), 8, 0, STR_PAD_LEFT);
    }

    return $r;
  }

    /**
     * @param $b
     * @param $p
     * @param string $f
     *
     * @return string
     */
  private static function formatBitMask($b, $p, $f = "html")
  {
    if ("html" == $f)
    {
      return substr($b, 0, $p) . '<span style="color:red">' . substr($b, $p) . '</span>';
    }
    else
    {
      return substr($b, 0, $p) . ' ' . substr($b, $p);
    }
  }
}

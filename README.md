# IpNetCalc

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/CyberLine/IpNetCalc/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/CyberLine/IpNetCalc/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/CyberLine/IpNetCalc/badges/build.png?b=master)](https://scrutinizer-ci.com/g/CyberLine/IpNetCalc/build-status/master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/fcf93f3d-d66c-4a82-b7bf-dd317ee9b15c/mini.png)](https://insight.sensiolabs.com/projects/fcf93f3d-d66c-4a82-b7bf-dd317ee9b15c)
[![Latest Stable Version](https://poser.pugx.org/cyberline/ip-net-calc/v/stable.svg)](https://packagist.org/packages/cyberline/ip-net-calc)
[![Total Downloads](https://poser.pugx.org/cyberline/ip-net-calc/downloads.svg)](https://packagist.org/packages/cyberline/ip-net-calc)
[![Latest Unstable Version](https://poser.pugx.org/cyberline/ip-net-calc/v/unstable.svg)](https://packagist.org/packages/cyberline/ip-net-calc)
[![License](https://poser.pugx.org/cyberline/ip-net-calc/license.svg)](https://packagist.org/packages/cyberline/ip-net-calc)

Compute the common mask from multiple IP addresses

## Example

	<?php
	require_once 'IpNetCalc.php';

	// returns: 192.168.0.0/22
	$ip = new IpNetCalc\IpNetCalc();
	print $ip->calcNetSum(array('192.168.0.1', '192.168.2.40'));

	// returns: 2000::/4
	print $ip->calcNetSum(array('2a00:1450:8004::69', '2001:1af8:1:f006::6'));

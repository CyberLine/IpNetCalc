# IpNetCalc

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/CyberLine/IpNetCalc/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/CyberLine/IpNetCalc/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/CyberLine/IpNetCalc/badges/build.png?b=master)](https://scrutinizer-ci.com/g/CyberLine/IpNetCalc/build-status/master)

Compute the common mask from multiple IP addresses

## Example

	<?php
	require_once 'IpNetCalc.php';

	// returns: 192.168.0.0/22
	$ip = new IPNetCalc();
	print $ip->calcNetSum(array('192.168.0.1', '192.168.2.40'));

	// returns: 2000::/4
	print $ip->calcNetSum(array('2a00:1450:8004::69', '2001:1af8:1:f006::6'));

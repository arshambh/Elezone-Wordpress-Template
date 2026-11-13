<?php
/**
 * Jalali (Persian) Date Converter.
 *
 * Converts a Gregorian date string to Jalali without relying on plugins.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Convert Gregorian to Jalali.
 *
 * @param int $gy Gregorian year.
 * @param int $gm Gregorian month.
 * @param int $gd Gregorian day.
 * @return array
 */
function elezone_gregorian_to_jalali( $gy, $gm, $gd ) {
	$g_d_m = array( 0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334 );
	$jy    = ( $gy <= 1600 ) ? 0 : 979;
	$gy   -= ( $gy <= 1600 ) ? 621 : 1600;
	$gy2   = ( $gm > 2 ) ? ( $gy + 1 ) : $gy;
	$days  = ( 365 * $gy ) + ( (int) ( ( $gy2 + 3 ) / 4 ) ) - ( (int) ( ( $gy2 + 99 ) / 100 ) ) + ( (int) ( ( $gy2 + 399 ) / 400 ) ) - 80 + $gd + $g_d_m[ $gm - 1 ];
	$jy   += 33 * ( (int) ( $days / 12053 ) );
	$days  = $days % 12053;
	$jy   += 4 * ( (int) ( $days / 1461 ) );
	$days  = $days % 1461;
	$jy   += (int) ( ( $days - 1 ) / 365 );
	if ( $days > 365 ) {
		$days = ( $days - 1 ) % 365;
	}
	if ( $days < 186 ) {
		$jm = 1 + (int) ( $days / 31 );
		$jd = 1 + ( $days % 31 );
	} else {
		$jm = 7 + (int) ( ( $days - 186 ) / 30 );
		$jd = 1 + ( ( $days - 186 ) % 30 );
	}
	return array( $jy, $jm, $jd );
}

/**
 * Format a date string to Jalali.
 *
 * @param string $date   Gregorian date string (e.g. from $comment->comment_date).
 * @param string $format Format type: 'j F Y' (day month year) or 'Y/m/d'.
 * @return string
 */
function elezone_jalali_date( $date, $format = 'j F Y' ) {
	$time = strtotime( $date );
	$gy   = (int) date( 'Y', $time );
	$gm   = (int) date( 'm', $time );
	$gd   = (int) date( 'd', $time );

	list( $jy, $jm, $jd ) = elezone_gregorian_to_jalali( $gy, $gm, $gd );

	if ( 'Y/m/d' === $format ) {
		return sprintf( '%04d/%02d/%02d', $jy, $jm, $jd );
	}

	$months = array( 'فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند' );

	return $jd . ' ' . $months[ $jm - 1 ] . ' ' . $jy;
}

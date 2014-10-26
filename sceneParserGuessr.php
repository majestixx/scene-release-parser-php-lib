<?php
require_once('sceneParser.php');

/**
 * this extends sceneParser by trying to guess certain values
 * e.g. a DVD is always SD and not HD, Releases without language are mostly in english
 *
 */
class SceneParserGuessr extends SceneParser {

	// ##### CLASS CONSTANTS #####
	protected static $sdsources = array ('webtv' => 'WebTV', 'hdtvrip' => 'HDTVRip',
			'pdtv' => 'PDTV', 'sdtv' => 'SDTV', 'dsr' => 'DSR', 'dvd' => 'DVD',
			'webrip' => 'Webrip', 'dvdr' => 'DVDR', 'r5' => 'R5', 'bdrip' => 'BDRip',
			'dvdrip' => 'DVDRip');

	protected static $hd720sources = array ('hdtv' => 'HDTV',	'ahdtv' => 'AHDTV', 'webhd' => 'WebHD');

	protected static $hd1080sources = array ('bluray' => 'BluRay', 'bdr' => 'BDR');

	// ##### CLASS PROPERTIES #####

	// ##### CONSTRUCTOR #####
	public function __construct($releaseName = NULL) {
		parent::__construct($releaseName);
	}

	// ##### OBJECT METHODS #####
	public function guessResolution(){
		$resolution = $this->getResolution();
		if(empty($resolution)) {
			// try to get resolution by source

			$source = $this->getSource();
			if(in_array ( $source , self::$sdsources )){
				return "SD";
			}

			if(in_array ( $source , self::$hd720sources )){
				return "720p";
			}

			if(in_array ( $source , self::$hd1080sources )){
				return "1080p";
			}
		}
		return $resolution;
	}

	public function guessYear() {
		$year = $this->getYear();
		if(empty($year)) {
			$date = new DateTime();
			return $date->format('Y'); // Take current year
		}
		return $year;
	}

	public function guessLanguage() {
		$language = $this->getLanguage();
		if(empty($language)){
			return "English";
		}
		return $language;
	}

	// ##### STATIC METHODS #####
	public static function getSDSources() {
		return self::$sdsources;
	}

	public static function get720pSources() {
		return self::$hd720sources;
	}

	public static function get1080pSources() {
		return self::$hd1080sources;
	}
}
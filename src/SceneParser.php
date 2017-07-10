<?php
namespace ReleaseParser;
/**
 * Scene Parser Class
 * Parses an scene release name into its parts
 */
class SceneParser {

// ##### CLASS CONSTANTS #####
	protected static $sources = array (
    'hdtv' => 'HDTV', 
    'webtv' => 'WebTV', 
    'hdtvrip' => 'HDTVRip', 
    'pdtv' => 'PDTV', 
    'sdtv' => 'SDTV',
		'ahdtv' => 'AHDTV',
    'tv-rip' => 'TV-Rip',
    'tvrip' => 'TV-Rip',
    'PPV' => 'PPV',
    'PPVRip' => 'PPVRip',
    'dsr' => 'DSR',
    'dsrip' => 'DSRip',
    'satrip' => 'SATRip',
    'dthrip' => 'DTHRip',
    'dvbrip' => 'DVBRip',
    
    'vodrip' => 'VODRip',
    'vodr' => 'VODR',
    
    'dvd' => 'DVD',
    'dvdr' => 'DVD-R',
    'dvd-5' => 'DVD-5',
    'dvd-9' => 'DVD-9',
    'r5' => 'R5',
    'dvdrip' => 'DVD-Rip',
    'r6-dvd' =>'R6-DVD',
    
    'screener' => 'Screener',
    'scr' => 'Scr',
    'dvdscr' => 'DVDSCR',
    'dvdscreener' => 'DVDSCREENER',
    'bluray-scr' => 'BluRay-Scr.',
    'bdscr' => 'BDSCR',
    
    'workprint' => 'Workprint',
    'wp' => 'WP',
    
    
    'webdl' => 'WEBDL',
    'web' => 'WEBDL',
    'webrip' => 'Web-Rip',
    'web-rip' => 'Web-Rip',    
    'webhd' => 'WebHD', 
    
    'ddc' => 'DDC',
    
    
    'bluray' => 'Blu-ray',
    'blu-ray' => 'Blu-ray',
    'bdr' => 'BDR', 
    'bdrip' => 'BDRip',
    'brrip' => 'BRRip',    
     
    'cam' => 'CAM',
    'camrip' => 'CAMRip',
    'ts' => 'TS', 
    'telesync' => 'TeleSync', 
    'pdvd' => 'PDVD', 
    'tc' => 'TC', 
    'telecine' => 'TeleCine'
  );

	protected static $encodings = array ('divx' => 'DivX', 'xvid' => 'XviD', 'x264' => 'x264', 'h264' => 'h264');

	protected static $resolutions = array ('sd' => 'SD', '720p' => '720p', '1080p' => '1080p');

	protected static $dubs = array ('dubbed' => 'DUBBED', 'ac3.dubbed' => 'AC3.Dubbed', 'md' => 'MD', 'ld' => 'LineDubbed');

	protected static $additionalFlagsList = array(
		'proper' => 'PROPER',
		'read.nfo' => 'READ.NFO',
		'repack' => 'REPACK',
		'complete' => 'COMPLETE',
		'ntsc' => 'NTSC',
		'pal' => 'PAL',
		'int' => 'iNT',
		'internal' => 'iNTERNAL',
		'festival' => 'FESTIVAL',
		'stv' => 'STV',
		'limited' => 'LIMITED',
		'tv' => 'TV',
		'ws' => 'WS',
		'fs' => 'FS',
		'rerip' => 'RERIP',
		'real' => 'REAL',
		'retail' => 'RETAIL',
		'extended' => 'EXTENDED',
		'remastered' => 'REMASTERED',
		'rated' => 'RATED',
		'unrated' => 'UNRATED',
		'chrono' => 'CHRONO',
		'theatrical' => 'THEATRICAL',
		'dc' => 'DC',
		'se' => 'SE',
		'uncut' => 'UNCUT',
		'dubbed' => 'DUBBED',
		'subbed' => 'SUBBED',
		'dl' => 'DL',
		'dual' => 'DUAL',
		'final' => 'FINAL',
		'colorized' => 'COLORIZED',
		'ac3' => 'AC3',
		'dolby digital' => 'Dolby Digital',
		'dts' => 'DTS',
		'aac' => 'AAC',
		'dts-hd' => 'DTS-HD',
		'dts-ma' => 'DTS-MA',
		'truehd' => 'TrueHD',
		'3d' => '3D',
		'hou' => 'HOU',
		'hsbs' => 'HSBS',
	);

// ##### CLASS PROPERTIES #####

	/*
	 * TV shows: Title.of.show.S00E00.recordingsource.encoding(.filextension)
Season (S00) - double digits. 01, 02, 03 ... 99. Same for episode (E00) - no space/period between S## and E##. Recording source: DVD, HDTV, WebTV, Webrip etc. Encoding: DivX, Xvid, x264, H264 etc.
Example: This.Is.My.Show.S01E02.HDTV.x264 (.mkv) or This.Is.My.Show.S01E02.Name.Of.Episode.HDTV.720p.AC3.x264

Movies: This.Is.My.Movie.Yearofrelease.Resolution.Source.Audio-format.Encoding (.filexstenstion)
Resolution: 480p, 720p, 1080p etc. Source: WebRip, HDTVRip,DVDR, BluRay etc. Audio-format: AC3 (Dolby Digital), DTS, AAC, DTS-HD, DTS-MA, TrueHD etc. Encoding: DivX, Xvid, x264, H.264 etc.
Example: This.Is.My.Movie.2014.1080p.BluRay.DTS-HD.x264 (.mkv)

There are several optional and special tags - for instance:
The.Fellowship.Of.The.Ring.Goes.To.Bahamas.2012.BluRay.1080p.BluRay.3D.DTS-HD.MA7.1 .(mkv)
	 */

	/**
	 * Type of the file
	 * either 'movie' or 'show'
	 * @var string
	 */
	protected $type;

	/**
	 * Title of the movie
	 * without "."
	 * @var string
	 */
	protected $title;

	/**
	 * if tv show: number of season	public function getEpisode()
	{
	  return $this->episode;
	}
	 * @var int
	 */
	protected $season;

	/**
	 * if tv show: number of episode
	 * @var int
	 */
	protected $episode;

	/**
	 * Language of the movie
	 * MULTi
	 */
	protected $language;

	/**
	 * Year of the movie (####)
	 * @var int
	 */
	protected $year;

	/**
	 * Resolution of the movie
	 * either: SD (480p,576i/576p), 720p, 1080p
	 */
	protected $resolution;

	/**
	 * Source
	 * either
	 *   TV: HDTV, WebTV, HDTVRip, PDTV, SDTV, AHDTV, DSR
	 *   Movie: DVD, Web-Rip, DVDR, Blu-ray, R5, BDR, BDRip, DVD-Rip
	 *   @see self::$sources
	 * @var string
	 */
	protected $source;

	/**
	 * If audio is dubbed
	 * either: DUBBED, AC3.Dubbed, MD, LD
	 * @var string
	 */
	protected $dubbed;

	/**
	 * Used encoding for the release
	 * either DivX, Xvid, x264, H264
	 * @var string
	 */
	protected $encoding;

	/**
	 * Shortcode of release group (e.g. AOE)
	 */
	protected $group;

	/** Additinal Flags
	 * WS
	 * PROPER
	 * READ.NFO
	 * REPACK
	 * COMPLETE
	 * NTSC / PAL
	 * iNT / iNTERNAL
	 * FESTIVAL, STV, LIMITED or TV
	 *  WS/FS (rules above), PROPER, REPACK, RERIP, REAL, RETAIL, EXTENDED,
	 *  REMASTERED, RATED, UNRATED, CHRONO, THEATRICAL, DC, SE, UNCUT, INTERNAL,
	 *  DUBBED, SUBBED, FINAL, COLORIZED
	 */
	protected $additionalFlags;


// ##### CONSTRUCTOR #####
	public function __construct($releaseName = NULL) {
		//Parse Release
		if(is_string($releaseName)){
			//Get release group
			$parts = explode('-', $releaseName);
			if(isset($parts[1]) && is_string($parts[1])){
				$this->group = $parts[1];

				//Proceed with the rest
				$releaseName = $parts[0];
			}

			//Split rest of the release
			$parts = explode('.', $releaseName);

			//Build lowercase version of parts
			$parts_lo = explode('.', strtolower($releaseName));

			// ====
			// Proceed from back to front
			// ====

			// Decide if movie or show
			// Show has season and episode
			// Format S##E##
			if(preg_match('/s([0-9]{2,})e([0-9]{2,})/', strtolower($releaseName), $matches)){
				if(isset($matches[1]) && is_numeric($matches[1]))
					$this->season = $matches[1];
				if(isset($matches[2]) && is_numeric($matches[2]))
					$this->episode = $matches[2];

				$this->type = 'show';

				//Remove from parts
				if($key = array_search($matches[0], $parts_lo)){
					$parts_lo[$key] = '';
				}
			}
			else {
				//is movie
				$this->type = 'movie';
			}

			//get encoding
			$encodings_lo = array_keys(self::$encodings);
			$result = array_intersect($parts_lo, $encodings_lo);
			if (!empty($result) && count($result) == 1){
				foreach($result as $key => $value ) {
					$this->encoding = self::$encodings[$value];
					$parts_lo[$key] = '';
				}
			}

			//get source
			$sources_lo = array_keys(self::$sources);
			$result = array_intersect($parts_lo, $sources_lo);
			if (!empty($result) && count($result) == 1){
				foreach($result as $key => $value ) {
					$this->source = self::$sources[$value];
					$parts_lo[$key] = '';
				}
			}

			//get resolution
			$resolutions_lo = array_keys(self::$resolutions);
			$result = array_intersect($parts_lo, $resolutions_lo);
			if (!empty($result) && count($result) == 1){
				foreach($result as $key => $value ) {
					$this->resolution = self::$resolutions[$value];
					$parts_lo[$key] = '';
				}
			}

			//get dubbed (single handling -> may span over multiple tags)
			if($key = array_search('md', $parts_lo)){
				//is md
				$this->dubbed = self::$dubs['md'];
			}
			elseif($key = array_search('ld', $parts_lo)){
				//is ld
				$this->dubbed = self::$dubs['ld'];
			}
			elseif($key = array_search('dubbed', $parts_lo)){
				if (is_numeric($key) && $key > 0 && ($parts_lo[$key -1] == 'ac3')){
					$this->dubbed = self::$dubs['ac3.dubbed'];
					$parts_lo[$key-1] = '';
				}
				else
					$this->dubbed = self::$dubs['dubbed'];
			}

			if(isset($key) && is_numeric($key))
				$parts_lo[$key] = '';

			//get language
			$languages = self::getLanguages();
			//print_r($languages);
			$languages_lo = array_keys($languages);
			$result = array_intersect($parts_lo, $languages_lo);
			if (!empty($result) && count($result) == 1){
				foreach($result as $key => $value ) {
					$this->language = $languages[$value];
					$parts_lo[$key] = '';
				}
			}

			//get year
			if(count($parts_lo) > 1){
				for($i = 1; $i < count($parts_lo); $i++) {
					if(preg_match('/^([0-9]{4})$/', $parts_lo[$i], $matches)){
						$this->year = $parts_lo[$i];
						$parts_lo[$i] = '';
						break;
					}
				}
			}

			//get additional flags
			$additionalFlagsList_lo = array_keys(self::$additionalFlagsList);
			$result = array_intersect($parts_lo, $additionalFlagsList_lo);
			if (!empty($result)){
				foreach($result as $key => $value ) {
					$this->additionalFlags[] = self::$additionalFlagsList[$value];
					$parts_lo[$key] = '';
				}
			}

			//get title
			foreach ($parts_lo as $key => $part){
				if(empty($part))
					break;
				else {
					if(empty($this->title))
						$this->title = $parts[$key];
					else
						$this->title .= " " . $parts[$key];
				}
			}
		}
	}


// ##### OBJECT METHODS #####
	public function getType()
	{
		return $this->type;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getSeason()
	{
		return $this->season;
	}

	public function getEpisode()
	{
		return $this->episode;
	}

	public function getLanguage()
	{
		return $this->language;
	}

	public function getResolution()
	{
		return $this->resolution;
	}

	public function getSource()
	{
		return $this->source;
	}

	public function getDubbed()
	{
		return $this->dubbed;
	}

	public function getEncoding()
	{
		return $this->encoding;
	}

	public function getYear()
	{
		return $this->year;
	}

	public function getGroup()
	{
		return $this->group;
	}

	public function getAdditionalFlags()
	{
		return $this->additionalFlags;
	}


// ##### STATIC METHODS #####
	/**
	 * Get array of possible languages
	 * Format: array('german' => 'German');
	 * @return array
	 */
	public static function getLanguages() {
		// Open the file
		$filename = 	dirname(__FILE__) . '/languages.txt';
		$fp = fopen($filename, 'r');

		// Add each line to an array
		if ($fp) {
			$array = explode("\n", fread($fp, filesize($filename)));

			$languages = array();
			foreach ($array as $language){
				$languages[strtolower($language)] = $language;
			}
			return $languages;
		}

		return array();
	}

	public static function getSources() {
		return self::$sources;
	}

	public static function getEncodings() {
		return self::$encodings;
	}

	public static function getResolutions() {
		return self::$resolutions;
	}

	public static function getDubs() {
		return self::$dubs;
	}

	public static function getAddtionalFlagsList() {
		return self::$additionalFlagsList;
	}

}

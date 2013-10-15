<?php

class mediawikiIncludesTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test configuration
	 *
	 * All skins and extensions that are loaded in the LocalSettings file will be
	 * checked against the update of submodules task to make sure they are actually pulled
	 * and we do not include a non existent file
	 * Below you can find two arrays for extensions and skins to ignore
	 * (this should be used when using extensions and skins that are not on gerrit.wikimedia.org)
	 */
	protected $ignoreExtensions = array(
		'OrainMessages',
		'YouTube'
	);

	protected $ignoreSkins = array(
		'common'
	);

	/**
	 * Actual test logic is below
	 */

	public function getListOfIncludedExtensions() {
		$file = file_get_contents( __DIR__ . '\..\roles\mediawiki\files\LocalSettings.php.j2' );
		preg_match_all( '/\/extensions\/([^\/]+)\//', $file, $parts );
		return $parts[1];
	}

	public function testExtensionsAreGitUpdated(){
		$extensions = $this->getListOfIncludedExtensions();
		$task = file_get_contents( __DIR__ . '\..\roles\mediawiki\tasks\main.yml' );
		foreach( $extensions as $extension ){
			if( !in_array( $extension, $this->ignoreExtensions ) )
			$this->assertContains( "extensions/{$extension}" ,$task );
		}
	}

	public function getListOfIncludedSkins() {
		$file = file_get_contents( __DIR__ . '\..\roles\mediawiki\files\LocalSettings.php.j2' );
		preg_match_all( '/\/skins\/([^\/]+)\//', $file, $parts );
		return $parts[1];
	}

	public function testSkinsAreGitUpdated(){
		$extensions = $this->getListOfIncludedSkins();
		$task = file_get_contents( __DIR__ . '\..\roles\mediawiki\tasks\main.yml' );
		foreach( $extensions as $extension ){
			if( !in_array( $extension, $this->ignoreSkins ) )
				$this->assertContains( "skins/{$extension}" ,$task );
		}
	}
}
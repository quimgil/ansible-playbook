<?php

class fileExistanceTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test configuration
	 *
	 * All files defined in the array below will be checked to make sure they exist
	 */
	protected $neededFiles = array(
		'local.yml', 'production',
		'roles' => array(
			'common' => array(
				'files' => array( 'ssh' => array( 'addshore.pub', 'kudu.pub' ), 'ferm.conf' ),
				'handlers' => array( 'main.yml' ),
				'tasks' => array( 'create_user.yml', 'main.yml' ),
			),
			'mariadb' => array( 'files' => array( 'my.cnf' ),
				'handlers' => array( 'main.yml' ),
				'tasks' => array( 'main.yml' ),
			),
			'mediawiki' => array(
				'files' => array( 'get_db_list.py', 'LocalSettings.php.j2', 'StartProfiler.php' ),
				'handlers' => array( 'main.yml' ),
				'tasks' => array( 'main.yml' ),
			),
			'nginx' => array(
				'files' => array(
					'conf.d' => array( 'custom.conf' ),
					'sites-enabled' => array( 'all.orain.org.j2', 'bits.orain.org.j2', 'default.j2', 'static.orain.org.j2' ),
					'sites-enabled-agnostic' => array( 'all.orain.org', 'bits.orain.org', 'default', 'static.orain.org' ),
					'robots.txt',
				),
				'handlers' => array( 'main.yml' ),
				'tasks' => array( 'main.yml' ),
			),
			'php' => array(
				'files' => array( 'pool.d' => array( 'www.conf' ) ),
				'handlers' => array( 'main.yml' ),
				'tasks' => array( 'main.yml' ),
			),
		)
	);

	/**
	 * Below is the actual logic for the test
	 */

	public function testExistance(){
		$this->doTestExistance( __DIR__ . '\..\\', $this->neededFiles );
	}

	public function doTestExistance( $path, $fileTree ){
		if( is_array( $fileTree ) ){
			foreach( $fileTree as $folder => $innerFile ){
				$this->doTestExistance( $path . $folder . '\\', $innerFile );
			}
		} else {
			$this->assertFileExists( $path . '..\\' . $fileTree );
		}
	}
}
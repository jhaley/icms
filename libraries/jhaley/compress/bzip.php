<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.compress.tar');

class BzipFile extends TarFile {
	function __construct($name) {
		parent::__construct($name);
		$this->options['type'] = "bzip";
	}

	function createBzip() {
		if ($this->options['inmemory'] == 0) {
			$pwd = getcwd();
			chdir($this->options['basedir']);
			if ($fp = bzopen($this->options['name'], "wb")) {
				fseek($this->archive, 0);
				while ($temp = fread($this->archive, 1048576))
					bzwrite($fp, $temp);
				bzclose($fp);
				chdir($pwd);
			}
			else {
				$this->error[] = "Could not open {$this->options['name']} for writing.";
				chdir($pwd);
				return 0;
			}
		}
		else
			$this->archive = bzcompress($this->archive, $this->options['level']);
		return 1;
	}

	function openArchive() {
		return @bzopen($this->options['name'], "rb");
	}
}
?>
<?php
App::uses('Folder', 'Utility');
class UpdateSchemaShell extends AppShell {

	protected $_schemaPath;

	public function main() {
		$this->_schemaPath = APP . 'Config' . DS . 'Schema';
		$snapshot = $this->_getLatestSnapshot();
		if ($snapshot === false) {
			$this->err('No schema file present');
		} else {
			$this->_update($snapshot);
		}
	}

	protected function _getLatestSnapshot() {
		$folder = new Folder($this->_schemaPath);
		$result = $folder->read();
		$files = $result[1];
		$count = 1;
		if (!in_array('schema.php', $files)) {
			return false;
		} else {
			while (in_array('schema_' . $count . '.php', $files)) {
				$count++;
			}
			return $count-1;
		}
	}

	protected function _update($snapshot = false){
		$command = 'schema update';
		if ($snapshot) {
			$command .= ' --snapshot ' . $snapshot;
		}
		$this->out($command);
		$this->dispatchShell($command);
	}
}

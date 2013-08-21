<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.base.object');

class JhaDBO extends JhaObject {
	private $_conexion;
	private $_config;
	private $_sql;
	private $_empty;
	private $_offset;
	private $_limit;
	private $_cursor;
	
	function __construct($config = null){
		$this->_config = $config;
		if(!$this->open()){
			throw new Exception ( "Error al conectarse a la Base de Datos." );
		}
	}
	
	public function isConnected(){
		if ($this->_conexion) {
			return true;
		}
		return false;
	}
	
	public function open(){
		$this->_conexion = @mysql_connect ( $this->_config->db_host, $this->_config->db_user, $this->_config->db_pass );
		if ($this->_conexion) {
			return @mysql_select_db ( $this->_config->db_database );
		}
		return false;
	}
	
    public function close() {
        if ($this->_conexion) {
            mysql_close ( $this->_conexion );
        }
    }
    
    public function setQuery($query, $offset = 0, $limit = -1){
    	$this->_sql = $this->replacePreffix($query);
    	$this->_offset = $offset;
    	$this->_limit = $limit;
    }
    
    public function executeQuery($query){
    	$this->_sql = $this->replacePreffix($query);
    	$this->_offset = 0;
    	$this->_limit = -1;
    	return $this->_query();
    }
    
    private function replacePreffix($query){
    	return str_replace("#__", $this->_config->db_preffix, $query);
    }
    
    private function _query(){
    	if(!$this->isConnected()){
    		return false;
    	}
    	$sql = $this->_sql;
    	if($this->_limit > 0)
    	    $sql .= " LIMIT " . $this->_offset . ", " . $this->_limit;
   	    
   	    $this->_cursor = mysql_query( $sql, $this->_conexion );
   	    if (!$this->_cursor) {
   	    	throw new Exception ( "Error en la Consulta: $sql" );
   	    }
   	    return $this->_cursor;
    }
    
    public function getAffectedRows() {
        return mysql_affected_rows( $this->_conexion );
    }
    
    public function getNumRows( $cursor = null ) {
        return mysql_num_rows( $cursor ? $cursor : $this->_cursor );
    }
    
    public function loadObject() {
        if (!($cursor = $this->_query())) {
            return null;
        }
        $res = null;
        if ($object = mysql_fetch_object( $cursor )) {
            $res = $object;
        }
        mysql_free_result( $cursor );
        return $res;
    }
    
    public function loadObjectList( $key = '' ) {
        if (!($cursor = $this->_query())) {
            return null;
        }
        $res = array();
        while ($row = mysql_fetch_object( $cursor )) {
            if ($key) {
                $res[$row->$key] = $row;
            } else {
                $res[] = $row;
            }
        }
        mysql_free_result( $cursor );
        return $res;
    }
    
    public function insertObject( $table, &$object, $keyName = NULL ) {
        $fmtsql = 'INSERT INTO '.$table.' ( %s ) VALUES ( %s ) ';
        $fields = array();
        foreach ($object->getProperties() as $k => $v) {
            if (is_array($v) or is_object($v) or $v === NULL) {
                continue;
            }
            $fields[] = $k;
            $values[] = "'" . $v . "'";
        }
        $this->setQuery( sprintf( $fmtsql, implode( ",", $fields ) ,  implode( ",", $values ) ) );
        if (!$this->_query()) {
            return false;
        }
        $id = $this->insertid();
        if ($keyName && $id) {
            $object->$keyName = $id;
        }
        return true;
    }
    
    public function updateObject( $table, &$object, $keyName, $updateNulls = true ) {
        $fmtsql = 'UPDATE '.$table.' SET %s WHERE %s';
        $tmp = array();
        foreach ($object->getProperties() as $k => $v) {
            if( is_array($v) or is_object($v) or $k[0] == '_' ) { // internal or NA field
                continue;
            }
            if( $k == $keyName ) { // PK not to be updated
                $where = $keyName . "='" . $v . "'";
                continue;
            }
            if ($v === null) {
                if ($updateNulls) {
                    $val = 'NULL';
                } else {
                    continue;
                }
            } else {
                $val = "'". $v . "'";
            }
            $tmp[] = $k . "=" . $val;
        }
        $this->setQuery( sprintf( $fmtsql, implode( ",", $tmp ) , $where ) );
        return $this->_query();
    }
    
	public function deleteObject( $table, &$object, $keyName = NULL ) {
        $fmtsql = 'DELETE FROM '.$table.' WHERE %s ';
        $where = array();
        foreach ($object->getProperties() as $k => $v) {
            if (is_array($v) or is_object($v) or $v === NULL) {
                continue;
            }
            $where[] = $k . "='" . $v . "'";
        }
        $this->setQuery( sprintf( $fmtsql, implode( " AND ", $where ) ) );
        if (!$this->_query()) {
            return false;
        }
        return true;
    }

    public function insertid() {
        return mysql_insert_id($this->_conexion);
    }
    
	public function insertGeneralObject( $table, $elems) {
        $fmtsql = 'INSERT INTO '.$table.' ( %s ) VALUES ( %s ) ';
        $fields = array();
        foreach ($elems as $k => $v) {
            if (is_array($v) or is_object($v) or $v === NULL) {
                continue;
            }
            $fields[] = $k;
            $values[] = "'" . $v . "'";
        }
        $this->setQuery( sprintf( $fmtsql, implode( ",", $fields ) ,  implode( ",", $values ) ) );
        if (!$this->_query()) {
            return false;
        }
        return true;
    }
    
	public function deleteGeneralObject( $table, $elems) {
        $fmtsql = 'DELETE FROM '.$table.' WHERE %s';
        $where = array();
        foreach ($elems as $k => $v) {
            if (is_array($v) or is_object($v) or $v === NULL) {
                continue;
            }
            $where[] = $k . "='" . $v . "'";
        }
        $this->setQuery( sprintf( $fmtsql, implode( " AND ", $where)) );
        if (!$this->_query()) {
            return false;
        }
        return true;
    }
}
?>
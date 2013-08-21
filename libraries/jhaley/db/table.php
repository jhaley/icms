<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.base.object');

class JhaTable extends JhaObject{
	var $_table;
	var $_table_key;
	var $_dbo;
	
	public function __construct($table, $table_key){
		$this->_table = $table;
		$this->_table_key = $table_key;
		$this->_dbo = &JhaFactory::getDBO();
	}
	
    /**
     * encargado de cargar los datos desde BD en funcion del $table_key
     */
    public function load($objid = NULL){
        $k = $this->_table_key;
        if ($objid !== null) {
            $this->$k = $objid;
        }
        $objid = $this->$k;
        if ($objid === null) {
            return false;
        }
        $db = &$this->_dbo;
        $query = "SELECT * FROM " . $this->_table . " WHERE " . $this->_table_key . " = '" . $objid . "'";
        $db->setQuery( $query );
        if ($result = $db->loadObject( )) {
            return $this->bind($result);
        }
        else {
            return false;
        }
    }
    
    /**
     * Establece los atributos del objeto en base a un array u objeto.
     */
    function bind($elem) {
        $isArrayElem = is_array( $elem );
        $fromObjectElem = is_object( $elem );
        if (!$isArrayElem && !$fromObjectElem) {
            throw new Exception("La fuente para cargar los datos no es valida.");
            return false;
        }
        $attr = $this->getProperties();
        foreach ($attr as $k => $v) {
            if ($isArrayElem && isset( $elem[$k] )) {
                $this->$k = $elem[$k];
            } else if ($fromObjectElem && isset( $elem->$k )) {
                $this->$k = $elem->$k;
            }
        }
        return true;
    }
	
	public function store(){
        $k = $this->_table_key;
        if( $this->$k) {
            $res = $this->_dbo->updateObject($this->_table, $this, $this->_table_key);
        }
        else {
            $res = $this->_dbo->insertObject($this->_table, $this, $this->_table_key);
        }
        if( !$res ) {
            throw new Exception("Error al guardar el registro en la Base de Datos");
        }
        return $res;
	}
	
	public function delete(){
        $k = $this->_table_key;
        if( $this->$k) {
            $res = $this->_dbo->deleteObject($this->_table, $this, $this->_table_key);
        }
        if( !$res ) {
            throw new Exception("Error al borrar el registro en la Base de Datos");
        }
        return $res;
	}
    
	public static function &getInstance($name, $prefix = 'JhaTable'){
        $name = preg_replace('/[^A-Z0-9_\.-]/i', '', $name);
        $tableClass = $prefix.ucfirst($name);
        $result = false;
        if (!class_exists( $tableClass )) {
            $path = JHA_LIBRARIES_PATH.DS.'jhaley'.DS.'db'.DS.'tables'.DS.$name.'.php';
            if ($path) {
                require_once $path;
                if (!class_exists( $tableClass )) {
                    throw new Exception( 'Tabla ' . $tableClass . ' no encontrada.' );
                    return $result;
                }
            }
            else return $result;
        }
        $result = new $tableClass();
        return $result;
	}
}
?>
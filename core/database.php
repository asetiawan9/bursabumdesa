<?php
class database{
	
    private $host=DB_HOST;
    private $user=DB_USER;
    private $pass=DB_PASS;
    private $dbname=DB_NAME;
 
    private $dbh;
    private $error;
	private $stmt;
	
	/** initiate database connection **/
    public function __construct()
	{
        $dsn='mysql:host='.$this->host.';dbname='.$this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT=>true,
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
        );
        try{
			$this->dbh=new PDO($dsn,$this->user,$this->pass,$options);
        } catch(PDOException $e){
            $this->error=$e->getMessage();
        }
    }
	
	/** prepare a query **/
	public function query($query){
		$this->stmt=$this->dbh->prepare($query);
	}
	
	/** bind parameters **/
	public function bind($param, $value, $type = null){
		$value=strip_tags($value, '<a><p><em><i><strong><h1><h2><h3><h4><h5><h6><div><span><ul><li>');
		if(is_null($type)) {
			switch (true) {
				case is_int($value):
					$type=PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type=PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type=PDO::PARAM_NULL;
					break;
				default:
					$type=PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}
	
	/** execute prepared query **/
	public function execute(){
		return $this->stmt->execute();
	}
	
	/** fetch one row **/
	public function fetch($fetchNum=false){
		$this->execute();
		if(!$fetchNum) $mode=PDO::FETCH_ASSOC;
		else $mode=PDO::FETCH_NUM;
		return $this->stmt->fetch($mode);
	}
	
	/** fetch all rows **/
	public function fetchAll($fetchNum=false){
		$this->execute();
		if(!$fetchNum) $mode=PDO::FETCH_ASSOC;
		else $mode=PDO::FETCH_NUM;
		return $this->stmt->fetchAll($mode);
	}
	/** returns row count **/
	public function rowCount(){
		$this->execute();
		return $this->stmt->rowCount();
	}
	
	/** returns last insert id **/
	public function lastInsertId(){
		$this->execute();
		return $this->dbh->lastInsertId();
	}
	
	/** extract values into comma seperated values **/
	public function extractCol($que) {
		$a=0;
		$this->query($que);
		$result=$this->fetchAll(true);
		foreach($result as $row) {
			$s[$a]=$row[0];
			$implode[]=$s[$a];
			$a++;
		}
		return @implode(",", $implode);
	}
	
}
?>
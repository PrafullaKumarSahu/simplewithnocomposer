<?php
class QueryBuilder
{
	protected $pdo;

    public function __construct($pdo)
    {
    	$this->pdo = $pdo;
    }

	public function selectAll($table)
	{
		$query = $this->pdo->prepare("select * from {$table}");
	    $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS);
	}

	public function find(){}
	public function get(){}

	public function insert($table, $parameters)
	{
		$sql = sprintf('insert into %s (%s) values (%s)', $table, implode(', ', array_keys($parameters)), ':' . implode(', :', array_keys($parameters)));
		//dd($sql);
		try{
			$statement = $this->pdo->prepare($sql);
		    if ( $statement->execute($parameters) ){
		    	header('Location: /');
		    }
		} catch(Exception $e){
			//echo $e->getMessage();
			die('Whoops, something went wrong!');
		}
	}

	public function delete($table, $parameters)
	{

		$sql = sprintf('DELETE FROM %s WHERE 1=1 AND %s', $table,  implode(', ', array_keys($parameters)), implode('=? AND ', array_keys($parameters) ) . '=?' );
	
		try{
			$statement = $this->pdo->prepare($sql);
		    if ( $statement->execute(array_values($parameters) ) ){
		    	$deleted = $statement->rowCount();
		    	dd($deleted);
		    	header('Location: /');
		    }
		} catch(Exception $e){
			//echo $e->getMessage();
			die('Whoops, something went wrong!');
		}
	}

	public function update($table, $data, $parameters)
	{

		$sql = sprintf('UPDATE %s SET (%s) WHERE 1=1 AND %s', $table,  implode('=?, ', array_keys($parameters)). '=?', implode('=? AND ', array_keys($parameters) ) . '=?');

		dd($sql);
		exit;
	
		try{
			$statement = $this->pdo->prepare($sql);
		    if ( $statement->execute(array_values($parameters) ) ){
		    	$deleted = $statement->rowCount();
		    	dd($deleted);
		    	header('Location: /');
		    }
		} catch(\Exception $e){
			//echo $e->getMessage();
			die('Whoops, something went wrong!');
		}
	}
}
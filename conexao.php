<?php
if (!$_SESSION) {
	session_start();
}
/**
 *@author Thayller Vilela Cintra
 *@link http://pxwstudio.com.br/fazendaDiamantina/
 *@package conexão e controle de dados
 */
//include_once "errors.php";
//namespace conexao_banco\crud\conn;
class conn {

	protected $user = "";
	protected $password = "";
	protected $host = "";
	protected $bd = "";
	protected $_db;

	public function connect() {
		/**
		 *@param conexão com banco de dados
		 *@return retorna o acesso ao banco para fazer modificações
		 *@throws $e->getMessage
		 */
		try {
			$this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->bd);
		} catch (mysqli_sql_exception $e) {
			/*$erros = new errors();
		$this->errors($e, "conexao");*/
		}
	}
	public function insert(array $dados, $where = null, $tabela) {
		/**
		 *@param inserção no banco de dados
		 *@return retorna 1 se não ocorrer erro
		 *@throws $e
		 */
		try {
			$where = $where != null ? "WHERE " . $where : "";
			$campos = implode(", ", array_keys($dados));
			$valores = "'" . implode("','", array_values($dados)) . "'";

			$con = new conn();
			$con->connect();

			return $con->mysqli->query("INSERT INTO " . $tabela . "(" . $campos . ") VALUES(" . $valores . ") " . $where . "");
		} catch (mysqli_sql_exception $e) {
			return $this->errors($e, "insert");
		}
	}
	public function read(array $dados, $where = null, $orderby = null, $tabela, $op = "query") {
		/**
		 *@param leitura de dados do banco de dados
		 *@return retorna 1 se não ocorrer erro
		 *@throws $e
		 */

		if ($dados[0] != "*") {
			$valores = implode(",", array_values($dados));
		} else {
			$valores = $dados[0];
		}
		$where = $where != null ? " WHERE " . $where : "";
		$orderby = $orderby != null ? " ORDER BY " . $orderby : "";

		$con = new conn();
		$con->connect();
		//exit("SELECT " . $valores . " FROM " . $tabela . "" . $where . "" . $orderby . "");
		//$result = $this->database->query($query); if (!$result) { throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}"); }
		$query = $con->mysqli->query("SELECT " . $valores . " FROM " . $tabela . "" . $where . "" . $orderby . "");
		//echo ("SELECT " . $valores . " FROM " . $tabela . "" . $where . "" . $orderby . "");

		if (!$query) {
			die("Database Error: " . $con->mysqli->error . "");
		} else {
			//	print_r($query->fetch_assoc());exit($op);
			if ($op == "count") {
				return $query->row;

			} elseif ($op == "query") {

				return $query;

			} elseif ($op == "fetch") {
				return $query->fetch_assoc();
			}

		}
	}
	public function update(array $dados, $where, $tabela) {
		/**
		 *@param atualizar dados no banco de dados
		 *@return retorna 1 se não ocorrer erro
		 *@throws $e
		 */
		try {
			foreach ($dados as $ind => $vals) {
				if ($ind == "qtAcesso") {
					$campos[] = "" . $ind . " = " . $vals . "";
				} else {
					$campos[] = "" . $ind . " = '" . $vals . "'";
				}
			}

			$campos = implode(", ", $campos);

			$con = new conn();
			$con->connect();

			return $con->mysqli->query("UPDATE " . $tabela . " SET " . $campos . " WHERE " . $where . "");
		} catch (mysqli_sql_exception $e) {
			return $this->errors($e, "update");
		}
	}
	public function delete($where, $tabela) {
		/**
		 *@param deleta registro no banco de dados
		 *@return retorna 1 caso não ocorra erro
		 *@throws $e
		 */
		try {
			$con = new conn();
			$con->connect();

			return $con->mysqli->query("DELETE FROM " . $tabela . " WHERE " . $where . "");
		} catch (mysqli_sql_exception $e) {
			return $this->errors($e, "delete");
		}
	}
	public function fechaConexao() {
		$this->_db->close();
	}
}

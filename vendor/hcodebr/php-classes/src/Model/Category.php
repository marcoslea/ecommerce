<?php
		
namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Mailer;


class Category extends Model {

	
	public static function listAll()
	{
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_categories ORDER BY descategory");
	}

	public function save()
	{
		$sql = new Sql();
		$results = $sql->select("CALL sp_categories_save(:idcategory, :descategory)",
		array(
			":idcategory"=>$this->getidcategory(),
			":descategory"=>$this->getdescategory()
			
			));

			$this->setData($results[0]);
			//chama o método updateFile	quando eu fizer um save
			Category::updateFile();
	
	}

	public function get($idcategory)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_categories WHERE idcategory = :idcategory", [
			':idcategory'=>$idcategory
		]);
		$this->setData($results[0]);
	}

	public function delete()
	{
		$sql = new Sql();

		$sql->query("DELETE FROM tb_categories WHERE idcategory = :idcategory",[
			':idcategory'=>$this->getidcategory	()

		]);
		//chama o método updateFile	quando eu fizer um delete
		Category::updateFile();
	}
	//atualiza as categorias criadas contidas no arquivo categories-menu.html
	public static function updateFile()
	{	//método que traz todas as categorias do banco de dados
		$categories = Category::listAll();
		//cria dinamicamente as categorias nor arquivo categories-menu.html, todas vez que uma categoria for criada no banco de dados
		$html = [];
		//foreach para percorrer as categorias no banco, e preencher o array $html
		foreach ($categories as $row) {
			array_push($html,'<li><a href="/categories/'.$row['idcategory'].'">'.$row['descategory'].'</a></li>');
		}
		//salva o arquivo, usando o caminho absoluto/como o arquivo é um array eu faço um implod por nada transformando a variável $html em string
		file_put_contents($_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR ."categories-menu.html", implode('',$html));
	}
	
}

?>
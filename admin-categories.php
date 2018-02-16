<?php
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;

$app->get("/admin/categories", function() {

			User::verifyLogin();

			$categories = Category::listAll();

			$page = new PageAdmin();

			$page->setTpl("categories", [
				'categories'=>$categories
			]);
		});

		$app->get("/admin/categories/create", function() {

			User::verifyLogin();


			$page = new PageAdmin();

			$page->setTpl("categories-create");
		});

		$app->post("/admin/categories/create", function() {

			User::verifyLogin();

			$category = new Category();

			$category->setData($_POST);

			$category->save();

			header('Location: /admin/categories');
			exit;

			
		});

		$app->get("/admin/categories/:idcategory/delete", function($idcategory){

			User::verifyLogin();

			$category = new Category();

			$category->get((int)$idcategory);

			$category->delete();
			
			header('Location: /admin/categories');
			exit;
		});

		$app->get("/admin/categories/:idcategory", function($idcategory){

			User::verifyLogin();

			$category = new Category();

			$category->get((int)$idcategory);

			$page = new PageAdmin();
			
			$page->setTpl("categories-update",[
				'category'=>$category->getValues()
			]);
		});

		$app->post("/admin/categories/:idcategory", function($idcategory){

			User::verifyLogin();

			$category = new Category();

			$category->get((int)$idcategory);

			$category->setData($_POST);

			$category->save();

			header('Location: /admin/categories');
			exit;

			
		});
		//rota para o arquivo category.html
		$app->get("/categories/:idcategory", function($idcategory){

			$category = new Category();
			//carrega a categoria
			$category->get((int)$idcategory);
			//essa rota retorna uma página do site, por isso usa-se a classe Page()
			$page = new Page();
			//chama e monta o template category com o rainTpl
			$page->setTpl("category", [
				'category'=>$category->getValues(),
				'products'=>[]//apenas para não dar erro nos teste por agora, pois ainda não tenho os produtos no banco
			]);
		});

?>
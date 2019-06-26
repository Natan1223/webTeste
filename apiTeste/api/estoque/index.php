<?php

require '../vendor/autoload.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->response()->header('Content-Type', 'application/json;charset=utf-8');

$app->get('/', function () {
  echo "Api em execução! ";
});


// rotas
// estoque loja
$app->post('/produto_estoque_loja','addProduto_loja');
$app->get('/produto_estoque_loja/:id','getProduto_loja');
$app->post('/atualiza_estoque_loja/:id','saveProduto_loja');
$app->get('/produtos_estoque_loja','getProdutos_loja');

// estoque galpão
$app->post('/produto_estoque_galpao','addProduto_galpao');
$app->get('/produto_estoque_galpao/:id','getProduto_galpao');
$app->post('/atualiza_estoque_galpao/:id','saveProduto_galpao');
$app->get('/produtos_estoque_galpao','getProdutos_galpao');


$app->run();

// conexão com o BD
function getConn()
{
 return new PDO('mysql:host=Host_do_banco_de_dados;dbname=nome_do_banco_de_dados',
  'usuario_banco_de_dados',
  'senha_banco_de_dados',
  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
  
  );

}

// ******************************************************************************************************
// Estoque loja
// Insere um novo produto no estoque com sua quantidade
function addProduto_loja()
{
  $request = \Slim\Slim::getInstance()->request();
  $produto = json_decode($request->getBody());
  $sql = "INSERT INTO estoque_loja (cod_produto,qtde_produto) values (:cod_produto,:qtde_produto) ";
  $conn = getConn();
  $stmt = $conn->prepare($sql);
  $stmt->bindParam("cod_produto",$produto->cod_produto);
  $stmt->bindParam("qtde_produto",$produto->qtde_produto);
  $stmt->execute();
  $produto->id = $conn->lastInsertId();
  echo json_encode($produto);
}

// Lista um produto especifico de acordo com o codigo do produto
function getProduto_loja($id)
{
  $conn = getConn();
  $sql = "SELECT * FROM estoque_loja WHERE cod_produto=:id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam("id",$id);
  $stmt->execute();
  $produto = $stmt->fetchObject();

  echo json_encode($produto);
}

// Atualiza a quantidade de produto no estoque
function saveProduto_loja($id)
{
  $request = \Slim\Slim::getInstance()->request();
  $produto = json_decode($request->getBody());
  $sql = "UPDATE estoque_loja SET qtde_produto=:qtde_produto WHERE cod_produto=:id";
  $conn = getConn();
  $stmt = $conn->prepare($sql);
  $stmt->bindParam("qtde_produto",$produto->qtde_produto);
  $stmt->bindParam("id",$id);
  $stmt->execute();
  echo json_encode($produto);
}

// Lista todos os produtos da tabela
function getProdutos_loja()
{
  $sql = "SELECT * FROM estoque_loja";
  $stmt = getConn()->query($sql);
  $produtos = $stmt->fetchAll(PDO::FETCH_OBJ);
  echo "{\"produtos\":".json_encode($produtos)."}";
}



// *******************************************************************************************************************
// Codigo para o estoque galpão

// Insere um novo produto no estoque com sua quantidade
function addProduto_galpao()
{
  $request = \Slim\Slim::getInstance()->request();
  $produto = json_decode($request->getBody());
  $sql = "INSERT INTO estoque_galpao (cod_produto,qtde_produto) values (:cod_produto,:qtde_produto) ";
  $conn = getConn();
  $stmt = $conn->prepare($sql);
  $stmt->bindParam("cod_produto",$produto->cod_produto);
  $stmt->bindParam("qtde_produto",$produto->qtde_produto);
  $stmt->execute();
  $produto->id = $conn->lastInsertId();
  echo json_encode($produto);
}

// Lista um produto especifico de acordo com o codigo do produto
function getProduto_galpao($id)
{
  $conn = getConn();
  $sql = "SELECT * FROM estoque_galpao WHERE cod_produto=:id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam("id",$id);
  $stmt->execute();
  $produto = $stmt->fetchObject();

  echo json_encode($produto);
}

// Atualiza a quantidade de produto no estoque
function saveProduto_galpao($id)
{
  $request = \Slim\Slim::getInstance()->request();
  $produto = json_decode($request->getBody());
  $sql = "UPDATE estoque_galpao SET qtde_produto=:qtde_produto WHERE cod_produto=:id";
  $conn = getConn();
  $stmt = $conn->prepare($sql);
  $stmt->bindParam("qtde_produto",$produto->qtde_produto);
  $stmt->bindParam("id",$id);
  $stmt->execute();
  echo json_encode($produto);
}

// Lista todos os produtos da tabela
function getProdutos_galpao()
{
  $sql = "SELECT * FROM estoque_galpao";
  $stmt = getConn()->query($sql);
  $produtos = $stmt->fetchAll(PDO::FETCH_OBJ);
  echo "{\"produtos\":".json_encode($produtos)."}";
}






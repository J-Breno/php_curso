<?php
interface Database {
    public function listarProdutos();
    public function adicionarProduto();
    public function alterarProduto();
}

class MysqlDB implements Database {
    public function listarProdutos()
    {

    }

    public function adicionarProduto()
    {
        echo "Adicionando com MySql";
    }

    public function alterarProduto()
    {
        
    }

}
<?php

namespace App\Controllers;

use MIG\Controller\Action;
use MIG\DI\Container;

class IndexController extends Action
{

    public function index()
    {
        $clientes = Container::getModel("Cliente");
        $this->view->cliente = $clientes->fetchClientes();
        $this->render('index');
    }

    public function consulta()
    {
        $id = $_POST['id'];
        if ($id > 0) {
            $clientes = Container::getModel("Cliente");
            $cliente = $clientes->fetchClientes($id);
            foreach ($cliente as $cliente2) ;
            $json = json_encode($cliente2);
        }
        echo $json;


    }

    public function exclusao()
    {
        $id = $_POST['id'];
        if ($id > 0) {
            $clientes = Container::getModel("Cliente");
            $retorno = $clientes->excluirCliente($id);
            $json = json_encode($retorno);
            echo $json;
        }

    }

    public function cadastro()
    {
        $clientes = Container::getModel("Cliente");

        if (isset($_POST) && isset($_FILES)) {

            $cliente['nome'] = (isset($_POST['nome'])) ? $_POST['nome'] : '';
            $cliente['email'] = (isset($_POST['email'])) ? $_POST['email'] : '';
            $cliente['telefone'] = (isset($_POST['telefone'])) ? $_POST['telefone'] : '';
            $cliente['foto'] = $_FILES["foto"];
            $cadastro = $clientes->cadastroCliente($cliente);

        }

    }

    public function contact()
    {
        $contatos = Container::getModel("Contato");
        $this->view->contatos = $contatos->find(2);
        //$this->view->eventos = array("Contato1","Contato2","Contato3");
        $this->render('contact');
    }


}
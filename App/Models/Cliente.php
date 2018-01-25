<?php

namespace App\Models;


use MIG\Model\Table;

class Cliente extends Table
{
    protected $table = "cliente";

    public function fetchClientes($id = 0)
    {
        $consulta = "";
        if ($id > 0) $consulta = " and c.id =" . $id;
        $query = "select c.*, f.endereco from cliente c left join foto f on c.album_id = f.album_id where c.ativo = 1" . $consulta;
        $clientes = $this->db->query($query);
        $a = 0;

        foreach ($clientes as $cliente2) {

            $query = "select tipocontato, descricao from contato c inner JOIN tipocontato t on c.tipocontato_id = t.id where c.cliente_id = " . $cliente2['id'];
            $contatos = $this->db->query($query);

            foreach ($contatos as $contato) {
                $cliente2 += [$contato['tipocontato'] => $contato['descricao']];
            }
            $cliente[$a] = $cliente2;
            $a++;

        }

        return $cliente;
    }

    public function excluirCliente($id)
    {
        $consulta = " and id =" . $id;
        $query = " UPDATE cliente set ativo = 0 where ativo = 1 " . $consulta;
        $clientes = $this->db->query($query);

        return "1";
    }

    public function alteraCliente($cliente)
    {
        $query = " UPDATE cliente set nome = '".$cliente['nome']."' where id = ". $cliente['id'];
        $clientes = $this->db->query($query);

        $query = " UPDATE contato set descricao = '".$cliente['email']."' where tipocontato_id = 1 and cliente_id = ". $cliente['id'];
        $email = $this->db->query($query);

        $query = " UPDATE contato set descricao = '".$cliente['telefone']."' where tipocontato_id = 2 and cliente_id = ". $cliente['id'];
        $telefone = $this->db->query($query);

        if($cliente['foto']['size']>0){
            $query = "select f.endereco from cliente c inner JOIN foto f on c.album_id = f.album_id where f.tipofoto_id = 1 and c.id = ".$cliente['id'];
            $albumArray = $this->db->query($query);
            foreach ($albumArray as $album);
            $endereco = $album['endereco'];
            if (!move_uploaded_file($cliente['foto']['tmp_name'], $endereco)) {
                $retorno = array('status' => 0, 'mensagem' => 'Houve um erro ao gravar arquivo na pasta de destino!');
                echo json_encode($retorno);
                exit();
            }

        }

    }


    public function cadastroCliente($cliente)
    {

        $query = "INSERT INTO `album` (`descricao`) VALUES ('Fotos de " . $cliente['nome'] . "')";
        $uploadalbum = $this->db->query($query);

        $lastId = "select id from album order by id desc limit 1";
        $lastId = $this->db->query($lastId);
        foreach ($lastId as $ultimoId) ;


        $endereco = 'img/clientes/album_' . $ultimoId['id'] . "_1_perfil.jpg";
        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $endereco)) {
            $retorno = array('status' => 0, 'mensagem' => 'Houve um erro ao gravar arquivo na pasta de destino!');
            echo json_encode($retorno);
            exit();
        }


        $query = "INSERT INTO `foto` (`album_id`, `tipofoto_id`, `endereco`) VALUES (" . $ultimoId['id'] . ", 1, '" . $endereco . "')";
        $uploadImagem = $this->db->query($query);

        $query = "INSERT INTO `cliente` (`album_id`, `nome`) VALUES ('" . $ultimoId['id'] . "', '" . $cliente['nome'] . "')";
        $clientes = $this->db->query($query);

        $lastId = "select id from cliente order by id desc limit 1";
        $lastId = $this->db->query($lastId);
        foreach ($lastId as $ultimoId) ;

        $query = "INSERT INTO `contato` (`cliente_id`, `tipocontato_id`, `descricao`) VALUES (" . $ultimoId['id'] . ", 1, '" . $cliente['email'] . "')";

        $contatoEmail = $this->db->query($query);

        $query = "INSERT INTO `contato` (`cliente_id`, `tipocontato_id`, `descricao`) VALUES (" . $ultimoId['id'] . ", 2, '" . $cliente['telefone'] . "')";
        $contatoTelefone = $this->db->query($query);


        print_r($ultimoId['id']);


    }

}
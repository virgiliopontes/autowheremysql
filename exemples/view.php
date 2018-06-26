
<?php
    require_once(__DIR__.'/../vendor/autoload.php');
    $autoWhereMysql = new AutoWhere\AutoWhereMysql('',true);
    $autoWhereMysql->show_dependences();
    $params = array(
        "method"=>'POST',
        "destino"=>'',
        "filters"=>array(
            "texto.~transportadoras.id"=>"ID",
            "texto.~transportadoras.nome"=>"Nome",
            "cpf.~cpf"=>"CPF",
            "cnpj.~cnpj"=>"CNPJ",
            "rg.~rg"=>"RG",
            "ie.~ie"=>"IE",
            "data.~data_nascimento"=>"Data de Nascimento",
            "telefone.~telefone"=>"Telefone",
            "telefone.~celular"=>"Celular",
            "text.~email"=>"e-Mail",
            "text.~comicao"=>"Comissão",
            "moeda.~meta"=>"Meta",
            "cep.~cep"=>"CEP",
            "texto.~bairro"=>"Bairro",
            "texto.~cidades.nome"=>"Cidade",
            "texto.~estados.uf"=>"Estado",
            "texto.~numero"=>"Numero",
            "texto.~rua"=>"Rua",
        )
    );
    if(isset($_POST['campofiltro'])){
        echo $autoWhereMysql->make_where($_POST['campofiltro'],$_POST['operador'],$_POST['valorfiltro']);
    }
    $autoWhereMysql->set_params($params);
    $autoWhereMysql->show_view();
?>
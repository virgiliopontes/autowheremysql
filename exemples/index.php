<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <?php
        require_once(__DIR__.'/../src/autowheremysql.php');
        $autoWhereMysql = new AutoWhere\AutoWhereMysql();
        if(isset($_POST['campofiltro'])){
            $where = $autoWhereMysql->make_where($_POST['campofiltro'],$_POST['operador'],$_POST['valorfiltro']);
        }
    ?>
</head>
<body>
    <br>
    <br>
    <div class="row"><center>
    <?php
        echo isset($where)?$where:'';
    ?>
    </center>
    <div class="col-sm-12">
        <div class="nav-tabs-custom">
        <form id="filtros" method="post">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Filtros Avançados</a></li>
            </ul>
            <div class="tab-content">
                <div id="erros"></div>
                <div class="tab-pane active" id="tab_1">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-6" >
                                <label for="campos">Campo:</label>
                                <select class="form-control" name="campos" id="campos">
                                <?php
                                    $filters = array(
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
                                    );
                                    foreach($filters as $key=>$value){
                                    echo "<option value='$key'>$value</option>";
                                    }
                                ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6" >
                                <label for="opr">Operação:</label>
                                <select class="form-control" name="opr" id="opr">
                                    <option value='='>Igual</option>
                                    <option value='!='>Diferente</option>
                                    <option value='contem'>contém</option>
                                    <option value='>'>Maior</option>
                                    <option value='>='>Maior ou Igual</option>
                                    <option value='<'>Menor</option>
                                    <option value='<='>Menor ou Igual</option>
                                    <option value='entre'>Entre</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12" id="inputvalorverf">
                                <label for="valorverf">Valor</label>
                                <input class="form-control valorverf" type="text" name="valorverf" id="valorverf" value="">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <center><input type="button" onclick="adicionar()" id="btn_funcionarios" class="btn btn-success btn-flat" value="Adicionar" style="margin-top:24px;"> <input type="submit" id="btn_funcionarios" class="btn btn-success btn-flat" value="Enviar" style="margin-top:24px;"></center>
                        </div>
                    </div>
                    <div class="col-md-12">
                    <h3 id="titulo"></h3>
                    <div id="item_selecionado" ></div>
                    <table id="tabela" class="table table-striped table-bordered dt-responsive" width="100%">
                        <thead>
                            <tr>
                                <th>Campo</th>
                                <td>Operador</td>
                                <td>Valor</td>
                                <td>Ação</td>
                            </tr>
                        </thead>
                        <tbody id="tabeladados">
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    <script>
    function excluird(dados){
        $('#'+dados).html('');
    }
    cont = 0;
    function adicionar(){
        if($('#valorverf').val()!=''){
            cont++;
            var html  = '<tr id="regra'+cont+'">'+
                            '<th><input type="hidden" name="campofiltro[]" value="'+$('#campos').val()+'"></input>'+$('#campos option:selected').html()+'</th>'+
                            '<td><input type="hidden" name="operador[]" value="'+$('#opr').val()+'"></input>'+$('#opr').val()+'</td>'+
                            '<td><input type="hidden" name="valorfiltro[]" value="'+$('#valorverf').val()+($('#valorverf2').val()!=''&&$('#valorverf2').val()!==undefined?'~~'+$('#valorverf2').val():'')+'"></input>'+$('#valorverf').val()+($('#valorverf2').val()!=''&&$('#valorverf2').val()!==undefined?' E '+$('#valorverf2').val():'')+'</td>'+
                            '<td class="col-md-1"><a class="btn btn-danger btn-sm sweet-2" onclick="excluird(\'regra'+cont+'\')" data-original-title="Excluir">Remover</a></td>'+
                        '</tr>';
            ant = $('#tabeladados').html();
            $('#tabeladados').html(html+ant);
            $('#valorverf').val('');
            if($('#valorverf2').val()!=''){
                $('#valorverf2').val('');
            }
            maskcampo();
        }else{
            alert('O Campo Valor não pode estar vazio!');
        }
    
    }

    $('#campos').change(function() {
        maskcampo();
    });

    function maskcampo(){
        mask = $('#campos').val().split(".~");
        switch(mask[0]) {
            case 'texto':
                $('.valorverf').unmask();
                $(".valorverf").maskMoney('destroy');
                break;
            case 'data':
                $(".valorverf").maskMoney('destroy');
                $('.valorverf').datepicker({
                    language: 'pt-BR',
                    format: 'dd/mm/yyyy',
                    forceParse: false
                });
                $('.valorverf').mask('99/99/9999');
                break;
            case 'moeda':
                $('.valorverf').unmask();
                $(".valorverf").maskMoney({prefix:'R$ ', thousands:'.', decimal:',', affixesStay: false});
                break;
            case 'telefone':
                $(".valorverf").maskMoney('destroy');
                $('.valorverf').mask("(99) 9999-9999?9");
                break;
            case 'cep':
                $(".valorverf").maskMoney('destroy');
                $(".valorverf").mask("99999-999");
                break;
            case 'cnpj':
                $(".valorverf").maskMoney('destroy');
                $(".valorverf").mask("99.999.999/9999-99");
                break;
            case 'cpf':
                $(".valorverf").maskMoney('destroy');
                $(".valorverf").mask("999.999.999-99");
                break;
            default:
                $('.valorverf').unmask();
                $(".valorverf").maskMoney('destroy');   
        }
    }

    $('#opr').change(function() {
        mudarinput();
        maskcampo();
    });

    function mudarinput(){
        if($('#valorverf').val()!=''){
            var value = $('#valorverf').val();
        }else{
            var value='';
        }
        switch($('#opr').val()) {
            case 'entre':
                $('#inputvalorverf').html('<div class="row"><div class="col-md-6 col-xs-6"><label for="valorverf">Valor</label><input class="form-control valorverf" type="text" name="valorverf" id="valorverf" value=""></div><div class="col-md-6 col-xs-6"><label for="valorverf">Valor</label><input class="form-control valorverf" type="text" name="valorverf2" id="valorverf2" value=""></div></div>'); 
                break;
            default:
                $('#inputvalorverf').html('<label for="valorverf">Valor</label><input class="form-control valorverf" type="text" name="valorverf" id="valorverf" value="">'); 
        }
        maskcampo();
        $('#valorverf').val(value);
    }
    </script>
    
</body>
</html>
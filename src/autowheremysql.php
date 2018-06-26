<?php
namespace AutoWhere;
use raelgc\view\Template;

class AutoWhereMysql{
    /**
     * @param array $tipos Array com os tipos de campos que ele deve remover caracteres especiais;
     */
    function __construct($tipos='',$view=false){
        if($tipos==''){
            $this->removermascaras = array("telefone","cnpj","cpf","rg","ie","cep");
        }else{
            $this->removermascaras = $tipos;
		}
		$view = $view===true ? __DIR__.'/view.html' : $view;
		
		if($view){
			$this->tpl = new Template($view);
		}
		
    }

    function moedaParaNumero($valor)    {
        if (is_null($valor) || strlen($valor) == 0) {
            return null;
        }

        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);

        return $valor;
	}

	function set_params($params){
		$this->params = $params;
	}

	function show_view(){
		if(isset($this->tpl)){
			$this->tpl->DESTINO = $this->params['destino'];
			$this->tpl->METHOD = $this->params['method'];

			foreach($this->params['filters'] as $key=>$value){
				$this->tpl->CAMPO = $key;
				$this->tpl->VALOR = $value;
				$this->tpl->block("BLOCK_PARAMETROS");
			}
			$this->tpl->block("BLOCK_VIEW");
			$this->tpl->show();		
		}
	}

	function show_dependences(){
		if(isset($this->tpl)){
			if(isset($this->dependences)){

			}else{
				$this->tpl->block("BLOCK_CDNJSDEPENDENCES");
			}

			$this->tpl->show();		
		}
	}

	function set_dependences($dependences){
		$this->dependences = $dependences;
	}
	
	/**
	 * Retorna a a parte Where de uma consulta apartir dos arrays passados
	 * @param array $campofiltro Tipo.~Campo no banco de dados
	 * @param array $operadores Operadores do filtro
	 * @param array $values Valores do filtro
	 * @return string
	 */
    function make_where($campofiltro,$operadores,$values){
		if(is_array($values)){
			//Limpa os dados para montar o WHERE
			foreach($values as $key=>$value){
				$tipo = explode('.~',$campofiltro[$key]);
				if(in_array($tipo[0],$this->removermascaras)){
					$values[$key] = preg_replace('/[^a-z0-9~-~ç-Ç]/i', '', $value);
				}elseif($tipo=="moeda"){
					$values[$key] = $this->moedaParaNumero($value);
				}else{
					$values[$key] = $value;
				}
			}

			//Deixa os Arrays em ordem decrescente
			krsort($values);
			krsort($operadores);
			krsort($campofiltro);

			$campos = array();
			foreach($values as $key=>$value){
				$TipoeCampo = explode('.~',$campofiltro[$key]);
				if(is_array($TipoeCampo)&&isset($TipoeCampo[1])){
					$campotabela = $TipoeCampo[1];
				}else{
					echo "Certifiquesse de estar utilizando '.~' para separar o tipo e campo na base de dados";
				}
                $campoOperador = $campotabela.$operadores[$key];

				if(!isset($campos[$campoOperador])){
					$campos[$campoOperador]=array();
				}
				
				if($operadores[$key]=="!="){
                    if($value=='null'){
                        $campos[$campoOperador][] .= $campotabela." IS NOT ".$value." ";
                    }else{
                        $campos[$campoOperador][] .= " (".$campoOperador."'".$value."' OR ".$campotabela." IS NULL) ";
                    }
                    
				}elseif($operadores[$key]=="="){
                    if($value=='null'){
                        $campos[$campoOperador][] .= $campotabela." IS NULL ";
                    }else{
                        $campos[$campoOperador][] .= $campoOperador."'".$value."' ";
                    }

                }elseif(($operadores[$key]==">"||$operadores[$key]=="<"||$operadores[$key]=="<="||$operadores[$key]==">=")&&$value!='null'){	
					$campos[$campoOperador][] .= $campoOperador." ".(is_numeric($value) ? $value : "'".$value."'" )." ";
                    
				}elseif($operadores[$key]=="contem"){
                    $campos[$campoOperador][] .= $campotabela." LIKE '%".$value."%' ";
                    
				}elseif($operadores[$key]=="entre"){
					$valores = explode('~~',$value);
					if(is_array($valores)){
						$campos[$campoOperador][] .= " (".$campotabela." BETWEEN '".$valores[0]."' AND '".$valores[1]."') ";
					}
                    unset($valores);
                    
				}
			}

			$where ="";
			foreach($campos as $key=>$values){
				if($where !=''){
					$where  .=' AND ';
				}
				if(count($values)>1){
					$where .= "( ";
					foreach($values as $qtd =>$value){
						if($qtd==0){
							$where .= $value;
						}else{
							$where .= ' OR '.$value;
						}
					}
					$where .= " )";
				}else{
					$where .=$values[0];
				}
			}

			if(substr($where , -4)=='AND '){
				$where  = substr($where ,0,-4);
			}
			
			return $where; 
		}else{
			return '';
		}
	}
}
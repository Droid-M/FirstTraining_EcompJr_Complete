<?php 

/**
 * Faz o tratamento dos parametros passados por GET e chama o controlador de acordo com eles
 * @author EcompJr
 * @access public
 *
 */
class Router{
    private $url;
    private $controller;
    private $method;
    private $param;

    /**
     * Faz a chamada para uma classe e seus metodos de acordo com o conteudo da url passada
     * @param _GET $request Conjunto de informacoes coletadas do navegador apos uma acao do usuario
     */
    public function start($request){        
        if(isset($request['url'])){
            $this->url = explode('/', $request['url']);
            $this->controller = ucfirst($this->url[0] . "Controller");
            array_shift($this->url);
        
            if(isset($this->url[0])){
                $this->method = $this->url[0];
                array_shift($this->url);
                if(isset($this->url[0])){
                    $this->param = $this->url;                    
                }
            }        
        }else{
            $this->controller = "HomeController";
            $this->method = "index";
        }        
        call_user_func([new $this->controller, $this->method], $this->param);
    }
}

<?php 
require_once('conexao.php');

if(isset($_POST['action'])){
    $action = $_POST["action"];

    switch($action){
        case '1' : salvarAviso();
        break;
        case '2' : editaAviso();
        break;
        default : return false;
        break;
    }
}
function verificarProximoAviso(){
    global $conn;
    $sql = 'SELECT * FROM avisosNum WHERE id = 1';
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0){        
        $row = $result->fetch_assoc();
        $now = new DateTime();
        $anoAtual = $now->format('Y');
        if($row['ano'] != $anoAtual){
            $row['ano'] = $anoAtual;
            $row['num'] = '1';

        } else {
            $row['num']++;
        }

        return $row;
    } else {
        return false;
    }
}
function salvarAviso(){
    $dados = $_POST;
    global $conn;
    
    
    $aviso = explode("/", atualizarNumeroAviso($dados["aviso"]));
    $avisoNum = $aviso['0'];
    $avisoAno = $aviso['1'];
    

    $now = new DateTime();
    $agora = $now->format('Y-m-d H:i:s');

    $sql = "INSERT INTO aviso (id, num, ano, dataAviso, titulo, breveResumo, texto, fixar) VALUES (NULL, '$avisoNum', '$avisoAno', '$agora', '".$dados["titulo"]."', '".$dados["descricao"]."', '".$dados["fullText"]."', ".$dados["fix"].")";
    $result = $conn->query($sql);

    if($result) {
        echo '{"retorno" : true}';
    } else {
        echo '{"retorno" : false, "msg" : "'.$sql.'"}';
    }
}

function editaAviso(){
    $dados = $_POST;
    global $conn; 

    $sql = "UPDATE aviso SET titulo = '".$dados["titulo"]."', breveResumo = '".$dados["descricao"]."', texto = '".$dados["fullText"]."', fixar = ".$dados["fix"].", edit = true WHERE id = '".$dados["idAviso"]."';";
    $result = $conn->query($sql);

    if($result) {
        echo '{"retorno" : true}';
    } else {
       echo '{"retorno" : false, "msg" : "'.$sql.'"}';
    }

}









function atualizarNumeroAviso($aviso){
    global $conn;

    $aviso1 = explode("/", $aviso);
    $avisoNum = $aviso1['0'];
    $avisoAno = $aviso1['1'];

    $sql = "UPDATE avisosNum SET num = '$avisoNum', ano = '$avisoAno' WHERE id = 1";
    $result = $conn->query($sql);

    return $aviso;

}
function verificarLidos(){
    global $conn;

    if(isset($_COOKIE['user'])){
        $user = $_COOKIE['user'];
    } else {
        $user = '';
    }

    $sql = "SELECT * FROM leitura WHERE user = '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0){
        $lidos = array();
        while ($row = $result->fetch_assoc()) {
            array_push($lidos, $row['idAviso']);
        }
        return '{"retorno" : true, "ids" : "'.implode(',', $lidos).'"}';
    } else {
        return '{"retorno" : false}';
    }   
}
function listarAvisos($array=["p" => '0']){
    global $conn;

    $rpp = '6'; //registro por pagina 
    $p = $array['p']; //pagina
    


    $lidos = json_decode(verificarLidos());
    if($lidos->retorno){
        $param = "WHERE id NOT IN ($lidos->ids) OR fixar = '1'";
    } else {
        $param = "";
    }
    
    if(isset($array["ref"])){
        $ref = $array["ref"];
        $param = "WHERE titulo LIKE '%$ref%' OR breveResumo LIKE '%$ref%' OR texto LIKE '%$ref%'";
        $refPagina = '&ref='.$array["ref"];
        if($array["ref"] == ''){
            $titulo = "Exibindo Todos os Avisos";
        } else {
            $titulo = "Exibindo Avisos por pequisados por referência (% ". $array["ref"]." %)";
        }
    } else {
        $titulo = "Exibindo Avisos não lidos ou fixados";
    }


    $sql = "SELECT count(*) FROM aviso $param";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $totalRegistros = $row["count(*)"];
    $qtPaginas = ceil($totalRegistros / $rpp);

    if ($p <= "1") {
        $posicao = 0;
        $pagina = "1";
    } else {
        $posicao = ($rpp * $p) - $rpp;
        $pagina = $p;
    }

    if ($qtPaginas > '1') {
        $paginacao = array('qtPagina' => $qtPaginas, 'pagina' => $pagina);
    } else {
        $paginacao = NULL;
    }

    $sql = "SELECT * FROM aviso $param ORDER BY fixar DESC, id DESC LIMIT $posicao,$rpp";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $html = '<div class="col-12"><h4>'.$titulo.'</h4></div>';
        
        while ($row = $result->fetch_assoc()) {
            if($row["fixar"]){
                $fixo = '- Fixado';
            } else {
                $fixo = '';
            }
            if($row["edit"]){
                $editado = '- EDITADO';
            } else {
                $editado = '';
            }
            $html .= <<<EOF
                <div class="col-4">
                    <div class="card text-dark bg-light mb-3" style="max-width: 25rem; min-height: 16rem">
                        <div class="card-header">Aviso nº  {$row['num']}/{$row['ano']} {$fixo} {$editado}</div>
                        <div class="card-body">
                            <h5 class="card-title">{$row['titulo']}</h5>
                            <p class="card-text">{$row['breveResumo']}</p>
                        </div>
                        <div class="card-footer text-end">
                        <a class="btn btn-primary" href="?m=2&id={$row['id']}">Ler aviso completo</a>
                      </div>
                    </div>
                </div>
            EOF;
            
        }
        if($paginacao){
            $html .= '
                <nav>
                    <ul class="pagination justify-content-center">';
                    if ($paginacao["pagina"] > '1') { 
                        $html .= '
                        <li class="page-item">
                            <a class="page-link" href="?p='.($paginacao['pagina']-1).$refPagina.'">Anterior</a>
                        </li>';
                    }
                    $html .= '
                    <li class="page-item disabled">
                        <P class="page-link">Página '.$paginacao["pagina"].' de '.$paginacao["qtPagina"].'</P>
                    </li>';

                    if ($paginacao["pagina"] < $paginacao["qtPagina"]) { 
                        $html .= ' 
                        <li class="page-item">
                            <a class="page-link" href="?p='.($paginacao["pagina"]+1).$refPagina.'">Próxima</a>
                        </li>';
                    }
                    $html .= '
                </ul>
            </nav>';
        }



        return $html;
        //$retorno = array('paginacao' => $paginacao, 'total' =>  $totalRegistros);
    } else {
        return '<h2> Aviso não localizado </h2>';
    }
}

function exibirAviso($id){
    global $conn, $privlegio;

    $sql = "SELECT * FROM aviso WHERE id = $id";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $data = date("d/m/Y H:i", strtotime($row["dataAviso"]));
        $html = '<div class="container p-3">';
        $html .= '<div class="row">';
        $html .= '<div class="col-12 text-center"><h1>Aviso nº'.$row["num"].'/'.$row["ano"].'</h1><h5>'.$data.'</h5></div><hr />';
        $html .= '</div>';
        $html .= '<div class="row">';
        $html .= '<div class="col-12 text-center"><h3>'.$row["titulo"].'</h3></div>';
        $html .= '</div>';
        $html .= '<div class="row">';
        $html .= '<div class="col-12">'.$row["texto"].'</div>';
        $html .= '</div>';
        $html .= '<div class="row">';
        $html .= '<div class="col-12 text-center">
                    <button class="btn btn-primary me-3">Dar Ciência e marcar como lido</button>
                    <button class="btn btn-primary '.$privlegio.' me-3">Exibir Histórico de leitura</button>
                    <a href="/?m=1&a=2&aviso='.$row["id"].'" class="btn btn-primary '.$privlegio.'">Editar</a></div>';
        $html .= '</div>';
        
        $html .= '</div>';

        
        return $html;
    } else {
        return '<h2> Aviso não localizado </h2>';
    }

}
function carregarAviso($id){
    global $conn;

    $sql = "SELECT * FROM aviso WHERE id = $id";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return false;
    }
}
?>
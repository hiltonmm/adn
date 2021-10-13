<?php 
require_once('conexao.php');

$action = $_POST["action"];
switch($action){
    case '1' : salvarAviso();
    break;
    default : return false;
    break;
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
    
    if($dados["aviso"] === $dados["controle_aviso"]){
        $aviso = atualizarNumeroAviso($dados["aviso"]);
    } else {
        $aviso = explode("/", $dados["aviso"])
        $aviso["num"] = $aviso['0'];
        $aviso["ano"] = $aviso['1'];

    }

    echo '{"retorno" : true}';
}
?>
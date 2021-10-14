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

function atualizarNumeroAviso($aviso){
    global $conn;

    $aviso1 = explode("/", $aviso);
    $avisoNum = $aviso1['0'];
    $avisoAno = $aviso1['1'];

    $sql = "UPDATE avisosNum SET num = '$avisoNum', ano = '$avisoAno' WHERE id = 1";
    $result = $conn->query($sql);

    return $aviso;

}
?>
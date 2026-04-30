<?php 

    function informaReceitaOuDespesa() {
        $tipoReceita = $_POST["tipo"] ?? null;
        $valorReceita = $_POST["valor"] ?? 0;
        
        if(!isset($_SESSION["totalReceitas"]) && !isset($_SESSION["totalDespesas"])){
            $_SESSION["totalReceitas"] = 0;
            $_SESSION["totalDespesas"] = 0;
        }

        if($tipoReceita == "receita"){
            $_SESSION["totalReceitas"] += $valorReceita;
        } else if($tipoReceita == "despesa"){
            $_SESSION["totalDespesas"] += $valorReceita;
        }
    };

    function saldo(){
        $saldo = $_SESSION["totalReceitas"] - $_SESSION["totalDespesas"];
        return $saldo;
    }

    function zerarHistorico() {
        unset($_SESSION['historico']);
        unset($_SESSION['totalReceitas']);
        unset($_SESSION['totalDespesas']);
        header('Location: historico.php');
        exit;
    }

    function validarHistorico(){
        return $_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['descricao']) && !empty($_POST['valor']);
    }
?>

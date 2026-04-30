<?php 
    session_start();

    $estaLogado = $_SESSION["logado"] ?? false;

    if(!$estaLogado){
        header("Location: login.php");
    }    
    
    $usuario = $_SESSION["usuario"] ?? null;

     if (!isset($_SESSION['historico'])) {
        $_SESSION['historico'] = [];
    }

    include "funcoes.php";

    if(validarHistorico()){
        $_SESSION['historico'][] = [
            date_default_timezone_set('America/Sao_paulo'),
            'data'      => date('d/m/Y - H:i'),
            'descricao' => $_POST['descricao'],
            'tipo'      => $_POST['tipo'],
            'valor'     => $_POST['valor']
        ];
    }
    
    informaReceitaOuDespesa();
    saldo();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carteira Digital</title>
    <link rel="icon" type="image/png" href="img/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="mx-auto flex min-h-screen w-full max-w-6xl flex-col gap-8 px-4 py-6 sm:px-6 lg:px-8">
        <header class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl shadow-cyan-950/30 backdrop-blur">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-[0.3em] text-cyan-300/80">Carteira Digital</p>
                    <h1 class="mt-2 text-3xl font-semibold text-white sm:text-4xl">My Wallet</h1>
                    <p class="mt-2 max-w-2xl text-sm text-slate-300">Acompanhe receitas, despesas e saldo em um painel limpo, rápido e responsivo.</p>
                </div>
                <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-slate-900/60 px-4 py-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-cyan-400/15 text-cyan-300 ring-1 ring-cyan-400/30">
                        <span class="text-lg font-semibold"><?php echo strtoupper(substr($usuario ?? 'U', 0, 1)); ?></span>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Bem-vindo</p>
                        <h2 class="text-lg font-semibold text-white">Olá, <?php echo $usuario; ?></h2>
                    </div>
                    <?php echo '<button class="ml-2 rounded-xl bg-rose-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-400" onclick="location.href=\'logout.php\'">Sair</button>'; ?>
                </div>
            </div>
        </header>

        <main class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr]">
            <section class="grid gap-4 sm:grid-cols-3">
                <article class="rounded-3xl border border-emerald-400/20 bg-emerald-400/10 p-5 shadow-lg shadow-emerald-950/20">
                    <p class="text-sm font-medium text-emerald-200/90">Total Receitas</p>
                    <p class="mt-3 text-2xl font-semibold text-white"><?php echo "R$ " . number_format($_SESSION["totalReceitas"], 2, ',', '.'); ?></p>
                </article>

                <article class="rounded-3xl border border-rose-400/20 bg-rose-400/10 p-5 shadow-lg shadow-rose-950/20">
                    <p class="text-sm font-medium text-rose-200/90">Total Despesas</p>
                    <p class="mt-3 text-2xl font-semibold text-white"><?php echo "R$ " . number_format($_SESSION["totalDespesas"], 2, ',', '.'); ?></p>
                </article>

                <article class="rounded-3xl border border-cyan-400/20 bg-cyan-400/10 p-5 shadow-lg shadow-cyan-950/20">
                    <p class="text-sm font-medium text-cyan-200/90">Saldo Disponível</p>
                    <p class="mt-3 text-2xl font-semibold text-white">R$ <?php echo number_format(saldo(), 2, ',', '.'); ?></p>
                </article>
            </section>

            <section class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl shadow-slate-950/30 backdrop-blur">
                <h3 class="text-xl font-semibold text-white">Adicionar Transação</h3>
                <p class="mt-1 text-sm text-slate-400">Registre rapidamente uma nova movimentação.</p>

                <form method="post" class="mt-6 space-y-4">
                    <div>
                        <label for="descricao" class="mb-2 block text-sm font-medium text-slate-200">Descrição</label>
                        <input type="text" name="descricao" placeholder="Insira a descrição da transação" class="w-full rounded-2xl border border-white/10 bg-slate-900/70 px-4 py-3 text-slate-100 placeholder:text-slate-500 outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20">
                    </div>
                    <div>
                        <label for="valor" class="mb-2 block text-sm font-medium text-slate-200">Valor</label>
                        <input type="number" name="valor" placeholder="Insira o valor da transação" step="0.01" class="w-full rounded-2xl border border-white/10 bg-slate-900/70 px-4 py-3 text-slate-100 placeholder:text-slate-500 outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20">
                    </div>
                    <div>
                        <label for="tipo" class="mb-2 block text-sm font-medium text-slate-200">Tipo</label>
                        <select name="tipo" class="w-full rounded-2xl border border-white/10 bg-slate-900/70 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20">
                            <option value="receita">Receita</option>
                            <option value="despesa">Despesa</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full rounded-2xl bg-cyan-500 px-4 py-3 font-semibold text-slate-950 transition hover:bg-cyan-400">Adicionar</button>
                </form>

                <div class="mt-6">
                    <?php echo '<button class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 font-semibold text-white transition hover:bg-white/10" onclick="location.href=\'historico.php\'">Ver Detalhes do Histórico</button>'; ?>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
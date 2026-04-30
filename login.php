<?php 
    session_start();

    $estaLogado = $_SESSION["logado"] ?? false;
    
    if ($estaLogado) {
        header("Location: index.php");
        exit();
    }

    $usuario = $_POST["nome"] ?? null;
    $senha = $_POST["senha"] ?? null;
        
    if($_SERVER["REQUEST_METHOD"] == "POST") {
            
        $usuario = $_POST["nome"] ?? null;
        $senha = $_POST["senha"] ?? null;
        
        password_hash("admin", PASSWORD_DEFAULT);
        $senhaComHash = '$2y$10$k9Zz93P4rkgeJqpXIGGm3OORdU.qODsAIIwJyUp7SlTo3Wji1Rnna';

    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar | Carteira Digital</title>
    <link rel="icon" type="image/png" href="img/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="flex min-h-screen items-center justify-center px-4 py-10">
        <div class="grid w-full max-w-5xl gap-0 overflow-hidden rounded-[2rem] border border-white/10 bg-white/5 shadow-2xl shadow-cyan-950/30 backdrop-blur lg:grid-cols-2">
            <section class="flex flex-col justify-between bg-gradient-to-br from-cyan-400 via-sky-500 to-blue-600 p-8 text-slate-950 sm:p-10">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-900/70">Carteira Digital</p>
                    <h1 class="mt-4 text-4xl font-bold leading-tight sm:text-5xl">Controle financeiro com visual premium.</h1>
                    <p class="mt-4 max-w-md text-sm leading-6 text-slate-900/80">Acesse sua conta para acompanhar receitas, despesas e histórico em um painel moderno.</p>
                </div>
                <div class="mt-10 grid grid-cols-3 gap-3 text-center text-sm font-medium text-slate-950/80">
                    <div class="rounded-2xl bg-white/35 p-4 backdrop-blur">
                        <p class="text-lg font-semibold text-slate-950">100%</p>
                        <p>responsivo</p>
                    </div>
                    <div class="rounded-2xl bg-white/35 p-4 backdrop-blur">
                        <p class="text-lg font-semibold text-slate-950">Tailwind</p>
                        <p>design</p>
                    </div>
                    <div class="rounded-2xl bg-white/35 p-4 backdrop-blur">
                        <p class="text-lg font-semibold text-slate-950">Rápido</p>
                        <p>acesso</p>
                    </div>
                </div>
            </section>

            <section class="flex items-center justify-center p-8 sm:p-10">
                <form method="post" class="w-full max-w-md space-y-5 rounded-[1.75rem] border border-white/10 bg-slate-950/70 p-8 shadow-xl">
                    <div>
                        <p class="text-sm font-medium uppercase tracking-[0.3em] text-cyan-300/80">Login</p>
                        <h2 class="mt-2 text-3xl font-semibold text-white">Entre na sua conta</h2>
                        <p class="mt-2 text-sm text-slate-400">Use seus dados para continuar.</p>
                    </div>

                    <div>
                        <label for="nome" class="mb-2 block text-sm font-medium text-slate-200">Usuário</label>
                        <input type="text" name="nome" placeholder="Digite seu usuário" class="w-full rounded-2xl border border-white/10 bg-slate-900/80 px-4 py-3 text-slate-100 placeholder:text-slate-500 outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20">
                    </div>

                    <div>
                        <label for="senha" class="mb-2 block text-sm font-medium text-slate-200">Senha</label>
                        <input type="password" name="senha" placeholder="Digite sua senha" class="w-full rounded-2xl border border-white/10 bg-slate-900/80 px-4 py-3 text-slate-100 placeholder:text-slate-500 outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20">
                    </div>

                    <?php 
                        if (!is_null($usuario) && !is_null($senha)) {
                            if ($usuario == "admin" && password_verify($senha, $senhaComHash)) {
                            $_SESSION["logado"] = true;
                            $_SESSION["usuario"] = $usuario;
                            header("Location: index.php");
                            exit();
                        } else {
                            echo "Usuario ou senha incorretos!";
                        }
                    }
                    ?>

                    <input type="submit" value="Entrar" class="w-full cursor-pointer rounded-2xl bg-cyan-500 px-4 py-3 font-semibold text-slate-950 transition hover:bg-cyan-400">
                </form>
            </section>
        </div>
    </div>
</body>
</html>
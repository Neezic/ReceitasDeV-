<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">

<h1>Login</h1>
<form action="<?= BASE_URL ?>?pagina=login&acao=login" method="POST">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
    Email: <input type="email" name="email"><br>
    Senha: <input type="password" name="senha"><br>
    <button type="submit">Entrar</button>
</form>
<a href="<?= BASE_URL ?>?pagina=login&acao=cadastro">Não tem uma conta? Cadastre-se</a>
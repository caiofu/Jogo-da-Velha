function Menu(acao)
{
    var rowLogin        =  document.getElementById('loginJogador');
    var rowCadastro     = document.getElementById('cadastraJogador');
    if(acao == 'login')
    {
       rowCadastro.style.display = "none";
       rowLogin.style.display = "flex";
    }
    else if (acao == 'cadastro')
    {
        rowCadastro.style.display = "flex";
       rowLogin.style.display = "none";
    }
}
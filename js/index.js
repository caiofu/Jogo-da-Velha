function Menu(acao)
{
    var rowLogin        =  document.getElementById('loginJogador');
    var rowCadastro     = document.getElementById('cadastraJogador');
    if(acao == 'login')
    {
       rowCadastro.style.display = "none";
       rowLogin.style.display = "block";
    }
    else if (acao == 'cadastro')
    {
        rowCadastro.style.display = "block";
       rowLogin.style.display = "none";
    }
}
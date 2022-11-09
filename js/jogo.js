function  posicaoEscolhida(icone)
{
  var idSelecao = document.querySelector('input[name="opcao"]:checked').value;

  console.log(idSelecao)
//Percorre para deixar selecionado somente o ultimo que foi escolhido
  for (let i = 1; i < 10; i++) 
  {
   
    if(i == idSelecao)
    {
        document.getElementById('sp'+idSelecao).innerHTML = icone;
    }
    else
    {
        //Condição para resetar somente campos que nao tiveram jogadas registradas
        if(document.querySelector("#opcao"+i).getAttribute("disabled") == null)
        {
            document.getElementById('sp'+i).innerHTML = "";
        }
        
    }
    
  }
}

function FinalizarTurno()
{
    //
 
    if(document.querySelector('input[name="opcao"]:checked') != null)
    {
      
        var campos = new FormData();
        campos.append("posicao", document.querySelector('input[name="opcao"]:checked').value);
         campos.append("idAdversario", document.getElementById("idAdversario").value);
        campos.append("idUsuario", document.getElementById("idUsuario").value);
        campos.append("idPartida", document.getElementById("idPartida").value);

       //Requisição
       var req  = new XMLHttpRequest();
       req.open('POST', '../paginas/registrarJogada.php');
       req.send(campos);

       req.onreadystatechange = function()
			{
				if(req.readyState == 4 && req.status == 200) // 4 - siginifica que foi concluido e contem resposta
				{
                    if(req.response == 1) // 1 - sucesso
                    {
                        document.getElementById("tabuleiro2").style.backgroundColor = "#6e7881ab"   
                     var procuraTurno =   setInterval(function() 
                     {
                             //Requisição
                            var dados = new FormData();
                            dados.append("idAdversario", document.getElementById('idAdversario').value)
                            dados.append("idPartida", document.getElementById("idPartida").value);
                            var ver  = new XMLHttpRequest();
                            ver.open('POST', '../paginas/verificaTurno.php');
                            ver.send(dados);

                            ver.onreadystatechange = function()
                            {
                                if(ver.readyState == 4 && ver.status == 200) // 4 - siginifica que foi concluido e contem resposta
                                {
                                   
                                    let dados = JSON.parse(ver.response);
                                      //Verifica se tem vencedor
                                      if(VerificaVencedor(dados, procuraTurno ) == false)
                                        {
                                            if(dados.turno == document.getElementById("idUsuario").value)
                                            {
                                                
                                                HabilitaCampos("habilitar");
                                                
                                                document.getElementById("aguardando").innerHTML = "";
                                                document.getElementById("tabuleiro2").style.backgroundColor = ""
                                                document.getElementById("btnFinalizarTurno").innerHTML =' <input type="button" class="botao-turno" onclick="FinalizarTurno();"  value="FINALIZAR TURNO">';
                                                console.log("e sua vez")
                                                VerificaTabuleiro();
                                                clearInterval(procuraTurno); //Para parar o intervalo
                                            }
                                            else
                                            {
                                                console.log("não é sua vez")
                                            }
                                        }
                                   
                                }
                            }
                            }
                        , 5000)
                        document.getElementById("aguardando").innerHTML= '<div class="animacao" >X</div>'+
                        '<div class="animacao2">O</div>'
                        +'<div class="animacao" >X</div>'
                        HabilitaCampos("desabilitar");
                        document.getElementById("btnFinalizarTurno").innerHTML = "<span class='msg-aguardando'>Aguardando jogada do oponente!</span>"
                    }
                }
            }
      
    }
    else
    {
        console.log("voce nao selecionou nada")
    }
}

//Responsavel por verificar de quem éa vez de jogar
function VerificaTurno()
{
    
    document.getElementById("aguardando").innerHTML = "<span class='msg-aguardando'>Verificando turno...</span>";

    //Dados da requisição
    var dados = new FormData();
    dados.append("idAdversario", document.getElementById('idAdversario').value)
    dados.append("idPartida", document.getElementById("idPartida").value);
    document.getElementById("tabuleiro2").style.backgroundColor = "#6e7881ab"

    //Fica a cada 10 segundos verificando se é sua vez de jogar
    var procuraTurno =   setInterval(function() 
    {
        //Requisição
     
        var ver  = new XMLHttpRequest();
        ver.open('POST', '../paginas/verificaTurno.php');
        ver.send(dados);
       
       ver.onreadystatechange = function()
        {
            if(ver.readyState == 4 && ver.status == 200) // 4 - siginifica que foi concluido e contem resposta
            {
                console.log(ver.response)
                let dados = JSON.parse(ver.response);
                console.log(dados)
                //VERIFICA SE TEM VENCEDOR OU NAO
                if(VerificaVencedor(dados, procuraTurno ) == false)
                {
                
                     //VERIFICA SE É O TURNO DO USUARIO LOGADO E PARA A REPETIÇÃO
                     if(dados.turno == document.getElementById("idUsuario").value)
                     {
                         HabilitaCampos("habilitar");
                         document.getElementById("aguardando").innerHTML = "";
                         document.getElementById("tabuleiro2").style.backgroundColor = ""
                         document.getElementById("btnFinalizarTurno").innerHTML =' <input type="button" class="botao-turno" onclick="FinalizarTurno();"  value="FINALIZAR TURNO">';
                         console.log("e sua vez")
                         VerificaTabuleiro();
                         clearInterval(procuraTurno); //Para parar o intervalo
                     }
                     else
                     {
                       
                         console.log("não é sua vez")
                     }
                }       
            }
        }
    }
   , 5000)
   //Timer
   setTimeout(function() 
    {
        //Mensagem de aguardando..
        document.getElementById("aguardando").innerHTML= '<div class="animacao" >X</div>'+
        '<div class="animacao2">O</div>'
        +'<div class="animacao" >X</div>';
        VerificaTabuleiro();
        HabilitaCampos("desabilitar");
        document.getElementById("btnFinalizarTurno").innerHTML = "<span class='msg-aguardando'>Aguardando jogada do oponente!</span>"
    }, 3000)
   
}

//Responsavel por verificar marcaçoes do tabuleiro
function VerificaTabuleiro()
{
    var campo = new FormData();
    campo.append('idPartida', document.getElementById("idPartida").value);
    campo.append("idUsuario", document.getElementById("idUsuario").value);
    campo.append("idAdversario", document.getElementById("idAdversario").value);
    
    var req  = new XMLHttpRequest();
    req.open('POST', '../paginas/verificaTabuleiro.php');
    req.send(campo);

    req.onreadystatechange = function()
    {
        if(req.readyState == 4 && req.status == 200) // 4 - siginifica que foi concluido e contem resposta
        {  
           let dados = JSON.parse(req.response);
           var tabuleiro = document.getElementById("tabuleiro2");

            //Loop do tamanhjo do tabuleiro
            for (let i = 0; i < dados.length; i++) 
            {
                    document.getElementById('sp'+dados[i].posicao).innerHTML = dados[i].icone;
                    document.querySelector("#opcao"+dados[i].posicao).setAttribute("disabled", "disabled");                        
            }                   
        }
    }
}

function HabilitaCampos(funcao)
{
    //habilidar/ desabilitar
    if(funcao == 'habilitar')
    {
        for (let i = 1; i < 10; i++)
        {
            document.querySelector("#opcao"+i).removeAttribute("disabled");
        } 
    }
    else if(funcao == 'desabilitar')
    {
        for (let i = 1; i < 10; i++)
        {
            document.querySelector("#opcao"+i).setAttribute("disabled", "disabled");
        } 
    }
}

function VerificaVencedor(dados, procuraTurno)
{
    if(dados.vencedor != 0)
    {
        
            //VENCEDOR
            if (dados.vencedor == document.getElementById("idUsuario").value) 
            {
                VerificaTabuleiro();
                HabilitaCampos("desabilitar");
                document.getElementById('tabuleiro2').style.backgroundColor = "#1f9b3b52"
                document.getElementById("btnFinalizarTurno").innerHTML = ""
                document.getElementById("aguardando").innerHTML = "";
                console.log("VOCE GANHOU")
                Swal.fire({
                    title: 'Você ganhou!',
                    text: 'Parabéns você ganhou!',
                    color: "white",
                    confirmButtonColor: '#007bff',
                    confirmButtonText: 'Ir para o Lobby',
                    background: "green",
                    allowOutsideClick: false,
                   
                  }).then((result) => {
                    /* Ação após clicar no botao */
                    if (result.isConfirmed) {
                        window.location.href = "../paginas/lobby.php";
                    } 
                  })
                clearInterval(procuraTurno);
            }
            //PERDEDOR
            else if (dados.vencedor == document.getElementById("idAdversario").value)
            {
                VerificaTabuleiro();
                HabilitaCampos("desabilitar");
                document.getElementById('tabuleiro2').style.backgroundColor = "#ff000057"
                document.getElementById("btnFinalizarTurno").innerHTML = ""
                document.getElementById("aguardando").innerHTML = "";
                Swal.fire({
                    title: 'Você perdeu!',
                    text: 'Não foi dessa vez :(',
                    color: "white",
                    confirmButtonColor: '#007bff',
                    background: "red",
                    allowOutsideClick: false,
                   
                  }).then((result) => {
                    /* Ação após clicar no botao */
                    if (result.isConfirmed) {
                        window.location.href = "../paginas/lobby.php";
                    } 
                  })
                console.log("VOCE PERDEU")
                clearInterval(procuraTurno);
            }
            return true;
    }
    else if(dados.empate != 0)
    {
        VerificaTabuleiro();
        HabilitaCampos("desabilitar");
        document.getElementById('tabuleiro2').style.backgroundColor = "#1f9b3b52"
        document.getElementById("btnFinalizarTurno").innerHTML = ""
        document.getElementById("aguardando").innerHTML = "";
        console.log("EMPATE!")
        Swal.fire({
            title: 'O JOGO EMPATOU!',
            text: 'Você empatou com seu adversário!',
            color: "white",
            confirmButtonColor: '#007bff',
            confirmButtonText: 'Ir para o Lobby',
            background: "green",
            allowOutsideClick: false,
           
          }).then((result) => {
            /* Ação após clicar no botao */
            if (result.isConfirmed) {
                window.location.href = "../paginas/lobby.php";
            } 
          })
        clearInterval(procuraTurno);
    }
    else
    {
        return false;
    }
}

function AtualizaRanking(idUsuario)
{
    //Animação
    var msgCarregandoModal = document.getElementById("msg-carregando-modal"); 
    var conteudoModal = document.getElementById("conteudo-modal");
    var corpoRanking = document.getElementById("corpo-ranking");
    
    conteudoModal.style.display ="none";
    msgCarregandoModal.style.display = "";
    msgCarregandoModal.innerHTML= '<div style="text-align: center;"><div class="animacao" >X</div>'+
    '<div class="animacao2">O</div>'
    +'<div class="animacao" >X</div><br><br>'+
    '<span class="msg-aguardando">Atualizando...</span></div>'
    

    var ver  = new XMLHttpRequest();
    ver.open('POST', '../paginas/dadosRanking.php');
    ver.send();

    ver.onreadystatechange = function()
    {
        if(ver.readyState == 4 && ver.status == 200) // 4 - siginifica que foi concluido e contem resposta
        {
            conteudoModal.style.display ="";
            msgCarregandoModal.style.display = "none";
            console.log(ver.response)
            let dados = JSON.parse(ver.response);
            corpoRanking.innerHTML = "";
            var colocacao =0;
            for (let i = 0; i < dados.length; i++) 
            {
                colocacao++;
                if(dados[i].idJogador == idUsuario  )
                {
                  bgPosicao = "style='background-color: green;'";
                }
                else
                {
                  bgPosicao = "";
                }
                corpoRanking.innerHTML += "<tr "+bgPosicao+"><td>"+colocacao+"</td><td>"+dados[i].nome+"</td><td>"+dados[i].vitoria+"</td><td>"+dados[i].derrota+"</td><td>"+dados[i].empate+"</td></tr>"
                
            }
         
            
        }
    }

}
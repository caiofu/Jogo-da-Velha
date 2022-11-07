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
        document.getElementById('sp'+i).innerHTML = "";
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
                     var procuraTurno =   setInterval(function() {
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
                                    if(ver.response == document.getElementById("idUsuario").value)
                                    {
                                        HabilitaCampos("habilitar");
                                        document.getElementById("aguardando").innerHTML = "";
                                        document.getElementById("btnFinalizarTurno").innerHTML =' <input type="button" class="botao-turno" onclick="FinalizarTurno();"  value="FINALIZAR TURNO">';
                                        console.log("e sua vez")
                                        clearInterval(procuraTurno); //Para parar o intervalo
                                    }
                                    else
                                    {
                                        console.log("não é sua vez")
                                    }
                                }
                            }
                            }
                        , 5000)
                        document.getElementById("aguardando").innerHTML= '<div class="animacao" >X</div>'+
                        '<div class="teste">O</div>'
                        +'<div class="animacao" >X</div>'
                        HabilitaCampos("desabilitar");
                        document.getElementById("btnFinalizarTurno").innerHTML = "Aguardando jogada do oponente!"
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
    //Fica a cada 10 segundos verificando se é sua vez de jogar
    document.getElementById("aguardando").innerHTML = "Verificando turno..";
    var procuraTurno =   setInterval(function() {
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
               if(ver.response == document.getElementById("idUsuario").value)
               {
                   HabilitaCampos("habilitar");
                   document.getElementById("aguardando").innerHTML = "";
                   document.getElementById("btnFinalizarTurno").innerHTML =' <input type="button" class="botao-turno" onclick="FinalizarTurno();"  value="FINALIZAR TURNO">';
                   console.log("e sua vez")
                   VerificaTabuleiro();
                   clearInterval(procuraTurno); //Para parar o intervalo
               }
               else
               {
                document.getElementById("aguardando").innerHTML= '<div class="animacao" >X</div>'+
                '<div class="teste">O</div>'
                +'<div class="animacao" >X</div>'
                HabilitaCampos("desabilitar");
                document.getElementById("btnFinalizarTurno").innerHTML = "Aguardando jogada do oponente!"
                   console.log("não é sua vez")
               }
           }
       }
       }
   , 5000)
}

//Responsavel por verificar marcaçoes do tabuleiro
function VerificaTabuleiro()
{
    var campo = new FormData();
    campo.append('idPartida', document.getElementById("idPartida").value);
    campo.append("idUsuario", document.getElementById("idUsuario").value);
    
    var req  = new XMLHttpRequest();
    req.open('POST', '../paginas/verificaTabuleiro.php');
    req.send(campo);

    req.onreadystatechange = function()
    {
        if(req.readyState == 4 && req.status == 200) // 4 - siginifica que foi concluido e contem resposta
        {
           console.log(req.response);
          
           let dados = JSON.parse(req.response);
           
           var tabuleiro = document.getElementById("tabuleiro2");

            //Loop do tamanhjo do tabuleiro
            for (let i = 0; i < dados.length; i++) 
            {
                    document.getElementById('sp'+dados[i].posicao).innerHTML = dados[i].icone;                          
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
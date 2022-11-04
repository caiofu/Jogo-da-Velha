function  posicaoEscolhida()
{
  var idSelecao = document.querySelector('input[name="opcao"]:checked').value;

  console.log(idSelecao)
//Percorre para deixar selecionado somente o ultimo que foi escolhido
  for (let i = 1; i < 10; i++) 
  {
   
    if(i == idSelecao)
    {
        document.getElementById('sp'+idSelecao).innerHTML = "X";
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
        //campos.append("idAdversario", document.getElementById("idAdversario").value);
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
function posicaoEscolhida()
{
  var idSelecao = document.querySelector('input[name="opcao"]:checked').value;

  console.log(idSelecao)
//Percorre para deixar selecionado somente o ultimo que foi escolhido
  for (let i = 1; i < 10; i++) 
  {
    console.log(idSelecao+'-'+i)
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
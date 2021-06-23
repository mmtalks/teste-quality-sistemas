<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8" />

<link type="text/css" rel="stylesheet" href="/css/principal.css" />

<title>Cadastro de Pessoas</title>
</head>

<body>

<div id="conteudoGeral">

    <div id="topoGeral">
    	<div id="logoTopo" onclick="location.href='/'" style="cursor:pointer;"></div>
    	<div id="dirTopo"></div>
    </div>
    
    <div id="baixoGeral">
    
    	<div id="menuEsq">
            <div id="titMenu">Menu de Opções</div>
            <a href="/">Início</a> 
            <a href="/lista">Listar Cadastros</a>
            <a href="/form">Incluir Novo</a>
        </div>
        
        <div id="conteudoDir">

            <div id="listaPessoas">
            
                <h1>Incluindo um Novo Cadastro</h1>
               
                <form id="formCadastrar" method="post" enctype="multipart/form-data" action="">
                    
                    <label for="cNome">Nome</label><br />
                    <input id="cNome" name="cNome" /><br />
                    
                    <label for="cDataNasc">Data de Nascimento</label><br />
                    <input type="date" id="cDataNasc" name="cDataNasc" /><br />
                    
                    <label for="cEmail">E-Mail</label><br />
                    <input id="cEmail" name="cEmail" /><br />
                    
                    <label for="cFoto">Foto (somente .jpg - máximo de 100Kb)</label><br />
                    <input id="cFoto" name="cFoto" type="file" accept="image/jpeg" /><br />

                </form>
                
                <a href="javascript:;" id="btPadrao" class="btPadrao">Salvar</a>
            
            </div>

        </div> <!-- FIM CONTEUDO DIR -->
    
    </div>

</div>


<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
let pessoa_id = 0;

try{
    pessoa_id = window.location.pathname.split('/')[2]
}catch(e){
    console.error(e);
}
async function getPessoa(pessoa_id){
    return await axios.get('/api/pessoa', {
        params: {
            pessoa_id
        }
    }).then((res)=>{
        return res;
    })
}

</script>

<script>

async function updatePessoa(pessoa_id){
    //return await axios.put();
}

</script>

<script>
$(document).ready(function(){
    let nome = $("#cNome").val();
    let data_nascimento = $("#cDataNasc").val();
    let email = $("#cEmail").val();

    $(document).on("click touchend", "#btPadrao", function(){
        getPessoa(pessoa_id).then((res)=>{
            updatePessoa(pessoa_id);
        })
    })

    

})
</script>

</body>
</html>



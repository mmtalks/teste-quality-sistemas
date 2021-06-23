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
<script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>

<script>

async function postPessoa(nome, data_nascimento, email, file_id){

    let data = new FormData();
    data.append('file', document.getElementById(file_id).files[0]);

    return await axios.post('/api/adicionar-pessoa', data, {
        params: {
            nome, data_nascimento, email
        },
        headers: {
            
        },
        onUploadProgress: function(progressEvent) {
                
            let percent = Math.round((progressEvent.loaded * 100) / progressEvent.total);
            
            //$('.progress-bar').attr("style", `width: ${percent}%`);
            
            //Aqui poderia entrar uma lógica para demonstrar o progresso do upload
        }
    }).then((res)=>{
        return res;
    });

}

</script>

<script>

$(document).ready(function(){
    $(document).on("click touchend", "#btPadrao", function(){
        
        let nome = $("#cNome").val();
        let data_nascimento = $("#cDataNasc").val();
        let email = $("#cEmail").val();

        postPessoa(nome, data_nascimento, email, "cFoto")
        .then((res)=>{
            console.log(res);
        });

    })
})

</script>



</body>
</html>



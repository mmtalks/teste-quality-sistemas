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
            	<h1>Dependentes</h1>
                
                <div id="infoDep">

                    <div id="fotoCadastro">
                        <img id="foto-uri" src="" width="77" height="77" />
                    </div> 
                    
                    <table id="tListaCad" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td class="tituloTab">Nome</td>    
                            <td id="nome"></td>    
                        </tr>              
                        <tr bgcolor="#cddeeb">
                            <td class="tituloTab">Data de Nascimento</td>    
                            <td id="data-nascimento"></td>    
                        </tr>              
                        <tr>
                            <td class="tituloTab">Email</td>    
                            <td id="email"></td>    
                        </tr>              
                    </table>
                    
                    <form id="frmAdicionaDep" action="">

                        <div class="agrupa mB mR">
                            <label for="cNomeDep">Nome</label><br />
                            <input type="text" name="cNomeDep" id="cNomeDep" />
                        </div>    
                        <div class="agrupa">
                            <label for="cDataNasc">Data de Nascimento</label><br />
                            <input type="date" name="cDataNasc" id="cDataNasc" />
                        </div>                            

	                    <a href="javascript:;" id="btn-adicionar" class="btPadrao">Adicionar</a>

                    </form>
                    
                    
                    <table id="tLista" cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <th width="60%" class="tL">Nome do Dependente</th>
                            <th width="33%">Data de Nascimento</th>
                            <th></th>
                        </tr>    
                    </thead>
                    <tbody>
                        
                    </tbody>
                    </table>
                    
                    <!--<a href="javascript:;" class="btPadrao mT">Salvar</a>-->
                </div>
                
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
</script>

<script>

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

async function getDependentes(pessoa_id){
    return await axios.get('/api/dependentes-por-pessoa/', {
        params: {
            pessoa_id
        }
    }).then((res)=>{
        return res;
    })
}

</script>

<script>

async function postDependente(pessoa_id, nome, data_nascimento){
    return await axios.post('/api/adicionar-dependente', {}, {
        params: {
            pessoa_id, nome, data_nascimento
        }
    }).then((res)=>{
        console.log(res);
    })
}

</script>

<script>

async function deleteDependente(dependente_id){
    return await axios.delete('/api/deletar-dependente', {data: {dependente_id}}, {}).then((res)=>{
        console.log(res);
    })
}

</script>

<script>



$(document).ready(function(){

    getPessoa(pessoa_id).then((res)=>{
        return res.data.data[0];
    }).then((res)=>{
        
        $('#nome').text(res.nome);
        $('#data-nascimento').text(res.data_nascimento.split('-').reverse().join('/'));
        $('#email').text(res.email);
        $('#foto-uri').attr('src', res.foto_uri)
    });


})



</script>

<script>

function mountTableDependentes(dependentes){
    let html = ``;
        dependentes.map((dependente)=>{
            html+=
            `
            <tr>
                <td>${dependente.nome}</td>
                <td align="center">${dependente.data_nascimento.split('-').reverse().join('/')}</td>
                <td align="center"><a data-dependente-id="${dependente.id}"  class="btRemover"></a></td>
            </tr>
            `;
        })

    $('#tLista tbody').html(html);
}

</script>

<script>

$(document).ready(function(){

    getDependentes(pessoa_id).then((res)=>{
        return res.data.data;
    }).then((dependentes)=>{

        mountTableDependentes(dependentes);

    })

})

</script>

<script>

$(document).ready(function(){
    $(document).on('click touchend', "#btn-adicionar", function(){

        let nome = $('#cNomeDep').val();
        let data_nascimento = $('#cDataNasc').val();

        postDependente(pessoa_id, nome, data_nascimento).then((res)=>{
            getDependentes(pessoa_id).then((res)=>{
                return res.data.data;
            }).then((dependentes)=>{

                mountTableDependentes(dependentes);

            })
        });

        $('#frmAdicionaDep')[0].reset();

    })
})

</script>

<script>

$(document).ready(function(){
    $(document).on('click touchend', ".btRemover", function(e){
        e.preventDefault();

        if(confirm("Você realmente deseja excluir?")) {
            
        }else {
            return;
        }

        let dependente_id = $(this).data('dependente-id');

        deleteDependente(dependente_id).then((res)=>{
            console.log(res);
            getDependentes(pessoa_id).then((res)=>{
                return res.data.data;
            }).then((dependentes)=>{

                mountTableDependentes(dependentes);

            })
        })

    })



})

</script>

<script>



</script>

</body>
</html>


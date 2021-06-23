<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8" />

<link type="text/css" rel="stylesheet" href="css/principal.css" />

<title>Cadastro de Pessoas</title>


<style>
#paginacao{
    display: grid;
    grid-template-columns: 100%;
}
#paginacao div{
    justify-self: center;
}


</style>
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
            	<h1>Cadastros</h1>

				<a href="javascript:;" class="btPadraoExcluir">Excluir</a>
                
                <table id="tLista" cellpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr>
                        <th width="5%"><input type="checkbox" class="checkbox" id="select_all" /></th>
                        <th width="5%">ID</th>
                        <th width="5%">Foto</th>
                        <th class="tL">Nome</th>
                        <th width="15%">Dt Nasc</th>
                        <th width="25%">Email</th>
                        <th width="7%">Dep</th>
                        <th width="7%">St</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>

                </table>
            	
            </div>

            <div id="paginacao">
                <div><a href="" class="btSeta1" id="pagina-anterior"></a> <div id="pags"><span id="pagina-atual">1</span> de <span id="pagina-final">10</span></div> <a href="" class="btSeta2" id="pagina-seguinte"></a></div>
                <!--<select id="paginas">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>-->
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
let current_page = 0;

async function pessoas(page){
    return await axios.get('/api/listagem-de-pessoas', {
        params: {
            page
        }
    })
    .then((res)=>{
        
        return res;
    })
}
</script>

<script>

function mountCurrentPage(res){
    current_page = res.data.data.pagina_atual+1;

    $("#pagina-final").text(res.data.data.total_de_paginas);
    $("#pagina-atual").text(current_page);

    let html = ``;
        res.data.data.lista.map((pessoa, index)=>{
            
            let backgroundColor = "";
            if(index%2==0){
                backgroundColor += "#cddeeb";
            }else{
                backgroundColor += "#f0f0f0";
            }

            let btCor = (pessoa.status=="ativado")?"btVerde":"btCinza";

            html += `

            <tr bgcolor="${backgroundColor}">
                <td align="center" style="border-left:0;"><input name="chkStatus" data-pessoa-id="${pessoa.id}" type="checkbox" class="checkbox" value="" id="chk_0" /></td>
                <td align="center">${pessoa.id}</td>
                <td align="center"><img src="${pessoa.foto_uri}" width="20" height="20" /></td>
                <td><a href="#" class="linkUser" title="Clique aqui para editar este cadastro." id="nm_">${pessoa.nome}</a></td>
                <td align="center">${pessoa.data_nascimento.split('-').reverse().join('/')}</td>
                <td align="center">${pessoa.email}</td>
                <td align="center">
                    <a href="/dependentes/${pessoa.id}" class="btAdicionar" title="Adicionar dependentes para este cadastro."></a>
                </td>
                <td align="center">
                    <a href="javascript:;" class="${btCor} btStatus" title="Ativar/Desativar este cadastro." data-pessoa-status="${pessoa.status}" data-pessoa-id="${pessoa.id}" id="bol_0"></a>
                </td>
            </tr>

            `;


        })
        $('#tLista tbody').html(html);
}

</script>

<script>

$(document).ready(function(){

    pessoas(current_page).then((res)=>{
        mountCurrentPage(res);
    })


})


</script>

<script>

$(document).ready(function(){
    $(document).on("click touchend", "#pagina-anterior", function(e){
        e.preventDefault();
        pessoas(current_page-1).then((res)=>{
            mountCurrentPage(res);
        });
    })
    $(document).on("click touchend", "#pagina-seguinte", function(e){
        e.preventDefault();
        pessoas(current_page+1).then((res)=>{
            mountCurrentPage(res);
        });
    })
})

</script>

<script>

async function deletePessoa(pessoas_id){
    return await axios.delete('/api/deletar-pessoa', {data: {pessoas_id}}, {}).then((res)=>{
        console.log(res);
    })
}

</script>

<script>

async function updateStatus(pessoa_id, status){
    return await axios.put('/api/atualizar-pessoa', {pessoa_id, status}).then((res)=>{
        console.log(res);
    });
}

</script>

<script>

$(document).ready(function(){

    $(document).on("click touchend", ".btStatus", function(e){
        e.preventDefault();

        let status = ($(this).data('pessoa-status') == "ativado") ? "desativado" : "ativado";
        let pessoa_id = $(this).data('pessoa-id');

        updateStatus(pessoa_id, status).then((res)=>{
            pessoas(current_page).then((res)=>{
                mountCurrentPage(res);
            })
        })


    })

})

</script>

<script>

$(document).ready(function(){
    $(document).on("click touchend", ".btPadraoExcluir", function(e){
        e.preventDefault();

        if (confirm("Tem certeza que deseja excluir?")) {
            
        } else {
            return;
        }

            let selected = [];
            $('.checkbox').prop('checked', function(){
                if($(this).is(":checked")){
                    selected.push($(this).attr('data-pessoa-id'));
                }
                
            });

            deletePessoa(selected).then((res)=>{
                pessoas(current_page).then((res)=>{
                    mountCurrentPage(res);
                });
            })

    })
})

</script>

<script>

$(document).ready(function(){
    $(document).on('click touchend', '#select_all', function(e){
        $('.checkbox').prop('checked', $('#select_all').prop('checked'));
    })
})

</script>

</body>
</html>


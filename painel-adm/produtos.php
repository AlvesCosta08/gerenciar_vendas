<?php 
$pag = 'produtos';
@session_start();

require_once('../conexao.php');
require_once('verificar-permissao.php');

?>

<a href="index.php?pagina=<?php echo $pag ?>&funcao=novo" type="button" class="btn btn-secondary mt-2">Novo Produto</a>

<div class="mt-4" style="margin-right:25px">
    <?php 
	$query = $pdo->query("SELECT * from produtos order by id desc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){ 
		?>
    <small>
    <table id="example" class="table table-hover my-4 text-center" style="width:100%">
    <thead>
        <tr>
            <th>Código Ref</th>
            <th>Categoria</th>
            <th>Item</th>
            <th>Unidade</th>
            <th>Preço Unitário</th>
            <th>Quantidade</th>
            <th>Estoque Mínimo</th>
            <th>Valor Compra</th>
            <th>IPI</th>
            <th>Percentual Custo</th>
            <th>Data</th>           
            <th>Foto</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        for ($i = 0; $i < $total_reg; $i++) {
            foreach ($res[$i] as $key => $value) {}

            $id_cat = $res[$i]['categoria'];
            $query_2 = $pdo->query("SELECT * from categorias where id = '$id_cat'");
            $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
            $nome_cat = $res_2[0]['nome'];

        ?>
            <tr>
                <td><?php echo $res[$i]['codigo'] ?></td>
                <td><?php echo $nome_cat ?></td>
                <td><?php echo $res[$i]['item'] ?></td>
                <td><?php echo $res[$i]['unidade'] ?></td>
                <td>R$ <?php echo number_format($res[$i]['preco_unitario'], 2, ',', '.'); ?></td>
                <td><?php echo $res[$i]['quantidade'] ?></td>
                <td><?php echo $res[$i]['estoque_min'] ?></td>
                <td>R$ <?php echo number_format($res[$i]['valor_compra'], 2, ',', '.'); ?></td>
                <td><?php echo $res[$i]['ipi'] ?></td>
                <td><?php echo $res[$i]['percentual_custo'] ?></td>
                <td><?php echo $res[$i]['data'] ?></td>           
               
                <td><img src="../img/<?php echo $pag ?>/<?php echo $res[$i]['foto'] ?>" width="40" class="img-fluid"></td>
                <td>
                    <a href="index.php?pagina=<?php echo $pag ?>&funcao=editar&id=<?php echo $res[$i]['id'] ?>" title="Editar Registro" style="text-decoration: none">
                        <i class="bi bi-pencil-square text-primary"></i>
                    </a>
                    <a href="index.php?pagina=<?php echo $pag ?>&funcao=deletar&id=<?php echo $res[$i]['id'] ?>" title="Excluir Registro" style="text-decoration: none">
                        <i class="bi bi-archive text-danger mx-1"></i>
                    </a>
                    <a href="#" onclick="mostrarDados('<?php echo $res[$i]['item'] ?>', '<?php echo $res[$i]['item'] ?>', '<?php echo $res[$i]['foto'] ?>', '<?php echo $nome_cat ?>', '<?php echo $nome_forn ?>', '<?php echo $tel_forn ?>')" title="Ver Descrição" style="text-decoration: none">
                        <i class="bi bi-card-text text-dark mx-1"></i>
                    </a>
                    <a target="_blank" title="Gerar Etiquetas" href="../rel/barras_class.php?codigo=<?php echo $res[$i]['codigo'] ?>" style="text-decoration: none">
                        <i class="bi bi-clipboard-check text-dark mx-1"></i>
                    </a>
                    <a target="_blank" title="Gerar Etiquetas com Valor" href="../rel/barras_valor_class.php?codigo=<?php echo $res[$i]['codigo'] ?>&valor=<?php echo $res[$i]['preco_unitario'] ?>&item=<?php echo $res[$i]['item'] ?>" style="text-decoration: none">
                        <i class="bi bi-clipboard-check text-danger mx-1"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

    </small>
    <?php }else{
		echo '<p>Não existem dados para serem exibidos!!';
	} ?>
</div>


<?php 
if(@$_GET['funcao'] == "editar"){
	$titulo_modal = 'Editar Registro';
	$query = $pdo->query("SELECT * FROM produtos WHERE id = '$_GET[id]'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){ 
		$categoria = $res[0]['categoria'];
		$codigo = $res[0]['codigo'];
		$foto = $res[0]['foto'];
		$item = $res[0]['item'];
		$unidade = $res[0]['unidade'];
		$preco_unitario = $res[0]['preco_unitario'];
		$quantidade = $res[0]['quantidade'];
		$estoque_min = $res[0]['estoque_min'];
		$valor_compra = $res[0]['valor_compra'];
		$ipi = $res[0]['ipi'];
		$percentual_custo = $res[0]['percentual_custo'];
		$data = $res[0]['data'];
	}
} else {
	$titulo_modal = 'Inserir Registro';
	$categoria = '';
	$codigo = '';
	$foto = '';
	$item = '';
	$unidade = '';
	$preco_unitario = '';
	$quantidade = '';
	$estoque_min = '';
	$valor_compra = '';
	$ipi = '';
	$percentual_custo = '';
	$data = '';
}
?>


<div class="modal fade" tabindex="-1" id="modalCadastrar" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $titulo_modal ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="codigo_ref" class="form-label">Código Referência</label>
								<input type="number" class="form-control" id="codigo" name="codigo" placeholder="Código" required="" value="<?php echo @$codigo ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="item" class="form-label">Item</label>
                                <input type="text" class="form-control" id="item" name="item" placeholder="Item"
                                    required value="<?php echo @$item ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="unidade" class="form-label">Unidade</label>
                                <input type="text" class="form-control" id="unidade" name="unidade"
                                    placeholder="Unidade" value="<?php echo @$unidade ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="preco_unitario" class="form-label">Preço Unitário</label>
                                <input type="text" class="form-control" id="preco_unitario" name="preco_unitario"
                                    placeholder="Preço Unitário" value="<?php echo @$preco_unitario ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="quantidade" class="form-label">Quantidade</label>
                                <input type="number" class="form-control" id="quantidade" name="quantidade"
                                    placeholder="Quantidade" value="<?php echo @$quantidade ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="estoque_min" class="form-label">Estoque Mínimo</label>
                                <input type="number" class="form-control" id="estoque_min" name="estoque_min"
                                    placeholder="Estoque Mínimo" value="<?php echo @$estoque_min ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="valor_compra" class="form-label">Valor Compra</label>
                                <input type="text" class="form-control" id="valor_compra" name="valor_compra"
                                    placeholder="Valor Compra" value="<?php echo @$valor_compra ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="ipi" class="form-label">IPI (%)</label>
                                <input type="text" class="form-control" id="ipi" name="ipi" placeholder="IPI"
                                    value="<?php echo @$ipi ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="percentual_custo" class="form-label">Percentual Custo (%)</label>
                                <input type="text" class="form-control" id="percentual_custo" name="percentual_custo"
                                    placeholder="Percentual Custo" value="<?php echo @$percentual_custo ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="data" class="form-label">Data</label>
                        <input type="date" class="form-control" id="data" name="data" value="<?php echo @$data ?>">
                    </div>


                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Categoria</label>
                                <select class="form-select mt-1" aria-label="Default select example" name="categoria">
                                    <?php 
									$query = $pdo->query("SELECT * from categorias order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$total_reg = @count($res);
									if($total_reg > 0){ 

										for($i=0; $i < $total_reg; $i++){
											foreach ($res[$i] as $key => $value){	}
												?>

                                    <option <?php if(@$categoria == $res[$i]['id']){ ?> selected <?php } ?>
                                        value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

                                    <?php }

									}else{ 
										echo '<option value="">Cadastre uma Categoria</option>';

									} ?>


                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1" class="form-label">Foto</label>
                                <input type="file" value="<?php echo @$foto ?>" class="form-control" id="imagem"
                                    name="foto" onChange="carregarImg();">
                            </div>



                        </div>

                        <div class="col-md-2">
                            <div id="divImgConta" class="mt-4">
                                <?php if(@$foto != ""){ ?>
                                <img src="../img/<?php echo $pag ?>/<?php echo $foto ?>" width="150px" id="target">
                                <?php  }else{ ?>
                                <img src="../img/<?php echo $pag ?>/sem-foto.jpg" width="100px" id="target">
                                <?php } ?>
                            </div>
                        </div>


                    </div>




                    <div id="codigoBarra"></div>


                    <small>
                        <div align="center" class="mt-1" id="mensagem">

                        </div>
                    </small>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar" class="btn btn-secondary"
                        data-bs-dismiss="modal">Fechar</button>
                    <button name="btn-salvar" id="btn-salvar" type="submit" class="btn btn-primary">Salvar</button>

                    <input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">

                    <input name="antigo" type="hidden" value="<?php echo @$item?>">

                    <input name="antigo2" type="hidden" value="<?php echo @$codigo_ref?>">


                </div>
            </form>
        </div>
    </div>
</div>






<div class="modal fade" tabindex="-1" id="modalDeletar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form-excluir">
                <div class="modal-body">

                    <p>Deseja Realmente Excluir o Registro?</p>

                    <small>
                        <div align="center" class="mt-1" id="mensagem-excluir">

                        </div>
                    </small>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-fechar" class="btn btn-secondary"
                        data-bs-dismiss="modal">Fechar</button>
                    <button name="btn-excluir" id="btn-excluir" type="submit" class="btn btn-danger">Excluir</button>

                    <input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">

                </div>
            </form>
        </div>
    </div>
</div>






<div class="modal fade" tabindex="-1" id="modalDados">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span id="nome-registro"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body mb-4">

                <b>Categoria: </b>
                <span id="categoria-registro"></span>
                <hr>

                <div id="div-forn">
                    <span class="mr-4">
                        <b>Fornecedor: </b>
                        <span id="nome-forn-registro"></span>
                    </span>

                    <span class="mr-4">
                        <b>Telefone: </b>
                        <span id="tel-forn-registro"></span>
                    </span>
                    <hr>
                </div>



                <b>Descrição: </b>
                <span id="descricao-registro"></span>
                <hr>
                <img id="imagem-registro" src="" class="mt-4" width="200">
            </div>

        </div>
    </div>
</div>

<?php 
if(@$_GET['funcao'] == "novo"){ ?>
<script type="text/javascript">
var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
    backdrop: 'static'
})

myModal.show();
</script>
<?php } ?>



<?php 
if(@$_GET['funcao'] == "editar"){ ?>
<script type="text/javascript">
var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
    backdrop: 'static'
})

myModal.show();
</script>
<?php } ?>



<?php 
if(@$_GET['funcao'] == "deletar"){ ?>
<script type="text/javascript">
var myModal = new bootstrap.Modal(document.getElementById('modalDeletar'), {

})

myModal.show();
</script>
<?php } ?>




<!--AJAX PARA INSERÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
$(document).ready(function() {
    // Controle de envio do formulário
    $("#form").submit(function(event) {
        event.preventDefault();
        var pag = "<?=$pag?>";
        var acao = "<?= @$_GET['funcao'] == 'editar' ? 'editar' : 'novo' ?>";  // Define a ação com PHP
        var url = acao === "editar" ? pag + "/atualizar_produto.php" : pag + "/inserir.php";
        var formData = new FormData(this);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(mensagem) {
                $('#mensagem').removeClass();
                if (mensagem.trim() === "Salvo com Sucesso!" || mensagem.trim() === "Atualizado com Sucesso!") {
                    $('#btn-fechar').click();
                    window.location = "index.php?pagina=" + pag;
                } else {
                    $('#mensagem').addClass('text-danger');
                }
                $('#mensagem').text(mensagem);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});
</script>



<!--AJAX PARA EXCLUIR DADOS -->
<script type="text/javascript">
$("#form-excluir").submit(function() {
    var pag = "<?=$pag?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: pag + "/excluir.php",
        type: 'POST',
        data: formData,

        success: function(mensagem) {

            $('#mensagem').removeClass()

            if (mensagem.trim() == "Excluído com Sucesso!") {

                $('#mensagem-excluir').addClass('text-success')

                $('#btn-fechar').click();
                window.location = "index.php?pagina=" + pag;

            } else {

                $('#mensagem-excluir').addClass('text-danger')
            }

            $('#mensagem-excluir').text(mensagem)

        },

        cache: false,
        contentType: false,
        processData: false,

    });
});
</script>



<script type="text/javascript">
$(document).ready(function() {
    gerarCodigo();
    $('#example').DataTable({
        "ordering": false
    });
});
</script>






<!--SCRIPT PARA CARREGAR IMAGEM -->
<script type="text/javascript">
function carregarImg() {

    var target = document.getElementById('target');
    var file = document.querySelector("input[type=file]").files[0];
    var reader = new FileReader();

    reader.onloadend = function() {
        target.src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);


    } else {
        target.src = "";
    }
}
</script>




<script type="text/javascript">
function mostrarDados(nome, descricao, foto, categoria, nome_forn, tel_forn) {
    event.preventDefault();

    if (nome_forn.trim() === "") {
        document.getElementById("div-forn").style.display = 'none';
    } else {
        document.getElementById("div-forn").style.display = 'block';
    }

    $('#nome-registro').text(nome);
    $('#categoria-registro').text(categoria);
    $('#descricao-registro').text(descricao);
    $('#nome-forn-registro').text(nome_forn);
    $('#tel-forn-registro').text(tel_forn);

    $('#imagem-registro').attr('src', '../img/produtos/' + foto);


    var myModal = new bootstrap.Modal(document.getElementById('modalDados'), {

    })

    myModal.show();
}
</script>







<!--AJAX PARA EXCLUIR DADOS -->
<script type="text/javascript">
$("#codigo").keyup(function() {
    gerarCodigo();
});
</script>


<script type="text/javascript">
var pag = "<?=$pag?>";

function gerarCodigo() {
    $.ajax({
        url: pag + "/barras.php",
        method: 'POST',
        data: $('#form').serialize(),
        dataType: "html",

        success: function(result) {
            $("#codigoBarra").html(result);
        }
    });
}
</script>



<script type="text/javascript">
function comprarProdutos(id, valor, lucro, valor_compra) {
    event.preventDefault();

    console.log(valor)

    $('#id-comprar').val(id);
    $('#valor_v').val(valor);
    $('#lucro').val(lucro);
    $('#valor_compra').val(valor_compra);

    var myModal = new bootstrap.Modal(document.getElementById('modalComprar'), {

    })
    myModal.show();
}
</script>







<!--AJAX PARA COMPRAR PRODUTO -->
<script type="text/javascript">
$("#form-comprar").submit(function() {
    var pag = "<?=$pag?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: pag + "/comprar-produto.php",
        type: 'POST',
        data: formData,

        success: function(mensagem) {

            $('#mensagem-comprar').removeClass()

            if (mensagem.trim() == "Salvo com Sucesso!") {

                //$('#nome').val('');
                //$('#cpf').val('');
                $('#btn-fechar').click();
                window.location = "index.php?pagina=" + pag;

            } else {

                $('#mensagem-comprar').addClass('text-danger')
            }

            $('#mensagem-comprar').text(mensagem)

        },

        cache: false,
        contentType: false,
        processData: false,
        xhr: function() { // Custom XMLHttpRequest
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                myXhr.upload.addEventListener('progress', function() {
                    /* faz alguma coisa durante o progresso do upload */
                }, false);
            }
            return myXhr;
        }
    });
});
</script>

<script type="text/javascript">
function calcularLucro() {
    console.log('chamou')

    valor_compra = $("#valor_compra").val();
    lucro = $("#lucro").val();

    valor_compra = valor_compra.replace(",", ".");
    lucro = lucro.replace("%", "");

    total = (valor_compra * lucro / 100);
    total = parseFloat(total) + parseFloat(valor_compra);
    $("#valor_v").val(total)

}
</script>





<script type="text/javascript">
function carregarArquivo() {
    var target = document.getElementById('target_arquivos');
    var file = document.querySelector("#arquivo").files[0];

    var arquivo = file['name'];
    resultado = arquivo.split(".", 2);

    if (resultado[1] === 'pdf') {
        $('#target_arquivos').attr('src', "../img/arquivos/pdf.png");
        return;
    }

    if (resultado[1] === 'rar' || resultado[1] === 'zip') {
        $('#target_arquivos').attr('src', "../img/arquivos/rar.png");
        return;
    }

    if (resultado[1] === 'doc' || resultado[1] === 'docx' || resultado[1] === 'txt') {
        $('#target_arquivos').attr('src', "../img/arquivos/word.png");
        return;
    }


    if (resultado[1] === 'xlsx' || resultado[1] === 'xlsm' || resultado[1] === 'xls') {
        $('#target_arquivos').attr('src', "../img/arquivos/excel.png");
        return;
    }


    if (resultado[1] === 'xml') {
        $('#target_arquivos').attr('src', "../img/arquivos/xml.png");
        return;
    }



    var reader = new FileReader();

    reader.onloadend = function() {
        target.src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);

    } else {
        target.src = "";
    }
}
</script>
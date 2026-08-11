<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Cadastro - Currículo</title>
    <link rel="stylesheet" href="css/forms.css">
</head>
<body>

    <div class="pagina-cadastro">
        <main>
            <div class="caixa-cadastro">
                <h1 class="titulo-pagina">PREENCHA O FORMULÁRIO</h1>
       
                <form method="POST" action="partials/form.php">
                     <h1>Dados pessoais</h1>
                    <input type="text" id="nome" name="nome" placeholder="Nome" required>
                    <input type="text" id="cargo" name="cargo" placeholder="Cargo" required>
                    <input type="text" name="resumo" placeholder="Resumo Profissional" required>
                    <textarea type="text" name="info_pessoais" ></textarea>

                    <h1>Contatos</h1>
                    <input type="email" name="email" placeholder="email" required>
                    <input type="text" name="telefone" placeholder="telefone" required>
                    <textarea name="perfis_profissionais"></textarea>

                    <h1>Experiências</h1>
                    <input type="text" id="empresa" name="empresa" placeholder="Empresa" required>
                    <input type="text" id="funcao" name="funcao" placeholder="Função" required>
                    <input type="text" name="periodo_exp" placeholder="Período de Experiência" required>
                    <textarea name="descricao_exp">contenos</textarea>

                    <h1>Formação</h1>
                    <input type="text" id="instituicao" name="instituicao" placeholder="Instituição" required>
                    <input type="text" id="curso" name="curso" placeholder="Curso" required>
                    <input type="text" id="periodo" name="periodo_exp" placeholder="Período de Experiência" required>

                    
                    <div class="btn">
                        <button type="submit">Cadastrar</button>
                    </div>

                </form>
        </main>
    </div>
</div>
</body>
</html>
    
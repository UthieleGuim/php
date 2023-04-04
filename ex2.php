<?php
    // Deixe essas duas linhas. Caso contrário, o navegador não vai conseguir rodar os testes.
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    // Deixe isso. Vai te ajudar.
    date_default_timezone_set("America/Sao_Paulo");
    $hoje = (new DateTimeImmutable("now"))->setTime(0, 0, 0, 0);


/*
Exercício 2 - Formulário, parte 1.


Crie uma página PHP com as seguintes características:
- 1. Os campos recebidos por POST são: "nome", "sexo" e "data-nascimento".
- 2. Sempre devolva uma página HTML completa e bem formada (o teste sempre vai passar ela num validador).
- 3. Se os dados estiverem todos bem formados, coloque dentro do <body>, apenas uma tag <p> contendo o seguinte:
     [Nome] é ["um garoto" ou "uma garota"] de [x] anos de idade.
- 4. Se os dados não estiverem todos bem-formado, coloque dentro do <body>, apenas uma tag <p> contendo o texto "Errado".
- 5. Os únicos valores válidos para o campo "sexo" são "M" e "F".
- 6. O campo "data-nascimento" está no formato "yyyy-MM-dd" e deve corresponder a uma data válida.
     - As partes do mês e do dia devem ter 2 dígitos casa e a do ano deve ter 4 dígitos.
- 7. A data de nascimento não pode estar no futuro e nem ser de mais de 120 anos no passado.
- 8. Espaços à direita ou a esquerda do nome devem ser ignorados. O nome nunca deve estar em branco.
- 9. Se qualquer dado não aparecer no POST, isso é considerado um erro.

Dica:
- Procure no material que o professor já deixou pronto.
*/

$nome	= isset($_POST['nome']) ? trim($_POST['nome']) : "";
$data_nascimento	= isset($_POST['data-nascimento']) ? $_POST['data-nascimento'] : "";
$sexo	= isset($_POST['sexo']) ? $_POST['sexo'] : "";

$mensagem;


if (empty($nome)) {
  $mensagem = "Errado";
} else {
  
  if ($sexo != "M" && $sexo != "F") {
    $mensagem = "Errado";
  } else {
    
    $data_nascimento_obj = DateTime::createFromFormat("Y-m-d", $data_nascimento);
    if (!$data_nascimento_obj || $data_nascimento != $data_nascimento_obj->format("Y-m-d")) {
      $mensagem = "Errado";
    } else {
      
      if ($data_nascimento_obj > $hoje) {
        $mensagem = "Errado";
      } else {
        
        $idade = $hoje->diff($data_nascimento_obj)->y;
        if ($idade > 120) {
          $mensagem = "Errado";
        } else {
          
          $genero = ($sexo == "M") ? "um garoto" : "uma garota";
          $mensagem = "{$nome} é {$genero} de {$idade} anos de idade.";
        }
      }
    }
  }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Exercício 2 - Formulário, parte 1</title>
    </head>
    <body>
        <p><?=$mensagem?></p>
    </body>
</html>
o codigo vai: 
Definir que a resposta será em formato JSON
Captura o método HTTP usado (GET, POST, DELETE)
Lê os dados enviados no corpo da requisição (para POST)
Banco de Dados Simulado
$usuarios é um array que simula um banco de dados com 5 usuários pré-cadastrados

Operações Implementadas
POST (Criar usuário)
Valida se login e senha foram enviados
Cria novo usuário com ID incremental
Adiciona ao array de usuários
Retorna o usuário criado com status 201 (Created)

GET (Ler usuários)
Retorna os 5 primeiros usuários do array em formato JSON

DELETE (Remover usuário)
Valida se o ID foi enviado na query string
Remove o usuário com ID correspondente
Retorna mensagem de sucesso
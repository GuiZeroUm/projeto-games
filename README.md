# Projeto Games

## Requisitos do Sistema
- MAMP (ou similar com Apache, MySQL e PHP)
- PHP 7.4 ou superior
- MySQL 5.7 ou superior

## Configuração do Ambiente

1. **Instalação do MAMP**
   - Baixe e instale o MAMP do site oficial: https://www.mamp.info/
   - Durante a instalação, mantenha as configurações padrão

2. **Configuração do Banco de Dados**
   - Inicie o MAMP
   - Acesse o phpMyAdmin: http://localhost:8888/phpMyAdmin5/
   - Crie um novo banco de dados chamado `projeto_games`
   - Importe o arquivo `database.sql` (será fornecido separadamente) para criar as tabelas necessárias

3. **Configuração do Projeto**
   - Coloque todos os arquivos do projeto na pasta: `/Applications/MAMP/htdocs/projeto-games/`
   - Certifique-se que as permissões das pastas estão corretas

4. **Acesso ao Projeto**
   - Para visualizar o site: http://localhost:8888/projeto-games/
   - Para acessar o phpMyAdmin: http://localhost:8888/phpMyAdmin5/

## Estrutura do Projeto
- `index.php` - Arquivo principal do projeto
- `database.sql` - Arquivo com a estrutura do banco de dados (será fornecido separadamente)

## Observações Importantes
- Sempre mantenha o MAMP rodando enquanto estiver trabalhando no projeto
- Faça backup do banco de dados antes de fazer alterações significativas
- Em caso de problemas, verifique se todas as portas necessárias estão disponíveis

# Introduction

Implementação de teste para projeto Finance

# Requirements

- Utilizar o Docker e Docker Compose
- Banco de dados MariaDB
- PHP 8.3
- Framework HyperF 3.1

## Iniciar projeto

Para facilitar a inicialização do projeto foi criado um arquivo na raiz do projeto chamado run.

- Dar permissão de execução do arquivo.
```bash
chomod +x run 
```

Iniciar o docker compose.
```bash
./run install
```

Acessar o banco de dados
[http://localhost:8080](http://localhost:8080)

Teste de transações com DEPOSIT
```curl
curl --request POST \
  --url http://localhost:9501/transaction \
  --header 'Content-Type: application/json' \
  --header 'User-Agent: insomnia/10.1.1' \
  --data '{
	"account_number" : "68c2c56d-8310-4628-b886-a82fccc289f5",
	"transaction_type" : "DEPOSIT",
	"transaction_value" : 100
}'
```

Teste de transações com SAKE
```curl
curl --request POST \
  --url http://localhost:9501/transaction \
  --header 'Content-Type: application/json' \
  --header 'User-Agent: insomnia/10.1.1' \
  --data '{
	"account_number" : "68c2c56d-8310-4628-b886-a82fccc289f5",
	"transaction_type" : "SAKE",
	"transaction_value" : 100
}'
```

Teste de transações com TRANSFER
```curl
curl --request POST \
  --url http://localhost:9501/transfer \
  --header 'Content-Type: application/json' \
  --header 'User-Agent: insomnia/10.1.1' \
  --data '{
	"account_number_origin" : "7557f6da-61f7-4e9c-8479-88aa52ed2050",
	"account_number_destination" : "68c2c56d-8310-4628-b886-a82fccc289f5",
	"transaction_value" : 100
}'
```

Rodando test.
```bash
./run test
```

Rodando test cobertura.
```bash
./run coverage
```

Rodando test K6.
```bash
./run testK6
```

![test-K6.png](test-K6.png)
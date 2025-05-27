
# 🎯 Academia Multitenant

Projeto de gestão de academias utilizando **Laravel + Inertia.js + Vue.js**, com ambiente totalmente configurado via **Docker**.

---

## 🚀 Tecnologias

- ⚙️ Backend: Laravel
- 🎨 Frontend: Vue.js + Inertia.js + Vite
- 🐬 Banco de Dados: MySQL
- 🌐 Servidor Web: Nginx
- 🐳 Ambiente: Docker + Docker Compose

---

## 🐳 Rodando o projeto com Docker

### 🔥 Pré-requisitos

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

---

### 🧠 Passos para rodar o projeto

### 1️⃣ Clone o repositório

```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio
```

---

### 2️⃣ Copie o arquivo de ambiente

```bash
cp .env.example .env
```

⚙️ **Edite as configurações do banco no seu `.env` caso necessário:**

```env
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=laravel
APP_URL=http://academia-multitenant.test:8080
TENANCY_CENTRAL_DOMAIN=academia-multitenant.test
```

---

### 3️⃣ Suba os containers com Docker

```bash
docker-compose up -d --build
```

---

### 4️⃣ Instale as dependências do frontend (Node + Vite)

```bash
docker exec -it node bash
npm install
npm run dev
```

---

### 5️⃣ Instale as dependências do Laravel e rode as migrations + seeders

Acesse o container do Laravel:

```bash
docker-compose exec app bash
```

Execute os comandos:

```bash
composer install
php artisan key:generate
php artisan migrate --seed
```

---

## 🏗️ Configuração de Hosts Locais

Para que o ambiente multitenant funcione corretamente, é necessário configurar o arquivo de **hosts** do seu sistema.

### 🖥️ Windows

1. Pressione `WIN + R` e digite:

```
notepad C:\Windows\System32\drivers\etc\hosts
```

2. Adicione as seguintes linhas no final do arquivo:

```
# CENTRAL
127.0.0.1 academia-multitenant.test

# TENANTS
127.0.0.1 academia1.academia-multitenant.test
127.0.0.1 academia2.academia-multitenant.test
```

💡 **Salve o arquivo com permissões de administrador.**

---

## 🔑 Acesso ao sistema

### 🌐 Central

- **URL:** [http://academia-multitenant.test:8080](http://academia-multitenant.test:8080)
- **Login:** `admin@example.com`
- **Senha:** `password123`

---

### 🏢 Tenants

| Tenant    | URL                                                             | Login                    | Senha   |
|------------|------------------------------------------------------------------|--------------------------|---------|
| Academia 1 | [http://academia1.academia-multitenant.test:8080](http://academia1.academia-multitenant.test:8080) | academia1@gmail.com      | 123456  |
| Academia 2 | [http://academia2.academia-multitenant.test:8080](http://academia2.academia-multitenant.test:8080) | academia2@gmail.com      | 123456  |

---

## 🗂️ Estrutura dos containers

| Serviço | Descrição           | Porta Externa     |
|---------|----------------------|-------------------|
| app     | Laravel (PHP-FPM)    | 9000              |
| mysql   | Banco de Dados MySQL | 3307              |
| nginx   | Servidor Nginx       | 8080              |
| node    | Node.js              | 5175 (ou dinâmica)|

---

## 🚧 Comandos úteis

✅ Subir os containers:

```bash
docker-compose up -d --build
```

✅ Derrubar os containers:

```bash
docker-compose down -v
```

✅ Acessar o container do Laravel:

```bash
docker exec -it laravel-app bash
```

✅ Acessar o container do Node:

```bash
docker exec -it node bash
```

✅ Rodar migrations e seeders novamente:

```bash
docker-compose exec app php artisan migrate:fresh --seed
```

---

## ⚠️ Problemas comuns

- 🔑 **Erro de permissão no banco ao criar tenants:**  
É necessário garantir que o usuário `laravel` no MySQL tenha permissões suficientes para criar e excluir bancos. Rode dentro do container mysql:

```sql
GRANT ALL PRIVILEGES ON *.* TO 'laravel'@'%';
FLUSH PRIVILEGES;
```

---

## 📜 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

## ✨ Desenvolvido por

[@GuilhermeRisson](https://github.com/GuilhermeRisson)

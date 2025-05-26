
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

### 5️⃣ Instale as dependências do Laravel e rode as migrations

Acesse o container do Laravel:

```bash
docker exec -it laravel-app bash
```

Dentro do container, execute:

```bash
composer install
php artisan key:generate
php artisan migrate --seed
```

---

## 🎯 Acesso ao sistema

- 🖥️ **Backend (Laravel via Nginx)**  
👉 [http://academia-multitenant.test:8080](http://academia-multitenant.test:8080)

---

## 🗂️ Estrutura dos containers

| Serviço | Descrição           | Porta Externa |
|---------|----------------------|----------------|
| app     | Laravel (PHP-FPM)    | 9000           |
| mysql   | Banco de Dados MySQL | 3307           |
| nginx   | Servidor Nginx       | 8080           |
| node    | Node.js              | 5175 (ou dinâmica) |

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

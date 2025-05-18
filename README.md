<h1 align="center">
  <br>
  <a href="https://github.com/alesofiati/phobo"><img src="/logo.png" alt="Phobos" style="border: 3px solid black;" width="200"></a>
  <br>
  Phobos
  <br>
</h1>

<h4 align="center">A plataforma dos viciados em séries — tipo academia, mas pra maratonar!</h4>

[![Veja o vídeo](https://img.youtube.com/vi/nKglN1uNm-A/maxresdefault.jpg)](https://youtu.be/nKglN1uNm-A)

<p align="center">
  <a href="#funcionalidades">Funcionalidades</a> •
  <a href="#como-instalar">Como instalar</a> •
  <a href="#testes">Testes</a> •
  <a href="#créditos">Créditos</a> •
  <a href="#licença">Licença</a> 
</p>

## Funcionalidades
* Login simplificado com nome de usuário
* Criar salas ([o que é uma sala?](#faq))
* Criar atividades ([o que é uma atividade?](#faq))
* Carregar imagens
* Interface responsiva (funciona em qualquer tela, pode confiar)
* Suculência ([o que é suculência?](#faq))


## Como instalar
Para baixar e rodar essa aplicação, você precisará de [Git](https://git-scm.com), [NodeJS](https://nodejs.org/en/download), [PHP 8.4](https://php.watch/articles/php-84-install-upgrade-guide-debian-ubuntu) e [Composer](https://getcomposer.org/download/) instalados no seu computador. No seu terminal favorito, digite:

```bash
# Baixe o código
$ git clone https://github.com/alesofiati/phobo

# Entre no repositório
$ cd phobo

# Instale as dependências do composer
$ composer install

# Inicie o Laravel Sail
$ ./vendor/bin/sail up -d

# Utilize o sail para instalar as dependências do npm
$ ./vendor/bin/sail npm i

# Copie o arquivo .env
$ cp .env.example .env

# Gere as as chaves de aplicação do Laravel
$ ./vendor/bin/sail key:generate

# Rode as migrations
$ ./vendor/bin/sail migrate

# Agora é só rodar o projeto
$ ./vendor/bin/sail composer run dev
```

## Testes
A aplicação contém testes. Eles estão dentro da pasta /tests. Utilizamos o [Pest](https://pestphp.com) para criar testes com mais facilidade e entender de forma fácil como a cobertura da aplicação estava evoluindo. Para rodar os testes, basta seguir os comandos:

```bash
# Rode os testes com cobertura
$ ./vendor/bin/sail pest --coverage
```

# FAQ
## O que é uma sala? 
A sala é um grupo de pessoas que estão assistindo a mesma série ou anime. Ela serve para reunir essas informações e mostrar quem está na frente em relação aos colegas de sala. 

## O que é uma atividade?
As atividades são o ponto central da aplicação: cada usuário pode criar suas próprias atividades dentro das salas que participa. Quando você assiste um episódio novo é uma atividade. A atividade também serve como um histórico de atividades daquela sala.

## O que é suculência?
Quando um jogo tem bons efeitos de feedback e interação com o jogador, dizemos que ele é um bom game feel. Quando ele se preocupa com as mínimas interações a fim de deixar tudo mais divertido, dizemos que ele é um bom game juice. Porém, no Brasil tem uma palavra melhor para isso: **SUCULÊNCIA**. Se tiver vontade de saber mais do tema, veja esse [artigo](https://www.reddit.com/r/gamedev/comments/1adodbd/game_juice_the_difference_between_a_good_game_and/?tl=pt-br).

## Créditos

Essa aplicação foi criada com ❤️ na [Codecon Universe](https://codecon.dev/universe).

## Licença

[MIT](/LICENSE)

---

> Felipe Passos &nbsp;&middot;&nbsp;
> GitHub [@Berkspar](https://github.com/berkspar) &nbsp;&middot;&nbsp;
> LinkedIn [in/berkspar](https://www.linkedin.com/in/berkspar)

> Alexandre Soffiatti &nbsp;&middot;&nbsp;
> GitHub [@Alesofiati](https://github.com/alesofiati) &nbsp;&middot;&nbsp;
> LinkedIn [in/alexandre-soffiatti](https://www.linkedin.com/in/alexandre-soffiatti-939185ba/)

> Nícollas Matheus &nbsp;&middot;&nbsp;
> GitHub [@NicollasMatheus37](https://github.com/NicollasMatheus37) &nbsp;&middot;&nbsp;
> LinkedIn [in/nicollas-matheus](https://www.linkedin.com/in/nicollas-matheus-2425b3148/)



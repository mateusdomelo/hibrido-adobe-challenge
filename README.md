# HIBRIDO | DESAFIO TÉCNICO | ADOBE COMMERCE

## Sobre o desafio
O cliente tem uma configuração multi-site com algumas páginas CMS que são
compartilhadas entre diferentes sites, porém isso está causando problemas de
conteúdo duplicado e afetando seus rankings de SEO, para resolver isso, precisamos
criar um novo módulo que fará o seguinte:
1. Adicione um bloco ao head
2. O bloco deve ser capaz de identificar o ID da página CMS e verificar se a
página é usada em múltiplas store-views
3. Nesse caso, deve adicionar uma Meta Tag hreflang ao head para cada
store-view que a página esteja ativa
4. As Meta Tag’s devem exibir o idioma da loja (exemplo: en-gb, en-us, pt-br,
etc...)


## Pre-requisitos e Funcionalidades:

  - Magento Open Source (Community) na versão 2.4.6-p3
  - Windows 11 (WSL2 com Ubuntu 22.04)
  - Docker: https://github.com/gaiterjones/docker-magento2
    - PHP 8.2.5;
    - Apache 2.4;
    - MYSQL 8;
    - Varnish 7; 
    - RabbitMQ 3;
    - ElasticSearch 7;
  - Amazon Web Services (AWS)
    - EC2 (Ubuntu)
    - RDS (MySQL)

## Instalação

1. Instalar o Docker de preferência. Para esse projeto, utilizei o docker informado anteriormente (https://github.com/gaiterjones/docker-magento2) dentro do WSL2 do Windows 11 para obter melhor performance final e próxima ao ambiente de "Produção".

   - ```bash
     https://github.com/gaiterjones/docker-magento2
     ```
2. Clonar este repositório:
   - ```bash
     git clone git@github.com:mateusdomelo/hibrido-adobe-challenge.git
     ```
3. Executar os comandos abaixo:
   - ```bash
     #Acessar container PHP para execução:
     "docker-compose exec -u magento php-apache bash"
     
     #Baixar as dependências:
     "composer install"

     #Instalar o projeto Magento:
     "bin/magento setup:install \
     --base-url=http://magento.local/ \
     --db-host=mysql \
     --db-name=magento2 \
     --db-user=magento \
     --db-password=SENHA-DB \
     --admin-firstname=Mateus \
     --admin-lastname=Melo \
     --admin-email=admin@admin.com \
     --admin-user=USER-ADMIN \
     --admin-password=SENHA-ADMIN \
     --language=en_US \
     --currency=BRL \
     --timezone=America/Chicago \
     --use-rewrites=1 \
     --search-engine=elasticsearch7 \
     --elasticsearch-host=elasticsearch \
     --elasticsearch-index-prefix=magento2"
     ```


## Processos e Desenvolvimento

Com o ambiente pronto para uso, fiz a criação da vendor "Hibrido" e o módulo "Cms", onde ficariam as classes e todos os códigos responsáveis pela aplicação da regra de negócio desejada.

Utilizei o arquivo <b>config.php</b> (app/etc) para configurar os multiplos sites, dispondo de 3 novas Store Views e 1 Store para cada Store View. Basendo nos seguintes dados:
```bash
# STORES (Groups)
  - 1ª Store:
	Nome: Brazil Store
	Status Code: brazil_store
	Sort Order: 1
  
  - 2ª Store:
	Nome: United States Store
	Status Code: united_states_store
	Sort Order: 2
  
  - 3ª Store:
	Nome: England Store
	Status Code: england_store
	Sort Order: 3


# STORE VIEWS (Stores)
  - 1ª Store View:
	Nome: Brazil Store View
	Status Code: pt_br
	Sort Order: 1
  
  - 2ª Store View:
	Nome: United States Store View
	Status Code: en_us
	Sort Order: 2
  
  - 3ª Store View:
	Nome: England Store View
	Status Code: en_gb
	Sort Order: 3
```

Para a construção das metas tags, criei o Bloco `"MetaTags.php"` (<b>Hibrido/Cms/Block</b>) responsável por englobar os dados necessário para serem utilizado junto ao novo template `"meta_tags.php"` (<b>Hibrido/Cms/view/frontend/templates</b>), onde foi feita a construção final das Meta Tags. 

Posteriormente, criei o layout (<b>Hibrido/Cms/view/frontend/layout</b>) de nome `"cms_page_view.xml"` para juntar o Bloco e o Template anteriores e, com isso, todas as páginas CMS terão a criação das Meta Tags individualmente caso existam em multiplas lojas.

## Deploy do Ambiente

Conforme sugerido no desafio técnico, disponibilizei um ambiente público utilizando o <b>Amazon Web Services</b> (AWS) com serviços <b>EC2</b> (instância Ubuntu) e <b>RDS</b> (Banco de Dados MySQL).

Pode ser conferido através dos endereços e acessos abaixo:

  - Frontend: http://54.158.42.112/
  - Admin (Backoffice): http://54.158.42.112/admin_bdda7t
    - User: equipe.hibrido
    - Password: 1tAd=}5K'$pw0WE?'9lNme3m.com   

## Contato

Email: mateusdomelo@gmail.com

LinkedIn: https://www.linkedin.com/in/mateusdomelo/

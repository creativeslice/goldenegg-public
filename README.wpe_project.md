# <<repository_name>>2020
<<project/client>> <<year>>> <<Initial/Refesh>>

https://github.com/creativeslice/<<repository_name>>

- Hosted on clients `<<client_wpengine_account>>` WP Engine account: `https://my.wpengine.com/installs/<<production_env>>`

## Deployment Production
Deploy from `main` using GitHub actions:
- WP Engine install: `<<production_env>>`
- Development site: `https://my.wpengine.com/installs/<<production_env>>`


## Deployment Staging
Deploy from `develop` using GitHub actions:
- WP Engine install: `<<staging_env>>`
- Development site: `https://my.wpengine.com/installs/<<staging_env>>`

### URLs
1. Local: https://<<repository_name>>.local or https://<<repository_name>>.test
1. Staging: https://<<staging_domain>>
1. Live: https://<<live_domain>>

## Development dependencies
1. node/nvm preferred `lts/fermium`  (node: v14.18.x / npm 6.14.x)
2. php 7.3+
3. mysql

### Gulp (build production assets)
- Production build: `npm run gulp:stage`
- Staging build: `npm run gulp:stage`
- Development build: `npm run gulp`
- Local dev with live reload: `npm run gulp:watch`
- Compile icons: `npm run gulp:icons`


### Changelog
Updates are documented here: https://github.com/creativeslice/<<repository_name>>


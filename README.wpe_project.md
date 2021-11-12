# <<repository_name>>2020
<<project/client>> <<year>>> <<Initial/Refesh>>

https://github.com/creativeslice/<<repository_name>>

- Hosted on clients `<<client_wpengine_account>>` WP Engine account: `https://my.wpengine.com/installs/<<production_env>>`

## Deployment Production
Deploy from `main` using GitHub actions:
- WP Engine install: `<<production_env>>`
- Production site: `https://my.wpengine.com/installs/<<production_env>>`


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
- Production build: `npm run gulp:prod`
- Staging build: `npm run gulp:stage`
- Development build: `npm run gulp`
- Local dev with live reload: `npm run gulp:watch`
- Compile icons: `npm run gulp:icons`


## Doing a [RELEASE]
1. Git-Flow 'Start Release' with release tag following [semvar](https://semver.org) (semantic versioning) like 1.1.2
2. Update any versioning strings or declares often found at top of `/wp-content/themes/<<repository_name>>/functions.php` (project dependent)
3. Git-Flow 'Finish Release' and push to `main` branch on GitHub, **NOTE** this will deploy to the live site. _Unless you are using the Pull Request Gatekeeper process then refer to <<>>_
4. Monitor build at [Actions](https://github.com/creativeslice/<<repository_name>>/actions) 
5. Refer to the pages to check below and validate release
6. Create [**Release**](https://github.com/creativeslice/<<repository_name>>/releases) in Github with changes
   1. If work documented in ClickUp
      1. select **closed** tasks (select both Task Name and Task URL)
      2. Go to [Regex101 Convert clipboard to markdown](https://regex101.com/r/CUxOq7/1/) you can use this to process ClickUp clipboard to markdown
   2. Click and [Create a new release](https://github.com/creativeslice/<<repository_name>>/releases/new) with the change notes either manually or from above
   3. Publish the release attached to tag created with release above.



### Changelog
Updates are documented here: https://github.com/creativeslice/<<repository_name>>/releases

## Post Deploy pages to check
* Home Page [Staging](https://<<staging_domain>>) [Live](https://<<live_domain>>) 
  * list of things to look at and pages....

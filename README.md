# docker-laravel-vue

## cloneしてからの環境構築

1. ### **dockerのコンテナを立ち上げる**

   - Docker Desktopを立ち上げ、docker-laravel-vue内で``` docker compose up -d ```でdockerコンテナを立ち上げる

2. ### **vendarの作成**

   - docker-karavek-vue内で``` docker compose exec app bash ```を打ちappコンテナ内に入り``` composer install ```をしてvendarを作成する

3. ### **node_moduleの作成**

   - exitでappコンテナから出て、dokcer-laravel-vue/src内で``` npm install ```を打つ

/src直下に作る.envがあるのですが、おれに聞いてください

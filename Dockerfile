FROM ghcr.io/shanginn/temporal-php-worker-image:master

COPY --chown=worker:worker . /worker

RUN composer install --no-dev --no-scripts --no-plugins --prefer-dist --no-progress --no-interaction

ENTRYPOINT ["/usr/local/bin/rr", "serve", "-c", "/worker/.rr.yaml"]

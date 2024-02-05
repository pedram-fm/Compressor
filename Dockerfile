FROM  bitnami/laravel
WORKDIR /app
RUN chown -R bitnami:bitnami /app
COPY --chown=bitnami:bitnami . .
USER bitnami

FROM bitnami/laravel:10
WORKDIR /app
RUN chown -R bitnami:bitnami /app
COPY --chown=bitnami:bitnami . .
RUN composer install
#RUN chown -R bitnami:bitnami /app
RUN sed -i 's/;extension=pdo_pgsql/extension=pdo_pgsql/' /opt/bitnami/php/etc/php.ini
RUN sed -i 's/;extension=pgsql/extension=pgsql/' /opt/bitnami/php/etc/php.ini
#RUN php artisan migrate --force
#RUN php artisan queue:work
RUN chmod +x /app/entrypoint.sh
ENTRYPOINT ["/app/entrypoint.sh"]
USER bitnami

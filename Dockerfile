FROM legalthings/apache-php71

WORKDIR /app
COPY . .
RUN ["mkdir", "-p", "img"]
RUN ["chmod", "-R", "755", "./"]

RUN ["chown", "-R", "www-data:www-data", "./img"]
RUN ["chmod", "-R", "g+rwX", "./img"]

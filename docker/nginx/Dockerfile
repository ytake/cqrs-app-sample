FROM nginx:1.19-alpine

RUN apk --update add tzdata && \
    cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
    apk del tzdata && \
    rm -rf /var/cache/apk/*

RUN rm /etc/nginx/nginx.conf /etc/nginx/conf.d/default.conf

RUN echo "Not Found" > /usr/share/nginx/html/index.html
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/conf.d/ /etc/nginx/conf.d/

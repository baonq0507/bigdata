# Sử dụng image từ quay.io/soketi/soketi:1.4-16-debian
FROM quay.io/soketi/soketi:1.4-16-debian

# Thiết lập các biến môi trường
ENV SOKETI_DEBUG=1
ENV SOKETI_DEFAULT_APP_ID=app-key
ENV SOKETI_DEFAULT_APP_KEY=app-key
ENV SOKETI_DEFAULT_APP_SECRET=app-secret

# Mở các cổng 6001 và 9601
EXPOSE 6001 9601

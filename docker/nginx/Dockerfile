FROM nginx:alpine

ARG APP_NAME

# define app name inside container
ENV APP_NAME ${APP_NAME}

# Copy entrypoint to container
COPY nginx/entrypoint.sh /nginx-entrypoint.sh

ENTRYPOINT ["/nginx-entrypoint.sh"]

# Expose public port and start nginx service
EXPOSE 80 8000
CMD ["nginx", "-g", "daemon off;"]

# Development Stage
FROM php:8.2-cli 

WORKDIR /app

# Copy the PHP script to the container
COPY index.php /app

# Create a non-root user
RUN groupadd -g 10021 choreo && \
    adduser  --disabled-password  --no-create-home --uid 10021 --ingroup choreo choreouser
   # useradd -u 10001 -g choreo -s /usr/sbin/nologin choreouser

# Switch to the non-root user
USER choreouser

# Start PHP's built-in server for production
CMD ["php", "-S", "0.0.0.0:8080"]

# Expose port for production
EXPOSE 8080

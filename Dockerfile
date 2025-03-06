# Development Stage
FROM php:8.2-cli 

WORKDIR /app

# Copy the PHP script to the container
COPY index.php .

# Create a non-root user
RUN useradd -M -N -r -s /usr/sbin/nologin choreouser

# Switch to the non-root user
USER choreouser

# Expose port for production
EXPOSE 8080

# Start PHP's built-in server for production
CMD ["php", "-S", "0.0.0.0:8080"]

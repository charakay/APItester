# Development Stage
FROM php:8.2-cli AS development

WORKDIR /app

# Copy the PHP script to the container
COPY . .

# Expose port 8080 for the built-in PHP server
EXPOSE 8080

# Start PHP's built-in server for development
CMD ["php", "-S", "0.0.0.0:8080", "-t", "/app"]

# Production Stage
FROM php:8.2-cli AS production

WORKDIR /app

# Copy only necessary files for production
COPY --from=development /app /app

# Create a non-root user
RUN groupadd -g 10001 choreo && \
    useradd -u 10001 -g choreo -s /usr/sbin/nologin choreouser

# Switch to the non-root user
USER choreouser

# Expose port for production
EXPOSE 8080

# Start PHP's built-in server for production
CMD ["php", "-S", "0.0.0.0:8080", "-t", "/app"]

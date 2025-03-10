FROM php:8.2-cli

WORKDIR /app

# Copy the PHP script to the container
COPY index.php /app

# Expose port for the built-in PHP server
EXPOSE 8080

# Create a non-root user
RUN adduser \
    --disabled-password \
    --gecos "" \
    --home "/nonexistent" \
    --shell "/sbin/nologin" \
    --no-create-home \
    --uid 10014 \
    "choreo"
# Use the above created unprivileged user
USER 10014

# Switch to the non-root user
USER choreo

# Start PHP's built-in server for production
CMD ["php", "-S", "0.0.0.0:8080"]

# Expose port for production
EXPOSE 8080

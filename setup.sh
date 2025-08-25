echo "Setting up Survey Management App with Laravel Sail..."

# Make sure sail is executable
chmod +x ./vendor/bin/sail

# Start Docker containers
./vendor/bin/sail up -d

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
while ! ./vendor/bin/sail exec mysql mysqladmin ping --silent; do
    sleep 1
done

# Install dependencies
./vendor/bin/sail composer install

# Generate application key
./vendor/bin/sail artisan key:generate

# Run migrations
./vendor/bin/sail artisan migrate

# Seed database (optional)
read -p "Do you want to seed the database with sample data? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    ./vendor/bin/sail artisan db:seed
    echo "Database seeded with sample data."
fi

echo "Setup complete!"
echo "Application should be running at: http://localhost"
echo "MailHog dashboard at: http://localhost:8025"
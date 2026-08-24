# SoulSoil



##  Quick Setup

1. **Install dependencies:**
   ```bash
   composer install
   ```

2. **Setup environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Run database migrations & seed dummy data:**
   ```bash
   php artisan migrate --seed
   ```

   *(Or seed specific dummy data separately:)*
   ```bash
   php artisan db:seed --class=DummyFarmSeeder
   php artisan db:seed --class=DummyPendingFarmerSeeder
   ```

4. **Run application:**
   ```bash
   php artisan serve
   ```

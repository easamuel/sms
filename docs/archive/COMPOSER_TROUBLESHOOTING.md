# Composer Installation Troubleshooting

## Issues Encountered

1. **Network Timeouts**: Connection timeouts when downloading packages
2. **Permission Denied**: Issues writing to vendor directory
3. **Process Timeout**: Git clone operations timing out

## Solutions

### Solution 1: Retry with Increased Timeout

```bash
composer install --prefer-dist --no-interaction --verbose
```

### Solution 2: Use Prefer Source (if dist fails)

```bash
composer install --prefer-source --no-interaction
```

### Solution 3: Install Without Dev Dependencies (Faster)

```bash
composer install --no-dev --prefer-dist
```

### Solution 4: Clear Composer Cache and Retry

```bash
composer clear-cache
composer install --prefer-dist
```

### Solution 5: Install with Network Disabled (if you have packages cached)

```bash
COMPOSER_DISABLE_NETWORK=1 composer install
```

### Solution 6: Use Chinese Mirror (if in China or having network issues)

```bash
composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
composer install
```

### Solution 7: Manual Steps if Network Continues to Fail

If network issues persist, you can:

1. Download Laravel manually from another machine with good internet
2. Copy the `vendor` folder from a working Laravel 10 installation
3. Run `composer dump-autoload` to regenerate autoload files

## Current Configuration

The `composer.json` has been updated with:
- `process-timeout: 0` (no timeout limit)
- `preferred-install: "dist"` (prefer zip downloads over git clones)
- Increased timeout settings

## Next Steps After Successful Installation

Once `composer install` completes successfully:

1. Generate application key:
   ```bash
   php artisan key:generate
   ```

2. Configure database in `.env`

3. Run migrations:
   ```bash
   php artisan migrate
   ```

4. Start server:
   ```bash
   php artisan serve
   ```

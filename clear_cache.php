<?php
// Clear OPcache
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "OPcache cleared successfully!\n";
} else {
    echo "OPcache is not enabled.\n";
}

// Clear any other PHP caches
if (function_exists('apc_clear_cache')) {
    apc_clear_cache();
    echo "APC cache cleared!\n";
}

echo "Cache clearing complete. Please refresh your browser.\n";

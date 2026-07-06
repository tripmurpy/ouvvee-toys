<?php

namespace Tests\Feature;

use Tests\TestCase;

class DatabaseConfigTest extends TestCase
{
    public function test_pgsql_connection_is_configured_for_supabase(): void
    {
        $pgsql = config('database.connections.pgsql');

        $this->assertSame('pgsql', $pgsql['driver']);
        $this->assertSame('public', $pgsql['search_path']);
        $this->assertSame('require', $pgsql['sslmode']);
    }
}

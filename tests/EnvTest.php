<?php

namespace Eco\Tests;

use Eco\Env;
use PHPUnit\Framework\TestCase;

class EnvTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $content =
        'FIRST_KEY=first'.PHP_EOL.
        'SECOND_KEY=2'.PHP_EOL.
        'LAST_KEY='.PHP_EOL;

        file_put_contents('.env', $content);
    }

    public function test_has()
    {
        $first = Env::has('.env', 'FIRST_KEY');
        $second = Env::has('.env', 'second_key');
        $last = Env::has('.env', 'Last_Key');
        $invalid = Env::has('.env', 'INVALID');

        $this->assertTrue($first);
        $this->assertTrue($second);
        $this->assertTrue($last);
        $this->assertFalse($invalid);
    }

    public function test_get()
    {
        $first = Env::get('.env', 'FIRST_KEY');
        $second = Env::get('.env', 'second_key');
        $last = Env::get('.env', 'Last_Key');
        $invalid = Env::get('.env', 'INVALID');

        $this->assertSame('FIRST_KEY=first', $first);
        $this->assertSame('SECOND_KEY=2', $second);
        $this->assertSame('LAST_KEY=', $last);
        $this->assertNull($invalid);
    }

    public function test_set()
    {
        Env::set('.env', 'FIRST_KEY', 'zim');
        Env::set('.env', 'second_key', 'zala');
        Env::set('.env', 'Last_Key', 'bim');
        Env::set('.env', 'NEW', 'new with space');

        $this->assertStringContainsString('FIRST_KEY=zim'.PHP_EOL, file_get_contents('.env'));
        $this->assertStringContainsString('SECOND_KEY=zala'.PHP_EOL, file_get_contents('.env'));
        $this->assertStringContainsString('LAST_KEY=bim'.PHP_EOL, file_get_contents('.env'));
        $this->assertStringContainsString('NEW=\'new with space\''.PHP_EOL, file_get_contents('.env'));
    }

    public function test_unset()
    {
        Env::unset('.env', 'FIRST_KEY');
        Env::unset('.env', 'second_key');
        Env::unset('.env', 'Last_Key');
        Env::unset('.env', 'NEW');

        $this->assertStringNotContainsString('FIRST_KEY=first'.PHP_EOL, file_get_contents('.env'));
        $this->assertStringNotContainsString('SECOND_KEY=2'.PHP_EOL, file_get_contents('.env'));
        $this->assertStringNotContainsString('LAST_KEY='.PHP_EOL, file_get_contents('.env'));
        $this->assertStringNotContainsString('NEW='.PHP_EOL, file_get_contents('.env'));
    }

    public function test_format_value()
    {
        $this->assertSame('value', Env::formatValue('value'));
        $this->assertSame('value', Env::formatValue('  value  '));
        $this->assertSame("'the value'", Env::formatValue('the value'));
        $this->assertSame("'the value'", Env::formatValue('  the value  '));
    }
}

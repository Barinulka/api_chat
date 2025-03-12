<?php 
namespace UnitTests\Command;

use App\Command\Arguments;
use App\Exception\Command\ArgumentException;
use PHPUnit\Framework\TestCase;

class ArgumentsTest extends TestCase
{
    public function testItReturnArgumetsValueByName(): void
    {
        $arguments = new Arguments(['test' => 'value']);

        $value = $arguments->get('test');

        $this->assertEquals('value', $value);
    }

    public function testItReturnStringValue(): void
    {
        $arguments = new Arguments(['test'=> 123]);

        $value = $arguments->get('test');

        $this->assertSame('123', $value);
    }

    public function testItThrowsAnExceptionWhenNoArgument(): void
    {
        $arguments = new Arguments([]);

        $this->expectException(ArgumentException::class);

        $this->expectExceptionMessage('Такого аргумента не существует');

        $arguments->get('test');
    }

    /**
     * @dataProvider argumentsProvider
     */
    public function testItConvertsArgumentsToString(
        $inputValue, 
        $expectedValue,
    ): void
    {
        $arguments = new Arguments(['test'=> $inputValue]);

        $value = $arguments->get('test');

        $this->assertSame($expectedValue, $value);
    }

    public static function argumentsProvider(): iterable
    {
        return [
            ['some_key', 'some_key'],
            ['key', 'key'],
            ['string', 'string'],
            [123, '123'],
            [12.3, '12.3'],
            ['123', '123']
        ];
    }
}
<?php

namespace PHPGen\Builders;

use PhpToken;
use ReflectionFunctionAbstract;
use SplFileObject;
use Stringable;

class FunctionBodyBuilder implements Stringable
{
    protected array $lines = [];



    /**
     * @param array<string> $lines
     */
    public function __construct(array $lines = [])
    {
        $this->lines = array_filter(array_map(trim(...), $lines));
    }

    /**
     * Create new instance
     *
     * @param array<string> $lines
     */
    public static function make(array $lines = []): static
    {
        return new static($lines);
    }

    public static function fromString(string $body): static
    {
        return static::make(explode("\n", $body));
    }

    public static function fromReflection(ReflectionFunctionAbstract $reflection): static
    {
        $filename = $reflection->getFileName();

        $start = max($reflection->getStartLine() - 1, 0);
        $end   = $reflection->getEndLine();
        $lines = $end - $start;

        $file = new SplFileObject($filename);
        $file->seek($start - 1);

        $body = '<?php ';

        do {
            $body .= $file->fgets();
        } while ($lines-- > 0);


        $tokens = PhpToken::tokenize($body, TOKEN_PARSE);

        $result         = [];
        $isInsideString = false;
        $write          = false;
        $activeLine     = null;
        $line           = '';

        foreach ($tokens as $token) {
            if (!$token->isIgnorable()) {
                // echo $token->getTokenName(), PHP_EOL;
            }

            if ($token->is('"')) {
                $isInsideString = !$isInsideString;
            }

            if (!$isInsideString) {
                if ($token->is('{')) {
                    $write = true;

                    continue;
                } elseif ($token->is('}')) {
                    $write = false;
                }
            }

            if ($activeLine !== null && $activeLine !== $token->line) {
                $result[]   = trim($line);
                $line       = '';
                $activeLine = $token->line;
            }

            if ($write) {
                $activeLine = $token->line;
                $line .= $token->text;
            }
        }

        var_dump($result);

        return static::make([]);

        // $handle = fopen($file, 'r');
        // if ($handle) {
        //     while (($line = fgets($handle)) !== false) {

        //     }

        //     fclose($handle);
        // }
    }



    public function __toString(): string
    {
        $tab   = 4;
        $space = str_repeat(' ', $tab);

        if (count($this->lines) === 0) {
            return "{\n\n}";
        }

        return "{\n" . implode("\n", array_map(fn ($line) => "{$space}{$line}", $this->lines)) . "\n}";
    }
}

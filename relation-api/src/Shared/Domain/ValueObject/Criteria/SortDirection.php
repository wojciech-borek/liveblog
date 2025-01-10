<?php
declare(strict_types=1);

namespace App\Shared\Domain\ValueObject\Criteria;
final class SortDirection
{
    private const ALLOWED_VALUES = ['asc', 'desc'];

    public const ASC = 1;
    public const DESC = -1;

    private int $value;

    public function __construct(private readonly string $direction = 'asc'
    ) {
        if (!in_array(strtolower($this->direction), self::ALLOWED_VALUES, true)) {
            throw new \DomainException('Sort direction must be "asc" or "desc"');
        }
        $this->value = strtolower($this->direction) === 'asc' ? self::ASC : self::DESC;
    }

    public function getValue(): int {
        return $this->value;
    }
}
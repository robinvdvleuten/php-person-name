<?php

namespace Webstronauts\PersonName;

/**
 * @property string $first
 * @property string $last
 * @property string $full
 * @property string $familiar
 * @property string $abbreviated
 * @property string $sorted
 * @property string $possessive
 * @property string $initials
 * @property string $mentionable
 */
class PersonName
{
    /**
     * @var string
     */
    private $first;

    /**
     * @var string
     */
    private $last;

    public static function make(?string $fullName = null): ?self
    {
        $segments = preg_split('/\s/', trim(preg_replace('/\s+/', ' ', $fullName)), 2);

        return $segments[0] ? new static($segments[0], $segments[1] ?? null) : null;
    }

    /**
     * Creates a new PersonName instance.
     *
     * @param string $first
     * @param string $last
     */
    public function __construct(string $first, ?string $last = null)
    {
        $this->first = $first;
        $this->last = $last;
    }

    public function first(): string
    {
        return $this->first;
    }

    public function last(): ?string
    {
        return $this->last;
    }

    /**
     * Returns first + last, such as "Jason Fried".
     *
     * @return string
     */
    public function full(): string
    {
        return $this->last ? "{$this->first} {$this->last}" : $this->first;
    }

    /**
     * Returns first + last initial, such as "Jason F.".
     *
     * @return string
     */
    public function familiar(): string
    {
        return $this->last ? "{$this->first} {$this->last[0]}." : $this->first;
    }

    /**
     * Returns first initial + last, such as "J. Fried".
     *
     * @return string
     */
    public function abbreviated(): string
    {
        return $this->last ? "{$this->first[0]}. {$this->last}" : $this->first;
    }

    /**
     * Returns last + first for sorting.
     *
     * @return string
     */
    public function sorted(): string
    {
        return $this->last ? "{$this->last}, {$this->first}" : $this->first;
    }

    /**
     * Returns full name with with trailing 's or ' if name ends in s.
     *
     * @return string
     */
    public function possessive(): string
    {
        return sprintf('%s\'%s', $this, substr($this, -1) !== 's' ? 's' : '');
    }

    /**
     * Returns just the initials.
     *
     * @return string
     */
    public function initials(): string
    {
        preg_match_all('/([[:word:]])[[:word:]]+/i', preg_replace('/(\(|\[).*(\)|\])/', '', $this), $matches);

        return implode('', end($matches));
    }

    /**
     * Returns a mentionable version of the familiar name.
     *
     * @return string
     */
    public function mentionable(): string
    {
        return strtolower(preg_replace('/\s+/', '', substr($this->familiar, 0, -1)));
    }

    /**
     * Make the methods accessibles as attributes.
     *
     * @param  string  $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        return call_user_func([$this, $attribute]);
    }

    public function __toString(): string
    {
        return $this->full;
    }
}

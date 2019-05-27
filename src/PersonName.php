<?php

namespace Webstronauts\PersonName;

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
        [$first, $last] = preg_split('/\s/', trim(preg_replace('/\s+/', ' ', $fullName)), 2);

        return $first ? new static($first, $last) : null;
    }

    /**
     * Creates a new PersonName instance.
     *
     * @param string $first
     * @param string $last
     * @return void
     */
    public function __construct(string $first, string $last = null)
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
    public function full()
    {
        return $this->last ? "{$this->first} {$this->last}" : $this->first;
    }

    /**
     * Returns first + last initial, such as "Jason F.".
     *
     * @return string
     */
    public function familiar()
    {
        return $this->last ? "{$this->first} {$this->last[0]}." : $this->first;
    }

    /**
     * Returns first initial + last, such as "J. Fried".
     *
     * @return string
     */
    public function abbreviated()
    {
        return $this->last ? "{$this->first[0]}. {$this->last}" : $this->first;
    }

    /**
     * Returns last + first for sorting.
     *
     * @return string
     */
    public function sorted()
    {
        return $this->last ? "{$this->last}, {$this->first}" : $this->first;
    }

    /**
     * Returns full name with with trailing 's or ' if name ends in s.
     *
     * @return string
     */
    public function possessive()
    {
        return sprintf('%s\'%s', $this, substr($this, -1) !== 's' ? 's' : '');
    }

    /**
     * Returns just the initials.
     *
     * @return string
     */
    public function initials()
    {
        preg_match_all('/([[:word:]])[[:word:]]+/i', preg_replace('/(\(|\[).*(\)|\])/', '', $this), $matches);
        return implode('', end($matches));
    }

    /**
     * Returns a mentionable version of the familiar name
     *
     * @return string
     */
    public function mentionable()
    {
        return strtolower(preg_replace('/\s+/', '', substr($this->familiar, 0, -1)));
    }

    /**
     * Make the methods accessibles as attributes.
     *
     * @param  string  $attribute
     * @return string
     */
    public function __get($attribute)
    {
        return call_user_func([$this, $attribute]);
    }

    public function __toString()
    {
        return $this->full;
    }
}

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
    const POSSESSIVE_FIRST = 'first';
    const POSSESSIVE_LAST = 'last';
    const POSSESSIVE_FULL = 'full';
    const POSSESSIVE_INITIALS = 'initials';
    const POSSESSIVE_SORTED = 'sorted';
    const POSSESSIVE_ABBREVIATED = 'abbreviated';

    /**
     * @var string
     */
    private $first;

    /**
     * @var string
     */
    private $last;

    /**
     * @var array
     */
    public $wordSplitters = [];

    /**
     * @var array
     */
    public $lowercaseExceptions = [];

    /**
     * @var array
     */
    public $uppercaseExceptions = [];

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
        $this->wordSplitters = [' ', '-', "O'", "L'", "La'", "D'", "De'", 'St.', 'Mc', 'Mac'];
        $this->lowercaseExceptions = ['the', 'van', 'den', 'von', 'und', 'der', 'de', 'da', 'of', 'and', "l'", "d'"];
        $this->uppercaseExceptions = ['III', 'IV', 'VI', 'VII', 'VIII', 'IX'];
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
     * @param  string  $method
     * @return string
     */
    public function possessive(string $method = self::POSSESSIVE_FULL): string
    {
        return sprintf('%s\'%s', call_user_func([$this, $method]), substr($this, -1) !== 's' ? 's' : '');
    }

    /**
     * Returns just the initials.
     *
     * @return string
     */
    public function initials(): string
    {
        preg_match_all('/([[:word:]])[[:word:]]*/i', preg_replace('/(\(|\[).*(\)|\])/', '', $this), $matches);

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
     * Returns a proper name case version of the full name.
     * @param  string $name Which part of the name to proper case. Default full|first|last.
     *
     * @return string
     */
    public function proper($name = null): string
    {
        switch ($name) {
            case 'first':
                $name = strtolower($this->first());
                break;
            case 'last':
                $name = strtolower($this->last());
                break;
            default:
                $name = strtolower($this->full());
        }
        foreach ($this->wordSplitters as $delimiter) {
            $words = explode($delimiter, $name);
            $newWords = [];
            foreach ($words as $word) {
                if (in_array(strtoupper($word), $this->uppercaseExceptions)) {
                    $word = strtoupper($word);
                } elseif (!in_array($word, $this->lowercaseExceptions)) {
                    $word = ucfirst($word);
                }
                $newWords[] = $word;
            }

            if (in_array(strtolower($delimiter), $this->lowercaseExceptions)) {
                $delimiter = strtolower($delimiter);
            }

            $name = implode($delimiter, $newWords);
        }

        return $name;
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

<?php

namespace Webstronauts\PersonName\Tests;

use PHPUnit\Framework\TestCase;
use Webstronauts\PersonName\PersonName;

class PersonNameTest extends TestCase
{
    /** @test */
    public function it_has_optional_last_name_argument()
    {
        $a = new PersonName('Foo', 'Bar');

        $this->assertEquals('Foo', $a->first);
        $this->assertEquals('Bar', $a->last);

        $b = new PersonName('Baz');

        $this->assertEquals('Baz', $b->first);
        $this->assertNull($b->last());
    }

    /** @test */
    public function it_returns_full_name()
    {
        $a = new PersonName('Foo', 'Bar');

        $this->assertEquals('Foo Bar', $a->full);
        $this->assertEquals('Foo Bar', $a);

        $b = new PersonName('Baz');

        $this->assertEquals('Baz', $b->full);
        $this->assertEquals('Baz', $b);
    }

    /** @test */
    public function it_returns_abbreviations()
    {
        $a = new PersonName('Foo', 'Bar');

        $this->assertEquals('Foo B.', $a->familiar);
        $this->assertEquals('F. Bar', $a->abbreviated);
        $this->assertEquals('Bar, Foo', $a->sorted);

        $b = new PersonName('Baz');

        $this->assertEquals('Baz', $b->familiar);
        $this->assertEquals('Baz', $b->abbreviated);
        $this->assertEquals('Baz', $b->sorted);
    }

    /** @test */
    public function it_returns_possessive()
    {
        $this->assertEquals('Foo Bar\'s', (new PersonName('Foo', 'Bar'))->possessive);
        $this->assertEquals('Baz\'s', (new PersonName('Baz'))->possessive);
        $this->assertEquals('Foo Bars\'', (new PersonName('Foo', 'Bars'))->possessive);
    }

    /** @test */
    public function it_returns_initials()
    {
        $this->assertEquals('DHH', PersonName::make('David Heinemeier Hansson')->initials);
        $this->assertEquals('DHH', PersonName::make('  David    Heinemeier   Hansson  ')->initials);
    }

    /** @test */
    public function it_returns_initials_for_first_name()
    {
        $this->assertEquals('D', PersonName::make('David')->initials);
    }

    /** @test */
    public function it_skips_anything_inside_parenthesis_when_returning_initials()
    {
        $this->assertEquals('CM', PersonName::make('Conor Muirhead (Basecamp)')->initials);
    }

    /** @test */
    public function it_skips_anything_inside_brackets_when_returning_initials()
    {
        $this->assertEquals('CM', PersonName::make('Conor Muirhead [Basecamp]')->initials);
    }

    /** @test */
    public function it_skips_non_word_characters_when_returning_initials()
    {
        $this->assertEquals('CM', PersonName::make('Conor Muirhead !')->initials);
    }

    /** @test */
    public function it_returns_mentionable()
    {
        $this->assertEquals('foob', (new PersonName('Foo', 'Bar'))->mentionable);
    }

    /** @test */
    public function it_returns_mentionable_with_first_name()
    {
        $this->assertEquals('wil', (new PersonName('Will'))->mentionable);
    }

    /** @test */
    public function it_returns_mentionable_with_three_names()
    {
        $this->assertEquals('wills', (new PersonName('Will', 'St. Clair'))->mentionable);
    }

    /** @test */
    public function it_returns_familiar()
    {
        $this->assertEquals('Foo B.', (new PersonName('Foo', 'Bar'))->familiar);
    }

    /** @test */
    public function it_returns_familiar_with_three_names()
    {
        $this->assertEquals('Will S.', (new PersonName('Will', 'St. Clair'))->familiar);
    }

    /** @test */
    public function it_can_be_created_from_full_name()
    {
        $a = PersonName::make('Will St. Clair');

        $this->assertEquals('Will', $a->first);
        $this->assertEquals('St. Clair', $a->last);

        $b = PersonName::make('Will');

        $this->assertEquals('Will', $b->first);
        $this->assertNull($b->last);

        $this->assertNull(PersonName::make());
        $this->assertNull(PersonName::make(''));
    }

    /** @test */
    public function it_can_be_created_from_full_name_with_spaces_at_edges_of_string()
    {
        $a = PersonName::make('  Will St. Clair ');

        $this->assertEquals('Will', $a->first);
        $this->assertEquals('St. Clair', $a->last);
        $this->assertEquals('Will St. Clair', $a->full);
    }

    /** @test */
    public function it_can_be_created_from_full_name_with_spaces_between_first_and_last_name()
    {
        $a = PersonName::make('Will   St. Clair');

        $this->assertEquals('Will', $a->first);
        $this->assertEquals('St. Clair', $a->last);
        $this->assertEquals('Will St. Clair', $a->full);
    }

    /** @test */
    public function it_can_be_created_from_full_name_with_spaces_between_multiple_last_name_words()
    {
        $a = PersonName::make('Will St.   Clair');

        $this->assertEquals('Will', $a->first);
        $this->assertEquals('St. Clair', $a->last);
        $this->assertEquals('Will St. Clair', $a->full);
    }

    /** @test */
    public function it_can_be_created_from_full_name_with_spaces_everywhere()
    {
        $a = PersonName::make('  Will     St.   Clair       ');

        $this->assertEquals('Will', $a->first);
        $this->assertEquals('St. Clair', $a->last);
        $this->assertEquals('Will St. Clair', $a->full);
    }

    /** @test */
    public function it_treats_blank_last_name_as_null()
    {
        $a = new PersonName('Baz', '');

        $this->assertEquals('Baz', $a->full);
        $this->assertEquals('Baz', $a->familiar);
        $this->assertEquals('Baz', $a->abbreviated);
        $this->assertEquals('Baz', $a->sorted);
        $this->assertEquals('Baz\'s', $a->possessive);
    }
}

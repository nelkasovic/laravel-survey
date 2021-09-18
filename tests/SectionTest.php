<?php

namespace Wimando\Survey\Tests;

use Wimando\Survey\Facades\Factories\Models\SectionFactory;
use Wimando\Survey\Models\Section;

class SectionTest extends TestCase
{
    /** @test */
    public function sectionHasName()
    {
        $section = SectionFactory::create(['id' => 1, 'name' => 'Basic Information']);
        $section->save();

        $section = Section::find(1);

        $this->assertEquals('Basic Information', $section->name);
    }
}

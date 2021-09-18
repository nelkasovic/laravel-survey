<?php

namespace Wimando\Survey\Tests;

use Wimando\Survey\Exceptions\GuestEntriesNotAllowedException;
use Wimando\Survey\Exceptions\MaxEntriesPerUserLimitExceeded;
use Wimando\Survey\Facades\Factories\Models\EntryFactory;
use Wimando\Survey\Models\Entry;
use Wimando\Survey\Models\Survey;

class SurveyEntryTest extends TestCase
{
    /** @test */
    public function testGuestMayNotCreateEntriesByDefault()
    {
        $survey = Survey::factory()->create();

        $this->expectException(GuestEntriesNotAllowedException::class);

        EntryFactory::create(['survey_id' => $survey->id])->save();
    }

    /** @test */
    public function testGuestMayCreateEntriesWhenSurveyAllowsGuestEntries()
    {
        $survey = Survey::factory()->create([
            'settings' => ['accept-guest-entries' => true],
        ]);

        $entry = EntryFactory::create(['survey_id' => $survey->id]);
        $entry->save();

        $this->assertDatabaseHas($entry->getTable(), ['id' => $entry->id]);
    }

    /** @test */
    public function testUsersMayCreateEntriesWhenSurveyDoesNotAcceptGuestEntries()
    {
        $survey = Survey::factory()->create();

        $user = $this->signIn();

        $entry = tap(Entry::make(['survey_id' => $survey->id])->by($user))->save();

        $this->assertDatabaseHas($entry->getTable(), ['id' => $entry->id]);
    }

    /** @test */
    public function testUsersMayCreateEntriesWithinTheSpecifiedMaxEntriesPerUserLimit()
    {
        $survey = Survey::factory()->create([
            'settings' => ['limit-per-participant' => 1],
        ]);

        $user = $this->signIn();

        $entry = tap(Entry::make(['survey_id' => $survey->id])->by($user))->save();

        $this->assertDatabaseHas($entry->getTable(), ['id' => $entry->id]);

        $this->expectException(MaxEntriesPerUserLimitExceeded::class);

        Entry::make(['survey_id' => $survey->id])->by($user)->save();
    }

    /** @test */
    public function testWhenGeustEntriesAreAllowedLimitPerParticipantIsIgnored()
    {
        $survey = Survey::factory()->create([
            'settings' => [
                'limit-per-participant' => 0,
                'accept-guest-entries' => true,
            ],
        ]);

        $user = $this->signIn();

        $entry = tap(Entry::make(['survey_id' => $survey->id])->by($user))->save();

        $this->assertDatabaseHas($entry->getTable(), ['id' => $entry->id]);
    }
}

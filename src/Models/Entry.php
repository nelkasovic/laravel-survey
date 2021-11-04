<?php

namespace Wimando\Survey\Models;

use Database\Factories\EntryFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Wimando\Survey\Contracts\Entry as EntryContract;
use Wimando\Survey\Exceptions\GuestEntriesNotAllowedException;
use Wimando\Survey\Exceptions\MaxEntriesPerUserLimitExceeded;
use Wimando\Survey\Facades\Factories\Models\AnswerFactory;

class Entry extends Model implements EntryContract
{
    /**
     * @var array
     */
    protected $fillable = ['survey_id', 'participant_id'];

    public function __construct(array $attributes = [])
    {
        if (!isset($this->table)) {
            $this->setTable(config('survey.database.tables.entries'));
        }

        parent::__construct($attributes);
    }

    protected static function boot(): void
    {
        parent::boot();

        //Prevent submission of entries that don't meet the parent survey's constraints.
        static::creating(function (self $entry) {
            $entry->validateParticipant();
            $entry->validateMaxEntryPerUserRequirement();
        });
    }

    /**
     * Validate participant's legibility.
     *
     * @throws GuestEntriesNotAllowedException
     */
    public function validateParticipant()
    {
        if ($this->survey->acceptsGuestEntries()) {
            return;
        }

        if (null !== $this->participant_id) {
            return;
        }

        throw new GuestEntriesNotAllowedException();
    }

    /**
     * Validate if entry exceeds the survey's
     * max entry per participant limit.
     *
     * @throws MaxEntriesPerUserLimitExceeded
     */
    public function validateMaxEntryPerUserRequirement()
    {
        $limit = $this->survey->limitPerParticipant();

        if (null === $limit) {
            return;
        }

        $count = static::where('participant_id', $this->participant_id)
            ->where('survey_id', $this->survey->id)
            ->count();

        if ($count >= $limit) {
            throw new MaxEntriesPerUserLimitExceeded();
        }
    }

    protected static function newFactory(): EntryFactory
    {
        return EntryFactory::new();
    }

    public function for(Survey $survey): Entry
    {
        $this->survey()->associate($survey);

        return $this;
    }

    public function survey(): BelongsTo
    {
        return $this->belongsTo(get_class(App::make(Survey::class)));
    }

    public function by(Model $model = null): Entry
    {
        $this->participant()->associate($model);

        return $this;
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'participant_id');
    }

    public function fromArray(array $values): Entry
    {
        Collection::make($values)->each(function ($item, $key) {
            $this->addAnswers(substr($key, 1), $item);
        });

        return $this;
    }

    public function addAnswers(int $questionId, array $options): Entry
    {
        Collection::make($options)->each(function ($value, $optionId) use ($questionId) {
            $this->answers->add(
                AnswerFactory::create([
                    'question_id' => $questionId,
                    'option_id' => $optionId,
                    'entry_id' => $this->id,
                    'value' => $value,
                ])
            );
        });

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function answerFor(Question $question)
    {
        $answer = $this->answers()
            ->where('question_id', $question->id)
            ->first();

        return isset($answer) ? $answer->value : null;
    }

    public function answers(): HasMany
    {
        return $this->hasMany(get_class(App::make(Answer::class)));
    }

    /**
     * Save the model and all of its relationships.
     * Ensure the answers are automatically linked to the entry.
     */
    public function push(): bool
    {
        $this->save();

        $this->answers()->each(function (Answer $answer) {
            $answer->entry_id = $this->id;
        });

        return parent::push();
    }
}

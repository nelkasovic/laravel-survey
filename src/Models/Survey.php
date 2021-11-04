<?php

namespace Wimando\Survey\Models;

use Database\Factories\SurveyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;
use Wimando\Survey\Contracts\Survey as SurveyContract;

class Survey extends Model implements SurveyContract
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['name', 'settings'];
    /**
     * @var array
     */
    protected $casts = [
        'settings' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        if (!isset($this->table)) {
            $this->setTable(config('survey.database.tables.surveys'));
        }

        parent::__construct($attributes);
    }

    protected static function newFactory(): SurveyFactory
    {
        return SurveyFactory::new();
    }

    public function sections(): HasMany
    {
        return $this->hasMany(get_class(App::make(Section::class)));
    }

    public function questions(): HasMany
    {
        return $this->hasMany(get_class(App::make(Question::class)));
    }

    public function lastEntry(Model $participant): ?Model
    {
        return $this->entriesFrom($participant)->first();
    }

    public function entriesFrom(Model $participant): HasMany
    {
        return $this->entries()->where('participant_id', $participant->id);
    }

    public function entries(): HasMany
    {
        return $this->hasMany(get_class(App::make(Entry::class)));
    }

    public function isEligible(Model $participant = null): bool
    {
        if (null === $participant) {
            return $this->acceptsGuestEntries();
        }

        if (null === $this->limitPerParticipant()) {
            return true;
        }

        return $this->limitPerParticipant() > $this->entriesFrom($participant)->count();
    }

    public function acceptsGuestEntries(): bool
    {
        return $this->settings['accept-guest-entries'] ?? false;
    }

    public function limitPerParticipant(): ?int
    {
        if ($this->acceptsGuestEntries()) {
            return null;
        }

        $limit = $this->settings['limit-per-participant'] ?? 1;

        return -1 !== $limit ? $limit : null;
    }

    /**
     * Combined validation rules of the survey.
     *
     * @return mixed
     */
    public function getRulesAttribute()
    {
        return $this->questions->mapWithKeys(function (Question $question) {
            if (!$question->rules) {
                return [];
            }
            if ($question->isSimpleType()) {
                return $question->options->mapWithKeys(function ($option) use ($question) {
                    return [$question->key.'.'.$option->id => $question->rules];
                })->all();
            }

            return [$question->key => $question->rules];
        })->all();
    }
}

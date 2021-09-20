<?php

namespace Wimando\Survey\Models;

use Database\Factories\SurveyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends Model
{

    use HasFactory;

    public function __construct(array $attributes = [])
    {
        if (!isset($this->table)) {
            $this->setTable(config('survey.database.tables.surveys'));
        }

        parent::__construct($attributes);
    }

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

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
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

        return $limit !== -1 ? $limit : null;
    }

    public function entriesFrom(Model $participant): HasMany
    {
        return $this->entries()->where('participant_id', $participant->id);
    }

    public function lastEntry(Model $participant): ?Model
    {
        return $this->entriesFrom($participant)->first();
    }

    public function isEligible(Model $participant = null): bool
    {
        if ($participant === null) {
            return $this->acceptsGuestEntries();
        }

        if ($this->limitPerParticipant() === null) {
            return true;
        }

        return $this->limitPerParticipant() > $this->entriesFrom($participant)->count();
    }

    /**
     * Combined validation rules of the survey.
     *
     * @return mixed
     */
    public function getRulesAttribute()
    {
        return $this->questions->mapWithKeys(function ($question) {
            return [$question->key => $question->rules];
        })->all();
    }

    protected static function newFactory(): SurveyFactory
    {
        return SurveyFactory::new();
    }
}

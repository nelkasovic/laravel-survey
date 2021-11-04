<?php

namespace Wimando\Survey\Models;

use Database\Factories\QuestionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;
use Wimando\Survey\Contracts\Question as QuestionContract;

class Question extends Model implements QuestionContract
{
    use HasFactory;

    const QUESTION_TYPE_RADIO = 'radio';
    const QUESTION_TYPE_CHECKBOX = 'checkbox';
    const QUESTION_TYPE_TEXT = 'text';
    const QUESTION_TYPE_NUMBER = 'number';

    /**
     * @var array
     */
    protected $fillable = ['type', 'content', 'rules', 'survey_id'];

    protected $casts = [
        'rules' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        if (!isset($this->table)) {
            $this->setTable(config('survey.database.tables.questions'));
        }

        parent::__construct($attributes);
    }

    protected static function boot(): void
    {
        parent::boot();

        //Ensure the question's survey is the same as the section it belongs to.
        static::creating(function (self $question) {
            $question->load('section');

            if ($question->section) {
                $question->survey_id = $question->section->survey_id;
            }
        });

        static::saved(function (self $question) {
            if ('number' === $question->type || 'text' === $question->type) {
                $question->options()->updateOrCreate([
                    'question_id' => $question->id,
                ]);
            }
        });
    }

    public function options(): HasMany
    {
        return $this->hasMany(get_class(App::make(Option::class)));
    }

    protected static function newFactory(): QuestionFactory
    {
        return QuestionFactory::new();
    }

    public function survey(): BelongsTo
    {
        return $this->belongsTo(get_class(App::make(Survey::class)));
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(get_class(App::make(Section::class)));
    }

    public function answers(): HasMany
    {
        return $this->hasMany(get_class(App::make(Answer::class)));
    }

    /**
     * @param $value
     *
     * @return array|mixed
     */
    public function getRulesAttribute($value)
    {
        $value = $this->castAttribute('rules', $value);

        return null !== $value ? $value : [];
    }

    public function getKeyAttribute(): string
    {
        return "q{$this->id}";
    }

    public function getFirstOption()
    {
        return $this->options()->first();
    }

    /**
     * Scope a query to only include questions that
     * don't belong to any sections.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeWithoutSection($query)
    {
        return $query->where('section_id', null);
    }

    public function isSimpleType(): bool
    {
        if (self::QUESTION_TYPE_NUMBER === $this->type) {
            return true;
        }
        if (self::QUESTION_TYPE_TEXT === $this->type) {
            return true;
        }

        return false;
    }
}

<?php

namespace Wimando\Survey\Models;

use Database\Factories\AnswerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;
use Wimando\Survey\Contracts\Answer as AnswerContract;

class Answer extends Model implements AnswerContract
{

    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['value', 'question_id', 'entry_id'];

    public function __construct(array $attributes = [])
    {
        if (!isset($this->table)) {
            $this->setTable(config('survey.database.tables.answers'));
        }

        parent::__construct($attributes);
    }

    protected static function newFactory(): AnswerFactory
    {
        return AnswerFactory::new();
    }

    public function entry(): BelongsTo
    {
        return $this->belongsTo(get_class(App::make(Entry::class)));
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(get_class(App::make(Question::class)));
    }
}

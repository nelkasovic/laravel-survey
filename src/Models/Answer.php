<?php

namespace Wimando\Survey\Models;

use Database\Factories\AnswerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{

    use HasFactory;

    public function __construct(array $attributes = [])
    {
        if (!isset($this->table)) {
            $this->setTable(config('survey.database.tables.answers'));
        }

        parent::__construct($attributes);
    }

    /**
     * @var array
     */
    protected $fillable = ['value', 'question_id', 'entry_id'];

    public function entry(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    protected static function newFactory(): AnswerFactory
    {
        return AnswerFactory::new();
    }
}

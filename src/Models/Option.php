<?php

namespace Wimando\Survey\Models;

use Database\Factories\OptionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;
use Wimando\Survey\Contracts\Option as OptionContract;

class Option extends Model implements OptionContract
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['value', 'question_id'];

    public function __construct(array $attributes = [])
    {
        if (!isset($this->table)) {
            $this->setTable(config('survey.database.tables.options'));
        }

        parent::__construct($attributes);
    }

    protected static function newFactory(): OptionFactory
    {
        return OptionFactory::new();
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(get_class(App::make(Question::class)));
    }
}

<?php

namespace Wimando\Survey\Models;

use Database\Factories\SectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{

    use HasFactory;

    public function __construct(array $attributes = [])
    {
        if (!isset($this->table)) {
            $this->setTable(config('survey.database.tables.sections'));
        }

        parent::__construct($attributes);
    }

    /**
     * @var array
     */
    protected $fillable = ['name'];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    protected static function newFactory(): SectionFactory
    {
        return SectionFactory::new();
    }
}

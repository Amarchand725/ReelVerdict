<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug()
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = $model->generateSlug($model->getSlugSource());
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty($model->getSlugSourceColumn())) {
                $model->slug = $model->generateSlug($model->getSlugSource());
            }
        });
    }

    protected function generateSlug($value)
    {
        $slug = Str::slug($value);

        $original = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }

    // You can override this in model
    protected function getSlugSource()
    {
        return $this->{$this->getSlugSourceColumn()};
    }

    protected function getSlugSourceColumn()
    {
        return 'title'; // default
    }
}
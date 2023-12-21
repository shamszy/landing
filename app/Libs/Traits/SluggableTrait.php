<?php

namespace App\Libs\Traits;

/**
 * SluggableTrait
 * @method static where(string $string, string $string1, $name)
 */
trait SluggableTrait
{
    /**
     * @return void
     */
    protected static function bootSluggableTrait(): void
    {
        static::creating(function ($model) {
            $slugSource = $model->attributes[$model->sluggable['source']];
            $model->slug = $model->generateSlug($slugSource, $model->sluggable['source']);
        });
        static::updating(function ($model) {
            $slugSource = $model->attributes[$model->sluggable['source']];
            $model->slug = $model->updateSlug($slugSource, $model->sluggable['source']);
        });
    }

    /**
     * @param $name
     * @param $key
     * @return mixed
     */
    private function generateSlug($name, $key): mixed
    {
        if (static::whereSlug($slug = str()->slug($name))->exists()) {
            return $this->extracted($key, $name, $slug);
        }
        return $slug;
    }

    /**
     * @param $name
     * @param $key
     * @return mixed
     */
    private function updateSlug($name, $key): mixed
    {
        if (!static::whereSlug($slug = str()->slug($name))->exists()) {
            return $this->extracted($key, $name, $slug);
        }
        return $slug;
    }

    /**
     * @param $key
     * @param $name
     * @param mixed $slug
     * @return array|string|string[]|null
     */
    private function extracted($key, $name, mixed $slug): string|array|null
    {
        $max = static::where("$key", '=', $name)->latest('id')->value('slug');
        if (isset($max[-1]) && is_numeric($max[-1])) {
            return preg_replace_callback('/(\d+)$/', function ($mathces) {
                return $mathces[1] + 1;
            }, $max);
        }
        return "{$slug}-" . +1;
    }

}

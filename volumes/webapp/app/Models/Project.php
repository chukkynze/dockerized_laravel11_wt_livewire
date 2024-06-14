<?php

namespace App\Models;

use App\Exceptions\SetNotAllowedException;
use App\Traits\Models\CustomUuids;
use Database\Factories\ProjectFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 *
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property int $type_id
 * @property int $status_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read ProjectStatus|null $status
 * @property-read Collection<int, Task> $tasks
 * @property-read int|null $tasks_count
 * @property-read ProjectType|null $type
 * @method static ProjectFactory factory($count = null, $state = [])
 * @method static Builder|Project newModelQuery()
 * @method static Builder|Project newQuery()
 * @method static Builder|Project onlyTrashed()
 * @method static Builder|Project query()
 * @method static Builder|Project search($value)
 * @method static Builder|Project whereCreatedAt($value)
 * @method static Builder|Project whereDeletedAt($value)
 * @method static Builder|Project whereId($value)
 * @method static Builder|Project whereMetadata($value)
 * @method static Builder|Project whereName($value)
 * @method static Builder|Project whereStatusId($value)
 * @method static Builder|Project whereTypeId($value)
 * @method static Builder|Project whereUpdatedAt($value)
 * @method static Builder|Project whereUuid($value)
 * @method static Builder|Project withTrashed()
 * @method static Builder|Project withoutTrashed()
 * @method static Builder|Project paginate($number)
 * @mixin Eloquent
 */
class Project extends Model
{
    use HasFactory,
        CustomUuids,
        SoftDeletes
        ;


    protected $table = 'projects';


    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $now = now();
            $model->uuid = (string) Str::uuid();
            $model->created_at = $now;
            $model->updated_at = $now;
        });
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }


    /**
     * @throws SetNotAllowedException
     */
    public function setUuid(?string $uuid): void
    {
        throw new SetNotAllowedException("Cannot set the uuid as '$uuid'. Uuid's are set by the framework");
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getType(): int
    {
        return $this->type_id;
    }

    public function getTypeId(): int
    {
        return $this->type_id;
    }

    public function setTypeId(int $type_id): void
    {
        $this->type_id = $type_id;
    }

    public function getStatusId(): int
    {
        return $this->status_id;
    }

    public function setStatusId(int $status_id): void
    {
        $this->status_id = $status_id;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setCreatedAt($value): static
    {
        $this->created_at = $value;
        return $this;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setUpdatedAt($value): static
    {
        $this->created_at = $value;
        return $this;
    }

    public function getDeletedAt(): ?Carbon
    {
        return $this->deleted_at;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setDeletedAt(mixed $value): static
    {
        $this->created_at = $value;
        return $this;
    }


    /**
     * Get the tasks for the project.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function type(): HasOne
    {
        return $this->hasOne(ProjectType::class, 'id', 'type_id');
    }

    public function status(): HasOne
    {
        return $this->hasOne(ProjectStatus::class, 'id', 'status_id');
    }

    public function scopeSearch($query, $value): void
    {
        $query->where('name', 'like', "%$value%");
    }
}

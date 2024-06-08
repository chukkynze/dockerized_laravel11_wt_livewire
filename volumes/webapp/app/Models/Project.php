<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string|null $uuid
 * @property string $name
 * @property int $priority
 * @property int $type_id
 * @property int $status_id
 * @property string $metadata
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Task> $tasks
 * @property-read int|null $tasks_count
 * @method static Builder|Project newModelQuery()
 * @method static Builder|Project newQuery()
 * @method static Builder|Project onlyTrashed()
 * @method static Builder|Project query()
 * @method static Builder|Project whereCreatedAt($value)
 * @method static Builder|Project whereDeletedAt($value)
 * @method static Builder|Project whereId($value)
 * @method static Builder|Project whereMetadata($value)
 * @method static Builder|Project whereName($value)
 * @method static Builder|Project wherePriority($value)
 * @method static Builder|Project whereStatusId($value)
 * @method static Builder|Project whereTypeId($value)
 * @method static Builder|Project whereUpdatedAt($value)
 * @method static Builder|Project whereUuid($value)
 * @method static Builder|Project withTrashed()
 * @method static Builder|Project withoutTrashed()
 * @method static Builder|Project search($string)
 * @method static Builder|Project paginate($number)
 * @mixin Eloquent
 */
class Project extends Model
{
    use HasFactory,
        SoftDeletes
        ;

    protected $table = 'projects';


    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
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

    public function getMetadata(): string
    {
        return $this->metadata;
    }

    public function setMetadata(string $metadata): void
    {
        $this->metadata = $metadata;
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
    public function setDeletedAt($value): static
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

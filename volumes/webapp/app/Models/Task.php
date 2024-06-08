<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * 
 *
 * @property int $id
 * @property string|null $uuid
 * @property int $project_id
 * @property string $name
 * @property int $priority
 * @property string $start_dt
 * @property string $end_dt
 * @property string $metadata
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \App\Models\Project $project
 * @method static Builder|Task newModelQuery()
 * @method static Builder|Task newQuery()
 * @method static Builder|Task onlyTrashed()
 * @method static Builder|Task query()
 * @method static Builder|Task whereCreatedAt($value)
 * @method static Builder|Task whereDeletedAt($value)
 * @method static Builder|Task whereEndDt($value)
 * @method static Builder|Task whereId($value)
 * @method static Builder|Task whereMetadata($value)
 * @method static Builder|Task whereName($value)
 * @method static Builder|Task wherePriority($value)
 * @method static Builder|Task whereProjectId($value)
 * @method static Builder|Task whereStartDt($value)
 * @method static Builder|Task whereUpdatedAt($value)
 * @method static Builder|Task whereUuid($value)
 * @method static Builder|Task withTrashed()
 * @method static Builder|Task withoutTrashed()
 * @mixin \Eloquent
 */
class Task extends Model
{
    use HasFactory,
        SoftDeletes
        ;

    protected $table = 'tasks';


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

    public function getProjectId(): int
    {
        return $this->project_id;
    }

    public function setProjectId(int $project_id): void
    {
        $this->project_id = $project_id;
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

    public function getStartDt(): string
    {
        return $this->start_dt;
    }

    public function setStartDt(string $start_dt): void
    {
        $this->start_dt = $start_dt;
    }

    public function getEndDt(): string
    {
        return $this->end_dt;
    }

    public function setEndDt(string $end_dt): void
    {
        $this->end_dt = $end_dt;
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
     * Get the project that owns the task.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}

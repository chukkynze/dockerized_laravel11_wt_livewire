<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property int $enabled
 * @property int $sort_order
 * @property string|null $meta
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ProjectType newModelQuery()
 * @method static Builder|ProjectType newQuery()
 * @method static Builder|ProjectType query()
 * @method static Builder|ProjectType whereCreatedAt($value)
 * @method static Builder|ProjectType whereDescription($value)
 * @method static Builder|ProjectType whereDisplayName($value)
 * @method static Builder|ProjectType whereEnabled($value)
 * @method static Builder|ProjectType whereId($value)
 * @method static Builder|ProjectType whereMeta($value)
 * @method static Builder|ProjectType whereName($value)
 * @method static Builder|ProjectType whereSortOrder($value)
 * @method static Builder|ProjectType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProjectType extends Model
{
    protected $table = 'project_types';

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDisplayName(): string
    {
        return $this->display_name;
    }

    public function setDisplayName(string $display_name): void
    {
        $this->display_name = $display_name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getEnabled(): int
    {
        return $this->enabled;
    }

    public function setEnabled(int $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getSortOrder(): int
    {
        return $this->sort_order;
    }

    public function setSortOrder(int $sort_order): void
    {
        $this->sort_order = $sort_order;
    }

    public function getMeta(): ?string
    {
        return $this->meta;
    }

    public function setMeta(?string $meta): void
    {
        $this->meta = $meta;
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
}

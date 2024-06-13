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
 * @method static Builder|ProjectStatus newModelQuery()
 * @method static Builder|ProjectStatus newQuery()
 * @method static Builder|ProjectStatus query()
 * @method static Builder|ProjectStatus whereCreatedAt($value)
 * @method static Builder|ProjectStatus whereDescription($value)
 * @method static Builder|ProjectStatus whereDisplayName($value)
 * @method static Builder|ProjectStatus whereEnabled($value)
 * @method static Builder|ProjectStatus whereId($value)
 * @method static Builder|ProjectStatus whereMeta($value)
 * @method static Builder|ProjectStatus whereName($value)
 * @method static Builder|ProjectStatus whereSortOrder($value)
 * @method static Builder|ProjectStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProjectStatus extends Model
{
    protected $table = 'project_statuses';

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

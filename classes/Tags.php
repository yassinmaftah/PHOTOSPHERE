<?php

class Tag {
    private ?int $id;
    private string $name;
    private string $slug;
    private int $usage_count;

    public function __construct(string $name, string $slug, int $usage_count = 0, ?int $id = null) {
        $this->name = $name;
        $this->slug = $slug;
        $this->usage_count = $usage_count;
        $this->id = $id;
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getSlug(): string { return $this->slug; }
    public function getUsageCount(): int { return $this->usage_count; }

}
?>
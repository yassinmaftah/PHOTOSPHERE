<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../classes/Tags.php';

class TagRepo {
    
    public function addTag(Tag $tag)
    {
        $db = Database::getConnection();
        
        $sql = "INSERT INTO tags (name, slug, usage_count) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        
        $stmt->execute([$tag->getName(), $tag->getSlug(), $tag->getUsageCount()]);
    }

    public function removeTag(string $tagName)
    {
        $db = Database::getConnection();
        $sql = "DELETE FROM tags WHERE name = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$tagName]);
    }

    public function getTags() 
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM tags ORDER BY usage_count DESC";
        $stmt = $db->query($sql);
        $rows = $stmt->fetchAll();
        
        $tagsList = [];
        foreach ($rows as $row) {
            $tagsList[] = new Tag($row['name'], $row['slug'], $row['usage_count'],$row['id']);
        }
        return $tagsList;
    }

    public function checkPost($post_id)
    {
        $db = Database::getConnection();
        $sql = "SELECT COUNT(*) FROM posts WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$post_id]);
        return $stmt->fetchColumn() > 0;
    }
    public function checkTag($tag_id)
    {
        $db = Database::getConnection();
        $sql = "SELECT COUNT(*) FROM tags WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$tag_id]);
        return $stmt->fetchColumn() > 0;
    }

    public function AddTagToPost($tag_id, $post_id) 
    {
        $db = Database::getConnection();
        $checkPost = $this->checkPost($post_id);
        $checkID = $this->checkTag($tag_id);
        if ($checkPost && $checkID)
        {
            $sql = "INSERT IGNORE INTO post_tags (post_id, tag_id) VALUES (?, ?)";
            $stmt = $db->prepare($sql);
            if ($stmt->execute([$post_id, $tag_id]))
                $this->incrementTagCount($tag_id);
        }
        else
            echo "Not fond Post or tag<br>";
    }

    public function incrementTagCount($tag_id) 
    {
        $db = Database::getConnection();
        $sql = "UPDATE tags SET usage_count = usage_count + 1 WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$tag_id]);
    }

    public function hasTag(string $tagName): bool 
    {
        $db = Database::getConnection();
        $sql = "SELECT COUNT(*) FROM tags WHERE name = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$tagName]);
        
        return $stmt->fetchColumn() > 0;
    }
    
    public function getTagIdByName(string $tagName)
    {
        $db = Database::getConnection();
        $sql = "SELECT id FROM tags WHERE name = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$tagName]);
        $result = $stmt->fetchColumn();
        
        return $result ? (int)$result : null;
    }
}
?>
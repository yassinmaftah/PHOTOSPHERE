<?php
require_once 'config/Database.php';
require_once 'classes/Tags.php'; 
require_once 'repo/TagRepo.php';


$tagRepo = new TagRepo();

$tagName = "Photography";
$tagSlug = "photography";
$postId = 10; 

echo "<h2>--- Start Tag Repository Test ---</h2>";

if ($tagRepo->hasTag($tagName)) {
    echo "Info: Tag '$tagName' already exists.<br>";
} else {
    echo "Action: Creating new tag '$tagName'...<br>";
    $newTag = new Tag($tagName, $tagSlug);
    $tagRepo->addTag($newTag);
    echo "Success: Tag added.<br>";
}

$tagId = $tagRepo->getTagIdByName($tagName);

if ($tagId) 
{
    echo "Info: The ID for '$tagName' is: $tagId<br>";

    echo "Action: Linking Tag ID $tagId to Post ID $postId...<br>";
    $tagRepo->AddTagToPost($tagId, $postId);
} 
else
    echo "Error: Could not find Tag ID.<br>";

echo "<hr>";
echo "<h3>Current Tags List:</h3>";

$allTags = $tagRepo->getTags();

echo "<pre>";
foreach ($allTags as $tag) {
    echo "ID: " . $tag->getId() . " | ";
    echo "Name: " . $tag->getName() . " | ";
    echo "Slug: " . $tag->getSlug() . " | ";
    echo "Count: " . $tag->getUsageCount() . "\n";
}
echo "</pre>";

?>
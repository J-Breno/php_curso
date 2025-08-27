<?php
class Post {
    public int $id;
    public int $likes = 0;
    public array $comments = [];
    public string $author;

    public function __construct(int $qtdLikes) {
        $this->likes = $qtdLikes;
    }

    public function aumentarLike() {
        $this->likes++;
    }


}

$post1 = new Post(25);
$post1->aumentarLike();
$post1->aumentarLike();

$post2 = new Post(2);
$post2->aumentarLike();

echo 'POST 1: '.$post1->likes."<br />";
echo 'POST 2: '.$post2->likes."<br />";
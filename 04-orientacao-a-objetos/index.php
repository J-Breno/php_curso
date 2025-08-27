<?php
class Post {
    public int $id;
    public int $likes = 0;
    public array $comments = [];
    private string $author;

    public function __construct(int $qtdLikes) {
        $this->likes = $qtdLikes;
    }

    public function aumentarLike() {
        $this->likes++;
    }

    public function setAuthor($n)
    {
        if(strlen($n) >= 3) {
            $this->author = ucfirst($n);
        }
    }

    public function  getAuthor(): string
    {
        return $this->author ?? 'Visitante';
    }
}

$post1 = new Post(25);
$post1->aumentarLike();
$post1->aumentarLike();
$post1->setAuthor("Breno");

$post2 = new Post(2);
$post2->aumentarLike();
$post2->setAuthor("João");
echo 'POST 1: '.$post1->likes." likes - ".$post1->getAuthor()."<br />";
echo 'POST 2: '.$post2->likes." likes - ".$post2->getAuthor()."<br />";
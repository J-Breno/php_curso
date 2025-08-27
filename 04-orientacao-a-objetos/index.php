<?php
class Post {
    private int $id;
    private int $likes = 0;

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function  getId()
    {
        return $this->id;
    }

    public function setLikes(int $likes)
    {
        $this->likes = $likes;
    }

    public function  getLikes()
    {
        return $this->likes;
    }
}

class Foto extends Post {
    private $url;

    public function _construct($id) {
        $this->setId($id);
    }

    public function setUrl($u)
    {
        $this->url = $u;
    }

    public function getUrl()
    {
        return $this->url;
    }
}

$foto = new Foto(20);
$foto->setLikes(12);

echo "FOTO: #".$foto->getId().' - '.$foto->getLikes()." likes";
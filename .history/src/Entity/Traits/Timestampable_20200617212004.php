



namespace App\Entity\Traits;


trait Timestampable
{
    /**
     *@ORM\Column(type="datetime",options={"default":"CURRENT_TIMESTAMP"})
    */
    private $createdAt;

    /**
     *@ORM\Column(type="datetime",options={"default":"CURRENT_TIMESTAMP"})
     */
    private $updatedAt;

}



<?php
namespace FootballBlog\Fkr;
use Faker;
use FootballBlog\Processors\BloggersFunctions;

class fakerIndex{


    private $faker;
    private $bloggerFunction;

    /**
     * Fkr constructor.
     */
    public function __construct()
    {
        $this->faker = Faker\Factory::create();
        $this->bloggerFunction = new BloggersFunctions();
    }

    public function fakerAddBlogger(){
        /*** @param $creatorID
        * @param $username
        * @param $password
        * @param $email
        * @param $firstName
        * @param $lastName
        * @param $description
        * @param $imageTempName
        * @param $imageFileName
        * @param $baseDir**/
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $username = $this->faker->name;
        $description = $this->faker->text();

        $this->bloggerFunction->addBlogger();
    }


}
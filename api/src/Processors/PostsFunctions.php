<?php
namespace FootballBlog\Processors;

use FootballBlog\Models\DataHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use FootballBlog\Utils\DBConnect;

/**
 * Class PostsFunctions
 * @package Processors
 */
class PostsFunctions{

    /**
     * @var DataHandler
     */
    private $dataHandle;
    /**
     * @var Logger
     */
    private $log;

    /**
     * PostsFunctions constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->dataHandle = new DataHandler();

        $this->log = new Logger("Posts Functions");
        $errorStreamHandler = new StreamHandler("../../runtime/logs/error.log",Logger::ERROR);
        $infoStreamHandler = new StreamHandler("../../runtime/logs/info.log",Logger::INFO);
        $debugStreamHandler = new StreamHandler("../../runtime/logs/debug.log",Logger::DEBUG);

        $this->log->pushHandler($errorStreamHandler);
        $this->log->pushHandler($infoStreamHandler);
        $this->log->pushHandler($debugStreamHandler);
    }

    /**
     *
     */
    public function fetchAllPublishedPosts(){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT b.postID, b.postTitle,b.postDescription,b.postContent,b.postDate,b.authorID,b.postImage,b.urlSlug,cat.categoryName FROM blog_posts b INNER JOIN categories cat ON b.categoryID = cat.categoryID WHERE b.isPublished = 1 ORDER BY b.postDate DESC";

        if ($stmt = mysqli_prepare($conn,$query)){
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostID,$fetchedPostTitle,$fetchedPostDesc,$fetchedPostContent,$fetchedPostDate,$fetchedAuthorID,$fetchedPostImage,$fetchedUrlSlug,$fetchedCategoryName);
                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "/".$fetchedPostImage;
//                    $imageURL = $fetchedPostImage;
                    $imageURL = "/dunda-v2".$fetchedPostImage;
                    $data[] = array("post_id"=>$fetchedPostID,"post_title"=>$fetchedPostTitle,"post_desc"=>$fetchedPostDesc,"post_content"=>$fetchedPostContent,"post_date"=>$fetchedPostDate,"author_id"=>$fetchedAuthorID,"category"=>$fetchedCategoryName,"url_slug"=>$fetchedUrlSlug,"image_url"=>$imageURL);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching published posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }


    public function fetchAllPublishedPostsMain(){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT b.postID, b.postTitle,b.postDescription,b.postContent,b.postDate,b.authorID,b.postImage,b.urlSlug,cat.categoryName FROM blog_posts b INNER JOIN categories cat ON b.categoryID = cat.categoryID WHERE b.isPublished = 1 ORDER BY b.postDate DESC";


        if ($stmt = mysqli_prepare($conn,$query)){
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostID,$fetchedPostTitle,$fetchedPostDesc,$fetchedPostContent,$fetchedPostDate,$fetchedAuthorID,$fetchedPostImage,$fetchedUrlSlug,$fetchedCategoryName);
                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "/".$fetchedPostImage;
//                    $imageURL = $fetchedPostImage;
                    $imageURL = "/dunda-v2".$fetchedPostImage;
                    $data[] = array("post_id"=>$fetchedPostID,"post_title"=>$fetchedPostTitle,"post_desc"=>$fetchedPostDesc,"post_content"=>$fetchedPostContent,"post_date"=>$fetchedPostDate,"author_id"=>$fetchedAuthorID,"category"=>$fetchedCategoryName,"url_slug"=>$fetchedUrlSlug,"image_url"=>$imageURL);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching published posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function shufflePublishedPostsAssoc(&$array) {
        $keys = array_keys($array);

        shuffle($keys);

        foreach($keys as $key) {
            $new[$key] = $array[$key];
        }

        return $array = $new;
//
//        return true;

    }

    public function shuffleFivePostsAssoc(&$array){
        $array = $this->shufflePublishedPostsAssoc($array);
        $result = array();
        for ($i = 0;$i < sizeof($array);$i++){
            array_push($result,$array[$i]);
        }
        return $array;
    }

    public function generatePrettyDate($rawDate){
        $convertDate = strtotime($rawDate);
        $day = date('j',$convertDate);
        $month = date('M',$convertDate);
        $year = date('Y',$convertDate);

        $result = $month.' '.$day.', '.$year;
        return $result;
    }

    /**
     * @return false|string
     */
    public function fetch30DayRecentPublishedPostsMain(){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT b.postID, b.postTitle,b.postDescription,b.postContent,b.postDate,b.authorID,b.postImage,b.urlSlug,cat.categoryName FROM blog_posts b INNER JOIN categories cat ON b.categoryID = cat.categoryID WHERE b.isPublished = 1 AND DATEDIFF(CURRENT_DATE,b.postDate) < 30 ORDER BY b.postDate DESC";

        if ($stmt = mysqli_prepare($conn,$query)){
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostID,$fetchedPostTitle,$fetchedPostDesc,$fetchedPostContent,$fetchedPostDate,$fetchedAuthorID,$fetchedPostImage,$fetchedUrlSlug,$fetchedCategoryName);
                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "/".$fetchedPostImage;
//                    $imageURL = $fetchedPostImage;
                    $imageURL = "/dunda-v2".$fetchedPostImage;
                    $data[] = array("post_id"=>$fetchedPostID,"post_title"=>$fetchedPostTitle,"post_desc"=>$fetchedPostDesc,"post_content"=>$fetchedPostContent,"post_date"=>$fetchedPostDate,"author_id"=>$fetchedAuthorID,"url_slug"=>$fetchedUrlSlug,"category"=>$fetchedCategoryName,"image_url"=>$imageURL);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching published posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function fetchRecentPublishedPostsMain(){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT b.postID, b.postTitle,b.postDescription,b.postContent,b.postDate,b.authorID,b.postImage,b.urlSlug,cat.categoryName FROM blog_posts b INNER JOIN categories cat ON b.categoryID = cat.categoryID WHERE b.isPublished = 1 ORDER BY b.postDate DESC LIMIT 3";

        if ($stmt = mysqli_prepare($conn,$query)){
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostID,$fetchedPostTitle,$fetchedPostDesc,$fetchedPostContent,$fetchedPostDate,$fetchedAuthorID,$fetchedPostImage,$fetchedUrlSlug,$fetchedCategoryName);
                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "/".$fetchedPostImage;
//                    $imageURL = $fetchedPostImage;
                    $imageURL = "/dunda-v2".$fetchedPostImage;
                    $data[] = array("post_id"=>$fetchedPostID,"post_title"=>$fetchedPostTitle,"post_desc"=>$fetchedPostDesc,"post_content"=>$fetchedPostContent,"post_date"=>$fetchedPostDate,"author_id"=>$fetchedAuthorID,"url_slug"=>$fetchedUrlSlug,"category"=>$fetchedCategoryName,"image_url"=>$imageURL);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching published posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }
    
    /**
     *
     */
    public function fetchUnpublishedPosts(){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT b.postID, b.postTitle,b.postDescription,b.postContent,b.postDate,b.authorID,b.postImage,b.urlSlug,cat.categoryName FROM blog_posts b INNER JOIN categories cat ON b.categoryID = cat.categoryID WHERE b.isPublished = 0 ORDER BY b.postDate DESC";

        if ($stmt = mysqli_prepare($conn,$query)){
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostID,$fetchedPostTitle,$fetchedPostDesc,$fetchedPostContent,$fetchedPostDate,$fetchedAuthorID,$fetchedPostImage,$fetchedUrlSlug,$fetchedCategoryName);
                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "/".$fetchedPostImage;
//                    $imageURL = $fetchedPostImage;
                    $imageURL = "/dunda-v2".$fetchedPostImage;
                    $data[] = array("post_id"=>$fetchedPostID,"post_title"=>$fetchedPostTitle,"post_desc"=>$fetchedPostDesc,"post_content"=>$fetchedPostContent,"post_date"=>$fetchedPostDate,"author_id"=>$fetchedAuthorID,"url_slug"=>$fetchedUrlSlug,"category"=>$fetchedCategoryName,"image_url"=>$imageURL);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching published posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @return false|string
     */
    public function fetchAllPosts(){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT b.postID, b.postTitle,b.postDescription,b.postContent,b.postDate,b.authorID,b.postImage,b.urlSlug,cat.categoryName FROM blog_posts b INNER JOIN categories cat ON b.categoryID = cat.categoryID ORDER BY b.postDate DESC";

        if ($stmt = mysqli_prepare($conn,$query)){
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostID,$fetchedPostTitle,$fetchedPostDesc,$fetchedPostContent,$fetchedPostDate,$fetchedAuthorID,$fetchedPostImage,$fetchedUrlSlug,$fetchedCategoryName);
                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "/".$fetchedPostImage;
//                    $imageURL = $fetchedPostImage;
                    $imageURL = "/dunda-v2".$fetchedPostImage;
                    $data[] = array("post_id"=>$fetchedPostID,"post_title"=>$fetchedPostTitle,"post_desc"=>$fetchedPostDesc,"post_content"=>$fetchedPostContent,"post_date"=>$fetchedPostDate,"author_id"=>$fetchedAuthorID,"url_slug"=>$fetchedUrlSlug,"category"=>$fetchedCategoryName,"image_url"=>$imageURL);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching published posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $postID
     * @return false|string
     */
    public function setTrendingPosts($postID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $postID = $this->dataHandle->sanitizeData($postID);

        $query = "UPDATE blog_posts SET isTrending = 1 WHERE postID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramPostID);
            $paramPostID = $postID;

            if (mysqli_stmt_execute($stmt)){
                $this->log->info("Post $postID set as trending");
                $output = array("error"=>"false","message"=>"Set as trending");
            }else{
                $this->log->error("Failed setting post trend ".mysqli_error($conn).' '.mysqli_stmt_error($stmt));
                $output = array("error"=>"true","message"=>"ailed setting as trending");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output = array("error"=>"true","message"=>"ailed setting as trending");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $postID
     * @return false|string
     */
    public function untrendPosts($postID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $postID = $this->dataHandle->sanitizeData($postID);

        $query = "UPDATE blog_posts SET isTrending = 0 WHERE postID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramPostID);
            $paramPostID = $postID;

            if (mysqli_stmt_execute($stmt)){
                $this->log->info("Post $postID set as trending");
                $output = array("error"=>"false","message"=>"Set as trending");
            }else{
                $this->log->error("Failed setting post trend ".mysqli_error($conn).' '.mysqli_stmt_error($stmt));
                $output = array("error"=>"true","message"=>"ailed setting as trending");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output = array("error"=>"true","message"=>"ailed setting as trending");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     *
     */
    public function fetchTrendingPosts(){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT b.postID, b.postTitle,b.postDescription,b.postContent,b.postDate,b.authorID,b.postImage,b.urlSlug,cat.categoryName FROM blog_posts b INNER JOIN categories cat ON b.categoryID = cat.categoryID WHERE b.isTrending = 1 ORDER BY b.postDate DESC";

        if ($stmt = mysqli_prepare($conn,$query)){
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostID,$fetchedPostTitle,$fetchedPostDesc,$fetchedPostContent,$fetchedPostDate,$fetchedAuthorID,$fetchedPostImage,$fetchedUrlSlug,$fetchedCategoryName);
                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "/".$fetchedPostImage;
//                    $imageURL = $fetchedPostImage;
                    $imageURL = "/dunda-v2".$fetchedPostImage;
                    $data[] = array("post_id"=>$fetchedPostID,"post_title"=>$fetchedPostTitle,"post_desc"=>$fetchedPostDesc,"post_content"=>$fetchedPostContent,"post_date"=>$fetchedPostDate,"author_id"=>$fetchedAuthorID,"url_slug"=>$fetchedUrlSlug,"category"=>$fetchedCategoryName,"image_url"=>$imageURL);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching published posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function fetchTrendingPostsMain(){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT b.postID, b.postTitle,b.postDescription,b.postContent,b.postDate,b.authorID,b.postImage,b.urlSlug,cat.categoryName FROM blog_posts b INNER JOIN categories cat ON b.categoryID = cat.categoryID WHERE b.isTrending = 1 AND b.isPublished = 1 ORDER BY b.postDate DESC";

        if ($stmt = mysqli_prepare($conn,$query)){
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostID,$fetchedPostTitle,$fetchedPostDesc,$fetchedPostContent,$fetchedPostDate,$fetchedAuthorID,$fetchedPostImage,$fetchedUrlSlug,$fetchedCategoryName);
                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "/".$fetchedPostImage;
//                    $imageURL = $fetchedPostImage;
                    $imageURL = "/dunda-v2".$fetchedPostImage;
                    $data[] = array("post_id"=>$fetchedPostID,"post_title"=>$fetchedPostTitle,"post_desc"=>$fetchedPostDesc,"post_content"=>$fetchedPostContent,"post_date"=>$fetchedPostDate,"author_id"=>$fetchedAuthorID,"url_slug"=>$fetchedUrlSlug,"category"=>$fetchedCategoryName,"image_url"=>$imageURL);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching published posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }


    /**
     * @return false|string
     */
    public function fetchCategories(){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT categoryID, categoryName FROM categories";

        if ($stmt = mysqli_prepare($conn,$query)){
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt,$categoryID,$categoryName);
                $count = mysqli_stmt_num_rows($stmt);
                while(mysqli_stmt_fetch($stmt)){
                    $data[]=array("id"=>$categoryID,"category_name"=>$categoryName);
                }
                $output=array("error"=>"false","data"=>$data,"count"=>$count);
            }else{
                $this->log->error("Failed fetching categories ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function fetchPostsByCategory($categoryID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $categoryID = $this->dataHandle->sanitizeData($categoryID);

        $query = "SELECT b.postID, b.postTitle,b.postDescription,b.postContent,b.postDate,b.authorID,b.postImage,b.urlSlug,cat.categoryName FROM blog_posts b INNER JOIN categories cat ON b.categoryID = cat.categoryID WHERE b.categoryID = ? ORDER BY b.postDate DESC";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramCategoryID);
            $paramCategoryID = $categoryID;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostID,$fetchedPostTitle,$fetchedPostDesc,$fetchedPostContent,$fetchedPostDate,$fetchedAuthorID,$fetchedPostImage,$fetchedCategoryName,$fetchedUrlSlug);
                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "/".$fetchedPostImage;
//                    $imageURL = $fetchedPostImage;
                    $imageURL = "/dunda-v2".$fetchedPostImage;
                    $data[] = array("post_id"=>$fetchedPostID,"post_title"=>$fetchedPostTitle,"post_desc"=>$fetchedPostDesc,"post_content"=>$fetchedPostContent,"post_date"=>$fetchedPostDate,"author_id"=>$fetchedAuthorID,"url_slug"=>$fetchedUrlSlug,"category"=>$fetchedCategoryName,"image_url"=>$imageURL);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching published posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function fetchPostsByCategoryMainSa($categoryID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $categoryID = $this->dataHandle->sanitizeData($categoryID);

        $query = "SELECT b.postID, b.postTitle,b.postDescription,b.postContent,b.postDate,b.authorID,b.postImage,cat.categoryName FROM blog_posts b INNER JOIN categories cat ON b.categoryID = cat.categoryID WHERE b.categoryID = ? ORDER BY b.postDate DESC";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramCategoryID);
            $paramCategoryID = $categoryID;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostID,$fetchedPostTitle,$fetchedPostDesc,$fetchedPostContent,$fetchedPostDate,$fetchedAuthorID,$fetchedPostImage,$fetchedCategoryName);
                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "/".$fetchedPostImage;
//                    $imageURL = $fetchedPostImage;
                    $imageURL = "/dunda-v2".$fetchedPostImage;
                    $data[] = array("post_id"=>$fetchedPostID,"post_title"=>$fetchedPostTitle,"post_desc"=>$fetchedPostDesc,"post_content"=>$fetchedPostContent,"post_date"=>$fetchedPostDate,"author_id"=>$fetchedAuthorID,"category"=>$fetchedCategoryName,"image_url"=>$imageURL);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching published posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function fetchPostsByCategoryMain($categoryName){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $categoryName = ucfirst(strtolower($categoryName));
        $categoryName = $this->dataHandle->sanitizeData($categoryName);

        $query = "SELECT b.postID, b.postTitle,b.postDescription,b.postContent,b.postDate,b.authorID,b.postImage,b.urlSlug,cat.categoryName FROM blog_posts b INNER JOIN categories cat ON b.categoryID = cat.categoryID WHERE cat.categoryName = ? AND b.isPublished = 1 ORDER BY b.postDate DESC";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'s',$paramCategoryName);
            $paramCategoryName = $categoryName;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostID,$fetchedPostTitle,$fetchedPostDesc,$fetchedPostContent,$fetchedPostDate,$fetchedAuthorID,$fetchedPostImage,$fetchedUrlSlug,$fetchedCategoryName);
                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "/".$fetchedPostImage;
//                    $imageURL = $fetchedPostImage;
                    $imageURL = "/dunda-v2".$fetchedPostImage;
                    $data[] = array("post_id"=>$fetchedPostID,"post_title"=>$fetchedPostTitle,"post_desc"=>$fetchedPostDesc,"post_content"=>$fetchedPostContent,"post_date"=>$fetchedPostDate,"author_id"=>$fetchedAuthorID,"url_slug"=>$fetchedUrlSlug,"category"=>$fetchedCategoryName,"image_url"=>$imageURL);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching published posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function countPostsPerCategory($categoryID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT COUNT(*) FROM blog_posts WHERE categoryID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramCategoryID);
            $paramCategoryID = $categoryID;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt,$count);
                while(mysqli_stmt_fetch($stmt)){
                    $mCount = $count;
                }
                $output = array("error"=>"false","message"=>"$mCount");
            }else{
                $this->log->error("Failed counting all posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Failed counting posts");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Failed counting posts");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $year
     */
    public function countPostsPerMonth($year){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $year = $this->dataHandle->sanitizeData($year);

        $query = "SELECT COUNT(*) AS postCount,MONTHNAME(postDate) AS monthPosted FROM blog_posts WHERE YEAR(postDate) = ? GROUP BY MONTH(postDate)";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramYear);
            $paramYear = $year;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostCount,$fetchedMonthPosted);
                while(mysqli_stmt_fetch($stmt)){
                    $output[] = array("month"=>$fetchedMonthPosted,"count"=>$fetchedMonthPosted);
                }
            }else{
                $this->log->error("Failed counting posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output[] = array("error"=>"true","message"=>"Ooops! Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output[] = array("error"=>"true","message"=>"Ooops! Something went wrong");
        }
        mysqli_close($conn);
        json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $postID
     * @param $firstName
     * @param $secondName
     * @param $commentMessage
     * @return false|string
     */
    public function addComment($postID, $firstName, $secondName, $commentMessage){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $postID = $this->dataHandle->sanitizeData($postID);
        $firstName = $this->dataHandle->sanitizeData($firstName);
        $lastName = $this->dataHandle->sanitizeData($secondName);
        $commentMessage = $this->dataHandle->sanitizeData($commentMessage);

        $query="INSERT INTO blog_comments (postID,commentFirstName,commentSecondName,commentMessage) VALUES (?,?,?,?)";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'isss',$paramPostID,$paramCommentFirstName,$paramCommentSecondNane,$paramCommentMessage);
            $paramPostID = $postID;
            $paramCommentFirstName = $firstName;
            $paramCommentSecondNane = $secondName;
            $paramCommentMessage = $commentMessage;

            if (mysqli_stmt_execute($stmt)){
                $this->log->info("Comment added by $firstName for $postID");
                $output=array("error"=>"false","message"=>"success");
            }else{
                $this->log->error("Failed adding comment ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output = array("error"=>"true","message"=>"Failed adding comment");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output = array("error"=>"true","message"=>"Failed adding comment");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $categoryID
     * @return false|string
     */
    public function deleteCategory($categoryID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $categoryID = $this->dataHandle->sanitizeData($categoryID);

        $query = "DELETE FROM categories WHERE categoryID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramCategoryID);
            $paramCategoryID = $categoryID;

            if (mysqli_stmt_execute($stmt)){
                $this->log->info("$categoryID deleted");
                $output=array("error"=>"false","message"=>"deleted successfully");
            }else{
                $this->log->error("Failed deleting category $categoryID");
                $output=array("error"=>"true","message"=>"deleted failed");
            }
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"false","message"=>"deleted failed");
        }
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @return false|string
     */
    public function countAllPosts(){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT COUNT(*) FROM blog_posts";

        if ($stmt = mysqli_prepare($conn,$query)){
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt,$count);
                while(mysqli_stmt_fetch($stmt)){
                    $mCount = $count;
                }
                $output = array("error"=>"false","message"=>"$mCount");
            }else{
                $this->log->error("Failed counting all posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Failed counting posts");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Failed counting posts");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @return false|string
     */
    public function countUnpublishedPosts(){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT COUNT(*) FROM blog_posts WHERE isPublished = 0";

        if ($stmt = mysqli_prepare($conn,$query)){
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt,$count);
                while(mysqli_stmt_fetch($stmt)){
                    $mCount = $count;
                }
                $output = array("error"=>"false","message"=>"$mCount");
            }else{
                $this->log->error("Failed counting all posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Failed counting posts");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Failed counting posts");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function countPublishedPosts(){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT COUNT(*) FROM blog_posts WHERE isPublished = 1";

        if ($stmt = mysqli_prepare($conn,$query)){
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt,$count);
                while(mysqli_stmt_fetch($stmt)){
                    $mCount = $count;
                }
                $output = array("error"=>"false","message"=>"$mCount");
            }else{
                $this->log->error("Failed counting all posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Failed counting posts");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Failed counting posts");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $postID
     * @return false|string
     */
    public function fetchPostDetails($postID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $postID = $this->dataHandle->sanitizeData($postID);

        $query = "SELECT b.postID, b.postTitle,b.postDescription,b.postContent,b.postDate,b.authorID,b.postImage,b.urlSlug,cat.categoryName FROM blog_posts b INNER JOIN categories cat ON b.categoryID = cat.categoryID WHERE b.postID = ? ORDER BY b.postDate DESC";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'s',$paramPostID);
            $paramPostID = $postID;
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostID,$fetchedPostTitle,$fetchedPostDesc,$fetchedPostContent,$fetchedPostDate,$fetchedAuthorID,$fetchedPostImage,$fetchedUrlSlug,$fetchedCategoryName);
                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "/".$fetchedPostImage;
//                    $imageURL = $fetchedPostImage;
                    $imageURL = "/dunda-v2".$fetchedPostImage;
                    $data[] = array("post_id"=>$fetchedPostID,"post_title"=>$fetchedPostTitle,"post_desc"=>$fetchedPostDesc,"post_content"=>$fetchedPostContent,"post_date"=>$fetchedPostDate,"author_id"=>$fetchedAuthorID,"url_slug"=>$fetchedUrlSlug,"category"=>$fetchedCategoryName,"image_url"=>$imageURL);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching published posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function fetchPostDetailsMain($postID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $postID = $this->dataHandle->sanitizeData($postID);

        $query = "SELECT b.postID, b.postTitle,b.postDescription,b.postContent,b.postDate,b.authorID,b.postImage,b.urlSlug,cat.categoryName FROM blog_posts b INNER JOIN categories cat ON b.categoryID = cat.categoryID WHERE b.postID = ? ORDER BY b.postDate DESC";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'s',$paramPostID);
            $paramPostID = $postID;
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostID,$fetchedPostTitle,$fetchedPostDesc,$fetchedPostContent,$fetchedPostDate,$fetchedAuthorID,$fetchedPostImage,$fetchedUrlSlug,$fetchedCategoryName);
                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "/".$fetchedPostImage;
//                    $imageURL = $fetchedPostImage;
                    $imageURL = "/dunda-v2".$fetchedPostImage;
                    $data[] = array("post_id"=>$fetchedPostID,"post_title"=>$fetchedPostTitle,"post_desc"=>$fetchedPostDesc,"post_content"=>$fetchedPostContent,"post_date"=>$fetchedPostDate,"author_id"=>$fetchedAuthorID,"url_slug"=>$fetchedUrlSlug,"category"=>$fetchedCategoryName,"image_url"=>$imageURL);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching published posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function fetchPostDetailsByDateAndSlug($postDate,$postUrlSlug){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $postDate = $this->dataHandle->sanitizeData($postDate);
        $postUrlSlug = $this->dataHandle->sanitizeData($postUrlSlug);

        $query = "SELECT b.postID, b.postTitle,b.postDescription,b.postContent,b.postDate,b.authorID,b.postImage,b.urlSlug,cat.categoryName FROM blog_posts b INNER JOIN categories cat ON b.categoryID = cat.categoryID WHERE b.postDate = ? AND b.urlSlug = ? ORDER BY b.postDate DESC";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'ss',$paramPostDate,$paramPostUrlSlug);
            $paramPostDate = $postDate;
            $paramPostUrlSlug = $postUrlSlug;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostID,$fetchedPostTitle,$fetchedPostDesc,$fetchedPostContent,$fetchedPostDate,$fetchedAuthorID,$fetchedPostImage,$fetchedUrlSlug,$fetchedCategoryName);

                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "/".$fetchedPostImage;
//                    $imageURL = $fetchedPostImage;
                    $imageURL = "/dunda-v2".$fetchedPostImage;
                    $data[] = array("post_id"=>$fetchedPostID,"post_title"=>$fetchedPostTitle,"post_desc"=>$fetchedPostDesc,"post_content"=>$fetchedPostContent,"post_date"=>$fetchedPostDate,"author_id"=>$fetchedAuthorID,"url_slug"=>$fetchedUrlSlug,"category"=>$fetchedCategoryName,"image_url"=>$imageURL);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching published posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function fetchPostsByTag($tag){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $tag = $this->dataHandle->sanitizeData(strtolower($tag));

        $query = "SELECT b.postID, b.postTitle,b.postDescription,b.postContent,b.postDate,b.authorID,b.postImage,b.urlSlug FROM blog_posts b INNER JOIN blog_tags t ON b.postID = t.postID WHERE t.tagName = ? AND b.isPublished = 1 ORDER BY b.postDate DESC";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'s',$paramTagName);
            $paramTagName = $tag;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostID,$fetchedPostTitle,$fetchedPostDesc,$fetchedPostContent,$fetchedPostDate,$fetchedAuthorID,$fetchedPostImage,$fetchedUrlSlug);
                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "/".$fetchedPostImage;
//                    $imageURL = $fetchedPostImage;
                    $imageURL = "/dunda-v2".$fetchedPostImage;
                    $data[] = array("post_id"=>$fetchedPostID,"post_title"=>$fetchedPostTitle,"post_desc"=>$fetchedPostDesc,"post_content"=>$fetchedPostContent,"post_date"=>$fetchedPostDate,"author_id"=>$fetchedAuthorID,"image_url"=>$imageURL,"url_slug"=>$fetchedUrlSlug);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching published $tag posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function fetchPostsByBlogger($bloggerID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $bloggerID = $this->dataHandle->sanitizeData(strtolower($bloggerID));

        $query = "SELECT b.postID, b.postTitle,b.postDescription,b.postContent,b.postDate,b.authorID,b.postImage,b.urlSlug FROM blog_posts b WHERE b.authorID = ? ORDER BY b.postDate DESC";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'s',$paramBloggerID);
            $paramBloggerID = $bloggerID;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostID,$fetchedPostTitle,$fetchedPostDesc,$fetchedPostContent,$fetchedPostDate,$fetchedAuthorID,$fetchedPostImage);
                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "/".$fetchedPostImage;
//                    $imageURL = $fetchedPostImage;
                    $imageURL = "/dunda-v2".$fetchedPostImage;
                    $data[] = array("post_id"=>$fetchedPostID,"post_title"=>$fetchedPostTitle,"post_desc"=>$fetchedPostDesc,"post_content"=>$fetchedPostContent,"post_date"=>$fetchedPostDate,"author_id"=>$fetchedAuthorID,"image_url"=>$imageURL);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching $bloggerID posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function fetchPostsByBloggerAdmin($bloggerID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $bloggerID = $this->dataHandle->sanitizeData(strtolower($bloggerID));

        $query = "SELECT b.postID, b.postTitle,b.postDescription,b.postContent,b.postDate,b.authorID,b.postImage,b.urlSlug FROM blog_posts b WHERE b.authorID = ? ORDER BY b.postDate DESC";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'s',$paramBloggerID);
            $paramBloggerID = $bloggerID;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPostID,$fetchedPostTitle,$fetchedPostDesc,$fetchedPostContent,$fetchedPostDate,$fetchedAuthorID,$fetchedPostImage,$fetchedUrlSlug);
                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "../".$fetchedPostImage;
//                    $imageURL = $fetchedPostImage;
                    $imageURL = "/dunda-v2".$fetchedPostImage;
                    $data[] = array("post_id"=>$fetchedPostID,"post_title"=>$fetchedPostTitle,"post_desc"=>$fetchedPostDesc,"post_content"=>$fetchedPostContent,"post_date"=>$fetchedPostDate,"author_id"=>$fetchedAuthorID,"image_url"=>$imageURL,"url_slug"=>$fetchedUrlSlug);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching $bloggerID posts ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function fetchBlogTags($postID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $postID = $this->dataHandle->sanitizeData(strtolower($postID));
        $query = "SELECT tagName FROM blog_tags WHERE postID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramPostID);
            $paramPostID = $postID;

            if (mysqli_stmt_execute($stmt)){
                $output = mysqli_stmt_get_result($stmt);
                $numRows = $output->num_rows;
            }else{
                $this->log->error("Failed fetching tags for $postID ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return $output;
    }

    public function fetchPopularTags(){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT tagName, COUNT(*) AS numPosts FROM blog_tags GROUP BY tagName ORDER BY numPosts DESC LIMIT 7";

        if ($stmt = mysqli_prepare($conn,$query)){
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt,$resTagName,$resNumPosts);
                while(mysqli_stmt_fetch($stmt)){
                    $res[] = array("tag_name"=>$resTagName,"num_posts"=>$resNumPosts);
                }
                $output=array("error"=>"false","data"=>$res);
            }else{
                $this->log->error("Failed fetching popular tags");
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output);
    }

    public function fetchAllTags(){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT tagName, COUNT(*) AS numPosts FROM blog_tags GROUP BY tagName ORDER BY numPosts DESC";

        if ($stmt = mysqli_prepare($conn,$query)){
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt,$resTagName,$resNumPosts);
                while(mysqli_stmt_fetch($stmt)){
                    $res[] = array("tag_name"=>$resTagName,"num_posts"=>$resNumPosts);
                }
                $output=array("error"=>"false","data"=>$res);
            }else{
                $this->log->error("Failed fetching popular tags");
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output);
    }

    public function countTagPosts($tagName){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $tagName = $this->dataHandle->sanitizeData(strtolower($tagName));
        $query = "SELECT COUNT(*) AS numRows FROM blog_posts b INNER JOIN blog_tags t ON b.postID = t.postID WHERE t.tagName = ? AND b.isPublished = 1 ORDER BY b.postDate DESC";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'s',$paramTagName);
            $paramTagName = $tagName;

            if (mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
//                $numRows = $output->num_rows;
                foreach ($result as $row){
                    $numRows = $row['numRows'];
                }
                $output = array("error"=>"false","message"=>$numRows);
            }else{
                $this->log->error("Failed counting posts for $tagName".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output);
    }

    /**
     * @param $bloggerID
     * Count posts by given blogger in the week
     * @return false|string
     */
    public function countWeekBloggerPosts($bloggerID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $bloggerID = $this->dataHandle->sanitizeData($bloggerID);
        $query = "SELECT COUNT(*) AS posts_count FROM blog_posts WHERE authorID = ? AND WEEK(postDate) = WEEK(CURRENT_TIMESTAMP)";

        if ($stmt = mysqli_prepare($conn,$query)){
           mysqli_stmt_bind_param($stmt,'i',$paramBloggerID);
           $paramBloggerID = $bloggerID;

           if (mysqli_stmt_execute($stmt)){
               mysqli_stmt_bind_result($stmt,$countResult);
               $res = 0;
               while(mysqli_stmt_fetch($stmt)){
                   $res = $countResult;
               }
               $output = array("error"=>"false","message"=>$res);
           }else{
               $this->log->error("Failed counting blogger $bloggerID this week's posts");
               $output=array("error"=>"true","message"=>"Failed counting posts");
           }
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
//        return json_encode($output);
        return $output;
    }

    /**
     * @param $bloggerID
     * Count posts by the given blogger in the month
     * @return false|string
     */
    public function countMonthBloggerPosts($bloggerID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $bloggerID = $this->dataHandle->sanitizeData($bloggerID);
        $query = "SELECT COUNT(*) AS posts_count FROM blog_posts WHERE authorID = ? AND MONTH(postDate) = MONTH(CURRENT_TIMESTAMP)";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramBloggerID);
            $paramBloggerID = $bloggerID;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$countResult);
                $res = 0;
                while(mysqli_stmt_fetch($stmt)){
                    $res = $countResult;
                }
                $output = array("error"=>"false","message"=>$res);
            }else{
                $this->log->error("Failed counting blogger $bloggerID this week's posts");
                $output=array("error"=>"true","message"=>"Failed counting posts");
            }
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
//        return json_encode($output);
        return $output;
    }

    /**
     * @param $bloggerID
     * Count posts by the given blogger in the year
     * @return false|string
     */
    public function countYearBloggerPosts($bloggerID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $bloggerID = $this->dataHandle->sanitizeData($bloggerID);
        $query = "SELECT COUNT(*) AS posts_count FROM blog_posts WHERE authorID = ? AND YEAR(postDate) = YEAR(CURRENT_TIMESTAMP)";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramBloggerID);
            $paramBloggerID = $bloggerID;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$countResult);
                $res = 0;
                while(mysqli_stmt_fetch($stmt)){
                    $res = $countResult;
                }
                $output = array("error"=>"false","message"=>$res);
            }else{
                $this->log->error("Failed counting blogger $bloggerID this week's posts");
                $output=array("error"=>"true","message"=>"Failed counting posts");
            }
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
//        return json_encode($output);
        return $output;
    }

    /**
     * @param $bloggerID
     * Count total posts by the given blogger
     * @return false|string
     */
    public function countTotalBloggerPosts($bloggerID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $bloggerID = $this->dataHandle->sanitizeData($bloggerID);
        $query = "SELECT COUNT(*) AS posts_count FROM blog_posts WHERE authorID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramBloggerID);
            $paramBloggerID = $bloggerID;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$countResult);
                $res = 0;
                while(mysqli_stmt_fetch($stmt)){
                    $res = $countResult;
                }
                $output = array("error"=>"false","message"=>$res);
            }else{
                $this->log->error("Failed counting blogger $bloggerID this week's posts");
                $output=array("error"=>"true","message"=>"Failed counting posts");
            }
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
//        return json_encode($output);
        return $output;
    }


    public function weekTopBloggersList(){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT b.memberID, b.firstName, b.lastName, COUNT(*) AS numPosts FROM bloggers b INNER JOIN blog_posts bp ON b.memberID = bp.authorID WHERE WEEK(bp.postDate) = WEEK(CURRENT_DATE) GROUP BY b.memberID  ORDER BY numPosts DESC LIMIT 10";

        if($stmt = mysqli_prepare($conn,$query)){
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$resMemberID,$resFirstName,$resLastName,$resNumPosts);
                $dataFlag = null;
                while (mysqli_stmt_fetch($stmt)){
                    $dataFlag = "dataPresent";
                    $data[] = array("member_id"=>$resMemberID,"first_name"=>$resFirstName,"last_name"=>$resLastName,"num_posts"=>$resNumPosts);
                }
                if (is_null($dataFlag)){
                    $output = array("error"=>"false","message"=>null);
                }else{
                    $output = array("error"=>"false","message"=>$data);
                }
            }else{
                $this->log->error("Failed listing top bloggers this week ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output = array("error"=>"true","message"=>"Failed listing posts");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
//        return json_decode($output);
        return $output;
    }
    public function monthTopBloggersList(){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT b.memberID, b.firstName, b.lastName, COUNT(*) AS numPosts FROM bloggers b INNER JOIN blog_posts bp ON b.memberID = bp.authorID WHERE MONTH(bp.postDate) = MONTH(CURRENT_DATE) GROUP BY b.memberID  ORDER BY numPosts DESC LIMIT 10";

        if($stmt = mysqli_prepare($conn,$query)){
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$resMemberID,$resFirstName,$resLastName,$resNumPosts);
                $dataFlag = null;
                while (mysqli_stmt_fetch($stmt)){
                    $dataFlag = "dataPresent";
                    $data[] = array("member_id"=>$resMemberID,"first_name"=>$resFirstName,"last_name"=>$resLastName,"num_posts"=>$resNumPosts);
                }
                if (is_null($dataFlag)){
                    $output = array("error"=>"false","message"=>null);
                }else{
                    $output = array("error"=>"false","message"=>$data);
                }
            }else{
                $this->log->error("Failed listing top bloggers this month ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output = array("error"=>"true","message"=>"Failed listing posts");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
//        return json_decode($output);
        return $output;
    }
    public function yearTopBloggersList(){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "SELECT b.memberID, b.firstName, b.lastName, COUNT(*) AS numPosts FROM bloggers b INNER JOIN blog_posts bp ON b.memberID = bp.authorID WHERE YEAR(bp.postDate) = YEAR(CURRENT_DATE) GROUP BY b.memberID  ORDER BY numPosts DESC LIMIT 10";

        if($stmt = mysqli_prepare($conn,$query)){
            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$resMemberID,$resFirstName,$resLastName,$resNumPosts);
                $dataFlag = null;
                while (mysqli_stmt_fetch($stmt)){
                    $dataFlag = "dataPresent";
                    $data[] = array("member_id"=>$resMemberID,"first_name"=>$resFirstName,"last_name"=>$resLastName,"num_posts"=>$resNumPosts);
                }
                if (is_null($dataFlag)){
                    $output = array("error"=>"false","message"=>null);
                }else{
                    $output = array("error"=>"false","message"=>$data);
                }
            }else{
                $this->log->error("Failed listing top bloggers this year ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output = array("error"=>"true","message"=>"Failed listing posts");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
//        return json_decode($output);
        return $output;
    }

    public function insertSlug($slug,$postID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $slug = $this->dataHandle->sanitizeData($slug);
        $postID = $this->dataHandle->sanitizeData($postID);

        $query = "UPDATE blog_posts SET urlSlug = ? WHERE postID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'si',$paramUrlSlug,$paramPostID);
            $paramPostID = $postID;
            $paramUrlSlug = $slug;

            if (mysqli_stmt_execute($stmt)){
//                $this->log->info("Updated url slug for $postID");
                $output = array("error"=>"false","message"=>"Success inserting slug");
            }else{
                $this->log->error("Failed inserting slug ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output = array("error"=>"true","message"=>"Failed inserting slug");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output);
    }

    public function newsUrlGenerator($fullDate,$postUrlSlug){
        $time = strtotime($fullDate);

        $dateOnlyformat = date('Ymd',$time);
        $timeOnlyformat = date('His',$time);

        return $url = 'news/'.$dateOnlyformat.'/'.$timeOnlyformat.'/'.$postUrlSlug;
    }

    public function arrayTrimContent($array,$length){
        if(sizeof($array) < 1){
            $outputArray[] = null;
        }else{
            for ($i = 0;$i < $length;$i++){
                if ($i < sizeof($array)){
                    $outputArray[] = $array[$i];
                }else{
                    break;
                }
            }
        }
        return $outputArray;
    }
}

<?php
namespace FootballBlog\Processors;

use http\Exception;
use FootballBlog\Models\DataHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use FootballBlog\Utils\DBConnect;
use Cocur\Slugify\Slugify;

/**
 * Class BloggersFunctions
 * @package Processors
 */
class BloggersFunctions{

    /**
     * @var Slugify variable
     */
    private $slugify;

    /**
     * @var Logger
     */
    private $log;
    /**
     * @var DataHandler
     */
    private $dataHandle;

    /**
     * BloggersFunctions constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->slugify = new Slugify();
        $this->dataHandle = new DataHandler();

        $this->log = new Logger("Bloggers Functions");
        $errorStreamHandler = new StreamHandler("../../runtime/logs/error.log",Logger::ERROR);
        $infoStreamHandler = new StreamHandler("../../runtime/logs/info.log",Logger::INFO);
        $debugStreamHandler = new StreamHandler("../../runtime/logs/debug.log",Logger::DEBUG);

        $this->log->pushHandler($errorStreamHandler);
        $this->log->pushHandler($infoStreamHandler);
        $this->log->pushHandler($debugStreamHandler);
    }


    /**
     * @param $username
     * @param $password
     * @param $email
     * @param $firstName
     * @param $lastName
     * @param $description
     * @param $imageTempName
     * @param $imageFileName
     * @return false|string
     */
    public function signUpAdmin($username, $password, $email, $firstName, $lastName, $description, $imageTempName, $imageFileName,$baseDir){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $baseDir = $baseDir."/";
        $username = $this->dataHandle->sanitizeData($username);
//        $uploadPath = $baseDir."/img/br-images/";
        $uploadPath = "img/br-images/";
        $finalImageName = $username.$imageFileName;
        $imageFilePath = $uploadPath.$finalImageName;

        $query = "INSERT INTO bloggers(username,userPassword,firstName,lastName,description,email,imageUrl) VALUES(?,?,?,?,?,?,?)";

        try{
            if (move_uploaded_file($imageTempName,$baseDir.$imageFilePath)){
                if ($stmt = mysqli_prepare($conn,$query)){
                    mysqli_stmt_bind_param($stmt,'sssssss',$paramUsername,$paramPassword,$paramFirstName,$paramLastName,$paramDescription,$paramEmail,$paramImageUrl);
                    $paramUsername = $username;
                    $paramPassword = password_hash($this->dataHandle->sanitizeData($password),PASSWORD_DEFAULT);
                    $paramFirstName = $this->dataHandle->sanitizeData($firstName);
                    $paramLastName = $this->dataHandle->sanitizeData($lastName);
                    $paramDescription = $this->dataHandle->sanitizeData($description);
                    $paramEmail = $this->dataHandle->sanitizeData($email);
                    $paramImageUrl = $imageFilePath;

                    if (mysqli_stmt_execute($stmt)){
                        $this->log->info("Admin account created successfully");
                        $output = array("error"=> "false","message"=>"success");
                    }else{
                        $this->log->error("Failed adding admin account ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                        $output = array("error"=>"true","message"=>"failed");
                    }
                    mysqli_stmt_close($stmt);
                }else{
                    $this->log->error("Prepare failed ".mysqli_error($conn).' '.mysqli_stmt_error($stmt));
                    $output=array("error"=>"true","message"=>"failed");
                }
            }else{
                $this->log->error("Failed moving file to $imageFilePath");
                $output = array("error"=>"true","message"=>"failed");
            }
        }catch (\Exception $exception){
            $this->log->error("Failed creating admin account");
            $output = array("error"=>"true","message"=>"failed");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function checkUsernameExists($username){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $username = $this->dataHandle->sanitizeData($username);
        $query = "SELECT * FROM bloggers WHERE username = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'s',$paramUsername);
            $paramUsername = $this->dataHandle->sanitizeData($username);

            if (mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
                $countResult = $result->num_rows;
                $output = array("error"=>"failed","message"=>$countResult);
            }else{
                $this->log->error("Failed checking available names ".mysqli_error($conn).' '.mysqli_stmt_error($stmt));
                $output = array("error"=>"true","message"=>"Failed");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output = array("error"=>"true","message"=>"Failed");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function checkEmailExists($email){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $email = $this->dataHandle->sanitizeData($email);
        $query = "SELECT * FROM bloggers WHERE email = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'s',$paramEmail);
            $paramEmail = $this->dataHandle->sanitizeData($email);

            if (mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
                $countResult = $result->num_rows;
                $output = array("error"=>"failed","message"=>$countResult);
            }else{
                $this->log->error("Failed checking available names ".mysqli_error($conn).' '.mysqli_stmt_error($stmt));
                $output = array("error"=>"true","message"=>"Failed");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output = array("error"=>"true","message"=>"Failed");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /***
     * @param $creatorID
     * @param $username
     * @param $password
     * @param $email
     * @param $firstName
     * @param $lastName
     * @param $description
     * @param $imageTempName
     * @param $imageFileName
     * @param $baseDir
     * @return false|string
     */
    public function addBlogger($creatorID,$username, $password, $email, $firstName, $lastName, $description, $imageTempName, $imageFileName,$baseDir){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $username = $this->dataHandle->sanitizeData($username);
        $uploadPath = $baseDir."/img/br-images/";

        $finalImageName = $username.$imageFileName;
        $imageFilePath = $uploadPath.$finalImageName;

        $query = "INSERT INTO bloggers(username,userPassword,firstName,lastName,description,email,imageUrl) VALUES(?,?,?,?,?,?,?)";

        if ($this->dataHandle->sanitizeData($creatorID) != "1"){
            return json_encode(array("error"=>"true","message"=>"Permission denied"),JSON_UNESCAPED_SLASHES);
        }

        try{
            if (move_uploaded_file($imageTempName,$imageFilePath)){
                if ($stmt = mysqli_prepare($conn,$query)){
                    mysqli_stmt_bind_param($stmt,'sssssss',$paramUsername,$paramPassword,$paramFirstName,$paramLastName,$paramDescription,$paramEmail,$paramImageUrl);
                    $paramUsername = $username;
                    $paramPassword = password_hash($this->dataHandle->sanitizeData($password),PASSWORD_DEFAULT);
                    $paramFirstName = $this->dataHandle->sanitizeData($firstName);
                    $paramLastName = $this->dataHandle->sanitizeData($lastName);
                    $paramDescription = $this->dataHandle->sanitizeData($description);
                    $paramEmail = $this->dataHandle->sanitizeData($email);
                    $paramImageUrl = $imageFilePath;

                    if (mysqli_stmt_execute($stmt)){
                        $this->log->info("Blogger account created successfully");
                        $output = array("error"=> "false","message"=>"success");
                    }else{
                        $this->log->error("Failed creating blogger account ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                        $output = array("error"=>"true","message"=>"failed");
                    }
                    mysqli_stmt_close($stmt);
                }else{
                    $this->log->error("Prepare failed ".mysqli_error($conn));
                    $output=array("error"=>"true","message"=>"failed");
                }
            }else{
                $this->log->error("Failed moving file to $imageFilePath");
                $output = array("error"=>"true","message"=>"failed");
            }
        }catch (\Exception $exception){
            $this->log->error("Failed creating blogger account");
            $output = array("error"=>"true","message"=>"failed");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $inputEmail
     * @param $inputPassword
     * @return false|string
     */
    public function login($inputEmail, $inputPassword){
        $dbConnection = new DBConnect();
        $conn = $dbConnection->dbConnection();

        $inputEmail = $this->dataHandle->sanitizeData($inputEmail);
        $inputPassword = $this->dataHandle->sanitizeData($inputPassword);

        $query= "SELECT username,userPassword FROM bloggers WHERE email = ?";
        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'s',$paramEmail);
            $paramEmail = $inputEmail;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$returnedUsername,$returnedPassword);
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) < 1 ){
                    $output = array("error"=>"true","message"=>"Account does not exist 1");
//                    $this->log->info("Details"putEmail));
                }
//                elseif (mysqli_stmt_num_rows($stmt) > 1){
//                    $this->log->debug("More than one account with same email $inputEmail");
//                    $output=array("error"=>"true","message"=>"Account does not exist");
//                }
                elseif (mysqli_stmt_num_rows($stmt) >= 1){

                    while (mysqli_stmt_fetch($stmt)){
                        if (password_verify($this->dataHandle->sanitizeData($inputPassword),$returnedPassword)){
                            //login success
                            //redirect
                            //setting sessions
                            $this->log->info("Email $inputEmail logged in");
                            $output = array("error"=>"false","message"=>"success");
                        }else{
                            $this->log->info("Login failed for user $inputEmail");
                            $output = array("error"=>"true","message"=>"Incorrect login credentials");
                        }
                    }
                }
                else{
                    $output=array("error"=>"true","message"=>"Account does not exist");
                }
            }else{
                $this->log->error("Login failed ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Oops! Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Oops! Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $postTitle
     * @param $postDescription
     * @param $postContent
     * @param $authorID
     * @param $imageTempName
     * @param $imageFileName
     * @param $baseDir
     * @return false|string
     */
    public function addPost($postTitle, $postDescription, $postContent, $authorID,$categoryID, $imageTempName, $imageFileName, $baseDir){
        $dbConnection = new DBConnect();
        $conn = $dbConnection->dbConnection();

        $postTitle = $this->dataHandle->sanitizeData($postTitle);
        $postDescription = $this->dataHandle->sanitizeData($postDescription);
//         $postContent = $this->dataHandle->sanitizeDescription($postContent);
        $authorID = $this->dataHandle->sanitizeData($authorID);
        $categoryID = $this->dataHandle->sanitizeData($categoryID);
        $postSlug = $this->slugify->slugify($postTitle);

        $query = "INSERT INTO blog_posts(postTitle,postDescription,postContent,authorID,categoryID,postImage,urlSlug) VALUES(?,?,?,?,?,?,?)";

//        $uploadPath = $baseDir."/img/p-images/";
        $uploadPath = "/img/p-images/";
        $finalImageName = md5($postTitle).$imageFileName;
        $imageFilePath = $uploadPath.$finalImageName;


        try{
            if (move_uploaded_file($imageTempName,$baseDir.$imageFilePath)){
                if ($stmt = mysqli_prepare($conn,$query)){
                    mysqli_stmt_bind_param($stmt,'sssiiss',$paramPostTitle,$paramPostDescription,$paramPostContent,$paramAuthorID,$paramCategoryID,$paramPostImage,$paramPostTitleSlug);
                    $paramAuthorID = $authorID;
                    $paramPostContent = $postContent;
                    $paramPostDescription = $postDescription;
                    $paramPostTitle = $postTitle;
                    $paramPostImage = $imageFilePath;
                    $paramCategoryID = $categoryID;
                    $paramPostTitleSlug = $postSlug;

                    if (mysqli_stmt_execute($stmt)){
                        $this->log->info("Post $postTitle added succesfully by $authorID");
                        $output = array("error"=>"false","message"=>"Post $postTitle added successfully");
                    }else{
                        $this->log->error("Failed adding post $postTitle".mysqli_error($conn).' '.mysqli_stmt_error($stmt));
                        $output = array("error"=>"true","message"=>"Failed adding post $postTitle");
                    }
                    mysqli_stmt_close($stmt);
                }else{
                    $this->log->error("Prepare failed $postTitle".mysqli_error($conn));
                    $output=array("error"=>"true","message"=>"Failed adding post $postTitle");
                }
            }else{
                $this->log->error("Failed moving file $imageFilePath. Possible permission issue".mysqli_error($conn));
                $this->log->debug("Failed moving file $imageFilePath. Possible permission issue".mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Failed adding post");
            }
        }catch (Exception $exception){
            $this->log->error("Adding post failed $postTitle");
            $output = array("error"=>"true","message"=>"Failed adding post");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $postID
     * @param $postTitle
     * @param $postDescription
     * @param $postContent
     * @return false|string
     */
    public function editPostDetails($postID, $postTitle, $postDescription, $postContent,$categoryID){
        $dbConnection = new DBConnect();
        $conn = $dbConnection->dbConnection();

        $postTitle = $this->dataHandle->sanitizeData($postTitle);
        $postDescription = $this->dataHandle->sanitizeData($postDescription);
        // $postContent = $this->dataHandle->sanitizeDescription($postContent);
        $postID = $this->dataHandle->sanitizeData($postID);
        $categoryID = $this->dataHandle->sanitizeData($categoryID);

        $query="UPDATE blog_posts SET postTitle = ?,postDescription = ?,postContent = ?,categoryID = ? WHERE postID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'sssii',$paramPostTitle,$paramPostDescription,$paramPostContent,$paramCategoryID,$paramPostID);
            $paramPostID = $postID;
            $paramPostContent = $postContent;
            $paramPostDescription = $postDescription;
            $paramPostTitle = $postTitle;
            $paramCategoryID = $categoryID;

            if (mysqli_stmt_execute($stmt)){
                $this->log->info("$postID details updated $postContent");
                $output = array("error"=>"false","message"=>"Post updating successful");
            }else{
                $this->log->error("Failed editing post details $postID ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output=array("error"=>"true","message"=>"Post updating failed");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Post updating failed");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $postID
     * @param $imageTempName
     * @param $imageFileName
     * @param $baseDir
     * @return false|string
     */
    public function changePostImage($postID, $imageTempName, $imageFileName, $baseDir){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $postID = $this->dataHandle->sanitizeData($postID);

        $uploadPath = "/img/p-images/";
        $finalImageName = md5($imageTempName).$imageFileName;
        $imageFilePath = $uploadPath.$finalImageName;


        $query ="UPDATE blog_posts SET postImage = ? WHERE postID = ?";

        if ($this->deletePostImage($postID)){
            try{
                if (move_uploaded_file($imageTempName,$baseDir.$imageFilePath)){

                    if ($stmt = mysqli_prepare($conn,$query)){
                        mysqli_stmt_bind_param($stmt,'si',$paramPostImage,$paramPostID);
                        $paramPostID = $postID;
                        $paramPostImage = $imageFilePath;

                        if (mysqli_stmt_execute($stmt)){
                            $this->log->info("$postID image update successfully");
                            $output=array("error"=>"false","message"=>"Post image update successfully");
                        }else{
                            $this->log->error("Failed updating image path $postID");
                            $output=array("error"=>"true","message"=>"Post image update failed");
                        }

                        mysqli_stmt_close($stmt);
                    }else{
                        $this->log->error("Prepare failed ".mysqli_error($conn));
                        $output=array("error"=>"true","message"=>"Post image update failed");
                    }
                }else{
                    $this->log->error("Failed adding image ".mysqli_error($conn));
                    $output=array("error"=>"true","message"=>"Post image update failed");
                }
            }catch (\Exception $e){
                $this->log->error("Failed changing image $e");
                $output=array("error"=>"true","message"=>"Post image update failed");
            }
        }else{
            $output=array("error"=>"true","message"=>"Post image update failed");
        }

        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $postID
     * @return bool
     */
    public function deletePostImage($postID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $postID = $this->dataHandle->sanitizeData($postID);

        $query = "SELECT postImage FROM blog_posts WHERE postID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'s',$paramPostID);
            $paramPostID = $postID;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$imageFilePath);

                while (mysqli_stmt_fetch($stmt)){
                    $dir = "../..";
                    $filePath = $dir.$imageFilePath;

                    if(file_exists($filePath)) {
                        chmod($filePath,0755);
                        unlink($filePath);
                        $this->log->info("Image $filePath deleted successfully");
                        $output=true;
                    }else{
                        $this->log->error("File not found $imageFilePath");
                        $output =false;
                    }
                }

            }else{
                $this->log->error("Failed fetching Image path ".mysqli_error($conn).' '.mysqli_stmt_error($stmt));
                $output=false;
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=false;
        }
        mysqli_close($conn);
        return $output;
    }

    /**
     * @param $bloggerID
     * @return bool
     */
    public function deleteBloggerImage($bloggerID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $bloggerID = $this->dataHandle->sanitizeData($bloggerID);

        $query = "SELECT imageUrl FROM bloggers WHERE memberID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'s',$paramBloggerID);
            $paramBloggerID = $bloggerID;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$imageFilePath);

                while (mysqli_stmt_fetch($stmt)){
                    $dir = "../../";
                    $filePath = $dir.$imageFilePath;

                    if(file_exists($filePath)) {
                        chmod($filePath,0755);
                        unlink($filePath);
                        $this->log->info("Image $filePath deleted successfully");
                        $output=true;
                    }else{
                        $this->log->error("File not found $imageFilePath");
                        $output =false;
                    }
                }

            }else{
                $this->log->error("Failed fetching Image path ".mysqli_error($conn).' '.mysqli_stmt_error($stmt));
                $output=false;
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=false;
        }
        mysqli_close($conn);
        return $output;
    }

    /**
     * @param $postID
     * @return false|string
     */
    public function publishPost($postID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $postID = $this->dataHandle->sanitizeData($postID);

        $query = "UPDATE blog_posts SET isPublished = 1 WHERE postID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramPostID);
            $paramPostID = $postID;

            if (mysqli_stmt_execute($stmt)){
                $this->log->info("Post $postID published");
                $output = array("error"=>"false","message"=>"Post published successfully");
            }else{
                $this->log->error("Publishing post failed for $postID");
                $output=array("error"=>"true","message"=>"Post publishing failed");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Post publishing failed");
        }

        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $postID
     * @return false|string
     */
    public function unpublishPost($postID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $postID = $this->dataHandle->sanitizeData($postID);

        $query = "UPDATE blog_posts SET isPublished = 0 WHERE postID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramPostID);
            $paramPostID = $postID;

            if (mysqli_stmt_execute($stmt)){
                $this->log->info("Post $postID unpublished");
                $output = array("error"=>"false","message"=>"Post unpublished successfully");
            }else{
                $this->log->error("Unpublishing post failed for $postID");
                $output=array("error"=>"true","message"=>"Post unpublishing failed");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output=array("error"=>"true","message"=>"Post unpublishing failed");
        }

        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }


    /**
     * @param $postID
     * @return false|string
     */
    public function deletePost($postID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $postID = $this->dataHandle->sanitizeData($postID);

        $query = "DELETE FROM blog_posts WHERE postID = ?";

        if ($stmt=mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramPostID);
            $paramPostID = $postID;

            if (mysqli_stmt_execute($stmt)){
                $this->log->info("$postID deleted successfully");
                $output = array("error"=>"false","message"=>"Post deleted successfully");
            }else{
                $this->log->error("Failed deleting post $postID");
                $output = array("error"=>"true","message"=>"Post deletion failed");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output = array("error"=>"true","message"=>"Post deletion failed");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $commentID
     * @return false|string
     */
    public function deleteComment($commentID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $commentID = $this->dataHandle->sanitizeData($commentID);

        $query = "DELETE FROM blog_comments WHERE commentID = ?";

        if ($stmt=mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramCommentID);
            $paramCommentID = $commentID;

            if (mysqli_stmt_execute($stmt)){
                $this->log->info("Comment $commentID deleted successfully");
                $output = array("error"=>"false","message"=>"Comment deleted successfully");
            }else{
                $this->log->error("Comment $commentID deletion failed ".mysqli_error($conn).' '.mysqli_stmt_error($stmt));
                $output = array("error"=>"true","message"=>"Comment deletion failed");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Comment $commentID deletion failed ".mysqli_error($conn));
            $output = array("error"=>"true","message"=>"Comment deletion failed");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function editBloggerDetails($username, $email, $firstName, $lastName, $description,$bloggerID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $query = "UPDATE bloggers SET firstName = ?, lastName = ?,username = ?,email = ?,description=? WHERE memberID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'sssssi',$paramFirstName,$paramLastName,$paramUsername,$paramEmail,$paramDescription,$paramMemberID);
            $paramUsername = $this->dataHandle->sanitizeData($username);
            $paramEmail = $this->dataHandle->sanitizeData($email);
            $paramFirstName = $this->dataHandle->sanitizeData($firstName);
            $paramLastName = $this->dataHandle->sanitizeData($lastName);
            $paramDescription = $this->dataHandle->sanitizeData($description);
            $paramMemberID = $this->dataHandle->sanitizeData($bloggerID);

            if (mysqli_stmt_execute($stmt)){
                $this->log->info("Updated blogger $bloggerID details");
                $output = array("error"=>"false","message"=>"Success");
            }else{
                $this->log->error("Failed editing blogger $bloggerID details ".mysqli_error($conn).' '.mysqli_stmt_error($stmt));
                $output = array("error"=>"true","message"=>"Editing details failed");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output = array("error"=>"true","message"=>"Editing details failed");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function changeBloggerImage($bloggerID, $imageTempName, $imageFileName, $baseDir){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $bloggerID = $this->dataHandle->sanitizeData($bloggerID);

        $uploadPath = "/img/br-images/";
        $finalImageName = md5($imageTempName).$imageFileName;
        $imageFilePath = $uploadPath.$finalImageName;


        $query ="UPDATE bloggers SET imageUrl = ? WHERE memberID = ?";

        if ($this->deleteBloggerImage($bloggerID)){
            try{
                if (move_uploaded_file($imageTempName,$baseDir.$imageFilePath)){

                    if ($stmt = mysqli_prepare($conn,$query)){
                        mysqli_stmt_bind_param($stmt,'si',$paramBloggerImage,$paramBloggerID);
                        $paramBloggerID = $bloggerID;
                        $paramBloggerImage = $imageFilePath;

                        if (mysqli_stmt_execute($stmt)){
                            $this->log->info("$bloggerID image update successfully");
                            $output=array("error"=>"false","message"=>"Blogger image update successfully");
                        }else{
                            $this->log->error("Failed updating image path $bloggerID");
                            $output=array("error"=>"true","message"=>"Blogger image update failed");
                        }

                        mysqli_stmt_close($stmt);
                    }else{
                        $this->log->error("Prepare failed ".mysqli_error($conn));
                        $output=array("error"=>"true","message"=>"Blogger image update failed");
                    }
                }else{
                    $this->log->error("Failed adding image ".mysqli_error($conn));
                    $output=array("error"=>"true","message"=>"Blogger image update failed");
                }
            }catch (\Exception $e){
                $this->log->error("Failed changing image $e");
                $output=array("error"=>"true","message"=>"Blogger image update failed");
            }
        }else{
            $output=array("error"=>"true","message"=>"Blogger image update failed");
        }

        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $bloggerID
     * @param $inputPassword
     * @param $newPassword
     * @return false|string
     */
    public function changeBloggerPassword($bloggerID, $inputPassword, $newPassword){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $bloggerID = $this->dataHandle->sanitizeData($bloggerID);
        $inputPassword = $this->dataHandle->sanitizeData($inputPassword);
        $newPassword = $this->dataHandle->sanitizeData($newPassword);

        $query = "UPDATE bloggers SET userPassword = ? WHERE memberID = ?";

        if ($this->verifyPassword($bloggerID,$inputPassword)){
            if ($stmt = mysqli_prepare($conn,$query)){
                mysqli_stmt_bind_param($stmt,'si',$paramUserPassword,$paramMemberID);
                $paramMemberID = $bloggerID;
                $paramUserPassword = password_hash($newPassword,PASSWORD_DEFAULT);

                if (mysqli_stmt_execute($stmt)){
                    $this->log->info("$bloggerID password changed");
                    $output = array("error"=>"false","message"=>"Password changed successfully");
                }else{
                    $this->log->error("Failed changing blogger $bloggerID password ".mysqli_error($conn).mysqli_stmt_error($stmt));
                    $output = array("error"=>"true","message"=>"Password changing failed");
                }
                mysqli_stmt_close($stmt);
            }else{
                $this->log->error("Prepare failed ".mysqli_error($conn));
                $output = array("error"=>"true","message"=>"Password changing failed");
            }
        }else{
            $output = array("error"=>"true","message"=>"Incorrect password entry");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $bloggerID
     * @param $inputPassword
     * @return bool
     */
    public function verifyPassword($bloggerID, $inputPassword){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $bloggerID = $this->dataHandle->sanitizeData($bloggerID);
        $inputPassword = $this->dataHandle->sanitizeData($inputPassword);

        $query = "SELECT userPassword FROM bloggers WHERE memberID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramMemberID);
            $paramMemberID = $bloggerID;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedPassword);
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1){
                    while (mysqli_stmt_fetch($stmt)){
                        if(password_verify($inputPassword,$fetchedPassword)){
                            $output = true;
                        }else{
                            $this->log->info("Input password does not match with old for $bloggerID");
                            $output = false;
                        }
                    }
                }else{
                    $this->log->error("Failed verifying password : more than one rows fetched $bloggerID ".mysqli_stmt_num_rows($stmt));
                    $output = false;
                }
                mysqli_stmt_close($stmt);
            }else{
                $this->log->error("Failed verifying password for $bloggerID ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output = false;
            }
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output = false;
        }

        mysqli_close($conn);
        return $output;
    }

    /**
     * @param $bloggerID
     * @return false|string
     */
    public function fetchBloggerDetailsAdmin($bloggerID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $bloggerID = $this->dataHandle->sanitizeData($bloggerID);

        $query = "SELECT firstName,lastName,email,username,imageUrl,description FROM bloggers WHERE memberID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramBloggerID);
            $paramBloggerID = $bloggerID;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedFirstName,$fetchedLastName,$fetchedEmail,$fetchedUsername,$fetchedImageUrl,$fetchedDescription);
                while(mysqli_stmt_fetch($stmt)){
//                    $imageURL = "https://top10betz.com".substr($fetchedImageUrl,26);
//                    $imageURL = "../".substr($fetchedImageUrl,51);
                    $imageURL = "../".$fetchedImageUrl;

                    $data[] = array("first_name"=>$fetchedFirstName,"last_name"=>$fetchedLastName,"email"=>$fetchedEmail,"username"=>$fetchedUsername,"description"=>$fetchedDescription,"image_url"=>$imageURL);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching blogger $bloggerID details ".mysqli_error($conn).' '.mysqli_stmt_error($stmt));
                $output = array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output = array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function fetchBloggerDetails($bloggerID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $bloggerID = $this->dataHandle->sanitizeData($bloggerID);

        $query = "SELECT firstName,lastName,email,imageUrl,description FROM bloggers WHERE memberID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramBloggerID);
            $paramBloggerID = $bloggerID;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedFirstName,$fetchedLastName,$fetchedEmail,$fetchedImageUrl,$fetchedDescription);
                while(mysqli_stmt_fetch($stmt)){
                    $imageURL = $fetchedImageUrl;
//                    $imageURL = '/'.$fetchedImageUrl;

                    $data[] = array("first_name"=>$fetchedFirstName,"last_name"=>$fetchedLastName,"email"=>$fetchedEmail,"description"=>$fetchedDescription,"image_url"=>$imageURL);
                }
                $output = array("error"=>"false","data"=>$data);
            }else{
                $this->log->error("Failed fetching blogger $bloggerID details ".mysqli_error($conn).' '.mysqli_stmt_error($stmt));
                $output = array("error"=>"true","message"=>"Something went wrong");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output = array("error"=>"true","message"=>"Something went wrong");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function getBloggerID($email){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $email = $this->dataHandle->sanitizeData($email);

        $query = "SELECT memberID FROM bloggers WHERE email = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'s',$paramEmail);
            $paramEmail = $email;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt,$fetchedID);
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) > 0){
                    while (mysqli_stmt_fetch($stmt)){
                        $output =array("id"=>$fetchedID);
                    }
                }else{
                    $output=array("error"=>"true","message"=>"Something went wrong");
                }

            }else{
                $this->log->error("Failed fetching member ID $email");
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

    public function addCategory($category){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $categoryName =$this->dataHandle->sanitizeData($category);
        $query = "INSERT INTO categories(categoryName) VALUES(?)";

        if ($stmt=mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'s',$paramCategoryName);
            $paramCategoryName = $categoryName;

            if (mysqli_stmt_execute($stmt)){
                $this->log->info("Added category ".$categoryName);
                $output = array("error"=>"false","message"=>"$categoryName added successfully");
            }else{
                $this->log->error("Adding category failed ".mysqli_error($conn).' '.mysqli_stmt_error($stmt));
                $output = array("error"=>"true","message"=>"Failed adding $categoryName");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $this->log->debug("Prepare failed ".mysqli_error($conn));
            $output = array("error"=>"true","message"=>"Failed adding $categoryName");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function getCategoryID($categoryName){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $categoryName = $this->dataHandle->sanitizeData($categoryName);

        $query = "SELECT categoryID FROM categories WHERE categoryName = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'s',$paramCategoryName);
            $paramCategoryName = $categoryName;

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt,$gottenCategoryID);
                while (mysqli_stmt_fetch($stmt)){
                    $categoryID = $gottenCategoryID;
                }
                $output = array("error"=>"false","category_id"=>$categoryID);
            }else{
                $this->log->error("Failed fetching category id for ".$categoryName. "due to ".mysqli_error($conn)." ".mysqli_stmt_error($stmt));
                $output = array("error"=>"true","message"=>"Failed fetching category Id");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output = array("error"=>"true","message"=>"Failed fetching category Id");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function addPostTags($postID,$tag){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $tag =$this->dataHandle->sanitizeData(strtolower($tag));
        $postID =$this->dataHandle->sanitizeData($postID);
        $query = "INSERT INTO blog_tags(tagName,postID) VALUES(?,?)";

        if ($stmt=mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'si',$paramTagName,$paramPostID);
            $paramTagName = $tag;
            $paramPostID = $postID;

            if (mysqli_stmt_execute($stmt)){
//                $this->log->info("Added category ".$categoryName);
                $output = array("error"=>"false","message"=>"$tag added successfully for $postID");
            }else{
                $this->log->error("Adding tag failed ".mysqli_error($conn).' '.mysqli_stmt_error($stmt));
                $output = array("error"=>"true","message"=>"Failed adding $tag for $postID");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $this->log->debug("Prepare failed ".mysqli_error($conn));
            $output = array("error"=>"true","message"=>"Failed adding $tag for $postID");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

    public function deletePostTags($postID,$tag){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $tag =$this->dataHandle->sanitizeData(strtolower($tag));
        $postID =$this->dataHandle->sanitizeData($postID);
        $query = "DELETE FROM blog_tags WHERE tagName = ? AND postID = ?;";

        if ($stmt=mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'si',$paramTagName,$paramPostID);
            $paramTagName = $tag;
            $paramPostID = $postID;

            if (mysqli_stmt_execute($stmt)){
//                $this->log->info("Added category ".$categoryName);
                $output = array("error"=>"false","message"=>"$tag deleted successfully for $postID");
            }else{
                $this->log->error("Deleting tag failed ".mysqli_error($conn).' '.mysqli_stmt_error($stmt));
                $output = array("error"=>"true","message"=>"Failed deleting $tag for $postID");
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $this->log->debug("Prepare failed ".mysqli_error($conn));
            $output = array("error"=>"true","message"=>"Failed deleting $tag for $postID");
        }
        mysqli_close($conn);
        return json_encode($output,JSON_UNESCAPED_SLASHES);
    }

}
<?php
namespace FootballBlog\Processors;

use FootballBlog\Models\DataHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use FootballBlog\Utils\DBConnect;

class SessionManager{

    private $dataHandle;
    private $log;

    public function __construct()
    {
        $this->dataHandle = new DataHandler();


        $this->log = new Logger("Session Manager");
        $errorStreamHandler = new StreamHandler("../../runtime/logs/error.log",Logger::ERROR);
        $infoStreamHandler = new StreamHandler("../../runtime/logs/info.log",Logger::INFO);
        $debugStreamHandler = new StreamHandler("../../runtime/logs/debug.log",Logger::DEBUG);

        $this->log->pushHandler($errorStreamHandler);
        $this->log->pushHandler($infoStreamHandler);
        $this->log->pushHandler($debugStreamHandler);
    }

    public function startSession($userID){

        if ($this->checkSessionExists($userID)){
            $this->stopSession($userID);
            $this->addSession($userID);
        }else{
            $this->addSession($userID);
        }
    }

    public function addSession($userID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $sessionID = $this->dataHandle->sanitizeData($userID);

        $query = "INSERT INTO session_manager(sessionID) VALUES(?)";


        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramSessionID);
            $paramSessionID = $sessionID;

            if (mysqli_stmt_execute($stmt)){
                $output = true;
                $this->log->info("Created session $userID");
            }else{
                $this->log->error("Failed creating session ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output = false;
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output = false;
        }
        mysqli_close($conn);
        return $output;
    }

    public function checkSessionExists($sessionID){
        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $sessionID = $this->dataHandle->sanitizeData($sessionID);

        $query = "SELECT * FROM session_manager WHERE sessionID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramSessionID);
            $paramSessionID = $sessionID;

            if (mysqli_stmt_execute($stmt)){
                $results = mysqli_stmt_get_result($stmt);

                if ($results->num_rows > 0){
                    $output = true;
                    $this->log->info("Session $sessionID exists");
                }else{
                    $output  = false;
                    $this->log->info("Session $sessionID does not exist");
                }
            }else{
                $this->log->error("Failed confirming status ".mysqli_stmt_error($stmt).' '.mysqli_error($conn));
                $output = false;
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output = false;
        }
        mysqli_close($conn);
        return $output;
    }

    public function stopSession($sessionID){

        $dbConnect = new DBConnect();
        $conn = $dbConnect->dbConnection();

        $sessionID = $this->dataHandle->sanitizeData($sessionID);

        $query = "DELETE FROM session_manager WHERE sessionID = ?";

        if ($stmt = mysqli_prepare($conn,$query)){
            mysqli_stmt_bind_param($stmt,'i',$paramUserID);
            $paramUserID = $sessionID;

            if (mysqli_stmt_execute($stmt)){
                $this->log->info("Deleted session $sessionID");
                $output = true;
            }else{
                $this->log->error("Failed stopping session ".mysqli_error($conn).' '.mysqli_stmt_error($stmt));
                $output = false;
            }
            mysqli_stmt_close($stmt);
        }else{
            $this->log->error("Prepare failed ".mysqli_error($conn));
            $output = false;
        }
        mysqli_close($conn);
        return $output;
    }
}
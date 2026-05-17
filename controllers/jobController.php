<?php

    require_once('../models/jobModel.php');
    session_start();

    $isLoggedIn = $_SESSION["isLoggedIn"] ?? false;
    if(!$isLoggedIn){
        header('location: ../views/login.php');
        exit();
    }

    $user_id = $_SESSION["user_id"] ?? "";
    $role    = $_SESSION["role"]    ?? "";

    if(isset($_REQUEST['action'])){
        $action = $_REQUEST['action'];

        // ─── SEARCH JOBS (AJAX) ──────────────────────────────
        if($action == "searchJobs"){
            $keyword = $_REQUEST['keyword'] ?? "";

            if($keyword == ""){
                $jobs = getAllActiveJobs();
            }else{
                $jobs = searchJobs($keyword);
            }

            foreach($jobs as &$job){
                $job['is_saved'] = checkSavedJob($user_id, $job['id']) ? "yes" : "no";
            }

            echo json_encode($jobs);

        // ─── FILTER JOBS (AJAX) ──────────────────────────────
        }else if($action == "filterJobs"){
            $category_id    = $_REQUEST['category_id']    ?? "";
            $job_type       = $_REQUEST['job_type']       ?? "";
            $location       = $_REQUEST['location']       ?? "";
            $salary_keyword = $_REQUEST['salary_keyword'] ?? "";

            $jobs = filterJobs($category_id, $job_type, $location, $salary_keyword);

            foreach($jobs as &$job){
                $job['is_saved'] = checkSavedJob($user_id, $job['id']) ? "yes" : "no";
            }

            echo json_encode($jobs);

        // ─── TOGGLE SAVE JOB (AJAX) ──────────────────────────
        }else if($action == "toggleSaveJob"){
            $job_id = $_REQUEST['job_id'] ?? "";

            if($job_id == ""){
                echo json_encode(['success' => false, 'message' => 'Job ID missing']);
            }else{
                $alreadySaved = checkSavedJob($user_id, $job_id);

                if($alreadySaved){
                    $result = unsaveJob($user_id, $job_id);
                    if($result){
                        echo json_encode(['success' => true, 'saved' => false]);
                    }else{
                        echo json_encode(['success' => false, 'message' => 'Could not remove']);
                    }
                }else{
                    $result = saveJob($user_id, $job_id);
                    if($result){
                        echo json_encode(['success' => true, 'saved' => true]);
                    }else{
                        echo json_encode(['success' => false, 'message' => 'Could not save']);
                    }
                }
            }

        // ─── APPLY FOR JOB ───────────────────────────────────
        }else if($action == "apply"){
            if($role != "seeker"){
                header('location: ../views/job_board.php');
                exit();
            }

            $job_id             = $_REQUEST['job_id']             ?? "";
            $cover_letter       = $_REQUEST['cover_letter']       ?? "";
            $use_profile_resume = $_REQUEST['use_profile_resume'] ?? "";
            $file               = $_FILES['resume_upload']        ?? null;

            if($job_id == ""){
                echo "Invalid job";
            }else if($cover_letter == ""){
                $_SESSION["coverLetterErr"] = "Cover letter is required";
                header("location: ../views/job_detail.php?id={$job_id}");
                exit();
            }else{
                $alreadyApplied = checkExistingApplication($job_id, $user_id);

                if($alreadyApplied){
                    $_SESSION["applyErr"] = "You have already applied for this job";
                    header("location: ../views/job_detail.php?id={$job_id}");
                    exit();
                }else{
                    $resume_path = "";

                    if($use_profile_resume == "yes"){
                        $resume_path = $_SESSION["file_path"] ?? "";
                    }else if($file && $file['name'] != ""){
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mime  = finfo_file($finfo, $file['tmp_name']);
                        finfo_close($finfo);

                        if($mime == "application/pdf" && $file['size'] <= 2097152){
                            $uploadDirectory = "../public/uploads/";
                            $resume_path     = $uploadDirectory.time()."_".basename($file['name']);
                            move_uploaded_file($file['tmp_name'], $resume_path);
                        }else{
                            $_SESSION["applyErr"] = "Resume must be a PDF file under 2MB";
                            header("location: ../views/job_detail.php?id={$job_id}");
                            exit();
                        }
                    }

                    $result = createApplication($job_id, $user_id, $cover_letter, $resume_path);

                    if($result){
                        $_SESSION["applySuccess"] = "Application submitted successfully";
                        header('location: ../views/my_applications.php');
                        exit();
                    }else{
                        $_SESSION["applyErr"] = "Application could not be submitted. Please try again.";
                        header("location: ../views/job_detail.php?id={$job_id}");
                        exit();
                    }
                }
            }

        // ─── REMOVE SAVED JOB ────────────────────────────────
        }else if($action == "removeSaved"){
            $job_id = $_REQUEST['job_id'] ?? "";

            if($job_id == ""){
                echo "Invalid job";
            }else{
                unsaveJob($user_id, $job_id);
                header('location: ../views/saved_jobs.php');
                exit();
            }

        }else{
            echo "Invalid request";
        }

    }else{
        echo "Action not found";
    }

?>

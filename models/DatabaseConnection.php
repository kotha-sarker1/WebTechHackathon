<?php

class DatabaseConnection {

    function openConnection() {

        $db_host = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "job_portal_db";

        $connection = new mysqli("localhost", "root", "", "job_portal_db");

        if ($connection->connect_error) {
            die("Database Connection Failed: " . $connection->connect_error);
        }

        return $connection;
    }

    function RegisterUser($connection, $name, $email, $passHash, $role, $path) {

        $sql = "INSERT INTO users (name, email, password_hash, role, file_path)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("sssss", $name, $email, $passHash, $role, $path);

        return $stmt->execute();
    }

    function GetUserByEmail($connection, $email) {

        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        return $stmt->get_result();
    }

    function CheckEmailExists($connection, $email) {

        $sql = "SELECT id FROM users WHERE email = ?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    function checkProfileIncomplete($connection, $user_id, $role) {

        $table = ($role == 'employer') ? 'employer_profiles' : 'seeker_profiles';

        $sql = "SELECT id FROM $table WHERE user_id = ?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("i", $user_id);

        $stmt->execute();

        return $stmt->get_result()->num_rows == 0;
    }

    function saveEmployerProfile($connection, $id, $company, $industry, $desc, $website) {

        $sql = "INSERT INTO employer_profiles (user_id, company_name, industry, description, website)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("issss", $id, $company, $industry, $desc, $website);

        return $stmt->execute();
    }

    function saveSeekerProfile($connection, $id, $headline, $skills, $exp) {

        $sql = "INSERT INTO seeker_profiles (user_id, headline, skills, years_experience)
                VALUES (?, ?, ?, ?)";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("issi", $id, $headline, $skills, $exp);

        return $stmt->execute();
    }

    function getProfileData($connection, $user_id, $role) {

        $table = ($role == 'employer') ? 'employer_profiles' : 'seeker_profiles';

        $sql = "SELECT * FROM $table WHERE user_id = ?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("i", $user_id);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    function updateEmployerProfile($connection, $id, $company, $industry, $desc, $website) {

        $sql = "UPDATE employer_profiles SET company_name=?, industry=?, description=?, website=?
                WHERE user_id=?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("ssssi", $company, $industry, $desc, $website, $id);

        return $stmt->execute();
    }

    function updateSeekerProfile($connection, $id, $headline, $skills, $exp) {

        $sql = "UPDATE seeker_profiles SET headline=?, skills=?, years_experience=?
                WHERE user_id=?";

        $stmt = $connection->prepare($sql);

        $stmt->bind_param("ssii", $headline, $skills, $exp, $id);

        return $stmt->execute();
    }
}

?>